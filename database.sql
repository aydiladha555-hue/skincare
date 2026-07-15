CREATE DATABASE IF NOT EXISTS skincare_store
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE skincare_store;

CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nomor_hp VARCHAR(30) DEFAULT '',
    alamat TEXT,
    foto_profil VARCHAR(255) DEFAULT '',
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NULL,
    nama_produk VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    harga INT NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    berat_produk INT NOT NULL DEFAULT 0,
    foto VARCHAR(255) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produk_kategori
        FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
        ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS pesanan (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    nama_penerima VARCHAR(100) NOT NULL,
    telepon VARCHAR(30) NOT NULL,
    alamat TEXT NOT NULL,
    catatan TEXT,
    total INT NOT NULL DEFAULT 0,
    tanggal_pesan DATE NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL DEFAULT 0,
    metode_pembayaran VARCHAR(30) NOT NULL DEFAULT 'COD',
    bank_transfer VARCHAR(50) DEFAULT '',
    bukti_pembayaran VARCHAR(255) DEFAULT '',
    status_pembayaran VARCHAR(50) NOT NULL DEFAULT 'Belum Dibayar',
    status VARCHAR(50) NOT NULL DEFAULT 'Menunggu Pembayaran',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pesanan_user
        FOREIGN KEY (id_user) REFERENCES users(id_user)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS detail_pesanan (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL,
    id_produk INT NULL,
    nama_produk VARCHAR(150) NOT NULL,
    harga INT NOT NULL,
    jumlah INT NOT NULL,
    subtotal INT NOT NULL,
    CONSTRAINT fk_detail_pesanan
        FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)
        ON DELETE CASCADE,
    CONSTRAINT fk_detail_produk
        FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
        ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS review_produk (
    id_review INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_produk INT NOT NULL,
    rating INT NOT NULL DEFAULT 5,
    komentar TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_review_user
        FOREIGN KEY (id_user) REFERENCES users(id_user)
        ON DELETE CASCADE,
    CONSTRAINT fk_review_produk
        FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
        ON DELETE CASCADE
);

DROP PROCEDURE IF EXISTS add_column_if_missing;
DELIMITER //
CREATE PROCEDURE add_column_if_missing(
    IN table_name_value VARCHAR(64),
    IN column_name_value VARCHAR(64),
    IN column_definition_value TEXT
)
BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = table_name_value
          AND COLUMN_NAME = column_name_value
    ) THEN
        SET @alter_sql = CONCAT('ALTER TABLE ', table_name_value, ' ADD COLUMN ', column_definition_value);
        PREPARE alter_stmt FROM @alter_sql;
        EXECUTE alter_stmt;
        DEALLOCATE PREPARE alter_stmt;
    END IF;
END//
DELIMITER ;

CALL add_column_if_missing('users', 'nomor_hp', 'nomor_hp VARCHAR(30) DEFAULT ''''');
CALL add_column_if_missing('users', 'alamat', 'alamat TEXT');
CALL add_column_if_missing('users', 'foto_profil', 'foto_profil VARCHAR(255) DEFAULT ''''');
CALL add_column_if_missing('produk', 'berat_produk', 'berat_produk INT NOT NULL DEFAULT 0');
CALL add_column_if_missing('pesanan', 'nama_penerima', 'nama_penerima VARCHAR(100) DEFAULT ''''');
CALL add_column_if_missing('pesanan', 'telepon', 'telepon VARCHAR(30) DEFAULT ''''');
CALL add_column_if_missing('pesanan', 'alamat', 'alamat TEXT');
CALL add_column_if_missing('pesanan', 'catatan', 'catatan TEXT');
CALL add_column_if_missing('pesanan', 'total', 'total INT NOT NULL DEFAULT 0');
CALL add_column_if_missing('pesanan', 'created_at', 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
CALL add_column_if_missing('pesanan', 'metode_pembayaran', 'metode_pembayaran VARCHAR(30) NOT NULL DEFAULT ''COD''');
CALL add_column_if_missing('pesanan', 'bank_transfer', 'bank_transfer VARCHAR(50) DEFAULT ''''');
CALL add_column_if_missing('pesanan', 'bukti_pembayaran', 'bukti_pembayaran VARCHAR(255) DEFAULT ''''');
CALL add_column_if_missing('pesanan', 'status_pembayaran', 'status_pembayaran VARCHAR(50) NOT NULL DEFAULT ''Belum Dibayar''');
CALL add_column_if_missing('detail_pesanan', 'nama_produk', 'nama_produk VARCHAR(150) DEFAULT ''''');
CALL add_column_if_missing('detail_pesanan', 'harga', 'harga INT NOT NULL DEFAULT 0');
DROP PROCEDURE IF EXISTS add_column_if_missing;

ALTER TABLE pesanan MODIFY status VARCHAR(50) NOT NULL DEFAULT 'Menunggu Pembayaran';
UPDATE pesanan SET total = total_harga WHERE total = 0 AND total_harga IS NOT NULL;

INSERT IGNORE INTO users (username, email, password, role) VALUES
('Admin GlowCare', 'admin@glowcare.test', '$2y$10$H5jOboA/S/mUUPtOhcHKX.h3oLsEY4jVzg8qOpPm5IyfX4N3axPxq', 'admin');

INSERT IGNORE INTO users (username, email, password, nomor_hp, alamat, role) VALUES
('User Demo', 'user@glowcare.test', '$2y$10$H5jOboA/S/mUUPtOhcHKX.h3oLsEY4jVzg8qOpPm5IyfX4N3axPxq', '081234567890', 'Jl. Demo Skincare No. 1', 'user');

UPDATE users
SET role='admin',
    password='$2y$10$H5jOboA/S/mUUPtOhcHKX.h3oLsEY4jVzg8qOpPm5IyfX4N3axPxq'
WHERE email IN ('admin@gmail.com','admin123@gmail.com','admin@glowcare.test');

INSERT IGNORE INTO kategori (id_kategori, nama_kategori) VALUES
(1, 'Cleanser'),
(2, 'Serum'),
(3, 'Moisturizer'),
(4, 'Sunscreen');

INSERT IGNORE INTO produk (id_produk, id_kategori, nama_produk, deskripsi, harga, stok, berat_produk, foto) VALUES
(1, 1, 'Gentle Hydrating Cleanser', 'Pembersih wajah lembut untuk kulit normal hingga kering.', 89000, 24, 120, ''),
(2, 2, 'Niacinamide Bright Serum', 'Serum ringan untuk membantu meratakan tampilan warna kulit.', 129000, 18, 60, ''),
(3, 3, 'Barrier Repair Moisturizer', 'Pelembap nyaman untuk menjaga kelembapan skin barrier.', 115000, 20, 100, ''),
(4, 4, 'Daily UV Aqua Sunscreen SPF 50', 'Sunscreen ringan untuk pemakaian harian.', 99000, 30, 80, '');
