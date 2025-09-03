

---


## 🗄️ `db.php`
```php
<?php
require_once __DIR__ . '/config.php';


function db() : PDO {
static $pdo;
if (!$pdo) {
$pdo = new PDO('sqlite:' . DB_PATH);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}
return $pdo;
}