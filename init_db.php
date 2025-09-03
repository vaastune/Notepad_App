<?php
require_once __DIR__ . '/db.php';


$pdo = db();


$pdo->exec('CREATE TABLE IF NOT EXISTS users (
id INTEGER PRIMARY KEY AUTOINCREMENT,
email TEXT UNIQUE NOT NULL,
full_name TEXT NOT NULL,
password_hash TEXT NOT NULL,
created_at TEXT NOT NULL
)');


$pdo->exec('CREATE TABLE IF NOT EXISTS notes (
id INTEGER PRIMARY KEY AUTOINCREMENT,
user_id INTEGER NOT NULL,
title TEXT NOT NULL,
content TEXT NOT NULL,
created_at TEXT NOT NULL,
updated_at TEXT NOT NULL,
FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
)');


echo "Database initialized.\n";