<?php
require_once 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    $_SESSION['message'] = 'ID komik tidak valid.';
    $_SESSION['message_type'] = 'danger';
    header('Location: dashboard.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM komik WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = 'Komik berhasil dihapus.';
        $_SESSION['message_type'] = 'success';
    } else {
        // Jika ID tidak ditemukan
        $_SESSION['message'] = 'Gagal menghapus: Komik tidak ditemukan.';
        $_SESSION['message_type'] = 'warning';
    }

} catch (PDOException $e) {
    throw $e;
}

header('Location: dashboard.php');
exit;