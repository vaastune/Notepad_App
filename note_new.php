<?php
// note_new.php: Add a new note (open app)
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new SQLite3('notes.db');
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    if ($title && $content) {
        $items = array_filter(array_map('trim', explode("\n", $content)));
        $todo_json = json_encode(array_map(function($item) {
            return ['text' => $item, 'checked' => false];
        }, $items));
        $stmt = $db->prepare('INSERT INTO notes (title, content) VALUES (?, ?)');
        $stmt->bindValue(1, $title, SQLITE3_TEXT);
        $stmt->bindValue(2, $todo_json, SQLITE3_TEXT);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
    $error = 'Title and content required.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Note</title>
    <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="datetime">
    <?php echo date('l, F j, Y - h:i A'); ?>
</div>
<div class="container">
    <h1>Add New Note</h1>
    <?php if (!empty($error)) echo '<p style="color:red">'.$error.'</p>'; ?>
    <form method="post">
        <input type="text" name="title" placeholder="To-Do List Title" required><br>
        <textarea name="content" placeholder="Enter each to-do item on a new line" rows="7"></textarea><br><br>
            <button type="submit" style="display: block; margin: 0 auto;">Save</button>
    </form>
        <br><br><a href="index.php" class="add-note-link">Back to List</a><br><br>
</div>
<footer class="footer">
    Start where you are. Use what you have. Do what you can.
</footer>
</body>
</html>
