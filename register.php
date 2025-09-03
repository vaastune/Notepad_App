<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = trim($_POST['email'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        try {
            register_user($email, $full_name, $password);
            login($email, $password);
            header('Location: /dashboard.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Could not register. Email may already be in use.';
        }
    }
}

include __DIR__ . '/header.php';
?>
<section class="card">
    <h1>Create your account</h1>
    <?php if ($error): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <?php csrf_field(); ?>
        <label>Full name
            <input type="text" name="full_name" required />
        </label>
        <label>University email
            <input type="email" name="email" required />
        </label>
        <label>Password
            <input type="password" name="password" minlength="6" required />
        </label>
        <label>Confirm password
            <input type="password" name="confirm" minlength="6" required />
        </label>
        <button type="submit" claACss="btn">Register</button>
    </form>
</section>
<?php include __DIR__ . '/footer.php'; ?>
