<?php

class Database
{
    private $host = "localhost";
    private $dbname = "skincare_store";
    private $username = "root";
    private $password = "";

    private $conn;

    public function connect()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn;

        } catch (PDOException $e) {
            die("Koneksi gagal : " . $e->getMessage());
        }
    }
}
