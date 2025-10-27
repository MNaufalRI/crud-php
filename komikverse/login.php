<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $correct_username = 'admin';
    $correct_password = 'password123';

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php?status=loginsuccess');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KomikVerse</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST" action="login.php">
            <h2>Login ke KomikVerse</h2>

            <?php if ($error): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn login-btn">Login</button>
             <p style="margin-top: 20px; font-size: 0.9rem; color: var(--text-secondary);">Hint: Coba username '<strong>admin</strong>' dan password '<strong>password123</strong>'</p>
            
            <p style="margin-top: 25px;">
                <a href="index.php" style="color: var(--text-secondary); font-size: 0.9rem; text-decoration: none;">
                    &larr; Kembali ke Halaman Utama
                </a>
            </p>
            </form>
    </div>
</body>
</html>