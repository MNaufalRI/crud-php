# KomikVerse - Landing Page & Dashboard CRUD

Ini adalah aplikasi web prototipe "KomikVerse" yang terdiri dari dua bagian:
1.  **Landing Page (index.php)**: Halaman publik yang menampilkan informasi komik, mengambil data dari API eksternal (Jikan API).
2.  **Dashboard Admin (dashboard.php)**: Halaman privat yang dilindungi login (sistem login berbasis session), dilengkapi dengan fungsionalitas **CRUD (Create, Read, Update, Delete)** penuh untuk mengelola data komik internal di database.

Aplikasi ini dibangun menggunakan **PHP Native (PHP 8.0+)** dan **PDO** untuk koneksi database, tanpa menggunakan framework atau ORM.

## Fitur yang Tersedia

### Fitur Publik (index.php)
* Landing page statis dengan beberapa bagian (Home, Popular, Kategori, About).
* Pengambilan data komik populer & kategori secara dinamis dari Jikan API (via `fetch` Javascript).
* Sidebar navigasi.
* Toggle Light/Dark mode (disimpan di LocalStorage).

### Fitur Dashboard Admin (CRUD)
* **Authentication**: Login (`login.php`) dan Logout (`logout.php`) sederhana berbasis Session. Halaman dashboard terlindungi.
* **Create**: Form tambah data komik (`tambah_komik.php`) dengan validasi di sisi server.
* **Read (List)**: Tampilan tabel data komik (`dashboard.php`) yang diurutkan berdasarkan tanggal dibuat (terbaru dulu).
* **Read (Detail)**: Halaman detail per komik (`detail_komik.php`).
* **Update**: Form edit (`edit_komik.php`) dengan data yang sudah terisi (pre-filled).
* **Delete**: Tombol hapus (`hapus_komik.php`) dengan konfirmasi Javascript (`confirm()`).
* **Pencarian**: Fitur pencarian berdasarkan *Judul* atau *Penulis* komik.
* **Pagination**: Daftar data dibagi menjadi beberapa halaman (5 data per halaman).
* **Keamanan**:
    * **SQL Injection**: Dicegah menggunakan **PDO Prepared Statements** di semua query database.
    * **XSS**: Dicegah menggunakan sanitasi output (fungsi `htmlspecialchars()`) sebelum menampilkan data ke HTML.
* **Error Handling**: Pesan error yang informatif ditampilkan, dan detail teknis (stack trace) disembunyikan di mode production (diatur via `config.php`).

## Kebutuhan Sistem

* **PHP 8.0** atau lebih baru.
* **Database**: MySQL atau MariaDB.
* **Web Server**: Apache, Nginx, atau server lokal seperti XAMPP / Laragon.
* **Ekstensi PHP**: `pdo_mysql`.
* **Browser**: Browser modern dengan Javascript aktif.

## Cara Instalasi dan Konfigurasi

1.  **Clone atau Download Proyek**
    Salin semua file proyek ke web root server lokal (misal: `C:\laragon\www\komikverse` atau `C:\xampp\htdocs\komikverse`).

2.  **Buat Database**
    * Buka phpMyAdmin (atau klien database lainnya).
    * Buat database baru. Contohnya saya membuat database dengan nama `komikverse_db`.
    * Impor file `schema.sql` ke dalam database tersebut. Ini akan membuat tabel `komik`.

3.  **Konfigurasi Environment**
    * Buat salinan dari file `config.example.php` (jika ada) atau buat file baru bernama `config.php` di root proyek.
    * Isi file `config.php` dengan kredensial database Anda.

4.  **Jalankan Aplikasi**
    * Akses proyek dari browser (misal: `http://localhost/komikverse/`).
    * Untuk mengakses dashboard, pergi ke `http://localhost/komikverse/login.php`.
    * Gunakan kredensial default:
        * **Username**: `admin`
        * **Password**: `password123`
        * (Kredensial ini di-hardcode di `login.php`).

## Struktur Folder

Proyek ini menggunakan struktur file "flat" (semua file utama ada di root) untuk kesederhanaan.
