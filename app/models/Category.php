<?php

class Category
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM kategori ORDER BY nama_kategori ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM kategori WHERE id_kategori=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($nama)
    {
        $stmt = $this->conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
        return $stmt->execute([$nama]);
    }

    public function update($id, $nama)
    {
        $stmt = $this->conn->prepare("UPDATE kategori SET nama_kategori=? WHERE id_kategori=?");
        return $stmt->execute([$nama, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM kategori WHERE id_kategori=?");
        return $stmt->execute([$id]);
    }
}
