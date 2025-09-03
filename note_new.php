<?php
// note_new.php: Add a new note (open app)
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new SQLite3('notes.db');
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    if ($title && $content) {
        $stmt = $db->prepare('INSERT INTO notes (title, content) VALUES (?, ?)');
        $stmt->bindValue(1, $title, SQLITE3_TEXT);
        $stmt->bindValue(2, $content, SQLITE3_TEXT);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
    $error = 'Title and content required.';
}
?>
<h1>Add New Note</h1>
<?php if (!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
<form method="post">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="content" placeholder="Content" required></textarea><br>
    <button type="submit">Save</button>
</form>
<a href="index.php">Back to Notes</a>
