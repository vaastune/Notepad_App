<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    logout();
}
header('Location: /login.php');
exit;