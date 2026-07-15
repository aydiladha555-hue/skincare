<?php

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../models/Review.php";

class ReviewController
{
    private $review;

    public function __construct()
    {
        $database = new Database();
        $this->review = new Review($database->connect());
    }

    public function create()
    {
        if (!isset($_SESSION['id_user'])) {
            header("Location:index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->review->create([
                'id_user' => $_SESSION['id_user'],
                'id_produk' => (int) $_POST['id_produk'],
                'rating' => max(1, min(5, (int) $_POST['rating'])),
                'komentar' => trim($_POST['komentar'])
            ]);
            header("Location:index.php?page=detail&id=" . (int) $_POST['id_produk']);
            exit;
        }

        header("Location:index.php?page=home");
        exit;
    }
}
