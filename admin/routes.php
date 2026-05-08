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
    <title>Карточки маршрутов | Админ-панель</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f6fa; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { color: #333; }
        .nav a { color: #667eea; text-decoration: none; margin-left: 15px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; background: #d4edda; color: #155724; }
        .card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group textarea { height: 80px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; color: white; }
        .btn-primary { background: #667eea; }
        .btn-success { background: #27ae60; }
        .btn-danger { background: #e74c3c; }
        .btn-warning { background: #f39c12; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="bi bi-card-list"></i> Карточки маршрутов</h1>
            <div class="nav">
                <a href="dashboard.php">Главная</a>
                <a href="users.php">Пользователи</a>
                <a href="tours.php">Туры</a>
                <a href="reviews.php">Отзывы</a>
                <a href="../index.php">На сайт</a>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="card">
            <h2><?= $editCard ? 'Редактировать карточку' : 'Добавить карточку' ?></h2>
            <form method="POST" style="margin-top: 20px;">
                <?php if ($editCard): ?>
                    <input type="hidden" name="card_id" value="<?= $editCard['id'] ?>">
                <?php endif; ?>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Название *</label>
                        <input type="text" name="title" required value="<?= $editCard['title'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Город *</label>
                        <select name="city_id" required>
                            <option value="saint-petersburg" <?= ($editCard['city_id'] ?? '') === 'saint-petersburg' ? 'selected' : '' ?>>Санкт-Петербург</option>
                            <option value="kaliningrad" <?= ($editCard['city_id'] ?? '') === 'kaliningrad' ? 'selected' : '' ?>>Калининград</option>
                            <option value="moscow" <?= ($editCard['city_id'] ?? '') === 'moscow' ? 'selected' : '' ?>>Москва</option>
                            <option value="kazan" <?= ($editCard['city_id'] ?? '') === 'kazan' ? 'selected' : '' ?>>Казань</option>
                            <option value="sochi" <?= ($editCard['city_id'] ?? '') === 'sochi' ? 'selected' : '' ?>>Сочи</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Категория</label>
                        <input type="text" name="category" placeholder="Достопримечательности, музеи..." value="<?= $editCard['category'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Цена (₽)</label>
                        <input type="number" name="price" value="<?= $editCard['price'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Длительность (часов)</label>
                        <input type="number" name="duration" value="<?= $editCard['duration'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Порядок сортировки</label>
                        <input type="number" name="sort_order" value="<?= $editCard['sort_order'] ?? 0 ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description"><?= $editCard['description'] ?? '' ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" <?= ($editCard['is_active'] ?? 1) ? 'checked' : '' ?>> Активна
                    </label>
                </div>
                
                <button type="submit" name="save_card" class="btn btn-success">Сохранить</button>
                <?php if ($editCard): ?>
                    <a href="?" class="btn btn-warning">Отмена</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card" style="margin-top: 20px;">
            <h2>Все карточки</h2>
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Город</th>
                        <th>Категория</th>
                        <th>Цена</th>
                        <th>Порядок</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cards as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['title']) ?></td>
                        <td><?= htmlspecialchars($c['city_id']) ?></td>
                        <td><?= htmlspecialchars($c['category']) ?></td>
                        <td><?= $c['price'] ? number_format($c['price'], 0, '.', ' ') . ' ₽' : '-' ?></td>
                        <td><?= $c['sort_order'] ?></td>
                        <td><?= $c['is_active'] ? '✅' : '❌' ?></td>
                        <td>
                            <a href="?edit=<?= $c['id'] ?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                            <a href="?delete=<?= $c['id'] ?>" class="btn btn-danger" onclick="return confirm('Удалить?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <a href="dashboard.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Назад</a>
        </div>
    </div>
</body>
</html>
