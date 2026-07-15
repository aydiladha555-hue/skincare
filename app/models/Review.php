<?php

class Review
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByProduct($productId)
    {
        $stmt = $this->conn->prepare("SELECT r.*, u.username FROM review_produk r JOIN users u ON r.id_user=u.id_user WHERE r.id_produk=? ORDER BY r.id_review DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO review_produk (id_user, id_produk, rating, komentar) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['id_user'],
            $data['id_produk'],
            $data['rating'],
            $data['komentar']
        ]);
    }
}
