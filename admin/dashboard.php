<?php
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();

$user = getCurrentUser();

// Получаем статистику
$pdo = getDbConnection();

// Количество пользователей
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
$usersCount = $stmt->fetch()['count'];

// Количество туров
$stmt = $pdo->query("SELECT COUNT(*) as count FROM tours");
$toursCount = $stmt->fetch()['count'];

// Количество отзывов на модерации
$stmt = $pdo->query("SELECT COUNT(*) as count FROM reviews WHERE is_approved = 0");
$reviewsPending = $stmt->fetch()['count'];

// Последние регистрации
$stmt = $pdo->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 5");
$recentUsers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Админ-панель | Туры Везде</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Mulish', sans-serif; background: #f5f6fa; }
        
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 { font-size: 24px; }
        
        .admin-nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .admin-nav a:hover { background: rgba(255,255,255,0.2); }
        
        .admin-container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        
        .stat-card:hover { transform: translateY(-5px); }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .stat-icon.blue { background: #e3f2fd; color: #2196f3; }
        .stat-icon.green { background: #e8f5e9; color: #4caf50; }
        .stat-icon.orange { background: #fff3e0; color: #ff9800; }
        .stat-icon.purple { background: #f3e5f5; color: #9c27b0; }
        
        .stat-value { font-size: 32px; font-weight: 700; color: #333; }
        .stat-label { color: #666; margin-top: 5px; }
        
        .admin-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .section-title {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .action-btn i { font-size: 24px; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .role-badge.admin { background: #ffe0b2; color: #e65100; }
        .role-badge.user { background: #e3f2fd; color: #1976d2; }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: opacity 0.3s;
        }
        
        .btn:hover { opacity: 0.8; }
        
        .btn-primary { background: #667eea; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-success { background: #27ae60; color: white; }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="admin-header-content">
            <h1><i class="bi bi-gear-fill"></i> Админ-панель</h1>
            <div class="admin-nav">
                <a href="/../admin/dashboard.php">Главная</a>
                <a href="/../admin/users.php">Пользователи</a>
                <a href="/../admin/tours.php">Туры</a>
                <a href="/../admin/routes.php">Карточки маршрутов</a>
                <a href="/../admin/reviews.php">Отзывы</a>
                <a href="/../index.php"><i class="bi bi-arrow-left"></i> На сайт</a>
                <a href="auth/logout.php">Выйти</a>
            </div>
        </div>
    </div>

    <div class="admin-container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-people"></i></div>
                <div class="stat-value"><?= $usersCount ?></div>
                <div class="stat-label">Пользователей</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-map"></i></div>
                <div class="stat-value"><?= $toursCount ?></div>
                <div class="stat-label">Туров</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon orange"><i class="bi bi-chat-dots"></i></div>
                <div class="stat-value"><?= $reviewsPending ?></div>
                <div class="stat-label">Отзывов на модерации</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon purple"><i class="bi bi-person-badge"></i></div>
                <div class="stat-value"><?= count($recentUsers) ?></div>
                <div class="stat-label">Последних пользователей</div>
            </div>
        </div>

        <div class="admin-section">
            <h2 class="section-title"><i class="bi bi-lightning-charge"></i> Быстрые действия</h2>
            <div class="quick-actions">
                <a href="/../admin/tours.php" class="action-btn">
                    <i class="bi bi-plus-circle"></i>
                    <span>Добавить тур</span>
                </a>
                <a href="/../admin/routes.php" class="action-btn">
                    <i class="bi bi-card-list"></i>
                    <span>Управление карточками</span>
                </a>
                <a href="/../admin/users.php" class="action-btn">
                    <i class="bi bi-person-plus"></i>
                    <span>Добавить пользователя</span>
                </a>
                <a href="/../admin/reviews.php" class="action-btn">
                    <i class="bi bi-check-circle"></i>
                    <span>Модерация отзывов</span>
                </a>
            </div>
        </div>

        <div class="admin-section">
            <h2 class="section-title"><i class="bi bi-clock-history"></i> Последние пользователи</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentUsers as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <span class="role-badge <?= $u['role'] ?>"><?= $u['role'] ?></span>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($u['created_at'])) ?></td>
                        <td>
                            <a href="admin/users.php?edit=<?= $u['id'] ?>" class="btn btn-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php" class="back-link"><i class="bi bi-arrow-left"></i> Вернуться на сайт</a>
    </div>
</body>
</html>
