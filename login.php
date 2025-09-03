<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (login($email, $password)) {
        header('Location: /dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}

include __DIR__ . '/header.php';
?>
<section class="card">
    <h1>Welcome back</h1>
    <?php if ($error): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <?php csrf_field(); ?>
        <label>Email
            <input type="email" name="email" required />
        </label>
        <label>Password
            <input type="password" name="password" required />
        </label>
        <button type="submit" class="btn">Log In</button>
    </form>
    <p class="muted">No account? <a href="/register.php">Register here</a>.</p>
</section>
<?php include __DIR__ . '/footer.php'; ?>