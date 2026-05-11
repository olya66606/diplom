<?php
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();

$pdo = getDbConnection();
$message = '';

// Обработка добавления/редактирования карточки
if (isset($_POST['save_card'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $city_id = $_POST['city_id'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $sort_order = $_POST['sort_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if (isset($_POST['card_id']) && $_POST['card_id']) {
        $stmt = $pdo->prepare("UPDATE route_cards SET title=?, description=?, city_id=?, category=?, price=?, duration=?, sort_order=?, is_active=? WHERE id=?");
        $stmt->execute([$title, $description, $city_id, $category, $price, $duration, $sort_order, $is_active, $_POST['card_id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO route_cards (title, description, city_id, category, price, duration, sort_order, is_active) VALUES (?,?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $city_id, $category, $price, $duration, $sort_order, $is_active]);
    }
    $message = 'Карточка сохранена';
}

// Обработка удаления
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM route_cards WHERE id = ?");
    $stmt->execute([(int)$_GET['delete']]);
    $message = 'Карточка удалена';
}

// Получение всех карточек
$stmt = $pdo->query("SELECT * FROM route_cards ORDER BY sort_order, id DESC");
$cards = $stmt->fetchAll();

// Получение данных для редактирования
$editCard = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM route_cards WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editCard = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Карточки маршрутов | Админ-панель</title>
    <style>
     
        .admin-routes { max-width: 1400px; margin: 100px auto; padding: 0 20px; }
        .admin-page-header { text-align: center; margin-bottom: 50px; }
        .admin-page-header h1 { font-size: 2.5rem; color: #1b5031; margin-bottom: 15px; font-weight: 700; }
        .admin-page-header p { font-size: 1.2rem; color: #666; }
        .admin-alert { padding: 15px 20px; border-radius: 16px; margin-bottom: 25px; font-weight: 500; display: flex; align-items: center; gap: 10px; background: #d4edda; color: #155724; border: 2px solid #28a745; }
        .admin-card { background: white; border-radius: 24px; padding: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 30px; }
        .admin-card-title { font-size: 1.8rem; color: #1b5031; margin-bottom: 25px; font-weight: 700; }
        .admin-form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px; }
        .admin-form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 0.95rem; }
        .admin-form-group input, .admin-form-group select, .admin-form-group textarea { width: 370px; padding: 12px 16px; border: 2px solid #e8ecf1; border-radius: 12px; font-size: 1rem; font-family: 'Mulish', sans-serif; transition: all 0.3s; }
        .admin-form-group input:focus, .admin-form-group select:focus, .admin-form-group textarea:focus { border-color: #2e8d53; outline: none; box-shadow: 0 0 0 3px rgba(46,141,83,0.1); }
        .admin-form-group textarea { height: 100px; resize: vertical; }
        .admin-btn { padding: 14px 32px; border-radius: 50px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-family: 'Mulish', sans-serif; display: inline-flex; align-items: center; gap: 10px; font-size: 1rem; border: none; text-decoration: none; }
        .admin-btn-success { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; }
        .admin-btn-success:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(46,141,83,0.4); }
        .admin-btn-secondary { background: #f8f9fc; color: #666; border: 2px solid #e8ecf1; }
        .admin-btn-secondary:hover { background: #e8ecf1; transform: translateY(-2px); }
        .admin-btn-warning { background: #ffc107; color: white; border: 2px solid #ffc107; }
        .admin-btn-warning:hover { background: #ff9800; border-color: #ff9800; }
        .admin-table-wrapper { overflow-x: auto; }
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th { text-align: left; padding: 18px 15px; background: #f8f9fc; color: #1b5031; font-weight: 700; font-size: 1rem; border-bottom: 2px solid #e8ecf1; }
        .admin-table td { padding: 18px 15px; border-bottom: 1px solid #e8ecf1; color: #555; font-size: 0.95rem; }
        .admin-table tr:hover { background: #f8f9fc; }
        .card-status { padding: 6px 16px; border-radius: 30px; font-size: 0.85rem; font-weight: 600; }
        .card-status-active { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; }
        .card-status-inactive { background: #f0f2f5; color: #999; }
        .card-actions { display: flex; gap: 10px; }
        .card-action-btn { width: 40px; height: 40px; border-radius: 50%; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s; font-size: 1.1rem; }
        .card-btn-edit { background: #f8f9fc; color: #ffc107; border: 2px solid #ffc107; }
        .card-btn-edit:hover { background: #ffc107; color: white; transform: scale(1.1); }
        .card-btn-delete { background: #f8f9fc; color: #ff6b6b; border: 2px solid #ff6b6b; }
        .card-btn-delete:hover { background: #ff6b6b; color: white; transform: scale(1.1); }
        .admin-nav-buttons { display: flex; gap: 15px; justify-content: center; margin-top: 30px; }
        @media (max-width: 768px) { .admin-routes { margin: 60px auto; } .admin-page-header h1 { font-size: 1.8rem; } .admin-card { padding: 20px; } .admin-form-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="admin-routes">
        <div class="admin-page-header">
            <h1><i class="bi bi-card-list"></i> Карточки маршрутов</h1>
            <p>Управляйте карточками туров и маршрутов</p>
        </div>

        <?php if ($message): ?>
            <div class="admin-alert"><i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="admin-card">
            <h2 class="admin-card-title"><?= $editCard ? 'Редактировать карточку' : 'Добавить карточку' ?></h2>
            <form method="POST">
                <?php if ($editCard): ?><input type="hidden" name="card_id" value="<?= $editCard['id'] ?>"><?php endif; ?>
                <div class="admin-form-grid">
                    <div class="admin-form-group"><label>Название *</label><input type="text" name="title" required value="<?= htmlspecialchars($editCard['title'] ?? '') ?>"></div>
                    <div class="admin-form-group"><label>Город *</label><select name="city_id" required><option value="saint-petersburg" <?= ($editCard['city_id'] ?? '') === 'saint-petersburg' ? 'selected' : '' ?>>Санкт-Петербург</option><option value="kaliningrad" <?= ($editCard['city_id'] ?? '') === 'kaliningrad' ? 'selected' : '' ?>>Калининград</option><option value="moscow" <?= ($editCard['city_id'] ?? '') === 'moscow' ? 'selected' : '' ?>>Москва</option><option value="japan" <?= ($editCard['city_id'] ?? '') === 'japan' ? 'selected' : '' ?>>Япония</option><option value="sochi" <?= ($editCard['city_id'] ?? '') === 'sochi' ? 'selected' : '' ?>>Сочи</option></select></div>
                    <div class="admin-form-group"><label>Категория</label><input type="text" name="category" placeholder="Достопримечательности, музеи..." value="<?= htmlspecialchars($editCard['category'] ?? '') ?>"></div>
                    <div class="admin-form-group"><label>Цена (₽)</label><input type="number" name="price" value="<?= $editCard['price'] ?? '' ?>"></div>
                    <div class="admin-form-group"><label>Длительность (часов)</label><input type="number" name="duration" value="<?= $editCard['duration'] ?? '' ?>"></div>
                    <div class="admin-form-group"><label>Порядок сортировки</label><input type="number" name="sort_order" value="<?= $editCard['sort_order'] ?? 0 ?>"></div>
                </div>
                <div class="admin-form-group"><label>Описание</label><textarea name="description"><?= htmlspecialchars($editCard['description'] ?? '') ?></textarea></div>
                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <button type="submit" name="save_card" class="admin-btn admin-btn-success"><i class="bi bi-check-circle-fill"></i> Сохранить</button>
                    <?php if ($editCard): ?><a href="?" class="admin-btn admin-btn-secondary">Отмена</a><?php endif; ?>
                </div>
            </form>
        </div>

        <div class="admin-card">
            <h2 class="admin-card-title">Все карточки</h2>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead><tr><th>Название</th><th>Город</th><th>Категория</th><th>Цена</th><th>Порядок</th><th>Статус</th><th>Действия</th></tr></thead>
                    <tbody>
                        <?php foreach ($cards as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['title']) ?></td>
                            <td><?= htmlspecialchars($c['city_id']) ?></td>
                            <td><?= htmlspecialchars($c['category']) ?></td>
                            <td><?= $c['price'] ? number_format($c['price'], 0, '.', ' ') . ' ₽' : '-' ?></td>
                            <td><?= $c['sort_order'] ?></td>
                            <td><span class="card-status <?= $c['is_active'] ? 'card-status-active' : 'card-status-inactive' ?>"><?= $c['is_active'] ? 'Активна' : 'Отключена' ?></span></td>
                            <td><div class="card-actions"><a href="?edit=<?= $c['id'] ?>" class="card-action-btn card-btn-edit"><i class="bi bi-pencil"></i></a><a href="?delete=<?= $c['id'] ?>" class="card-action-btn card-btn-delete" onclick="return confirm('Удалить?')"><i class="bi bi-trash"></i></a></div></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-nav-buttons">
            <a href="dashboard.php" class="admin-btn admin-btn-secondary"><i class="bi bi-arrow-left"></i> Назад в панель</a>
            <a href="../index.php" class="admin-btn admin-btn-success"><i class="bi bi-house-door"></i> На сайт</a>
        </div>
    </div>
</body>
</html>
