<?php
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();

$pdo = getDbConnection();
$message = '';
$messageType = '';

// Обработка добавления/редактирования тура
if (isset($_POST['save_tour'])) {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $city_id = $_POST['city_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $badge = $_POST['badge'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if (isset($_POST['tour_id']) && $_POST['tour_id']) {
        // Обновление
        $stmt = $pdo->prepare("UPDATE tours SET title=?, location=?, city_id=?, description=?, price=?, duration=?, badge=?, is_active=? WHERE id=?");
        $stmt->execute([$title, $location, $city_id, $description, $price, $duration, $badge, $is_active, $_POST['tour_id']]);
        $message = 'Тур обновлен';
    } else {
        // Добавление
        $stmt = $pdo->prepare("INSERT INTO tours (title, location, city_id, description, price, duration, badge, is_active) VALUES (?,?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $location, $city_id, $description, $price, $duration, $badge, $is_active]);
        $message = 'Тур добавлен';
    }
    $messageType = 'success';
}

// Обработка удаления
if (isset($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM tours WHERE id = ?");
    $stmt->execute([$deleteId]);
    $message = 'Тур удален';
    $messageType = 'success';
}

// Получение всех туров
$stmt = $pdo->query("SELECT * FROM tours ORDER BY created_at DESC");
$tours = $stmt->fetchAll();

// Получение данных для редактирования
$editTour = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->execute([$editId]);
    $editTour = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Управление турами | Админ-панель</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f6fa; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { color: #333; }
        .nav a { color: #667eea; text-decoration: none; margin-left: 15px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert.success { background: #d4edda; color: #155724; }
        .card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group textarea { height: 100px; resize: vertical; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #667eea; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-warning { background: #f39c12; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        .badge { padding: 4px 10px; border-radius: 15px; font-size: 11px; background: #e3f2fd; }
        .active { color: #27ae60; }
        .inactive { color: #e74c3c; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="bi bi-map"></i> Управление турами</h1>
            <div class="nav">
                <a href="dashboard.php">Главная</a>
                <a href="users.php">Пользователи</a>
                <a href="routes.php">Карточки</a>
                <a href="reviews.php">Отзывы</a>
                <a href="../index.php">На сайт</a>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="card">
            <h2><?= $editTour ? 'Редактировать тур' : 'Добавить новый тур' ?></h2>
            <form method="POST" style="margin-top: 20px;">
                <?php if ($editTour): ?>
                    <input type="hidden" name="tour_id" value="<?= $editTour['id'] ?>">
                <?php endif; ?>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Название *</label>
                        <input type="text" name="title" required value="<?= $editTour['title'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Местоположение *</label>
                        <input type="text" name="location" required value="<?= $editTour['location'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Город *</label>
                        <select name="city_id" required>
                            <option value="saint-petersburg" <?= ($editTour['city_id'] ?? '') === 'saint-petersburg' ? 'selected' : '' ?>>Санкт-Петербург</option>
                            <option value="kaliningrad" <?= ($editTour['city_id'] ?? '') === 'kaliningrad' ? 'selected' : '' ?>>Калининград</option>
                            <option value="moscow" <?= ($editTour['city_id'] ?? '') === 'moscow' ? 'selected' : '' ?>>Москва</option>
                            <option value="kazan" <?= ($editTour['city_id'] ?? '') === 'kazan' ? 'selected' : '' ?>>Казань</option>
                            <option value="sochi" <?= ($editTour['city_id'] ?? '') === 'sochi' ? 'selected' : '' ?>>Сочи</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Цена (₽)</label>
                        <input type="number" name="price" value="<?= $editTour['price'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Длительность (дней)</label>
                        <input type="number" name="duration" value="<?= $editTour['duration'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Бейдж</label>
                        <input type="text" name="badge" placeholder="Например: Хит, Популярный" value="<?= $editTour['badge'] ?? '' ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description"><?= $editTour['description'] ?? '' ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" <?= ($editTour['is_active'] ?? 1) ? 'checked' : '' ?>> Активен
                    </label>
                </div>
                
                <button type="submit" name="save_tour" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> <?= $editTour ? 'Сохранить' : 'Добавить' ?>
                </button>
                <?php if ($editTour): ?>
                    <a href="?" class="btn btn-warning">Отмена</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card" style="margin-top: 20px;">
            <h2>Все туры</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Город</th>
                        <th>Цена</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tours as $tour): ?>
                    <tr>
                        <td><?= $tour['id'] ?></td>
                        <td><?= htmlspecialchars($tour['title']) ?></td>
                        <td><?= htmlspecialchars($tour['location']) ?></td>
                        <td><?= number_format($tour['price'], 0, '.', ' ') ?> ₽</td>
                        <td class="<?= $tour['is_active'] ? 'active' : 'inactive' ?>">
                            <?= $tour['is_active'] ? 'Активен' : 'Отключен' ?>
                        </td>
                        <td>
                            <a href="?edit=<?= $tour['id'] ?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                            <a href="?delete=<?= $tour['id'] ?>" class="btn btn-danger" onclick="return confirm('Удалить?')"><i class="bi bi-trash"></i></a>
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
