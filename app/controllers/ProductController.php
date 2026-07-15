<?php

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Category.php";
require_once __DIR__ . "/../models/Review.php";

class ProductController
{
    private $db;
    private $product;
    private $category;
    private $review;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();

        $this->product = new Product($this->db);

        $this->category = new Category($this->db);
        $this->review = new Review($this->db);
    }

    // ==========================
    // ADMIN
    // ==========================

    private function requireLogin()
    {
        if (!isset($_SESSION['id_user'])) {
            header("Location:index.php?page=login");
            exit;
        }
    }

    private function requireAdmin()
    {
        $this->requireLogin();

        if ($_SESSION['role'] != "admin") {
            header("Location:index.php?page=home");
            exit;
        }
    }

    private function uploadProductPhoto($fieldName, $oldPhoto = "")
    {
        if (empty($_FILES[$fieldName]['name'])) {
            return $oldPhoto;
        }

        if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload foto gagal. Silakan pilih ulang file gambar.");
        }

        if ($_FILES[$fieldName]['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran foto maksimal 2MB.");
        }

        $imageInfo = getimagesize($_FILES[$fieldName]['tmp_name']);
        if ($imageInfo === false) {
            throw new Exception("File harus berupa gambar JPG, PNG, atau WEBP.");
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($imageInfo['mime'], $allowedTypes)) {
            throw new Exception("Format foto hanya boleh JPG, PNG, atau WEBP.");
        }

        $folder = "uploads/products/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $extension = image_type_to_extension($imageInfo[2], false);
        $fileName = time() . "_" . bin2hex(random_bytes(4)) . "." . $extension;

        if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $folder . $fileName)) {
            throw new Exception("Foto tidak bisa disimpan ke folder uploads/products.");
        }

        if ($oldPhoto && is_file($folder . $oldPhoto)) {
            unlink($folder . $oldPhoto);
        }

        return $fileName;
    }

    public function index()
    {
        $this->requireAdmin();

        $products = $this->product->getAll();

        require "app/views/products/index.php";
    }

    public function create()
    {
        $this->requireAdmin();

        $categories = $this->category->getAll();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            try {
                $this->validateProductInput($_POST);
                $foto = $this->uploadProductPhoto('foto');
            } catch (Exception $e) {
                $error = $e->getMessage();
                require "app/views/products/create.php";
                return;
            }

            $data = [

                'id_kategori' => $_POST['id_kategori'],
                'nama_produk' => $_POST['nama_produk'],
                'deskripsi' => $_POST['deskripsi'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok'],
                'berat_produk' => $_POST['berat_produk'],
                'foto' => $foto

            ];

            $this->product->insert($data);

            header("Location:index.php?page=products");

            exit;
        }

        require "app/views/products/create.php";
    }

    public function edit()
    {
        $this->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        $produk = $this->product->getById($id);

        if (!$produk) {
            header("Location:index.php?page=products");
            exit;
        }

        $categories = $this->category->getAll();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            try {
                $this->validateProductInput($_POST);
                $foto = $this->uploadProductPhoto('foto', $produk['foto']);
            } catch (Exception $e) {
                $error = $e->getMessage();
                require "app/views/products/edit.php";
                return;
            }

            $data = [

                'id_produk' => $id,
                'id_kategori' => $_POST['id_kategori'],
                'nama_produk' => $_POST['nama_produk'],
                'deskripsi' => $_POST['deskripsi'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok'],
                'berat_produk' => $_POST['berat_produk'],
                'foto' => $foto

            ];

            $this->product->update($data);

            header("Location:index.php?page=products");

            exit;
        }

        require "app/views/products/edit.php";
    }

    public function delete()
    {
        $this->requireAdmin();

        $this->product->delete((int) ($_GET['id'] ?? 0));

        header("Location:index.php?page=products");

        exit;
    }

    // ==========================
    // USER
    // ==========================

    public function home()
    {
        $this->requireLogin();

        $products = $this->product->getAllUser();
        $categories = $this->category->getAll();

        require "app/views/home.php";
    }

    public function detail()
    {
        $this->requireLogin();

        if (!isset($_GET['id'])) {

            header("Location:index.php?page=home");

            exit;
        }

        $produk = $this->product->detail($_GET['id']);

        if (!$produk) {
            header("Location:index.php?page=home");
            exit;
        }
        $reviews = $this->review->getByProduct($produk['id_produk']);

        require "app/views/products/detail.php";
    }

    private function validateProductInput($input)
    {
        $required = ['id_kategori', 'nama_produk', 'harga', 'stok', 'berat_produk'];
        foreach ($required as $field) {
            if (!isset($input[$field]) || trim((string) $input[$field]) === '') {
                throw new Exception("Field produk wajib diisi lengkap.");
            }
        }

        if (!is_numeric($input['harga']) || (int) $input['harga'] < 0) {
            throw new Exception("Harga harus berupa angka dan tidak boleh minus.");
        }

        if (!is_numeric($input['stok']) || (int) $input['stok'] < 0) {
            throw new Exception("Stok harus berupa angka dan tidak boleh minus.");
        }

        if (!is_numeric($input['berat_produk']) || (int) $input['berat_produk'] < 0) {
            throw new Exception("Berat produk harus berupa angka dan tidak boleh minus.");
        }
    }
}
