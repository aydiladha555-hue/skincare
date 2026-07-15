<?php

class Order
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ==========================
    // MEMBUAT PESANAN
    // ==========================
    public function create($data)
    {
        $total = 0;

        foreach ($data['items'] as $item) {
            $total += (int)$item['harga'] * (int)$item['jumlah'];
        }

        try {

            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("
                INSERT INTO pesanan
                (id_user,nama_penerima,telepon,alamat,catatan,total,tanggal_pesan,total_harga,metode_pembayaran,bank_transfer,bukti_pembayaran,status_pembayaran,status)
                VALUES
                (?,?,?,?,?,?,CURDATE(),?,?,?,?,?,?)
            ");

            $metodePembayaran = $data['metode_pembayaran'] ?? 'COD';
            $bankTransfer = $metodePembayaran === 'Transfer Bank' ? ($data['bank_transfer'] ?? '') : '';
            $buktiPembayaran = $metodePembayaran === 'Transfer Bank' ? ($data['bukti_pembayaran'] ?? '') : '';
            $statusPembayaran = $metodePembayaran === 'COD' ? 'Bayar di Tempat' : 'Menunggu Konfirmasi';
            $statusPesanan = $metodePembayaran === 'COD' ? 'Diproses' : 'Menunggu Pembayaran';

            $stmt->execute([
                $data['id_user'],
                $data['nama_penerima'],
                $data['telepon'],
                $data['alamat'],
                $data['catatan'],
                $total,
                $total,
                $metodePembayaran,
                $bankTransfer,
                $buktiPembayaran,
                $statusPembayaran,
                $statusPesanan
            ]);

            $idPesanan = $this->conn->lastInsertId();

            $detail = $this->conn->prepare("
                INSERT INTO detail_pesanan
                (id_pesanan,id_produk,nama_produk,harga,jumlah,subtotal)
                VALUES (?,?,?,?,?,?)
            ");

            $stok = $this->conn->prepare("
                UPDATE produk
                SET stok = stok - ?
                WHERE id_produk = ?
            ");

            foreach ($data['items'] as $item) {

                $subtotal = $item['harga'] * $item['jumlah'];

                $detail->execute([
                    $idPesanan,
                    $item['id_produk'],
                    $item['nama_produk'],
                    $item['harga'],
                    $item['jumlah'],
                    $subtotal
                ]);

                $stok->execute([
                    $item['jumlah'],
                    $item['id_produk']
                ]);
            }

            $this->conn->commit();

            return $idPesanan;

        } catch (Exception $e) {

            $this->conn->rollBack();

            return false;
        }
    }

    // ==========================
    // ADMIN
    // ==========================

    public function getAll()
    {
        $sql = "
            SELECT
                p.*,
                u.username,
                u.email
            FROM pesanan p
            JOIN users u
            ON p.id_user=u.id_user
            ORDER BY p.created_at DESC
        ";

        return $this->conn
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT
                p.*,
                u.username,
                u.email
            FROM pesanan p
            JOIN users u
            ON p.id_user=u.id_user
            WHERE p.id_pesanan=?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItems($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM detail_pesanan
            WHERE id_pesanan=?
        ");

        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->conn->prepare("
            UPDATE pesanan
            SET status=?
            WHERE id_pesanan=?
        ");

        return $stmt->execute([$status, $id]);
    }

    public function getPaymentOrders()
    {
        $sql = "
            SELECT
                p.*,
                u.username,
                u.email
            FROM pesanan p
            JOIN users u ON p.id_user=u.id_user
            ORDER BY p.created_at DESC
        ";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePaymentStatus($id, $status)
    {
        $stmt = $this->conn->prepare("
            UPDATE pesanan
            SET status_pembayaran=?
            WHERE id_pesanan=?
        ");

        return $stmt->execute([$status, $id]);
    }

    public function updatePaymentProof($idUser, $orderId, $fileName)
    {
        $stmt = $this->conn->prepare("
            UPDATE pesanan
            SET bukti_pembayaran=?,
                status_pembayaran='Menunggu Konfirmasi'
            WHERE id_user=? AND id_pesanan=? AND metode_pembayaran='Transfer Bank'
        ");

        return $stmt->execute([$fileName, $idUser, $orderId]);
    }

    // ==========================
    // USER
    // ==========================

    public function getByUser($idUser)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM pesanan
            WHERE id_user=?
            ORDER BY created_at DESC
        ");

        $stmt->execute([$idUser]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserAndId($idUser, $orderId)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM pesanan
            WHERE id_user=? AND id_pesanan=?
        ");

        $stmt->execute([$idUser, $orderId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================
    // DASHBOARD
    // ==========================

    public function totalRevenue()
    {
        $stmt = $this->conn->query("
            SELECT
            COALESCE(SUM(total),0)
            FROM pesanan
            WHERE status!='Dibatalkan'
        ");

        return $stmt->fetchColumn();
    }

    public function salesByStatus()
    {
        $stmt = $this->conn->query("
            SELECT
                status,
                COUNT(*) jumlah,
                COALESCE(SUM(total),0) total
            FROM pesanan
            GROUP BY status
            ORDER BY jumlah DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bestSellers()
    {
        $stmt = $this->conn->query("
            SELECT
                nama_produk,
                SUM(jumlah) total_terjual,
                SUM(subtotal) total_pendapatan
            FROM detail_pesanan
            GROUP BY nama_produk
            ORDER BY total_terjual DESC
            LIMIT 10
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function latestOrders($limit = 5)
    {
        $stmt = $this->conn->prepare("
            SELECT
                p.*,
                u.username
            FROM pesanan p
            JOIN users u
            ON p.id_user=u.id_user
            ORDER BY p.created_at DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function monthlySales()
    {
        $stmt = $this->conn->query("
            SELECT
                MONTH(created_at) bulan,
                SUM(total) total
            FROM pesanan
            WHERE status!='Dibatalkan'
            GROUP BY MONTH(created_at)
            ORDER BY MONTH(created_at)
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByUser($idUser)
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*)
            FROM pesanan
            WHERE id_user=?
        ");

        $stmt->execute([$idUser]);

        return $stmt->fetchColumn();
    }

    public function latestByUser($idUser, $limit = 5)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM pesanan
            WHERE id_user=?
            ORDER BY created_at DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, (int)$idUser, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // TAMBAHAN
    // ==========================

    public function totalOrder()
    {
        return $this->conn
            ->query("SELECT COUNT(*) FROM pesanan")
            ->fetchColumn();
    }

    public function orderToday()
    {
        return $this->conn
            ->query("
                SELECT COUNT(*)
                FROM pesanan
                WHERE DATE(created_at)=CURDATE()
            ")
            ->fetchColumn();
    }

    public function revenueToday()
    {
        return $this->conn
            ->query("
                SELECT
                COALESCE(SUM(total),0)
                FROM pesanan
                WHERE DATE(created_at)=CURDATE()
            ")
            ->fetchColumn();
    }

    public function recentActivities($limit = 10)
    {
        $stmt = $this->conn->prepare("
            SELECT
                p.id_pesanan,
                u.username,
                p.status,
                p.total,
                p.created_at
            FROM pesanan p
            JOIN users u
            ON p.id_user=u.id_user
            ORDER BY p.created_at DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
