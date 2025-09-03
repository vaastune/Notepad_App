<?php
$db = new SQLite3('notes.db');
$result = $db->query('SELECT * FROM notes ORDER BY created_at DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Notes</title>
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
    <h1>Your Notes</h1>
    <a href="note_new.php" class="add-note-link">Add New Note</a>
    <ul>
    <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)):
        $todo_items = [];
        if ($row['content']) {
            $decoded = json_decode($row['content'], true);
            if (is_array($decoded)) {
                $todo_items = $decoded;
            }
        }
    ?>
        <li>
            <div style="flex:1;">
                <strong><?= htmlspecialchars($row['title']) ?></strong><br>
                <ul style="margin:8px 0 8px 0; padding-left:0;">
                <?php foreach ($todo_items as $idx => $item): ?>
                    <li style="list-style:none; display:flex; align-items:center;">
                        <input type="checkbox" class="todo-checkbox" data-note-id="<?= $row['id'] ?>" data-idx="<?= $idx ?>" <?= $item['checked'] ? 'checked' : '' ?>>
                        <span><?= htmlspecialchars($item['text']) ?></span>
                    </li>
                <?php endforeach; ?>
                </ul>
                <small><?= $row['created_at'] ?></small><br>
                <a href="note_edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="note_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this note?');">Delete</a>
            </div>
        </li>
    <?php endwhile; ?>
    </ul>
</div>
<footer class="footer">
    Start where you are. Use what you have. Do what you can.
</footer>
<script>
document.querySelectorAll('.todo-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var noteId = this.getAttribute('data-note-id');
        var idx = this.getAttribute('data-idx');
        var checked = this.checked ? 1 : 0;
        fetch('todo_toggle.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'note_id=' + encodeURIComponent(noteId) + '&idx=' + encodeURIComponent(idx) + '&checked=' + checked
        });
    });
});
</script>
</body>
</html>