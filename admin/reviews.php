<?php
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();

$pdo = getDbConnection();
$message = '';

// Обработка одобрения/отклонения отзыва
if (isset($_POST['approve_review'])) {
    $reviewId = (int)$_POST['review_id'];
    $isApproved = isset($_POST['is_approved']) ? 0 : 1;
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
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Модерация отзывов | Админ-панель</title>
    <style>
        .admin-reviews { max-width: 1400px; margin: 100px auto; padding: 0 20px; }
        .admin-page-header { text-align: center; margin-bottom: 50px; }
        .admin-page-header h1 { font-size: 2.5rem; color: #1b5031; margin-bottom: 15px; font-weight: 700; }
        .admin-page-header p { font-size: 1.2rem; color: #666; }
        .admin-alert { padding: 15px 20px; border-radius: 16px; margin-bottom: 25px; font-weight: 500; display: flex; align-items: center; gap: 10px; background: #d4edda; color: #155724; border: 2px solid #28a745; }
        .admin-card { background: white; border-radius: 24px; padding: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .admin-filters { display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; }
        .admin-filter-btn { padding: 12px 24px; border-radius: 50px; text-decoration: none; color: #666; font-weight: 600; transition: all 0.3s; font-family: 'Mulish', sans-serif; border: 2px solid #e8ecf1; background: #f8f9fc; }
        .admin-filter-btn:hover { background: #e8ecf1; transform: translateY(-2px); }
        .admin-filter-btn.active { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; border-color: transparent; }
        .admin-review-item { border: 1px solid #e8ecf1; border-radius: 20px; padding: 25px; margin-bottom: 20px; transition: all 0.3s; }
        .admin-review-item:hover { box-shadow: 0 5px 20px rgba(0,0,0,0.08); transform: translateY(-2px); }
        .admin-review-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; flex-wrap: wrap; gap: 15px; }
        .admin-review-user-info { display: flex; align-items: center; gap: 12px; }
        .admin-review-user-avatar { width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; }
        .admin-review-user-name { font-weight: 700; color: #1b5031; font-size: 1.1rem; }
        .admin-review-place { color: #666; font-size: 0.95rem; }
        .admin-review-status { padding: 6px 16px; border-radius: 30px; font-size: 0.85rem; font-weight: 600; }
        .admin-review-status-approved { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; }
        .admin-review-status-pending { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: white; }
        .admin-review-stars { color: #ffc107; font-size: 1.3rem; margin-bottom: 12px; }
        .admin-review-text { color: #555; line-height: 1.7; margin: 15px 0; font-size: 1rem; }
        .admin-review-meta { font-size: 0.9rem; color: #999; margin-bottom: 20px; }
        .admin-review-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .admin-review-btn { padding: 12px 24px; border-radius: 50px; border: none; cursor: pointer; font-weight: 600; transition: all 0.3s; font-family: 'Mulish', sans-serif; display: inline-flex; align-items: center; gap: 8px; font-size: 0.95rem; text-decoration: none; }
        .admin-review-btn-approve { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; }
        .admin-review-btn-approve:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(46,141,83,0.4); }
        .admin-review-btn-hide { background: #ffc107; color: white; }
        .admin-review-btn-hide:hover { background: #ff9800; transform: translateY(-2px); }
        .admin-review-btn-delete { background: #ff6b6b; color: white; }
        .admin-review-btn-delete:hover { background: #ee5253; transform: translateY(-2px); }
        .admin-nav-buttons { display: flex; gap: 15px; justify-content: center; margin-top: 30px; }
        .admin-nav-btn { padding: 14px 32px; border-radius: 50px; font-weight: 600; transition: all 0.3s; font-family: 'Mulish', sans-serif; display: flex; align-items: center; gap: 10px; font-size: 1rem; text-decoration: none; }
        .admin-nav-btn-primary { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; }
        .admin-nav-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(46,141,83,0.4); }
        .admin-nav-btn-secondary { background: #f8f9fc; color: #666; border: 2px solid #e8ecf1; }
        .admin-nav-btn-secondary:hover { background: #e8ecf1; transform: translateY(-2px); }
        @media (max-width: 768px) { .admin-reviews { margin: 60px auto; } .admin-page-header h1 { font-size: 1.8rem; } .admin-card { padding: 20px; } .admin-review-header { flex-direction: column; } }
    </style>
</head>
<body>
    <div class="admin-reviews">
        <div class="admin-page-header">
            <h1><i class="bi bi-chat-dots-fill"></i> Модерация отзывов</h1>
            <p>Управляйте отзывами пользователей</p>
        </div>

        <?php if ($message): ?>
            <div class="admin-alert"><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="admin-card">
            <div class="admin-filters">
                <a href="<?= $showPending ? '' : '?pending=1' ?>" class="admin-filter-btn <?= !$showPending ? 'active' : '' ?>">
                    <i class="bi bi-clock-history"></i> На модерации (<?= $pendingCount ?>)
                </a>
                <a href="?<?= $showPending ? '' : 'pending=1' ?>" class="admin-filter-btn <?= $showPending ? 'active' : '' ?>">
                    <i class="bi bi-list-ul"></i> Все отзывы
                </a>
            </div>

            <?php if (empty($reviews)): ?>
                <p style="text-align: center; color: #999; padding: 40px; font-size: 1.1rem;"><i class="bi bi-inbox"></i> Отзывов не найдено</p>
            <?php else: ?>
                <?php foreach ($reviews as $r): ?>
                <div class="admin-review-item">
                    <div class="admin-review-header">
                        <div class="admin-review-user-info">
                            <div class="admin-review-user-avatar"><?= strtoupper(substr($r['user_name'], 0, 1)) ?></div>
                            <div>
                                <div class="admin-review-user-name"><?= htmlspecialchars($r['user_name']) ?></div>
                                <div class="admin-review-place"><i class="bi bi-pin-map"></i> <?= htmlspecialchars($r['place_name']) ?></div>
                            </div>
                        </div>
                        <span class="admin-review-status <?= $r['is_approved'] ? 'admin-review-status-approved' : 'admin-review-status-pending' ?>">
                            <?= $r['is_approved'] ? '<i class="bi bi-check-circle"></i> Одобрено' : '<i class="bi bi-clock"></i> На модерации' ?>
                        </span>
                    </div>
                    
                    <div class="admin-review-stars"><?= str_repeat('★', $r['rating']) ?></div>
                    <p class="admin-review-text"><?= nl2br(htmlspecialchars($r['review_text'])) ?></p>
                    <div class="admin-review-meta"><i class="bi bi-calendar"></i> <?= date('d.m.Y H:i', strtotime($r['created_at'])) ?></div>
                    
                    <div class="admin-review-actions">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="review_id" value="<?= $r['id'] ?>">
                            <button type="submit" name="approve_review" class="admin-review-btn <?= $r['is_approved'] ? 'admin-review-btn-hide' : 'admin-review-btn-approve' ?>">
                                <i class="bi <?= $r['is_approved'] ? 'bi-eye-slash' : 'bi-check-circle' ?>"></i>
                                <?= $r['is_approved'] ? 'Скрыть' : 'Одобрить' ?>
                            </button>
                        </form>
                        <a href="?delete=<?= $r['id'] ?>" class="admin-review-btn admin-review-btn-delete" onclick="return confirm('Удалить отзыв?')">
                            <i class="bi bi-trash"></i> Удалить
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="admin-nav-buttons">
            <a href="dashboard.php" class="admin-nav-btn admin-nav-btn-secondary"><i class="bi bi-arrow-left"></i> Назад в панель</a>
            <a href="../index.php" class="admin-nav-btn admin-nav-btn-primary"><i class="bi bi-house-door"></i> На сайт</a>
        </div>
    </div>
</body>
</html>
