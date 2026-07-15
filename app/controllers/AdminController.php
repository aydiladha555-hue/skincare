<?php

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../models/Category.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../models/User.php";

class AdminController
{
    private $category;
    private $product;
    private $order;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->category = new Category($db);
        $this->product = new Product($db);
        $this->order = new Order($db);
        $this->user = new User($db);
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
            header("Location:index.php?page=login");
            exit;
        }
    }

    public function categories()
    {
        $this->requireAdmin();
        $categories = $this->category->getAll();
        require "app/views/admin/categories.php";
    }

    public function categoryCreate()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama = trim($_POST['nama_kategori']);
            if ($nama !== '') {
                $this->category->insert($nama);
            }
            header("Location:index.php?page=admin_categories");
            exit;
        }
        $kategori = null;
        require "app/views/admin/category_form.php";
    }

    public function categoryEdit()
    {
        $this->requireAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $kategori = $this->category->getById($id);
        if (!$kategori) {
            header("Location:index.php?page=admin_categories");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama = trim($_POST['nama_kategori']);
            if ($nama !== '') {
                $this->category->update($id, $nama);
            }
            header("Location:index.php?page=admin_categories");
            exit;
        }
        require "app/views/admin/category_form.php";
    }

    public function categoryDelete()
    {
        $this->requireAdmin();
        $this->category->delete((int) ($_GET['id'] ?? 0));
        header("Location:index.php?page=admin_categories");
        exit;
    }

    public function orders()
    {
        $this->requireAdmin();
        $orders = $this->order->getAll();
        require "app/views/admin/orders.php";
    }

    public function orderDetail()
    {
        $this->requireAdmin();
        $order = $this->order->getById((int) ($_GET['id'] ?? 0));
        if (!$order) {
            header("Location:index.php?page=admin_orders");
            exit;
        }
        $items = $this->order->getItems($order['id_pesanan']);
        require "app/views/admin/order_detail.php";
    }

    public function orderStatus()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->order->updateStatus((int) $_POST['id_pesanan'], $_POST['status']);
        }
        header("Location:index.php?page=admin_order_detail&id=" . (int) $_POST['id_pesanan']);
        exit;
    }

    public function payments()
    {
        $this->requireAdmin();
        $orders = $this->order->getPaymentOrders();
        require "app/views/admin/payments.php";
    }

    public function paymentStatus()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->order->updatePaymentStatus((int) $_POST['id_pesanan'], $_POST['status_pembayaran']);
        }
        header("Location:index.php?page=admin_payments");
        exit;
    }

    public function users()
    {
        $this->requireAdmin();
        $users = $this->user->getAll();
        require "app/views/admin/users.php";
    }

    public function userRole()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->updateRole((int) $_POST['id_user'], $_POST['role']);
        }
        header("Location:index.php?page=admin_users");
        exit;
    }

    public function userDelete()
    {
        $this->requireAdmin();
        $this->user->delete((int) ($_GET['id'] ?? 0));
        header("Location:index.php?page=admin_users");
        exit;
    }

    public function stock()
    {
        $this->requireAdmin();
        $products = $this->product->getAll();
        $lowStock = $this->product->lowStock();
        require "app/views/admin/stock.php";
    }

    public function stockUpdate()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->product->updateStock((int) $_POST['id_produk'], (int) $_POST['stok']);
        }
        header("Location:index.php?page=admin_stock");
        exit;
    }

    public function reports()
    {
        $this->requireAdmin();
        $orders = $this->order->getAll();
        $totalRevenue = $this->order->totalRevenue();
        $bestSellers = $this->order->bestSellers();
        $salesByStatus = $this->order->salesByStatus();
        require "app/views/admin/reports.php";
    }
}
