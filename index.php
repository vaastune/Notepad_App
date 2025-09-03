<?php
require_once __DIR__ . '/auth.php';
$me = current_user();
if ($me) {
header('Location: /dashboard.php');
} else {
header('Location: /login.php');
}
exit;