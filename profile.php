<?php
require_once 'includes/auth_functions.php';

// Защита страницы - только для авторизованных пользователей
requireLogin();

$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <link rel="icon" href="img/logoosn.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>Личный кабинет | Туры Везде</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Mulish', sans-serif; background: linear-gradient(135deg, #bcddff54, #98dbb8a1); padding: 20px; }
        .profile-container { max-width: 800px; margin: 80px auto 20px; background: white; border-radius: 30px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        h1 { color: #1b5031; margin-bottom: 30px; border-bottom: 3px solid #e3f7ee; padding-bottom: 15px; }
        .user-info { background: #e3f7ee; padding: 20px; border-radius: 20px; margin-bottom: 30px; }
        .user-info p { font-size: 1.2rem; margin-bottom: 10px; }
        .route-section h2 { color: #333; margin-bottom: 20px; }
        .route-item { background: #f8f9fa; padding: 15px; border-radius: 12px; margin-bottom: 10px; border-left: 4px solid #2e8d53; }
        .logout-btn { background: #e74c3c; color: white; border: none; padding: 12px 25px; border-radius: 50px; font-size: 1rem; cursor: pointer; margin-top: 20px; }
        .logout-btn:hover { background: #c0392b; }
        .back-link { margin-top: 20px; display: inline-block; color: #2e8d53; text-decoration: none; }

        /* Сохраненные туры */
        .saved-tours-section { margin-top: 40px; }
        .saved-tours-section h2 { color: #1b5031; margin-bottom: 25px; }
        .saved-tours-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .saved-tour-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.3s; }
        .saved-tour-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .saved-tour-image { height: 180px; background-size: cover; background-position: center; position: relative; }
        .saved-tour-content { padding: 20px; }
        .saved-tour-title { font-size: 1.2rem; color: #1b5031; margin-bottom: 10px; font-weight: 600; }
        .saved-tour-meta { display: flex; justify-content: space-between; margin-bottom: 15px; color: #666; font-size: 0.9rem; }
        .saved-tour-price { font-size: 1.3rem; font-weight: 700; color: #2e8d53; }
        .saved-tour-actions { display: flex; gap: 10px; }
        .tour-action-btn { flex: 1; padding: 10px; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; transition: all 0.3s; }
        .btn-view-tour { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; }
        .btn-view-tour:hover { transform: scale(1.05); }
        .btn-delete-tour { background: #fee; color: #e74c3c; border: 2px solid #e74c3c; }
        .btn-delete-tour:hover { background: #e74c3c; color: white; }
        .no-tours { text-align: center; padding: 40px; background: #f8f9fc; border-radius: 20px; color: #999; }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="profile-container">
        <h1><i class="bi bi-person-circle"></i> Личный кабинет</h1>
        <div class="user-info">
            <p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Дата регистрации:</strong> <?= date('d.m.Y', strtotime($user['created_at'] ?? 'now')) ?></p>
        </div>
        <div class="route-section">
            <h2><i class="bi bi-signpost-split"></i> Ваш сохраненный маршрут</h2>
            <div id="userRoute">
                <p>Здесь будет отображаться ваш маршрут...</p>
            </div>
        </div>
        
        <div class="saved-tours-section">
            <h2><i class="bi bi-bookmark-heart"></i> Сохраненные туры</h2>
            <div id="savedTours" class="saved-tours-grid">
                <div class="no-tours">Загрузка туров...</div>
            </div>
        </div>
        
        <button class="logout-btn" id="logoutBtn">Выйти</button>
        <br>
        <a href="index.php" class="back-link"><i class="bi bi-arrow-left"></i> На главную</a>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');

            logoutBtn.addEventListener('click', function() {
                window.location.href = 'auth/logout.php';
            });
            
            // Загрузка сохраненных туров
            loadSavedTours();
        });
        
        function loadSavedTours() {
            fetch('/api/get_saved_tours.php')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('savedTours');
                    
                    if (!data.tours || data.tours.length === 0) {
                        container.innerHTML = '<div class="no-tours">У вас пока нет сохраненных туров</div>';
                        return;
                    }
                    
                    container.innerHTML = data.tours.map(tour => `
                        <div class="saved-tour-card" data-tour-id="${tour.tour_id}">
                            <div class="saved-tour-image" style="background-image: url('${tour.tour_image || 'img/default-tour.jpg'}')"></div>
                            <div class="saved-tour-content">
                                <h3 class="saved-tour-title">${tour.tour_title}</h3>
                                <div class="saved-tour-meta">
                                    <span><i class="bi bi-clock"></i> ${tour.tour_duration} дня</span>
                                    <span class="saved-tour-price">${parseInt(tour.tour_price).toLocaleString('ru-RU')} ₽</span>
                                </div>
                                <div class="saved-tour-actions">
                                    <button class="tour-action-btn btn-view-tour" onclick="showTourDetails(${tour.tour_id})">
                                        <i class="bi bi-eye"></i> Подробнее
                                    </button>
                                    <button class="tour-action-btn btn-delete-tour" onclick="deleteSavedTour(${tour.tour_id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `).join('');
                })
                .catch(error => {
                    console.error('Ошибка загрузки туров:', error);
                    document.getElementById('savedTours').innerHTML = '<div class="no-tours">Ошибка загрузки сохраненных туров</div>';
                });
        }
        
        function deleteSavedTour(tourId) {
            if (!confirm) return;
            
            fetch('/api/delete_saved_tour.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ tour_id: tourId })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    loadSavedTours();
                
                } else {
                
                }
            })
            .catch(error => {
                console.error('Ошибка удаления:', error);
            
            });
        }
    </script>
</body>
</html>
