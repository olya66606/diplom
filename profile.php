<?php
require_once 'includes/auth_functions.php';
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
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        body {
             font-family: 'Mulish', sans-serif;
              background: linear-gradient(135deg, #bcddff54, #98dbb8a1); 
              padding: 0 20px;
            }
        .profile-container { 
            max-width: 800px; 
            margin: 80px auto 20px; 
            background: white; 
            border-radius: 30px; 
            padding: 40px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); 
        }
        h1 { 
            color: #1b5031;
            margin-bottom: 30px;
            border-bottom: 3px solid #e3f7ee; 
            padding-bottom: 15px; 
            }
        .user-info { 
            background: #e3f7ee;
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 30px; 
            }
        .user-info p { 
            font-size: 1.2rem;
             margin-bottom: 10px; 
            }
        .route-section h2 { 
            color: #333;
             margin-bottom: 20px; 
            }
        .route-item {
            background: #f8f9fa;
            padding: 15px; 
            border-radius: 12px;
            margin-bottom: 10px;
            border-left: 4px solid #2e8d53; 
        }
        .logout-btn { 
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px; 
            font-size: 1rem; 
            cursor: pointer; 
            margin-top: 20px; 
        }
        .logout-btn:hover { 
            background: #c0392b; 
        }
        .back-link { 
            margin-top: 20px; 
            display: inline-block; 
            color: #2e8d53; 
            text-decoration: none; 
        }

        /* Сохраненные туры */
        .saved-tours-section { 
            margin-top: 40px;
         }
        .saved-tours-section h2 { 
            color: #1b5031; 
            margin-bottom: 25px; 
        }
        .saved-tours-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 20px; 
            margin-top: 20px; 
        }
        .saved-tour-card { 
            background: white; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1); 
            transition: all 0.3s; 
        }
        .saved-tour-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.15); 
        }
        .saved-tour-image { 
            height: 180px; 
            background-size: cover; 
            background-position: center; 
            position: relative; 
        }
        .saved-tour-content { 
            padding: 20px; 
        }
        .saved-tour-title { 
            font-size: 1.2rem; 
            color: #1b5031; 
            margin-bottom: 10px; 
            font-weight: 600; 
        }
        .saved-tour-meta { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 15px; 
            color: #666; 
            font-size: 0.9rem; 
        }
        .saved-tour-price { 
            font-size: 1.3rem; 
            font-weight: 700; 
            color: #2e8d53; 
        }
        .saved-tour-actions { 
            display: flex; 
            gap: 10px; 
        }
        .tour-action-btn { 
            flex: 1; 
            padding: 10px; 
            border: none; 
            border-radius: 10px; 
            cursor: pointer; 
            font-weight: 600; 
            transition: all 0.3s; 
        }
        .btn-view-tour { 
            background:  linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
        }
        .btn-view-tour:hover { 
            transform: scale(1.05); 
        }
        .btn-delete-tour { 
            background: #fee; 
            color: #e74c3c;
            border: 2px solid #e74c3c; 
        }

        .btn-delete-tour:hover { 
            background: #e74c3c; 
            color: white; 
        }
        .no-tours { 
            text-align: center; 
            padding: 40px; 
            background: #f8f9fc; 
            border-radius: 20px; 
            color: #999; 
        }
        .tour-source-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
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
                <p>Загрузка маршрутов...</p>
            </div>
            <a href="planner.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background:  linear-gradient(135deg, #266d59 0%, #3a8340 100%); color: white; text-decoration: none; border-radius: 50px; font-weight: 600;">
                <i class="bi bi-map"></i> Создать новый маршрут
            </a>
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
            
           
            loadSavedRoutes();
            
           
            loadSavedTours();
        });
            

        function loadSavedRoutes() {
            const userRoute = document.getElementById('userRoute');
            
         
            let savedRoutes = JSON.parse(localStorage.getItem('saved_routes')) || [];
            
            const plannerRoutes = savedRoutes.filter(route => 
                route.source === 'planner' || 
                (route.places && route.places.length > 0 && !route.id)
            );
            
            if (plannerRoutes.length === 0) {
                userRoute.innerHTML = `
                    <div style="text-align: center; padding: 40px; background: #f8f9fc; border-radius: 20px;">
                        <i class="bi bi-compass" style="font-size: 3rem; color: #2e8d53; margin-bottom: 15px; display: block;"></i>
                        <h3 style="color: #1b5031; margin-bottom: 10px;">Нет сохранённых маршрутов</h3>
                        <p style="color: #666; margin-bottom: 20px;">Создайте маршрут в конструкторе маршрутов</p>
                        <a href="planner.php" style="display: inline-block; padding: 12px 30px; background:  linear-gradient(135deg, #266d59 0%, #3a8340 100%); color: white; text-decoration: none; border-radius: 50px; font-weight: 600;">
                            <i class="bi bi-map"></i> Создать маршрут
                        </a>
                    </div>
                `;
                return;
            }
            
            let html = '<div style="display: flex; flex-direction: column; gap: 15px;">';
            
            plannerRoutes.forEach((route, index) => {
                const routeName = route.name || (route.places ? `Маршрут (${route.places.length} мест)` : 'Маршрут');
                const routeDate = route.date ? new Date(route.date).toLocaleDateString('ru-RU') : '';
                const placeCount = route.places ? route.places.length : 0;
                
                html += `
                    <div style="display: flex; gap: 15px; background: #f8f9fa; padding: 15px; border-radius: 16px; border-left: 4px solid #2e8d53;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; background:  linear-gradient(135deg, #266d59 0%, #3a8340 100%); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem;">
                            ${index + 1}
                        </div>
                        <div style="flex-grow: 1;">
                            <h4 style="color: #1b5031; margin-bottom: 5px;">${routeName}</h4>
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #666;">
                                <i class="bi bi-geo-alt" style="color: #2e8d53;"></i>
                                <span>${placeCount} мест</span>
                                ${routeDate ? `<span style="margin-left: 15px;"><i class="bi bi-calendar"></i> ${routeDate}</span>` : ''}
                            </div>
                        </div>
                        <div style="flex-shrink: 0; display: flex; align-items: center; gap: 10px;">
                            <button onclick="loadRouteToPlanner(${index})" style="padding: 8px 16px; background: #2e8d53; color: white; border: none; border-radius: 20px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                                <i class="bi bi-map"></i> Открыть
                            </button>
                            <button onclick="deleteSavedRoute(${index})" style="padding: 8px 12px; background: #fee; color: #e74c3c; border: none; border-radius: 20px; font-size: 0.85rem; cursor: pointer;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            userRoute.innerHTML = html;
        }
        
        // Загрузить маршрут в конструктор
        function loadRouteToPlanner(routeIndex) {
            let savedRoutes = JSON.parse(localStorage.getItem('saved_routes')) || [];
            const plannerRoutes = savedRoutes.filter(route => 
                route.source === 'planner' || 
                (route.places && route.places.length > 0 && !route.id)
            );
            const route = plannerRoutes[routeIndex];
            
            if (route && route.places) {
                localStorage.setItem('selected_places', JSON.stringify(route.places));
                showNotification('Маршрут загружен в конструктор!');
                window.location.href = 'planner.php';
            }
        }
        
    
        function deleteSavedRoute(routeIndex) {
            let savedRoutes = JSON.parse(localStorage.getItem('saved_routes')) || [];
            const plannerRoutes = savedRoutes.filter(route => 
                route.source === 'planner' || 
                (route.places && route.places.length > 0 && !route.id)
            );
            const routeToDelete = plannerRoutes[routeIndex];
            
         
            const originalIndex = savedRoutes.findIndex(r => r.name === routeToDelete.name && r.date === routeToDelete.date);
            
            if (originalIndex !== -1) {
                savedRoutes.splice(originalIndex, 1);
                localStorage.setItem('saved_routes', JSON.stringify(savedRoutes));
                loadSavedRoutes();
                showNotification('Маршрут удалён!');
            }
        }
        
    
        function loadSavedTours() {
            const container = document.getElementById('savedTours');
            
        
            let savedTours = JSON.parse(localStorage.getItem('saved_routes')) || [];
            const mainPageTours = savedTours.filter(tour => tour.source === 'main-page');
            
            if (mainPageTours.length === 0) {
                container.innerHTML = '<div class="no-tours">У вас пока нет сохранённых туров. Выберите тур на главной странице!</div>';
                return;
            }
            
            container.innerHTML = mainPageTours.map((tour, index) => {
                const tourName = tour.name || 'Тур';
                const tourImage = tour.image || 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
                const placeCount = tour.places ? tour.places.length : 0;
                const tourDate = tour.date ? new Date(tour.date).toLocaleDateString('ru-RU') : new Date().toLocaleDateString('ru-RU');
                
                return `
                    <div class="saved-tour-card">
                        <div class="saved-tour-image" style="background-image: url('${tourImage}')">
                            <span class="tour-source-badge"><i class="bi bi-building"></i> Тур</span>
                        </div>
                        <div class="saved-tour-content">
                            <h3 class="saved-tour-title">${tourName}</h3>
                            <div class="saved-tour-meta">
                                <span><i class="bi bi-geo-alt"></i> ${placeCount} мест</span>
                                <span><i class="bi bi-calendar"></i> ${tourDate}</span>
                            </div>
                            ${tour.price ? `<div class="saved-tour-price"><i class="bi bi-cash-coin"></i> ${parseInt(tour.price).toLocaleString('ru-RU')} ₽</div>` : ''}
                            <div class="saved-tour-actions">
                                <button class="tour-action-btn btn-view-tour" onclick="viewTour(${index})">
                                    <i class="bi bi-eye"></i> Смотреть
                                </button>
                                <button class="tour-action-btn btn-delete-tour" onclick="deleteSavedTour(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }
        
        function viewTour(index) {
            let savedTours = JSON.parse(localStorage.getItem('saved_routes')) || [];
            const mainPageTours = savedTours.filter(tour => tour.source === 'main-page');
            const tour = mainPageTours[index];
            
            if (tour && tour.id) {
             
                showNotification('Открываю страницу тура...');
                setTimeout(() => {
                    window.location.href = 'index.php?tour=' + tour.id;
                }, 500);
            }
        }
        
        function deleteSavedTour(index) {
            let savedTours = JSON.parse(localStorage.getItem('saved_routes')) || [];
            const mainPageTours = savedTours.filter(tour => tour.source === 'main-page');
            const tourToDelete = mainPageTours[index];
            
         
            const originalIndex = savedTours.findIndex(t => t.id === tourToDelete.id && t.name === tourToDelete.name);
            
            if (originalIndex !== -1) {
                savedTours.splice(originalIndex, 1);
                localStorage.setItem('saved_routes', JSON.stringify(savedTours));
                loadSavedTours();
                showNotification('Тур удалён!');
            }
        }
        
        
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
                color: white;
                padding: 15px 25px;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease;
            `;
            notification.innerHTML = `<i class="bi bi-check-circle-fill"></i> ${message}`;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
    </script>
</body>
</html>
