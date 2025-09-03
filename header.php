<?php
require_once __DIR__ . '/config.php';
// Cache current_user result in session if available
if (!isset($_SESSION['me'])) {
	$_SESSION['me'] = current_user();
}
$me = $_SESSION['me'];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="/assets/style.css" />
</head>
<body>
    <header class="app-header">
        <div class="container">
        <div class="brand">
        <div class="logo">📝</div>
        <span class="name"><?= htmlspecialchars(APP_NAME) ?></span>
</div>
<nav>
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
</header>
<main class="container">