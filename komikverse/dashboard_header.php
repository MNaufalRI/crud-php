<?php
require_once 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Dashboard'); ?> - KomikVerse</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo $_COOKIE['theme'] ?? 'dark'; ?>-mode">
    
    <header class="dashboard-header">
        <div class="container">
            <h1 class="logo">Dashboard KomikVerse</h1>
            <nav>
                <a href="dashboard.php">Daftar Komik</a>
                <a href="index.php" target="_blank">Lihat Landing Page</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </nav>
        </div>
    </header>

    <main class="dashboard-container">