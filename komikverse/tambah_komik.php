<?php
$title = 'Tambah Komik Baru'; 
require_once 'dashboard_header.php'; 

$errors = [];
$input = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input['judul'] = trim($_POST['judul'] ?? '');
    $input['penulis'] = trim($_POST['penulis'] ?? '');
    $input['deskripsi'] = trim($_POST['deskripsi'] ?? '');

    if (empty($input['judul'])) {
        $errors[] = 'Judul tidak boleh kosong.';
    }
    if (strlen($input['judul']) > 255) {
        $errors[] = 'Judul terlalu panjang (maks 255 karakter).';
    }
    if (strlen($input['penulis']) > 255) {
        $errors[] = 'Nama penulis terlalu panjang (maks 255 karakter).';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO komik (judul, penulis, deskripsi) VALUES (?, ?, ?)");
            $stmt->execute([$input['judul'], $input['penulis'], $input['deskripsi']]);
            
            $_SESSION['message'] = 'Komik baru berhasil ditambahkan.';
            $_SESSION['message_type'] = 'success';
            header('Location: dashboard.php');
            exit;
            
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
?>

<h2>Tambah Komik Baru</h2>

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
    <form class="login-form" method="POST" action="tambah_komik.php" style="max-width: 800px; text-align: left;">
        <div class="form-group">
            <label for="judul">Judul Komik *</label>
            <input type="text" id="judul" name="judul" value="<?php echo e($input['judul'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" name="penulis" value="<?php echo e($input['penulis'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="6"><?php echo e($input['deskripsi'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn login-btn">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary" style="display: block; width: 100%; margin-top: 10px; text-align: center;">Batal</a>
    </form>
</div>

<?php
require_once 'dashboard_footer.php'; 
?>