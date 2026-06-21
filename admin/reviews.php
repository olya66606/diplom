<?php
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();

$pdo = getDbConnection();

// Получение статистики
$stmt = $pdo->query("SELECT COUNT(*) FROM user_stories WHERE is_approved = 0");
$pendingCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM user_stories WHERE is_approved = 1");
$approvedCount = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM user_stories");
$totalCount = $stmt->fetchColumn();

// Получение историй
$city = $_GET['city'] ?? 'all';
$status = $_GET['status'] ?? 'pending';

$where = [];
$params = [];

if ($city !== 'all') {
    $where[] = "city = ?";
    $params[] = $city;
}

if ($status === 'pending') {
    $where[] = "is_approved = 0";
} elseif ($status === 'approved') {
    $where[] = "is_approved = 1";
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
$stmt = $pdo->prepare("SELECT * FROM user_stories $whereSql ORDER BY created_at DESC");
$stmt->execute($params);
$stories = $stmt->fetchAll();

$categoryNames = [
    'coffee' => 'Кофе',
    'walk' => 'Прогулки',
    'secret' => 'Секретное',
    'romantic' => 'Романтика',
    'food' => 'Еда',
    'view' => 'Виды'
];

$cityNames = [
    'saint-petersburg' => 'Санкт-Петербург',
    'kaliningrad' => 'Калининград',
    'moscow' => 'Москва',
    'sochi' => 'Сочи'
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Модерация историй | Админ-панель</title>
    <style>
        .admin-stories { 
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
            background: #d4edda; 
            color: #155724; 
            border: 2px solid #28a745; 
        }
        .admin-stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }
        .admin-stat-card { 
            background: white; 
            border-radius: 20px; 
            padding: 24px; 
            text-align: center; 
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
         }
        .admin-stat-value { 
            font-size: 2.2rem; 
            font-weight: 800; 
            color: #2e8d53; 
        }
        .admin-stat-label { 
            font-size: 0.95rem; 
            color: #666; 
            margin-top: 6px; 
            font-weight: 600; 
        }
        .admin-card { 
            background: white; 
            border-radius: 24px; 
            padding: 35px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        }
        .admin-filters { 
            display: flex;
            gap: 15px; 
            margin-bottom: 30px; 
            flex-wrap: wrap; 
        }
        .admin-filter-btn {
             padding: 12px 24px; 
             border-radius: 50px; 
             text-decoration: none;
             color: #666; 
             font-weight: 600; 
             transition: all 0.3s; 
             font-family: 'Mulish', sans-serif; 
             border: 2px solid #e8ecf1; 
             background: #f8f9fc; 
             cursor: pointer; 
            }
        .admin-filter-btn:hover { 
            background: #e8ecf1; 
            transform: translateY(-2px); 
        }
        .admin-filter-btn.active { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
            border-color: transparent; 
        }
        .admin-story-item { 
            border: 1px solid #e8ecf1; 
            border-radius: 20px; 
            padding: 25px; 
            margin-bottom: 20px; 
            transition: all 0.3s; 
        }
        .admin-story-item:hover { 
            box-shadow: 0 5px 20px rgba(0,0,0,0.08); 
            transform: translateY(-2px); 
        }
        .admin-story-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start; 
            margin-bottom: 15px; 
            flex-wrap: wrap; 
            gap: 15px; 
        }
        .admin-story-author-info { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
        }
        .admin-story-avatar {
             width: 45px; 
             height: 45px; 
             border-radius: 50%; 
             background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
             color: white; 
             display: flex; 
             align-items: center; 
             justify-content: center; 
             font-weight: 700; 
             font-size: 1.2rem; 
            }
        .admin-story-author-name { 
            font-weight: 700; 
            color: #1b5031; 
            font-size: 1.1rem; 
        }
        .admin-story-city { 
            color: #666; 
            font-size: 0.95rem; 
        }
        .admin-story-category { 
            padding: 6px 16px; 
            border-radius: 30px; 
            font-size: 0.85rem; 
            font-weight: 600; 
            background: #f0fff4; 
            color: #2e8d53; 
            border: 1px solid #d4f0e4; 
        }
        .admin-story-title { 
            font-size: 1.2rem; 
            font-weight: 700; 
            color: #1b5031; 
            margin: 12px 0 8px; 
        }
        .admin-story-text { 
            color: #555; 
            line-height: 1.7; 
            margin: 10px 0; 
            font-size: 1rem; 
        }
        .admin-story-place { 
            background: linear-gradient(135deg, #f8f9fc 0%, #e8ecf1 100%); 
            padding: 12px 16px; 
            border-radius: 14px; 
            margin: 12px 0; 
        }
        .admin-story-place-name { 
            font-weight: 700; 
            color: #1b5031; 
            font-size: 0.95rem; 
        }
        .admin-story-place-address { 
            font-size: 0.85rem; 
            color: #666; 
            margin-top: 2px; 
        }
        .admin-story-meta { 
            display: flex; 
            gap: 20px; 
            font-size: 0.9rem; 
            color: #999; 
            margin: 15px 0; 
            flex-wrap: wrap; 
        }
        .admin-story-actions { 
            display: flex; 
            gap: 12px; 
            flex-wrap: wrap; 
        }
        .admin-story-btn { 
            padding: 12px 24px; 
            border-radius: 50px;
            border: none; 
            cursor: pointer; 
            font-weight: 600;
             transition: all 0.3s; 
             font-family: 'Mulish', sans-serif; 
             display: inline-flex; 
             align-items: center; 
             gap: 8px; font-size: 0.95rem; 
             text-decoration: none; 
            }
        .admin-story-btn-delete { 
            background: #ff6b6b; 
            color: white; 
        }
        .admin-story-btn-delete:hover { 
            background: #ee5253; 
            transform: translateY(-2px); 
        }
        .admin-story-btn-edit { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
        }
        .admin-story-btn-edit:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(46,141,83,0.4); 
        }
        .admin-nav-buttons { 
            display: flex; 
            gap: 15px; 
            justify-content: center; 
            margin-top: 30px; 
        }
        .admin-nav-btn { 
            padding: 14px 32px; 
            border-radius: 50px; 
            font-weight: 600; 
            transition: all 0.3s; 
            font-family: 'Mulish', sans-serif; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-size: 1rem; 
            text-decoration: none; 
        }
        .admin-nav-btn-primary { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 

            color: white; }
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
        .admin-story-btn-approve { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
        }
        .admin-story-btn-approve:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(46,141,83,0.4); 
        }
        .empty-state { 
            text-align: center; 
            padding: 60px 20px; 
        }
        .empty-state i { 
            font-size: 3rem;
             color: #ccc; 
             margin-bottom: 15px; 
            }
        .empty-state h3 { 
            color: #999; 
            font-weight: 600; 
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-content h3 {
            color: #1b5031;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .modal-content p {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .modal-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .modal-btn {
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Mulish', sans-serif;
            font-size: 1rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .modal-btn-approve {
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
        }
        .modal-btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46,141,83,0.4);
        }
        .modal-btn-delete {
            background: #ff6b6b;
            color: white;
        }
        .modal-btn-delete:hover {
            background: #ee5253;
            transform: translateY(-2px);
        }
        .modal-btn-cancel {
            background: #f8f9fc;
            color: #666;
            border: 2px solid #e8ecf1;
        }
        .modal-btn-cancel:hover {
            background: #e8ecf1;
        }
        .modal-btn-loading {
            opacity: 0.7;
            pointer-events: none;
        }
        .error-message {
            color: #ff6b6b;
            font-size: 0.9rem;
            margin-top: 15px;
            font-weight: 600;
        }
        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            background: none;
            border: none;
        }
        .modal-close:hover {
            color: #1b5031;
        }
        @media (max-width: 768px) { 
            .admin-stories {
                 margin: 60px auto; 
                } 
                .admin-page-header h1 { 
                    font-size: 1.8rem; 
                }
                 .admin-card { 
                    padding: 20px;
                 } 
                 .admin-story-header { 
                    flex-direction: column; 
                } 
            }
    </style>
</head>
<body>
    <div class="admin-stories">
        <div class="admin-page-header">
            <h1><i class="bi bi-journal-text"></i> Модерация историй</h1>
            <p>Управляйте историями местных жителей</p>
        </div>

        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="admin-stat-value"><?= $totalCount ?></div>
                <div class="admin-stat-label">Всего историй</div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-value"><?= $pendingCount ?></div>
                <div class="admin-stat-label">На модерации</div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-value"><?= $approvedCount ?></div>
                <div class="admin-stat-label">Одобрено</div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-filters">
                <a href="?status=pending&city=all" class="admin-filter-btn <?= ($status === 'pending' && $city === 'all') ? 'active' : '' ?>">
                    <i class="bi bi-clock"></i> На модерации
                </a>
                <a href="?status=approved&city=all" class="admin-filter-btn <?= ($status === 'approved') ? 'active' : '' ?>">
                    <i class="bi bi-check-circle"></i> Одобренные
                </a>
                <div style="flex: 1;"></div>
                <a href="?status=<?= $status ?>&city=saint-petersburg" class="admin-filter-btn <?= ($city === 'saint-petersburg') ? 'active' : '' ?>">
                    <i class="bi bi-building"></i> СПб
                </a>
                <a href="?status=<?= $status ?>&city=kaliningrad" class="admin-filter-btn <?= ($city === 'kaliningrad') ? 'active' : '' ?>">
                    <i class="bi bi-water"></i> Калининград
                </a>
            </div>

            <?php if (empty($stories)): ?>
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h3>Историй не найдено</h3>
                </div>
            <?php else: ?>
                <?php foreach ($stories as $story): ?>
                    <div class="admin-story-item">
                        <div class="admin-story-header">
                            <div class="admin-story-author-info">
                                <div class="admin-story-avatar"><?= htmlspecialchars($story['author'][0]) ?></div>
                                <div>
                                    <div class="admin-story-author-name"><?= htmlspecialchars($story['author']) ?></div>
                                    <div class="admin-story-city"><i class="bi bi-geo-alt"></i> <?= $cityNames[$story['city']] ?? $story['city'] ?></div>
                                </div>
                            </div>
                            <span class="admin-story-category">
                                <i class="bi bi-tag"></i> <?= $categoryNames[$story['category']] ?? $story['category'] ?>
                            </span>
                        </div>

                        <div class="admin-story-title"><?= htmlspecialchars($story['title']) ?></div>
                        <p class="admin-story-text"><?= htmlspecialchars($story['text']) ?></p>

                        <div class="admin-story-place">
                            <div class="admin-story-place-name"><i class="bi bi-shop"></i> <?= htmlspecialchars($story['place_name']) ?></div>
                            <div class="admin-story-place-address"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($story['place_address']) ?></div>
                        </div>

                        <div class="admin-story-meta">
                            <span><i class="bi bi-calendar"></i> <?= date('d.m.Y H:i', strtotime($story['created_at'])) ?></span>
                            <span><i class="bi bi-<?= $story['is_approved'] ? 'check-circle' : 'clock' ?>"></i> 
                                <?= $story['is_approved'] ? 'Одобрена' : 'На модерации' ?>
                            </span>
                        </div>

                        <div class="admin-story-actions">
                            <?php if (!$story['is_approved']): ?>
                                <button class="admin-story-btn admin-story-btn-approve" onclick="openApproveModal(<?= $story['id'] ?>, '<?= addslashes(htmlspecialchars($story['title'])) ?>')">
                                    <i class="bi bi-check-circle"></i> Одобрить
                                </button>
                            <?php endif; ?>
                            <button class="admin-story-btn admin-story-btn-delete" onclick="openDeleteModal(<?= $story['id'] ?>, '<?= addslashes(htmlspecialchars($story['title'])) ?>')">
                                <i class="bi bi-trash"></i> Удалить
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="admin-nav-buttons">
            <a href="dashboard.php" class="admin-nav-btn admin-nav-btn-secondary"><i class="bi bi-arrow-left"></i> Назад в панель</a>
            <a href="../locals.php" class="admin-nav-btn admin-nav-btn-primary"><i class="bi bi-journal-text"></i> На страницу</a>
        </div>
    </div>

    <!-- Модальное окно подтверждения одобрения -->
    <div id="approveModal" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('approveModal')">&times;</button>
            <h3><i class="bi bi-check-circle" style="color: #2e8d53;"></i> Одобрить историю</h3>
            <p id="approveModalText"></p>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-cancel" onclick="closeModal('approveModal')">Отмена</button>
                <button class="modal-btn modal-btn-approve" id="approveConfirmBtn">
                    <i class="bi bi-check-circle-fill"></i> Одобрить
                </button>
            </div>
        </div>
    </div>

    <!-- Модальное окно подтверждения удаления -->
    <div id="deleteModal" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('deleteModal')">&times;</button>
            <h3><i class="bi bi-trash" style="color: #ff6b6b;"></i> Удалить историю</h3>
            <p id="deleteModalText"></p>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-cancel" onclick="closeModal('deleteModal')">Отмена</button>
                <button class="modal-btn modal-btn-delete" id="deleteConfirmBtn">
                    <i class="bi bi-trash-fill"></i> Удалить
                </button>
            </div>
        </div>
    </div>

    <!-- Модальное окно ошибки -->
    <div id="errorMessage" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
        <div class="modal-content">
            <h3><i class="bi bi-exclamation-triangle" style="color: #ff6b6b;"></i> Ошибка</h3>
            <p id="errorMessageText" style="color: #ff6b6b; font-weight: 600;"></p>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-cancel" onclick="document.getElementById('errorMessage').classList.remove('active')">Закрыть</button>
            </div>
        </div>
    </div>

    <script>
        let currentStoryId = null;

        function openApproveModal(id, title) {
            currentStoryId = id;
            document.getElementById('approveModalText').textContent = 'Вы уверены, что хотите одобрить историю "' + title + '"? Она будет опубликована на странице местных жителей.';
            document.getElementById('approveConfirmBtn').onclick = function() {
                performAction(id, 'approve');
            };
            document.getElementById('approveModal').classList.add('active');
        }

        function openDeleteModal(id, title) {
            currentStoryId = id;
            document.getElementById('deleteModalText').textContent = 'Вы уверены, что хотите удалить историю "' + title + '"? Это действие нельзя отменить.';
            document.getElementById('deleteConfirmBtn').onclick = function() {
                performAction(id, 'delete');
            };
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            currentStoryId = null;
        }

        async function performAction(id, action) {
            const btn = document.getElementById(action === 'approve' ? 'approveConfirmBtn' : 'deleteConfirmBtn');
            btn.classList.add('modal-btn-loading');
            btn.disabled = true;
            
            try {
                const response = await fetch('../api/moderate_story.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: action, id: id })
                });
                const result = await response.json();
                
                if (result.success) {
                    closeModal(action === 'approve' ? 'approveModal' : 'deleteModal');
                    location.reload();
                } else {
                    document.getElementById('errorMessageText').textContent = result.message || 'Что-то пошло не так';
                    document.getElementById('errorMessage').classList.add('active');
                }
            } catch (e) {
                document.getElementById('errorMessageText').textContent = 'Ошибка соединения с сервером: ' + e.message;
                document.getElementById('errorMessage').classList.add('active');
            } finally {
                btn.classList.remove('modal-btn-loading');
                btn.disabled = false;
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('approveModal');
                closeModal('deleteModal');
            }
        });
    </script>
</body>
</html>
