<?php

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Order.php";

class CartController
{
    private $product;
    private $order;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->product = new Product($db);
        $this->order = new Order($db);
    }

    private function requireLogin()
    {
        if (!isset($_SESSION['id_user'])) {
            header("Location:index.php?page=login");
            exit;
        }
    }

    private function uploadPaymentProof()
    {
        if (empty($_FILES['bukti_pembayaran']['name'])) {
            throw new Exception("Bukti pembayaran wajib diupload untuk transfer bank.");
        }

        if ($_FILES['bukti_pembayaran']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload bukti pembayaran gagal. Silakan pilih file lagi.");
        }

        if ($_FILES['bukti_pembayaran']['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran bukti pembayaran maksimal 2MB.");
        }

        $tmpName = $_FILES['bukti_pembayaran']['tmp_name'];
        $originalName = $_FILES['bukti_pembayaran']['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];

        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception("Bukti pembayaran hanya boleh JPG, PNG, WEBP, atau PDF.");
        }

        if ($extension !== 'pdf' && getimagesize($tmpName) === false) {
            throw new Exception("File bukti pembayaran harus berupa gambar yang valid atau PDF.");
        }

        $folder = "uploads/payments/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $fileName = "bukti_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $extension;

        if (!move_uploaded_file($tmpName, $folder . $fileName)) {
            throw new Exception("Bukti pembayaran tidak bisa disimpan.");
        }

        return $fileName;
    }

    public function index()
    {
        $this->requireLogin();

        $cartItems = $_SESSION['cart'] ?? [];
        require "app/views/cart/index.php";
    }

    public function add()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_produk'])) {
            header("Location:index.php?page=home");
            exit;
        }

        $id = (int) $_POST['id_produk'];
        $jumlah = max(1, (int) ($_POST['jumlah'] ?? 1));
        $produk = $this->product->detail($id);

        if (!$produk || (int) $produk['stok'] <= 0) {
            header("Location:index.php?page=home");
            exit;
        }

        $jumlah = min($jumlah, (int) $produk['stok']);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['jumlah'] = min(
                (int) $_SESSION['cart'][$id]['jumlah'] + $jumlah,
                (int) $produk['stok']
            );
        } else {
            $_SESSION['cart'][$id] = [
                'id_produk' => $produk['id_produk'],
                'nama_produk' => $produk['nama_produk'],
                'harga' => $produk['harga'],
                'stok' => $produk['stok'],
                'foto' => $produk['foto'],
                'jumlah' => $jumlah
            ];
        }

        header("Location:index.php?page=cart");
        exit;
    }

    public function update()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jumlah'])) {
            foreach ($_POST['jumlah'] as $id => $jumlah) {
                $id = (int) $id;
                if (!isset($_SESSION['cart'][$id])) {
                    continue;
                }

                $stok = (int) $_SESSION['cart'][$id]['stok'];
                $_SESSION['cart'][$id]['jumlah'] = min(max(1, (int) $jumlah), $stok);
            }
        }

        header("Location:index.php?page=cart");
        exit;
    }

    public function remove()
    {
        $this->requireLogin();

        if (isset($_GET['id'], $_SESSION['cart'][(int) $_GET['id']])) {
            unset($_SESSION['cart'][(int) $_GET['id']]);
        }

        header("Location:index.php?page=cart");
        exit;
    }

    public function checkout()
    {
        $this->requireLogin();

        $cartItems = $_SESSION['cart'] ?? [];
        if (!$cartItems) {
            header("Location:index.php?page=cart");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $metodePembayaran = trim($_POST['metode_pembayaran'] ?? 'COD');
            $bankTransfer = trim($_POST['bank_transfer'] ?? '');

            if (!in_array($metodePembayaran, ['COD', 'Transfer Bank'])) {
                $metodePembayaran = 'COD';
            }

            if ($metodePembayaran === 'Transfer Bank' && $bankTransfer === '') {
                $error = "Silakan pilih bank tujuan transfer.";
                require "app/views/cart/checkout.php";
                return;
            }

            $buktiPembayaran = "";
            if ($metodePembayaran === 'Transfer Bank') {
                try {
                    $buktiPembayaran = $this->uploadPaymentProof();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    require "app/views/cart/checkout.php";
                    return;
                }
            }

            $data = [
                'id_user' => $_SESSION['id_user'],
                'nama_penerima' => trim($_POST['nama_penerima'] ?? ''),
                'telepon' => trim($_POST['telepon'] ?? ''),
                'alamat' => trim($_POST['alamat'] ?? ''),
                'catatan' => trim($_POST['catatan'] ?? ''),
                'metode_pembayaran' => $metodePembayaran,
                'bank_transfer' => $bankTransfer,
                'bukti_pembayaran' => $buktiPembayaran,
                'items' => $cartItems
            ];

            $orderId = $this->order->create($data);
            if (!$orderId) {
                $error = "Pesanan gagal dibuat. Silakan coba lagi.";
                require "app/views/cart/checkout.php";
                return;
            }
            unset($_SESSION['cart']);

            header("Location:index.php?page=checkout_success&id=" . $orderId);
            exit;
        }

        require "app/views/cart/checkout.php";
    }

    public function success()
    {
        $this->requireLogin();
        require "app/views/cart/success.php";
    }

    public function history()
    {
        $this->requireLogin();
        $orders = $this->order->getByUser($_SESSION['id_user']);
        require "app/views/cart/history.php";
    }

    public function track()
    {
        $this->requireLogin();
        $orderId = (int) ($_GET['id'] ?? 0);
        $order = $this->order->getByUserAndId($_SESSION['id_user'], $orderId);

        if (!$order) {
            header("Location:index.php?page=order_history");
            exit;
        }

        require "app/views/cart/track.php";
    }

    public function proof()
    {
        $this->requireLogin();

        $orderId = (int) ($_GET['id'] ?? ($_POST['id_pesanan'] ?? 0));
        $order = $this->order->getByUserAndId($_SESSION['id_user'], $orderId);

        if (!$order || ($order['metode_pembayaran'] ?? '') !== 'Transfer Bank') {
            header("Location:index.php?page=order_history");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $fileName = $this->uploadPaymentProof();
                $this->order->updatePaymentProof($_SESSION['id_user'], $orderId, $fileName);
                header("Location:index.php?page=order_history");
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        require "app/views/cart/payment_proof.php";
    }
}
