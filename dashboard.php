<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';
require_auth();
$me = current_user();

// Fetch notes for this user
$stmt = db()->prepare(
    'SELECT id, title, substr(content,1,120) AS preview, created_at, updated_at 
     FROM notes 
     WHERE user_id = ? 
     ORDER BY updated_at DESC'
);
$stmt->execute([$me['id']]);
$notes = $stmt->fetchAll();

include __DIR__ . '/header.php';
?>
<section class="grid">
    <div class="card">
        <h1>Welcome, <?= htmlspecialchars($me['full_name']) ?></h1>
        <p class="muted">Here are your recent notes. Create a new one any time.</p>
        <a href="/note_new.php" class="btn">➕ New Note</a>
    </div>

    <div class="card calendar-card">
        <h2>Calendar</h2>
        <div id="calendar" class="calendar"></div>
    </div>

    <div class="card span-2">
        <h2>Your notes</h2>
        <?php if (!$notes): ?>
            <p class="muted">No notes yet. Go ahead and create your first note!</p>
        <?php else: ?>
            <div class="notes">
                <?php foreach ($notes as $n): ?>
                    <a class="note" href="/note_view.php?id=<?= (int)$n['id'] ?>">
                        <div class="note-title"><?= htmlspecialchars($n['title']) ?></div>
                        <div class="note-preview">
                            <?= htmlspecialchars($n['preview']) ?>
                            <?= strlen($n['preview']) >= 120 ? '…' : '' ?>
                        </div>
                        <div class="note-meta">Updated <?= htmlspecialchars($n['updated_at']) ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>