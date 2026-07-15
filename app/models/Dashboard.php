<?php

class Dashboard
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function jumlahProduk()
    {
        return $this->countTable('produk');
    }

    public function jumlahKategori()
    {
        return $this->countTable('kategori');
    }

    public function jumlahPesanan()
    {
        return $this->countTable('pesanan');
    }

    public function jumlahUser()
    {
        return $this->countTable('users');
    }

    private function countTable($table)
    {
        if (!$this->tableExists($table)) {
            return 0;
        }

        $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $table);
        return $stmt->fetchColumn();
    }

    private function tableExists($table)
    {
        try {
            $stmt = $this->conn->prepare("SHOW TABLES LIKE ?");
            $stmt->execute([$table]);
            return (bool) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return false;
        }
    }
}
