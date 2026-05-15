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
        $stmt = $pdo->prepare("UPDATE tours SET title=?, location=?, city_id=?, description=?, price=?, duration=?, badge=?, is_active=? WHERE id=?");
        $stmt->execute([$title, $location, $city_id, $description, $price, $duration, $badge, $is_active, $_POST['tour_id']]);
        $message = 'Тур обновлен';
    } else {
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
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Управление турами | Админ-панель</title>
    <style>
        .admin-tours {
            max-width: 1400px;
            margin: 100px auto;
            padding: 0 20px;
        }
        
        .admin-page-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .admin-page-header h1 {
            font-size: 2.5rem;
            color: #1b5031;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .admin-page-header p {
            font-size: 1.2rem;
            color: #666;
        }
        
        .admin-alert {
            padding: 15px 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .admin-alert.success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #28a745;
        }
        
        .admin-alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #dc3545;
        }
        
        .admin-card {
            background: white;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        
        .admin-card-title {
            font-size: 1.8rem;
            color: #1b5031;
            margin-bottom: 25px;
            font-weight: 700;
        }
        
        .admin-form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .admin-form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 0.95rem;
        }
        
        .admin-form-group input,
        .admin-form-group select,
        .admin-form-group textarea {
            width: 550px;
            padding: 12px 16px;
            border: 2px solid #e8ecf1;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Mulish', sans-serif;
            transition: all 0.3s;
        }
        
        .admin-form-group input:focus,
        .admin-form-group select:focus,
        .admin-form-group textarea:focus {
            border-color: #2e8d53;
            outline: none;
            box-shadow: 0 0 0 3px rgba(46,141,83,0.1);
        }
        
        .admin-form-group textarea {
            height: 120px;
            resize: vertical;
        }
        
        .admin-form-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .admin-btn {
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Mulish', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            border: none;
            text-decoration: none;
        }
        
        .admin-btn-success {
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
        }
        
        .admin-btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46,141,83,0.4);
        }
        
        .admin-btn-primary {
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
        }
        
        .admin-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46,141,83,0.4);
        }
        
        .admin-btn-secondary {
            background: #f8f9fc;
            color: #666;
            border: 2px solid #e8ecf1;
        }
        
        .admin-btn-secondary:hover {
            background: #e8ecf1;
            transform: translateY(-2px);
        }
        
        .admin-btn-danger {
            background: #ff6b6b;
            color: white;
            border: 2px solid #ff6b6b;
        }
        
        .admin-btn-danger:hover {
            background: #ee5253;
            border-color: #ee5253;
        }
        
        .admin-btn-warning {
            background: #ffc107;
            color: white;
            border: 2px solid #ffc107;
        }
        
        .admin-btn-warning:hover {
            background: #ff9800;
            border-color: #ff9800;
        }
        
        .admin-table-wrapper {
            overflow-x: auto;
        }
        
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .admin-table th {
            text-align: left;
            padding: 18px 15px;
            background: #f8f9fc;
            color: #1b5031;
            font-weight: 700;
            font-size: 1rem;
            border-bottom: 2px solid #e8ecf1;
        }
        
        .admin-table td {
            padding: 18px 15px;
            border-bottom: 1px solid #e8ecf1;
            color: #555;
            font-size: 0.95rem;
        }
        
        .admin-table tr:hover {
            background: #f8f9fc;
        }
        
        .tour-status {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .tour-status-active {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            color: white;
        }
        
        .tour-status-inactive {
            background: #f0f2f5;
            color: #999;
        }
        
        .tour-actions {
            display: flex;
            gap: 10px;
        }
        
        .tour-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            font-size: 1.1rem;
        }
        
        .tour-btn-edit {
            background: #f8f9fc;
            color: #ffc107;
            border: 2px solid #ffc107;
        }
        
        .tour-btn-edit:hover {
            background: #ffc107;
            color: white;
            transform: scale(1.1);
        }
        
        .tour-btn-delete {
            background: #f8f9fc;
            color: #ff6b6b;
            border: 2px solid #ff6b6b;
        }
        
        .tour-btn-delete:hover {
            background: #ff6b6b;
            color: white;
            transform: scale(1.1);
        }
        
        .admin-nav-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        @media (max-width: 768px) {
            .admin-tours {
                margin: 60px auto;
            }
            
            .admin-page-header h1 {
                font-size: 1.8rem;
            }
            
            .admin-card {
                padding: 20px;
            }
            
            .admin-form-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-table {
                font-size: 0.85rem;
            }
            
            .tour-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="admin-tours">
        <div class="admin-page-header">
            <h1><i class="bi bi-map-fill"></i> Управление турами</h1>
            <p>Добавляйте, редактируйте и удаляйте туры</p>
        </div>

        <?php if ($message): ?>
            <div class="admin-alert <?= $messageType ?>">
                <i class="bi <?= $messageType === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?>"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="admin-card">
            <h2 class="admin-card-title">
                <?= $editTour ? 'Редактировать тур' : 'Добавить новый тур' ?>
            </h2>
            <form method="POST">
                <?php if ($editTour): ?>
                    <input type="hidden" name="tour_id" value="<?= $editTour['id'] ?>">
                <?php endif; ?>
                
                <div class="admin-form-grid">
                    <div class="admin-form-group">
                        <label>Название *</label>
                        <input type="text" name="title" required value="<?= htmlspecialchars($editTour['title'] ?? '') ?>">
                    </div>
                    <div class="admin-form-group">
                        <label>Местоположение *</label>
                        <input type="text" name="location" required value="<?= htmlspecialchars($editTour['location'] ?? '') ?>">
                    </div>
                    <div class="admin-form-group">
                        <label>Город *</label>
                        <select name="city_id" required>
                            <option value="saint-petersburg" <?= ($editTour['city_id'] ?? '') === 'saint-petersburg' ? 'selected' : '' ?>>Санкт-Петербург</option>
                            <option value="kaliningrad" <?= ($editTour['city_id'] ?? '') === 'kaliningrad' ? 'selected' : '' ?>>Калининград</option>
                            <option value="moscow" <?= ($editTour['city_id'] ?? '') === 'moscow' ? 'selected' : '' ?>>Москва</option>
                            <option value="japan" <?= ($editTour['city_id'] ?? '') === 'japan' ? 'selected' : '' ?>>Япония</option>
                            <option value="sochi" <?= ($editTour['city_id'] ?? '') === 'sochi' ? 'selected' : '' ?>>Сочи</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label>Цена (₽)</label>
                        <input type="number" name="price" value="<?= $editTour['price'] ?? '' ?>">
                    </div>
                    <div class="admin-form-group">
                        <label>Длительность (дней)</label>
                        <input type="number" name="duration" value="<?= $editTour['duration'] ?? '' ?>">
                    </div>
                    <div class="admin-form-group">
                        <label>Бейдж</label>
                        <input type="text" name="badge" placeholder="Например: Хит, Популярный" value="<?= htmlspecialchars($editTour['badge'] ?? '') ?>">
                    </div>
                </div>
                
                <div class="admin-form-group">
                    <label>Описание</label>
                    <textarea name="description"><?= htmlspecialchars($editTour['description'] ?? '') ?></textarea>
                </div>
                
 
                
                <div class="admin-form-actions">
                    <button type="submit" name="save_tour" class="admin-btn admin-btn-success">
                        <i class="bi bi-check-circle-fill"></i> <?= $editTour ? 'Сохранить' : 'Добавить' ?>
                    </button>
                    <?php if ($editTour): ?>
                        <a href="?" class="admin-btn admin-btn-secondary">Отмена</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="admin-card">
            <h2 class="admin-card-title">Все туры</h2>
            <div class="admin-table-wrapper">
                <table class="admin-table">
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
                            <td>
                                <span class="tour-status <?= $tour['is_active'] ? 'tour-status-active' : 'tour-status-inactive' ?>">
                                    <?= $tour['is_active'] ? 'Активен' : 'Отключен' ?>
                                </span>
                            </td>
                            <td>
                                <div class="tour-actions">
                                    <a href="?edit=<?= $tour['id'] ?>" class="tour-action-btn tour-btn-edit" title="Редактировать">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="?delete=<?= $tour['id'] ?>" class="tour-action-btn tour-btn-delete" onclick="return confirm('Удалить этот тур?')" title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-nav-buttons">
            <a href="dashboard.php" class="admin-btn admin-btn-secondary">
                <i class="bi bi-arrow-left"></i> Назад в панель
            </a>
            <a href="../index.php" class="admin-btn admin-btn-primary">
                <i class="bi bi-house-door"></i> На сайт
            </a>
        </div>
    </div>
</body>
</html>
