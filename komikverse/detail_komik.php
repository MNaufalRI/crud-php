<?php
require_once 'koneksi.php'; 

$id = $_GET['id'] ?? null;
if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    $_SESSION['message'] = 'ID komik tidak valid.';
    $_SESSION['message_type'] = 'danger';
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM komik WHERE id = ?");
$stmt->execute([$id]);
$komik = $stmt->fetch();

if (!$komik) {
    $_SESSION['message'] = 'Data komik tidak ditemukan.';
    $_SESSION['message_type'] = 'warning';
    header('Location: dashboard.php');
    exit;
}

$title = 'Detail: ' . e($komik['judul']);
require_once 'dashboard_header.php';
?>

<div class="detail-container">
    <h2><?php echo e($komik['judul']); ?></h2>
    
    <div class="detail-meta">
        <strong>Penulis:</strong> <?php echo e($komik['penulis'] ?: 'N/A'); ?><br>
        <strong>ID:</strong> <?php echo e($komik['id']); ?><br>
        <strong>Dibuat:</strong> <?php echo e($komik['created_at']); ?><br>
        <strong>Diperbarui:</strong> <?php echo e($komik['updated_at']); ?>
    </div>
    
    <hr>
    
    <div class="detail-deskripsi">
        <h3>Deskripsi</h3>
        <p><?php echo nl2br(e($komik['deskripsi'] ?: 'Tidak ada deskripsi.')); ?></p>
    </div>
    
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Daftar</a>
    <a href="edit_komik.php?id=<?php echo e($komik['id']); ?>" class="btn btn-primary" style="margin-left: 10px;">Edit Komik Ini</a>
</div>


<?php
require_once 'dashboard_footer.php'; // Memuat footer
?>