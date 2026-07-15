<?php

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../models/Dashboard.php";
require_once __DIR__ . "/../models/Order.php";
require_once __DIR__ . "/../models/Product.php";

class DashboardController
{
    private $dashboard;
    private $order;
    private $product;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->dashboard = new Dashboard($db);
        $this->order = new Order($db);
        $this->product = new Product($db);
    }

    public function admin()
    {
        if (!isset($_SESSION['id_user'])) {
            header("Location:index.php?page=login");
            exit;
        }

        if ($_SESSION['role'] != "admin") {
            header("Location:index.php?page=dashboard_user");
            exit;
        }

        $jumlahProduk = $this->dashboard->jumlahProduk();
        $jumlahKategori = $this->dashboard->jumlahKategori();
        $jumlahPesanan = $this->dashboard->jumlahPesanan();
        $jumlahUser = $this->dashboard->jumlahUser();
        $totalPendapatan = $this->order->totalRevenue();
        $statistikPenjualan = $this->order->salesByStatus();
        $stokMenipis = $this->product->lowStock();

        require "app/views/dashboard/admin.php";
    }

    public function user()
    {
        if (!isset($_SESSION['id_user'])) {
            header("Location:index.php?page=login");
            exit;
        }

        require "app/views/dashboard/user.php";
    }
}
