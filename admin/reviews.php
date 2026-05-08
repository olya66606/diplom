<?php
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();

$pdo = getDbConnection();
$message = '';

// Обработка одобрения/отклонения отзыва
if (isset($_POST['approve_review'])) {
    $reviewId = (int)$_POST['review_id'];
    $isApproved = isset($_POST['is_approved']) ? 1 : 0;
    $stmt = $pdo->prepare("UPDATE reviews SET is_approved = ? WHERE id = ?");
    $stmt->execute([$isApproved, $reviewId]);
    $message = 'Статус отзыва обновлен';
}

// Обработка удаления
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->execute([(int)$_GET['delete']]);
    $message = 'Отзыв удален';
}

// Получение всех отзывов
$showPending = isset($_GET['pending']);
if ($showPending) {
    $stmt = $pdo->query("SELECT r.*, u.name as user_name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.is_approved = 0 ORDER BY r.created_at DESC");
} else {
    $stmt = $pdo->query("SELECT r.*, u.name as user_name FROM reviews r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
}
$reviews = $stmt->fetchAll();

// Подсчет
$stmt = $pdo->query("SELECT COUNT(*) as count FROM reviews WHERE is_approved = 0");
$pendingCount = $stmt->fetch()['count'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Модерация отзывов | Админ-панель</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f6fa; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { color: #333; }
        .nav a { color: #667eea; text-decoration: none; margin-left: 15px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; background: #d4edda; color: #155724; }
        .card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .filters { margin-bottom: 20px; }
        .filters a { padding: 8px 16px; border-radius: 5px; text-decoration: none; color: #666; margin-right: 10px; }
        .filters a.active { background: #667eea; color: white; }
        .review-item { border: 1px solid #eee; border-radius: 8px; padding: 20px; margin-bottom: 15px; }
        .review-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .review-user { font-weight: 600; color: #333; }
        .review-place { color: #667eea; font-weight: 600; }
        .review-text { color: #555; margin: 10px 0; line-height: 1.6; }
        .review-meta { font-size: 13px; color: #999; }
        .review-actions { margin-top: 15px; display: flex; gap: 10px; }
        .btn { padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; color: white; font-size: 14px; }
        .btn-success { background: #27ae60; }
        .btn-danger { background: #e74c3c; }
        .btn-warning { background: #f39c12; }
        .badge { padding: 4px 10px; border-radius: 15px; font-size: 11px; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .stars { color: #f39c12; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="bi bi-chat-dots"></i> Модерация отзывов</h1>
            <div class="nav">
                <a href="dashboard.php">Главная</a>
                <a href="users.php">Пользователи</a>
                <a href="tours.php">Туры</a>
                <a href="routes.php">Карточки</a>
                <a href="../index.php">На сайт</a>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="filters">
                <a href="?<?= $showPending ? '' : 'pending=1' ?>" class="<?= $showPending ? 'active' : '' ?>">
                    <?= $showPending ? 'Все отзывы' : 'На модерации (' . $pendingCount . ')' ?>
                </a>
                <a href="?">Все отзывы</a>
                <a href="?pending=1">Только на модерации</a>
            </div>

            <?php if (empty($reviews)): ?>
                <p style="text-align: center; color: #999; padding: 40px;">Отзывов не найдено</p>
            <?php else: ?>
                <?php foreach ($reviews as $r): ?>
                <div class="review-item">
                    <div class="review-header">
                        <div>
                            <span class="review-user"><?= htmlspecialchars($r['user_name']) ?></span>
                            <span style="color: #999;"> — </span>
                            <span class="review-place"><?= htmlspecialchars($r['place_name']) ?></span>
                        </div>
                        <span class="badge <?= $r['is_approved'] ? 'badge-approved' : 'badge-pending' ?>">
                            <?= $r['is_approved'] ? '✅ Одобрено' : '⏱️ На модерации' ?>
                        </span>
                    </div>
                    
                    <div class="stars"><?= str_repeat('★', $r['rating']) ?></div>
                    <p class="review-text"><?= nl2br(htmlspecialchars($r['review_text'])) ?></p>
                    <div class="review-meta">
                        <?= date('d.m.Y H:i', strtotime($r['created_at'])) ?>
                    </div>
                    
                    <div class="review-actions">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="review_id" value="<?= $r['id'] ?>">
                            <input type="hidden" name="is_approved" value="<?= $r['is_approved'] ? 0 : 1 ?>">
                            <button type="submit" name="approve_review" class="btn <?= $r['is_approved'] ? 'btn-warning' : 'btn-success' ?>">
                                <?= $r['is_approved'] ? '⏸️ Скрыть' : '✅ Одобрить' ?>
                            </button>
                        </form>
                        <a href="?delete=<?= $r['id'] ?>" class="btn btn-danger" onclick="return confirm('Удалить отзыв?')">
                            🗑️ Удалить
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="dashboard.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Назад</a>
        </div>
    </div>
</body>
</html>
