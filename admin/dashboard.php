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
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Админ-панель | Туры Везде</title>
    <style>
        .admin-dashboard {
            max-width: 1400px;
            margin: 100px auto;
            padding: 0 20px;
        }
        
        .admin-dashboard-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .admin-dashboard-header h1 {
            font-size: 2.5rem;
            color: #1b5031;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .admin-dashboard-header p {
            font-size: 1.2rem;
            color: #666;
        }
        
        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .admin-stat-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .admin-stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
        
        .admin-stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
        }
        
        .admin-stat-icon.blue {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            color: white;
        }
        
        .admin-stat-icon.green {
            background:linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
        }
        
        .admin-stat-icon.orange {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
        }
        
        .admin-stat-icon.purple {
            background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
            color: white;
        }
        
        .admin-stat-content {
            flex: 1;
        }
        
        .admin-stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1b5031;
            line-height: 1;
            margin-bottom: 8px;
        }
        
        .admin-stat-label {
            font-size: 1rem;
            color: #666;
            font-weight: 500;
        }
        
        .admin-section {
            background: white;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        
        .admin-section-header {
            margin-bottom: 30px;
        }
        
        .admin-section-title {
            font-size: 1.8rem;
            color: #1b5031;
            margin-bottom: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .admin-section-subtitle {
            font-size: 1rem;
            color: #666;
        }
        
        .admin-quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        
        .admin-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            padding: 30px 20px;
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            min-height: 150px;
        }
        
        .admin-action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(46,141,83,0.3);
        }
        
        .admin-action-btn i {
            font-size: 3rem;
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
        
        .admin-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }
        
        .admin-user-name {
            font-weight: 600;
            color: #1b5031;
        }
        
        .admin-user-email {
            font-size: 0.85rem;
            color: #888;
        }
        
        .admin-role-badge {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .admin-role-badge-admin {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
        }
        
        .admin-role-badge-user {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            color: white;
        }
        
        .admin-nav-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .admin-nav-btn {
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            font-family: 'Mulish', sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
        }
        
        .admin-nav-btn-primary {
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
        }
        
        .admin-nav-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46,141,83,0.4);
        }
        
        .admin-nav-btn-secondary {
            background: #f8f9fc;
            color: #666;
            border: 2px solid #e8ecf1;
        }
        
        .admin-nav-btn-secondary:hover {
            background: #e8ecf1;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .admin-dashboard {
                margin: 60px auto;
            }
            
            .admin-dashboard-header h1 {
                font-size: 1.8rem;
            }
            
            .admin-stats-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-section {
                padding: 20px;
            }
            
            .admin-table {
                font-size: 0.85rem;
            }
            
            .admin-nav-buttons {
                flex-direction: column;
            }
            
            .admin-nav-btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="admin-dashboard">
        <div class="admin-dashboard-header">
            <h1><i class="bi bi-gear-fill"></i> Админ-панель</h1>
            <p>Управляйте сайтом и контентом</p>
        </div>

        <div class="admin-stats-grid">
            <div class="admin-stat-card">
                <div class="admin-stat-icon blue">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="admin-stat-content">
                    <div class="admin-stat-value"><?= $usersCount ?></div>
                    <div class="admin-stat-label">Пользователей</div>
                </div>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-icon green">
                    <i class="bi bi-map-fill"></i>
                </div>
                <div class="admin-stat-content">
                    <div class="admin-stat-value"><?= $toursCount ?></div>
                    <div class="admin-stat-label">Туров</div>
                </div>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-icon orange">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div class="admin-stat-content">
                    <div class="admin-stat-value" id="adminStoriesCount">—</div>
                    <div class="admin-stat-label"> Истории мод</div>
                </div>
            </div>
            
            <div class="admin-stat-card">
                <div class="admin-stat-icon purple">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div class="admin-stat-content">
                    <div class="admin-stat-value"><?= count($recentUsers) ?></div>
                    <div class="admin-stat-label">Новых пользователей</div>
                </div>
            </div>
        </div>

        <div class="admin-section">
            <div class="admin-section-header">
                <h2 class="admin-section-title">
                    <i class="bi bi-lightning-charge-fill"></i> Быстрые действия
                </h2>
                <p class="admin-section-subtitle">Доступные операции управления</p>
            </div>
            <div class="admin-quick-actions">
                <a href="tours.php" class="admin-action-btn">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Добавить тур</span>
                </a>
                <a href="routes.php" class="admin-action-btn">
                    <i class="bi bi-card-list"></i>
                    <span>Карточки маршрутов</span>
                </a>
                <a href="users.php" class="admin-action-btn">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Пользователи</span>
                </a>
                <a href="reviews.php" class="admin-action-btn">
                    <i class="bi bi-journal-text"></i>
                    <span>Модерация историй</span>
                </a>
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-nav-buttons">
            <a href="../index.php" class="admin-nav-btn admin-nav-btn-primary">
                <i class="bi bi-house-door"></i> На сайт
            </a>
        </div>
    </div>

    <script>
        const stories = JSON.parse(localStorage.getItem('locals_stories')) || [];
        document.getElementById('adminStoriesCount').textContent = stories.length;
    </script>
</body>
</html>
