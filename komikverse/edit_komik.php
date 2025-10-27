<?php
$title = 'Edit Komik'; 
require_once 'dashboard_header.php'; 

$errors = [];
$komik = null;

$id = $_GET['id'] ?? null;
if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    $_SESSION['message'] = 'ID komik tidak valid.';
    $_SESSION['message_type'] = 'danger';
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form_id = $_POST['id'] ?? null;
    $judul = trim($_POST['judul'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($form_id != $id) {
        $errors[] = 'ID tidak cocok. Terjadi kesalahan.';
    }
    if (empty($judul)) {
        $errors[] = 'Judul tidak boleh kosong.';
    }


    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE komik SET judul = ?, penulis = ?, deskripsi = ? WHERE id = ?");
            $stmt->execute([$judul, $penulis, $deskripsi, $id]);
            
            $_SESSION['message'] = 'Data komik berhasil diperbarui.';
            $_SESSION['message_type'] = 'success';
            header('Location: dashboard.php');
            exit;
            
        } catch (PDOException $e) {
            throw $e;
        }
    }
    

    $komik = ['id' => $id, 'judul' => $judul, 'penulis' => $penulis, 'deskripsi' => $deskripsi];

} else {
    $stmt = $pdo->prepare("SELECT * FROM komik WHERE id = ?");
    $stmt->execute([$id]);
    $komik = $stmt->fetch();

    if (!$komik) {
        $_SESSION['message'] = 'Data komik tidak ditemukan.';
        $_SESSION['message_type'] = 'warning';
        header('Location: dashboard.php');
        exit;
    }
}
?>

<h2>Edit Komik: <?php echo e($komik['judul']); ?></h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>Gagal menyimpan:</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="form-container">
    <form class="login-form" method="POST" action="edit_komik.php?id=<?php echo e($id); ?>" style="max-width: 800px; text-align: left;">
        <input type="hidden" name="id" value="<?php echo e($komik['id']); ?>">
        
        <div class="form-group">
            <label for="judul">Judul Komik *</label>
            <input type="text" id="judul" name="judul" value="<?php echo e($komik['judul'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" name="penulis" value="<?php echo e($komik['penulis'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="6"><?php echo e($komik['deskripsi'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn login-btn">Update</button>
        <a href="dashboard.php" class="btn btn-secondary" style="display: block; width: 100%; margin-top: 10px; text-align: center;">Batal</a>
    </form>
</div>

<?php
require_once 'dashboard_footer.php'; 
?>