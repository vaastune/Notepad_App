<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';
require_auth();
$me = current_user();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    if ($title === '' || $content === '') {
        $error = 'Title and content are required.';
    } else {
