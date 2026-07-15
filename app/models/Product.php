<?php

class Product
{
    private $conn;
    private $table = "produk";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ==========================
    // ADMIN
    // ==========================

    public function getAll()
    {
        $sql = "SELECT p.*, k.nama_kategori
                FROM produk p
                LEFT JOIN kategori k
                ON p.id_kategori = k.id_kategori
                ORDER BY p.id_produk DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM produk WHERE id_produk=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $sql = "INSERT INTO produk
                (id_kategori,nama_produk,deskripsi,harga,stok,berat_produk,foto)
                VALUES(?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([

            $data['id_kategori'],
            $data['nama_produk'],
            $data['deskripsi'],
            $data['harga'],
            $data['stok'],
            $data['berat_produk'],
            $data['foto']

        ]);
    }

    public function update($data)
    {
        $sql = "UPDATE produk SET

                id_kategori=?,
                nama_produk=?,
                deskripsi=?,
                harga=?,
                stok=?,
                berat_produk=?,
                foto=?

                WHERE id_produk=?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([

            $data['id_kategori'],
            $data['nama_produk'],
            $data['deskripsi'],
            $data['harga'],
            $data['stok'],
            $data['berat_produk'],
            $data['foto'],
            $data['id_produk']

        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM produk WHERE id_produk=?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$id]);
    }

    // ==========================
    // USER
    // ==========================

    public function getAllUser()
    {
        $where = [];
        $params = [];

        if (!empty($_GET['q'])) {
            $where[] = "p.nama_produk LIKE ?";
            $params[] = "%" . $_GET['q'] . "%";
        }

        if (!empty($_GET['kategori'])) {
            $where[] = "p.id_kategori = ?";
            $params[] = $_GET['kategori'];
        }

        $order = "p.id_produk DESC";
        if (($_GET['sort'] ?? '') == 'harga_asc') {
            $order = "p.harga ASC";
        } elseif (($_GET['sort'] ?? '') == 'harga_desc') {
            $order = "p.harga DESC";
        }

        $sql = "SELECT p.*,k.nama_kategori
                FROM produk p
                LEFT JOIN kategori k ON p.id_kategori=k.id_kategori";

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY " . $order;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lowStock($limit = 5)
    {
        $stmt = $this->conn->prepare("SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori k ON p.id_kategori=k.id_kategori WHERE p.stok <= ? ORDER BY p.stok ASC");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStock($id, $stok)
    {
        $stmt = $this->conn->prepare("UPDATE produk SET stok=? WHERE id_produk=?");
        return $stmt->execute([$stok, $id]);
    }

    public function detail($id)
    {
        $sql = "SELECT p.*,k.nama_kategori

                FROM produk p

                LEFT JOIN kategori k

                ON p.id_kategori=k.id_kategori

                WHERE p.id_produk=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
