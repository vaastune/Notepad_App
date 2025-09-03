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
        $stmt = $db->prepare('UPDATE notes SET title = ?, content = ? WHERE id = ?');
        $stmt->bindValue(1, $title, SQLITE3_TEXT);
        $stmt->bindValue(2, $content, SQLITE3_TEXT);
        $stmt->bindValue(3, $id, SQLITE3_INTEGER);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
    $error = 'Title and content required.';
}
$stmt = $db->prepare('SELECT * FROM notes WHERE id = ?');
$stmt->bindValue(1, $id, SQLITE3_INTEGER);
$note = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
if (!$note) die('Note not found.');
?>
<h1>Edit Note</h1>
<?php if (!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
<form method="post">
    <input type="text" name="title" value="<?= htmlspecialchars($note['title']) ?>" required><br>
    <textarea name="content" required><?= htmlspecialchars($note['content']) ?></textarea><br>
    <button type="submit">Update</button>
</form>
<a href="index.php">Back to Notes</a>
