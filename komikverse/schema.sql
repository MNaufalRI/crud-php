-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS komikverse_db;
USE komikverse_db;

-- Tabel untuk menampung data komik
CREATE TABLE IF NOT EXISTS komik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    penulis VARCHAR(255) DEFAULT NULL,
    deskripsi TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Catatan: Tabel user tidak dibuat karena login Anda masih hardcoded
-- di login.php ('admin' / 'password123'). CRUD ini akan
-- fokus pada pengelolaan data 'komik'.