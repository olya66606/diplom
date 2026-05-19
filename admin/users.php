<?php
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();

$pdo = getDbConnection();
$message = '';
$messageType = '';

// Получение текущего пользователя из сессии
$currentUserId = $_SESSION['user_id'] ?? 0;

// Обработка удаления пользователя
if (isset($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    if ($deleteId !== $currentUserId) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$deleteId]);
        $message = 'Пользователь удален';
        $messageType = 'success';
    } else {
        $message = 'Нельзя удалить самого себя';
        $messageType = 'error';
    }
}

// Обработка изменения роли
if (isset($_POST['update_role'])) {
    $userId = (int)$_POST['user_id'];
    $newRole = $_POST['role'];
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$newRole, $userId]);
    $message = 'Роль обновлена';
    $messageType = 'success';
}

// Обработка редактирования пользователя
if (isset($_POST['edit_user'])) {
    $userId = (int)$_POST['user_id'];
    $newName = trim($_POST['name']);
    $newEmail = trim($_POST['email']);
    $newRole = $_POST['role'];
    
    if (!empty($newName) && !empty($newEmail)) {
        // Проверка email на уникальность
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$newEmail, $userId]);
        if ($stmt->rowCount() > 0) {
            $message = 'Email уже используется';
            $messageType = 'error';
        } else {
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->execute([$newName, $newEmail, $newRole, $userId]);
            $message = 'Пользователь обновлён';
            $messageType = 'success';
        }
    } else {
        $message = 'Заполните все поля';
        $messageType = 'error';
    }
}

// Получение данных пользователя для редактирования
$editUser = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$editId]);
    $editUser = $stmt->fetch();
}

// Получение всех пользователей
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Управление пользователями | Админ-панель</title>
    <style>
        .admin-users-container {
            max-width: 1400px;
            margin: 100px auto;
            padding: 0 20px;
        }
        
        .admin-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .admin-header h1 {
            font-size: 2.5rem;
            color: #1b5031;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .admin-header p {
            font-size: 1.2rem;
            color: #666;
        }
        
        .admin-card {
            background: white;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 30px;
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
        
        .users-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .users-table th {
            text-align: left;
            padding: 18px 15px;
            background: #f8f9fc;
            color: #1b5031;
            font-weight: 700;
            font-size: 1rem;
            border-bottom: 2px solid #e8ecf1;
        }
        
        .users-table td {
            padding: 18px 15px;
            border-bottom: 1px solid #e8ecf1;
            color: #555;
            font-size: 0.95rem;
        }
        
        .users-table tr:hover {
            background: #f8f9fc;
        }
        
        .user-badge {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .user-badge-admin {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
        }
        
        .user-badge-user {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            color: white;
        }
        
        .role-select {
            padding: 8px 14px;
            border: 2px solid #e8ecf1;
            border-radius: 20px;
            font-size: 0.9rem;
            font-family: 'Mulish', sans-serif;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .role-select:focus {
            border-color: #2e8d53;
            outline: none;
        }
        
        .user-actions {
            display: flex;
            gap: 10px;
        }
        
        .user-action-btn {
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
        
        .btn-delete {
            background: #f8f9fc;
            color: #ff6b6b;
            border: 2px solid #ff6b6b;
        }
        
        .btn-delete:hover {
            background: #ff6b6b;
            color: white;
            transform: scale(1.1);
        }
        
        .user-avatar {
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
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-name {
            font-weight: 600;
            color: #1b5031;
        }
        
        .user-email {
            font-size: 0.85rem;
            color: #888;
        }
        
        .admin-nav {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .admin-nav-btn {
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            font-family: 'Mulish', sans-serif;
            display: flex;
            align-items: center;
            gap: 8px;
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
        
        .you-badge {
            background: #f0f2f5;
            color: #999;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .admin-users-container {
                margin: 60px auto;
            }
            
            .admin-header h1 {
                font-size: 1.8rem;
            }
            
            .admin-card {
                padding: 20px;
                overflow-x: auto;
            }
            
            .users-table {
                min-width: 700px;
            }
            
            .admin-nav {
                flex-direction: column;
            }
            
            .admin-nav-btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="admin-users-container">
        <div class="admin-header">
            <h1><i class="bi bi-people-fill"></i> Управление пользователями</h1>
            <p>Управляйте пользователями и их ролями</p>
        </div>

        <?php if ($message): ?>
            <div class="admin-alert <?= $messageType ?>">
                <i class="bi <?= $messageType === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?>"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="admin-card">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Пользователь</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="user-name"><?= htmlspecialchars($u['name']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="user-email"><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <?php if ($u['id'] != $currentUserId): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                    <select name="role" class="role-select" onchange="this.form.submit()">
                                        <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>Пользователь</option>
                                        <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Админ</option>
                                    </select>
                                    <input type="hidden" name="update_role" value="1">
                                </form>
                            <?php else: ?>
                                <span class="user-badge user-badge-admin">Админ</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d.m.Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <div class="user-actions">
                                <?php if ($u['id'] != $currentUserId): ?>
                                    <a href="?delete=<?= $u['id'] ?>" 
                                       class="user-action-btn btn-delete" 
                                       onclick="return ">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="you-badge">Вы</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-nav">
            <a href="dashboard.php" class="admin-nav-btn admin-nav-btn-secondary">
                <i class="bi bi-arrow-left"></i> Назад в панель
            </a>
            <a href="../index.php" class="admin-nav-btn admin-nav-btn-primary">
                <i class="bi bi-house-door"></i> На сайт
            </a>
        </div>
    </div>
</body>
</html>
