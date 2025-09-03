<?php
// Configuration stub

// Start session and set common config
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Path to SQLite database file (created by init_db.php)
define('DB_PATH', __DIR__ . '/data.sqlite');

// App branding
define('APP_NAME', 'Uni Notepad');
define('APP_PRIMARY', '#0d47a1'); // University blue

// Simple helper to enforce HTTPS cookies where possible
if (PHP_VERSION_ID >= 70300) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

// CSRF utilities
function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field() {
    $t = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    echo '<input type="hidden" name="csrf" value="' . $t . '">';
}

function csrf_check() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ok = isset($_POST['csrf']) && hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']);
        if (!$ok) {
            http_response_code(400);
            exit('Invalid CSRF token');
        }
    }
}
