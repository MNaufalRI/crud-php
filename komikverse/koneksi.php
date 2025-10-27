<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

// === ERROR HANDLING ===
if (DISPLAY_ERRORS) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(0);
}

set_exception_handler(function($exception) {
    error_log($exception->getMessage());
    

    http_response_code(500);
    if (DISPLAY_ERRORS) {
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; background: #fff1f1; border: 1px solid #ffb8b8; margin: 20px;'>";
        echo "<b>Fatal Error:</b> " . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8');
        echo "<hr><pre>" . htmlspecialchars($exception->getTraceAsString(), ENT_QUOTES, 'UTF-8') . "</pre>";
        echo "</div>";
    } else {
        echo "<div style='font-family: Arial, sans-serif; padding: 20px; background: #f8f8f8; border: 1px solid #ccc; margin: 20px;'>";
        echo "<b>Terjadi kesalahan pada sistem.</b><p>Mohon maaf atas ketidaknyamanannya. Tim kami telah diberi tahu dan sedang menanganinya.</p>";
        echo "</div>";
    }
    exit;
});

$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

/**
 * Sanitasi output untuk mencegah XSS.
 * @param string|null $string
 * @return string
 */
function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}