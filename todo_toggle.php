<?php
// todo_toggle.php: AJAX handler to toggle a to-do item's checked state
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note_id = isset($_POST['note_id']) ? intval($_POST['note_id']) : 0;
    $idx = isset($_POST['idx']) ? intval($_POST['idx']) : -1;
    $checked = isset($_POST['checked']) ? (intval($_POST['checked']) ? true : false) : false;
    if ($note_id > 0 && $idx >= 0) {
        $db = new SQLite3('notes.db');
        $stmt = $db->prepare('SELECT content FROM notes WHERE id = ?');
        $stmt->bindValue(1, $note_id, SQLITE3_INTEGER);
        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
        if ($result && $result['content']) {
            $todo_items = json_decode($result['content'], true);
            if (is_array($todo_items) && isset($todo_items[$idx])) {
                $todo_items[$idx]['checked'] = $checked;
                $new_json = json_encode($todo_items);
                $update = $db->prepare('UPDATE notes SET content = ? WHERE id = ?');
                $update->bindValue(1, $new_json, SQLITE3_TEXT);
                $update->bindValue(2, $note_id, SQLITE3_INTEGER);
                $update->execute();
                echo 'OK';
                exit;
            }
        }
    }
}
echo 'ERROR';
