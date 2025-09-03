<?php
require_once __DIR__ . '/config.php';
// Cache current_user result in session if available
if (!isset($_SESSION['me'])) {
    $_SESSION['me'] = current_user();
}
$me = $_SESSION['me'];
?><!DOCTYPE html>
<html>
<head>
    <title>Notepad App</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <header class="app-header">
        <div class="container">
            <div class="brand">
                <form action="/logout.php" method="post" class="inline">
                    <?php 
                    // Outputs a hidden input field for CSRF protection; see csrf_field() implementation for details.
                    csrf_field(); 
                    ?>
                    <button type="submit" class="link">Logout</button>
                </form>
                <?php if ($me): ?>
                    <a href="/dashboard.php">Dashboard</a>
                    <a href="/note_new.php" class="btn">New Note</a>
                    <form action="/logout.php" method="post" class="inline">
                        <?php csrf_field(); ?>
                        <button type="submit" class="link">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="/login.php">Login</a>
                    <a href="/register.php" class="btn">Register</a>
                <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>
    <main class="container">