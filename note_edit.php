<?php
// note_edit.php: Edit an existing note
$db = new SQLite3('notes.db');
$id = $_GET['id'] ?? '';
if (!$id) {
    die('Note ID required.');
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    if ($title && $content) {
        $items = array_filter(array_map('trim', explode("\n", $content)));
        $todo_json = json_encode(array_map(function($item) {
            return ['text' => $item, 'checked' => false];
        }, $items));
        $stmt = $db->prepare('UPDATE notes SET title = ?, content = ? WHERE id = ?');
        $stmt->bindValue(1, $title, SQLITE3_TEXT);
        $stmt->bindValue(2, $todo_json, SQLITE3_TEXT);
        $stmt->bindValue(3, $id, SQLITE3_INTEGER);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
    $error = 'Title and content required.';
}
// Load note and decode todo items
$stmt = $db->prepare('SELECT * FROM notes WHERE id = ?');
$stmt->bindValue(1, $id, SQLITE3_INTEGER);
$note = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
if (!$note) die('Note not found.');
$todo_items = [];
if ($note['content']) {
    $decoded = json_decode($note['content'], true);
    if (is_array($decoded)) {
        $todo_items = $decoded;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit To-Do</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="datetime">
    <?php echo date('l, F j, Y - h:i A'); ?>
</div>
<div class="container">
    <h1>Edit To-Do</h1>
    <?php if (!empty($error)) echo '<p style=\"color:red\">'.$error.'</p>'; ?>
    <form method="post">
    <input type="text" name="title" value="<?= htmlspecialchars($note['title']) ?>" required><br>
        <textarea name="content" placeholder="Enter each to-do item on a new line" rows="7"><?php
            foreach ($todo_items as $item) {
                echo htmlspecialchars($item['text']) . "\n";
            }
        ?></textarea><br>
        <button type="submit" style="display: block; margin: 0 auto;">Update</button>
    </form>
    <a href="index.php" class="add-note-link">Back to List</a><br><br>
</div>
<footer class="footer">
    Start where you are. Use what you have. Do what you can.
</footer>
</body>
</html>
