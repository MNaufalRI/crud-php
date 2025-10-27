<?php
$title = 'Daftar Komik'; 
require_once 'dashboard_header.php'; 

// --- LOGIKA PENCARIAN ---
$search = $_GET['search'] ?? '';
$whereClause = '';
$params = [];

if (!empty($search)) {
    $whereClause = " WHERE (judul LIKE ? OR penulis LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// --- LOGIKA PAGINATION ---
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); 
$limit = 5; 
$offset = ($page - 1) * $limit;

// --- AMBIL DATA ---
$stmt_count = $pdo->prepare("SELECT COUNT(id) FROM komik" . $whereClause);
$stmt_count->execute($params);
$total_records = $stmt_count->fetchColumn();
$total_pages = ceil($total_records / $limit);

$query = "SELECT id, judul, penulis, created_at FROM komik" . $whereClause . " ORDER BY created_at DESC LIMIT ? OFFSET ?";

$params[] = $limit;
$params[] = $offset;

$stmt = $pdo->prepare($query);

$param_index = 1;
foreach ($params as $value) {
    $param_type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $stmt->bindValue($param_index, $value, $param_type);
    $param_index++;
}

$stmt->execute();
$daftar_komik = $stmt->fetchAll();

?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo e($_SESSION['message_type']); ?>">
        <?php echo e($_SESSION['message']); ?>
        <?php 
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        ?>
    </div>
<?php endif; ?>

<div class="dashboard-page-header">
    <h2>Manajemen Komik (Total: <?php echo $total_records; ?>)</h2>
    <div class="header-actions">
        <form method="GET" action="dashboard.php" class="search-form">
            <input type="text" name="search" placeholder="Cari judul atau penulis..." value="<?php echo e($search); ?>">
            <button type="submit">Cari</button>
        </form>
        <a href="tambah_komik.php" class="btn btn-primary">Tambah Komik Baru</a>
    </div>
</div>

<div class="table-container">
    <table class="crud-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftar_komik)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">
                        <?php if (!empty($search)): ?>
                            Tidak ada komik yang cocok dengan pencarian "<?php echo e($search); ?>".
                        <?php else: ?>
                            Belum ada data komik.
                        <?php endif; ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($daftar_komik as $komik): ?>
                <tr>
                    <td><?php echo e($komik['id']); ?></td>
                    <td><?php echo e($komik['judul']); ?></td>
                    <td><?php echo e($komik['penulis']); ?></td>
                    <td><?php echo e($komik['created_at']); ?></td>
                    <td class="action-links">
                        <a href="detail_komik.php?id=<?php echo e($komik['id']); ?>" class="btn-action btn-detail">Detail</a>
                        <a href="edit_komik.php?id=<?php echo e($komik['id']); ?>" class="btn-action btn-edit">Edit</a>
                        <a href="hapus_komik.php?id=<?php echo e($komik['id']); ?>" 
                           class="btn-action btn-hapus" 
                           data-judul="<?php echo e($komik['judul']); ?>">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($total_pages > 1): ?>
    <nav class="pagination">
        <ul>
            <?php if ($page > 1): ?>
                <li><a href="?page=<?php echo $page - 1; ?>&search=<?php echo e($search); ?>">«</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a href="?page=<?php echo $i; ?>&search=<?php echo e($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li><a href="?page=<?php echo $page + 1; ?>&search=<?php echo e($search); ?>">»</a></li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>


<?php
require_once 'dashboard_footer.php'; 
?>