<?php
// note_delete.php: Delete a note
$db = new SQLite3('notes.db');
$id = $_GET['id'] ?? '';
if ($id) {
    $stmt = $db->prepare('DELETE FROM notes WHERE id = ?');
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);
    $stmt->execute();
}
header('Location: index.php');
exit;
?>
