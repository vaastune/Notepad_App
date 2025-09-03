<?php
$db = new SQLite3('notes.db');
$result = $db->query('SELECT * FROM notes ORDER BY created_at DESC');
?>
<h1>Simple Note Taking App</h1>
<a href="note_new.php">Add New Note</a>
<ul>
<?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
    <li>
        <strong><?= htmlspecialchars($row['title']) ?></strong><br>
        <?= nl2br(htmlspecialchars($row['content'])) ?><br>
        <small><?= $row['created_at'] ?></small><br>
        <a href="note_edit.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="note_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this note?');">Delete</a>
    </li>
<?php endwhile; ?>
</ul>