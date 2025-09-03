<?php
// Simple note-taking app DB init (no users)
$db = new SQLite3('notes.db');
$db->exec('CREATE TABLE IF NOT EXISTS notes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');
echo "Database initialized.";
