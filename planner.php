<?php
require_once 'includes/auth_functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="icon" href="img/logoosn.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Конструктор маршрутов | Туры Везде</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Mulish', sans-serif;
            background: linear-gradient(135deg, #bcddff54, #98dbb8a1);
            padding-top: 90px;
        }
        /* Planner Container */
        .planner-container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        /* Info Block */
        .info-block {
            background: white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .city-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .city-info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fc 0%, #e8ecf1 100%);
            border-radius: 16px;
            transition: all 0.3s;
        }
        
        .city-info-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(46,141,83,0.2);
        }
        
        .city-info-item i {
            font-size: 1.8rem;
            color: #2e8d53;
        }
        
        .city-info-text h4 {
            font-size: 0.75rem;
            color: #888;
            margin-bottom: 4px;
        }
        
        .city-info-text p {
            font-size: 1rem;
            font-weight: 700;
            color: #1b5031;
        }
        
        /* Map Section */
        .map-section {
            background: white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .section-header h2 {
            color: #1b5031;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }
        
        #map {
            height: 500px;
            width: 100%;
            border-radius: 20px;
            border: 3px solid #e8ecf1;
        }
        
        .map-controls {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        
        .map-btn {
            padding: 10px 20px;
            border-radius: 50px;
            border: 2px solid #e8ecf1;
            background: white;
            cursor: pointer;
            font-weight: 600;
            font-family: 'Mulish', sans-serif;
            transition: all 0.3s;
            color: #666;
        }
        
        .map-btn:hover, .map-btn.active {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            border-color: transparent;
            color: white;
        }
        
        /* Categories Filter */
        .categories-section {
            background: white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .category-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        .category-tab {
            padding: 12px 24px;
            border-radius: 50px;
            border: 2px solid #e8ecf1;
            background: white;
            cursor: pointer;
            font-weight: 600;
            font-family: 'Mulish', sans-serif;
            transition: all 0.3s;
            color: #666;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .category-tab:hover, .category-tab.active {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Tinder Cards Stack */
        .cards-stack-section {
            background: white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .cards-stack-container {
            position: relative;
            height: 550px;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }
        
        .tinder-card {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            cursor: grab;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        
        .tinder-card:active {
            cursor: grabbing;
        }
        
        .tinder-card.dragging {
            transition: none;
        }
        
        .tinder-card.swiping-right {
            box-shadow: 0 0 0 5px rgba(46,141,83,0.3);
        }
        
        .tinder-card.swiping-left {
            box-shadow: 0 0 0 5px rgba(255,107,107,0.3);
        }
        
        .card-image {
            height: 300px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .card-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .card-category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .card-content {
            padding: 20px;
        }
        
        .card-title {
            font-size: 1.4rem;
            color: #1b5031;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .card-location {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .card-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }
        
        .stars {
            color: #ffc107;
            font-size: 1.1rem;
        }
        
        .rating-text {
            color: #666;
            font-size: 0.85rem;
        }
        
        .card-description {
            color: #555;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .card-review {
            background: #f8f9fc;
            padding: 12px;
            border-radius: 12px;
            font-style: italic;
            color: #666;
            font-size: 0.85rem;
            border-left: 3px solid #2e8d53;
        }
        
        .card-actions {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            justify-content: center;
        }
        
        .card-action-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .btn-dislike {
            background: #f8f9fc;
            color: #ff6b6b;
            border: 2px solid #ff6b6b;
        }
        
        .btn-dislike:hover {
            background: #ff6b6b;
            color: white;
            transform: scale(1.1);
        }
        
        .btn-like {
            background: #f8f9fc;
            color: #2e8d53;
            border: 2px solid #2e8d53;
        }
        
        .btn-like:hover {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            color: white;
            transform: scale(1.1);
        }
        
        .btn-add {
            background: #f8f9fc;
            color: #246d3e;
            border: 2px solid #246d3e;
        }
        
        .btn-add:hover {
            background: #246d3e;
            color: white;
            transform: scale(1.1);
        }
        
        /* Stack Indicator */
        .stack-indicator {
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            color: #888;
            font-size: 0.9rem;
        }
        
        /* Selected Places */
        .selected-places-section {
            background: white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .selected-places-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .selected-place-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 14px;
            border-left: 4px solid #2e8d53;
            transition: all 0.2s;
        }
        
        .selected-place-item:hover {
            background: #f0f2f5;
            transform: translateX(5px);
        }
        
        .place-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .place-number {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        .remove-place-btn {
            background: none;
            border: none;
            color: #ff6b6b;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .remove-place-btn:hover {
            transform: scale(1.2);
        }
        
        /* Route Stats */
        .route-stats {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            color: white;
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
        }
        
        .stat-label {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .action-btn {
            flex: 1;
            padding: 15px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-family: 'Mulish', sans-serif;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46,141,83,0.4);
        }
        
        .btn-secondary {
            background: #f8f9fc;
            color: #666;
            border: 2px solid #e8ecf1;
        }
        
        .btn-secondary:hover {
            background: #e8ecf1;
            transform: translateY(-2px);
        }
        
        /* Toast Notification */
        .toast-notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2e8d53;
            color: white;
            padding: 15px 28px;
            border-radius: 50px;
            font-weight: 500;
            z-index: 2000;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        /* Swipe Indicators */
        .swipe-indicator {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            font-weight: 800;
            opacity: 0;
            transition: opacity 0.2s;
            z-index: 10;
            padding: 20px;
            border: 4px solid;
            border-radius: 12px;
        }
        
        .swipe-like {
            left: 20px;
            color: #2e8d53;
            border-color: #2e8d53;
        }
        
        .swipe-dislike {
            right: 20px;
            color: #ff6b6b;
            border-color: #ff6b6b;
        }
        
        /* Route Marker Styles */
        .route-marker {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            color: white;
            border: 2px solid white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
        }
        
        .route-marker-start {
            background: linear-gradient(135deg, #2e8d53 0%, #34af76 100%);
        }
        
        .route-marker-end {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5253 100%);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-left { width: auto; }
            .header-logo>img { margin-right: auto; }
            .header-right { display: none; }
            
            .cards-stack-container {
                height: 600px;
            }
            
            .route-stats {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
        
        /* Footer */
        footer {
            background-color: #ffffff;
            padding: 40px 0 20px;
            margin-top: 50px;
        }
        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .footer-top {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 40px;
        }
        .footer-section {
            flex: 1;
            min-width: 250px;
        }
        .footer-section h3 {
            color: #1b5031;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 700;
        }
        .contact-list { list-style: none; }
        .contact-item { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; color: #666; }
        .footer-bottom { text-align: center; padding-top: 20px; border-top: 1px solid #e8ecf1; color: #666; }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="planner-container">
        <!-- Информация о поездке -->
        <div class="info-block">
            <div class="city-info-grid" id="tripInfo">
                <div class="city-info-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div class="city-info-text">
                        <h4>Город</h4>
                        <p id="cityName">Загрузка...</p>
                    </div>
                </div>
                <div class="city-info-item">
                    <i class="bi bi-people-fill"></i>
                    <div class="city-info-text">
                        <h4>Гостей</h4>
                        <p id="travelersCount">1 чел.</p>
                    </div>
                </div>
                <div class="city-info-item">
                    <i class="bi bi-wallet2-fill"></i>
                    <div class="city-info-text">
                        <h4>Бюджет</h4>
                        <p id="budgetAmount">30 000 ₽</p>
                    </div>
                </div>
                <div class="city-info-item">
                    <i class="bi bi-calendar-fill"></i>
                    <div class="city-info-text">
                        <h4>Даты</h4>
                        <p id="travelDates">не выбраны</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Карта -->
        <div class="map-section">
            <div class="section-header">
                <h2><i class="bi bi-map-fill"></i> Интерактивная карта</h2>
            </div>
            <div id="map"></div>
            <div class="map-controls">
                <button class="map-btn active" data-category="all">Все места</button>
                <button class="map-btn" data-category="restaurants"><i class="bi bi-cup-hot"></i> Рестораны</button>
                <button class="map-btn" data-category="museums"><i class="bi bi-building"></i> Музеи</button>
                <button class="map-btn" data-category="parks"><i class="bi bi-tree"></i> Парки</button>
                <button class="map-btn" data-category="attractions"><i class="bi bi-star"></i> Достопримечательности</button>
            </div>
        </div>

        <!-- Категории мест -->
        <div class="categories-section">
            <div class="section-header">
                <h2><i class="bi bi-grid-3x3"></i> Выберите категории</h2>
            </div>
            <div class="category-tabs" id="categoryTabs">
                <button class="category-tab active" data-category="restaurants">
                    <i class="bi bi-cup-hot"></i> Рестораны
                </button>
                <button class="category-tab" data-category="museums">
                    <i class="bi bi-building"></i> Музеи
                </button>
                <button class="category-tab" data-category="parks">
                    <i class="bi bi-tree"></i> Парки
                </button>
                <button class="category-tab" data-category="attractions">
                    <i class="bi bi-star"></i> Достопримечательности
                </button>
                <button class="category-tab" data-category="hotels">
                    <i class="bi bi-hotel"></i> Отели
                </button>
                <button class="category-tab" data-category="cafes">
                    <i class="bi bi-coffee"></i> Кафе
                </button>
            </div>
        </div>

        <!-- Tinder-карточки -->
        <div class="cards-stack-section">
            <div class="section-header">
                <h2><i class="bi bi-heart-fill"></i> Нравится / Не нравится</h2>
            </div>
            <div class="cards-stack-container" id="cardsStack">
                <!-- Карточки будут добавлены через JS -->
            </div>
            <div class="stack-indicator" id="stackIndicator">Осталось карточек: 0</div>
            <div class="action-buttons">
                <button class="action-btn btn-secondary" id="prevCardBtn">
                    <i class="bi bi-arrow-left"></i> Назад
                </button>
                <button class="action-btn btn-secondary" id="randomCardBtn">
                    <i class="bi bi-shuffle"></i> Случайная
                </button>
                <button class="action-btn btn-secondary" id="resetCardsBtn">
                    <i class="bi bi-arrow-clockwise"></i> Сброс
                </button>
            </div>
        </div>

        <!-- Выбранные места -->
        <div class="selected-places-section">
            <div class="section-header">
                <h2><i class="bi bi-list-check"></i> Ваш маршрут</h2>
            </div>
            <div id="routeStats" class="route-stats" style="display: none;">
                <div class="stat-item">
                    <div class="stat-value" id="totalDistance">0</div>
                    <div class="stat-label">км</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="totalTime">0</div>
                    <div class="stat-label">мин</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="totalPlaces">0</div>
                    <div class="stat-label">мест</div>
                </div>
            </div>
            <div class="selected-places-list" id="selectedPlacesList">
                <p style="text-align: center; color: #999; padding: 20px;">
                    <i class="bi bi-compass"></i> Добавьте места, свайпнув вправо
                </p>
            </div>
            <div class="action-buttons">
                <button class="action-btn btn-secondary" id="clearRouteBtn">
                    <i class="bi bi-trash-fill"></i> Очистить
                </button>
                <button class="action-btn btn-primary" id="saveRouteBtn">
                    <i class="bi bi-save-fill"></i> Сохранить маршрут
                </button>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script>
        // Данные о местах по категориям
        const placesData = {
            'saint-petersburg': {
                center: [59.9343, 30.3351],
                zoom: 13,
                restaurants: [
                    {
                        id: 1,
                        name: 'Ресторан "Север"',
                        location: 'Невский проспект, 15',
                        coords: [59.9375, 30.3280],
                        rating: 4.8,
                        reviews: 342,
                        description: 'Авторская кухня с северным колоритом. Уютная атмосфера и лучшая пивная карта в городе.',
                        review: 'Лучший оленина в моей жизни! Обязательно попробуйте.',
                        image: 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600',
                        price: '2500-4000 ₽'
                    },
                    {
                        id: 2,
                        name: 'Бистро "Амбар"',
                        location: 'ул. Рубинштейна, 7',
                        coords: [59.9350, 30.3350],
                        rating: 4.6,
                        reviews: 218,
                        description: 'Современное бистро с европейской кухней. Отличный выбор вин и коктейлей.',
                        review: 'Прекрасное место для романтического вечера.',
                        image: 'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=600',
                        price: '1500-3000 ₽'
                    },
                    {
                        id: 3,
                        name: 'Кофейня "Зерно"',
                        location: 'Лиговский проспект, 53',
                        coords: [59.9280, 30.3180],
                        rating: 4.9,
                        reviews: 156,
                        description: 'Специальties кофе и домашняя выпечка. Идеальное место для утреннего кофе.',
                        review: 'Лучший капучино в Санкт-Петербурге!',
                        image: 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=600',
                        price: '300-800 ₽'
                    }
                ],
                museums: [
                    {
                        id: 101,
                        name: 'Государственный Эрмитаж',
                        location: 'Дворцовая площадь, 2',
                        coords: [59.9402, 30.3141],
                        rating: 4.9,
                        reviews: 15420,
                        description: 'Один из крупнейших музеев мира. Коллекция насчитывает более 3 миллионов произведений искусства.',
                        review: 'Нужно минимум 3 дня, чтобы всё увидеть!',
                        image: 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=600',
                        price: '500 ₽'
                    },
                    {
                        id: 102,
                        name: 'Русский музей',
                        location: 'Инженерная ул., 4',
                        coords: [59.9376, 30.3325],
                        rating: 4.7,
                        reviews: 8934,
                        description: 'Крупнейшая коллекция русского искусства от древних икон до современного искусства.',
                        review: 'Бриллиант русской культуры.',
                        image: 'https://images.unsplash.com/photo-1518972458042-16b6830324da?w=600',
                        price: '400 ₽'
                    }
                ],
                parks: [
                    {
                        id: 201,
                        name: 'Екатерининский парк',
                        location: 'г. Пушкин, г. Санкт-Петербург',
                        coords: [59.7146, 30.3969],
                        rating: 4.8,
                        reviews: 12543,
                        description: 'Парк в стиле барокко с огромным количеством достопримечательностей и прудов.',
                        review: 'Невероятно красивый парк в любое время года!',
                        image: 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=600',
                        price: 'Бесплатно'
                    },
                    {
                        id: 202,
                        name: 'Александровский сад',
                        location: 'Марсово поле, 1',
                        coords: [59.9385, 30.3250],
                        rating: 4.5,
                        reviews: 3421,
                        description: 'Центральный городской парк с фонтанами и аллеями для прогулок.',
                        review: 'Отличное место для утренних пробежек.',
                        image: 'https://images.unsplash.com/photo-1444858291040-58f756a3bdd6?w=600',
                        price: 'Бесплатно'
                    }
                ],
                attractions: [
                    {
                        id: 301,
                        name: 'Храм Спаса на Крови',
                        location: 'наб. канала Грибоедова, 2Б',
                        coords: [59.9401, 30.3287],
                        rating: 4.9,
                        reviews: 18765,
                        description: 'Великолепный храм с уникальными мозаиками и архитектурой в русском стиле.',
                        review: 'Внутри ещё красивее, чем снаружи!',
                        image: 'https://images.unsplash.com/photo-1564858051047-2f213095da05?w=600',
                        price: '250 ₽'
                    },
                    {
                        id: 302,
                        name: 'Исаакиевский собор',
                        location: 'Исаакиевская площадь, 4',
                        coords: [59.9340, 30.3062],
                        rating: 4.8,
                        reviews: 21543,
                        description: 'Один из крупнейших соборов мира. Колоннада предлагает лучший вид на город.',
                        review: 'Восхитительная архитектура и история.',
                        image: 'https://images.unsplash.com/photo-1548685913-fe654f120069?w=600',
                        price: '300 ₽'
                    }
                ],
                hotels: [
                    {
                        id: 401,
                        name: 'Астория',
                        location: 'Исаакиевская площадь, 4',
                        coords: [59.9335, 30.3055],
                        rating: 4.7,
                        reviews: 2341,
                        description: 'Люксовый отель в центре города с богатой историей и безупречным сервисом.',
                        review: 'Пятизвёздочный сервис на высоте.',
                        image: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600',
                        price: 'от 15000 ₽/ночь'
                    }
                ],
                cafes: [
                    {
                        id: 501,
                        name: 'Кафе "Булочная Фредди"',
                        location: 'ул. Рубинштейна, 18',
                        coords: [59.9342, 30.3365],
                        rating: 4.6,
                        reviews: 1876,
                        description: 'Популярная булочная с свежей выпечкой и кофе с собой.',
                        review: 'Круассаны просто божественные!',
                        image: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600',
                        price: '200-600 ₽'
                    }
                ]
            }
        };

        // Инициализация
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем данные из localStorage
            const savedData = JSON.parse(localStorage.getItem('selected_city'));
            const cityId = 'saint-petersburg';
            const city = placesData[cityId];
            
            // Заполняем информацию о поездке
            if (savedData) {
                document.getElementById('cityName').textContent = 'Санкт-Петербург';
                document.getElementById('travelersCount').textContent = (savedData.travelers || '1') + ' чел.';
                document.getElementById('budgetAmount').textContent = (savedData.budgetFormatted || '30 000') + ' ₽';
                document.getElementById('travelDates').textContent = savedData.dates || 'не выбраны';
            } else {
                document.getElementById('cityName').textContent = 'Санкт-Петербург';
            }
            
            let map;
            let markers = [];
            let routingControl = null;
            let selectedPlaces = JSON.parse(localStorage.getItem('selected_places')) || [];
            
            // Данные для карточек
            let allPlaces = [];
            let currentCardIndex = 0;
            let cardStack = [];
            
            // Инициализация карты
            function initMap() {
                if (!document.getElementById('map')) return;
                
                map = L.map('map', {
                    center: city.center,
                    zoom: city.zoom,
                    zoomControl: true
                });
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);
                
                map.markers = [];
                map.routeMarkers = [];
            }
            
            // Инициализация карточек
            function initCards() {
                allPlaces = [
                    ...placesData[cityId].restaurants.map(p => ({...p, category: 'restaurants'})),
                    ...placesData[cityId].museums.map(p => ({...p, category: 'museums'})),
                    ...placesData[cityId].parks.map(p => ({...p, category: 'parks'})),
                    ...placesData[cityId].attractions.map(p => ({...p, category: 'attractions'})),
                    ...placesData[cityId].hotels.map(p => ({...p, category: 'hotels'})),
                    ...placesData[cityId].cafes.map(p => ({...p, category: 'cafes'}))
                ];
                
                cardStack = [...allPlaces];
                renderCards();
            }
            
            // Получение иконки категории
            function getCategoryIcon(category) {
                const icons = {
                    'restaurants': 'bi-cup-hot',
                    'museums': 'bi-building',
                    'parks': 'bi-tree',
                    'attractions': 'bi-star',
                    'hotels': 'bi-hotel',
                    'cafes': 'bi-coffee'
                };
                return icons[category] || 'bi-geo-alt';
            }
            
            // Получение названия категории
            function getCategoryName(category) {
                const names = {
                    'restaurants': 'Ресторан',
                    'museums': 'Музей',
                    'parks': 'Парк',
                    'attractions': 'Достопримечательность',
                    'hotels': 'Отель',
                    'cafes': 'Кафе'
                };
                return names[category] || 'Место';
            }
            
            // Отрисовка карточек
            function renderCards() {
                const container = document.getElementById('cardsStack');
                container.innerHTML = '';
                
                const visibleCards = Math.min(cardStack.length, 3);
                
                for (let i = visibleCards - 1; i >= 0; i--) {
                    const place = cardStack[i];
                    const card = document.createElement('div');
                    card.className = 'tinder-card';
                    card.style.zIndex = visibleCards - i;
                    card.style.transform = `scale(${1 - i * 0.05}) translateY(${i * 10}px)`;
                    
                    const stars = '★'.repeat(Math.floor(place.rating)) + (place.rating % 1 >= 0.5 ? '½' : '');
                    
                    card.innerHTML = `
                        <div class="card-image" style="background-image: url('${place.image}')">
                            <span class="card-badge">${place.price || 'Цена по запросу'}</span>
                            <span class="card-category"><i class="bi ${getCategoryIcon(place.category)}"></i> ${getCategoryName(place.category)}</span>
                            <div class="swipe-indicator swipe-like">LIKE</div>
                            <div class="swipe-indicator swipe-dislike">NOPE</div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">${place.name}</h3>
                            <div class="card-location"><i class="bi bi-geo-alt"></i> ${place.location}</div>
                            <div class="card-rating">
                                <div class="stars">${stars}</div>
                                <span class="rating-text">${place.rating} (${place.reviews} отзывов)</span>
                            </div>
                            <p class="card-description">${place.description}</p>
                            <div class="card-review">"${place.review}"</div>
                            <div class="card-actions">
                                <button class="card-action-btn btn-dislike" onclick="swipeCard('left')"><i class="bi bi-x-lg"></i></button>
                                <button class="card-action-btn btn-add" onclick="addToRouteFromCard(${place.id})"><i class="bi bi-plus-lg"></i></button>
                                <button class="card-action-btn btn-like" onclick="swipeCard('right')"><i class="bi bi-heart-fill"></i></button>
                            </div>
                        </div>
                    `;
                    
                    container.appendChild(card);
                    initCardDrag(card, i);
                }
                
                document.getElementById('stackIndicator').textContent = `Осталось карточек: ${cardStack.length}`;
            }
            
            // Инициализация drag для карточки
            function initCardDrag(card, index) {
                if (index !== 0) return;
                
                let startX = 0;
                let currentX = 0;
                let isDragging = false;
                
                card.addEventListener('mousedown', startDrag);
                card.addEventListener('touchstart', startDrag);
                
                function startDrag(e) {
                    isDragging = true;
                    startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    card.classList.add('dragging');
                }
                
                document.addEventListener('mousemove', drag);
                document.addEventListener('touchmove', drag);
                
                function drag(e) {
                    if (!isDragging) return;
                    
                    currentX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    const diff = currentX - startX;
                    const rotate = diff * 0.05;
                    
                    card.style.transform = `translateX(${diff}px) rotate(${rotate}deg)`;
                    
                    // Показываем индикаторы
                    const likeIndicator = card.querySelector('.swipe-like');
                    const dislikeIndicator = card.querySelector('.swipe-dislike');
                    
                    if (diff > 50) {
                        likeIndicator.style.opacity = Math.min(diff / 100, 1);
                        dislikeIndicator.style.opacity = 0;
                        card.classList.add('swiping-right');
                    } else if (diff < -50) {
                        dislikeIndicator.style.opacity = Math.min(Math.abs(diff) / 100, 1);
                        likeIndicator.style.opacity = 0;
                        card.classList.add('swiping-left');
                    } else {
                        likeIndicator.style.opacity = 0;
                        dislikeIndicator.style.opacity = 0;
                        card.classList.remove('swiping-right', 'swiping-left');
                    }
                }
                    
                document.addEventListener('mouseup', endDrag);
                document.addEventListener('touchend', endDrag);
                
                function endDrag(e) {
                    if (!isDragging) return;
                    isDragging = false;
                    card.classList.remove('dragging');
                    
                    const diff = currentX - startX;
                    
                    if (diff > 100) {
                        swipeCard('right');
                    } else if (diff < -100) {
                        swipeCard('left');
                    } else {
                        card.style.transform = '';
                        card.classList.remove('swiping-right', 'swiping-left');
                        card.querySelector('.swipe-like').style.opacity = 0;
                        card.querySelector('.swipe-dislike').style.opacity = 0;
                    }
                    
                    document.removeEventListener('mousemove', drag);
                    document.removeEventListener('touchmove', drag);
                    document.removeEventListener('mouseup', endDrag);
                    document.removeEventListener('touchend', endDrag);
                }
            }
            
            // Свайп карточки
            window.swipeCard = function(direction) {
                const card = document.querySelector('.tinder-card');
                if (!card || cardStack.length === 0) return;
                
                const place = cardStack[0];
                
                if (direction === 'right') {
                    card.style.transform = 'translateX(500px) rotate(30deg)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        cardStack.shift();
                        selectedPlaces.push(place);
                        localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
                        updateSelectedPlaces();
                        updateRouteOnMap();
                        showNotification(`✓ ${place.name} добавлено в маршрут`);
                        renderCards();
                    }, 300);
                } else {
                    card.style.transform = 'translateX(-500px) rotate(-30deg)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        cardStack.shift();
                        renderCards();
                    }, 300);
                }
            };
            
            // Добавить в маршрут из карточки
            window.addToRouteFromCard = function(placeId) {
                const place = allPlaces.find(p => p.id === placeId);
                if (place && !selectedPlaces.find(p => p.id === placeId)) {
                    selectedPlaces.push(place);
                    localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
                    updateSelectedPlaces();
                    updateRouteOnMap();
                    showNotification(`✓ ${place.name} добавлено в маршрут`);
                } else {
                    showNotification('Уже добавлено в маршрут', true);
                }
            };
            
            // Обновление списка выбранных мест
            function updateSelectedPlaces() {
                const container = document.getElementById('selectedPlacesList');
                
                if (selectedPlaces.length === 0) {
                    container.innerHTML = '<p style="text-align: center; color: #999; padding: 20px;"><i class="bi bi-compass"></i> Добавьте места, свайпнув вправо</p>';
                    return;
                }
                
                container.innerHTML = '';
                selectedPlaces.forEach((place, index) => {
                    const item = document.createElement('div');
                    item.className = 'selected-place-item';
                    item.innerHTML = `
                        <div class="place-info">
                            <span class="place-number">${index + 1}</span>
                            <div>
                                <strong>${place.name}</strong>
                                <div style="font-size: 0.85rem; color: #666; margin-top: 4px;">
                                    <i class="bi ${getCategoryIcon(place.category)}"></i> ${getCategoryName(place.category)}
                                </div>
                            </div>
                        </div>
                        <button class="remove-place-btn" onclick="removePlace(${place.id})"><i class="bi bi-x-circle-fill"></i></button>
                    `;
                    container.appendChild(item);
                });
            }
            
            // Удалить место из маршрута
            window.removePlace = function(placeId) {
                selectedPlaces = selectedPlaces.filter(p => p.id !== placeId);
                localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
                updateSelectedPlaces();
                updateRouteOnMap();
                showNotification('Место удалено из маршрута');
            };
                
            // Обновление маршрута на карте
            function updateRouteOnMap() {
                if (!map) return;
                
                // Удаляем старый маршрут
                if (routingControl) {
                    map.removeControl(routingControl);
                    routingControl = null;
                }
                
                // Очищаем маркеры маршрута (но оставляем маркеры мест)
                if (map.routeMarkers) {
                    map.routeMarkers.forEach(m => map.removeLayer(m));
                    map.routeMarkers = [];
                }
                
                if (selectedPlaces.length === 0) {
                    document.getElementById('routeStats').style.display = 'none';
                    return;
                }
                
                if (selectedPlaces.length === 1) {
                    // Отображаем только одну точку
                    const place = selectedPlaces[0];
                    const icon = L.divIcon({
                        className: 'route-marker route-marker-start',
                        html: '<i class="bi bi-geo-alt-fill"></i>',
                        iconSize: [36, 36],
                        iconAnchor: [18, 18]
                    });
                    
                    const marker = L.marker(place.coords, { icon }).addTo(map);
                    marker.bindPopup(`<b>${place.name}</b><br>${place.location}`).openPopup();
                    map.routeMarkers = [marker];
                    
                    // Центрируем карту на точке
                    map.setView(place.coords, 15);
                    
                    document.getElementById('routeStats').style.display = 'grid';
                    document.getElementById('totalPlaces').textContent = 1;
                    document.getElementById('totalDistance').textContent = 0;
                    document.getElementById('totalTime').textContent = 0;
                    return;
                }
                
                // Создаем waypoints для маршрута
                const waypoints = selectedPlaces.map(p => L.latLng(p.coords[0], p.coords[1]));
                
                // Построение маршрута с использованием Leaflet Routing Machine
                routingControl = L.Routing.control({
                    waypoints: waypoints,
                    routeWhileDragging: false,
                    showAlternatives: false,
                    fitSelectedRoutes: true,
                    show: false, // Скрыть панель с инструкциями
                    lineOptions: {
                        styles: [
                            { color: '#2e8d53', weight: 6, opacity: 0.9 },
                            { color: '#4ecdc4', weight: 3, opacity: 0.6 }
                        ]
                    },
                    createMarker: function(i, waypoint, n) {
                        // Создаем кастомные маркеры для каждой точки
                        let iconClass = 'route-marker';
                        let html = i + 1;
                        
                        if (i === 0) {
                            iconClass += ' route-marker-start';
                            html = '<i class="bi bi-flag-fill"></i>';
                        } else if (i === n - 1) {
                            iconClass += ' route-marker-end';
                            html = '<i class="bi bi-flag-fill"></i>';
                        }
                        
                        return L.marker(waypoint, {
                            icon: L.divIcon({
                                className: iconClass,
                                html: html,
                                iconSize: [36, 36],
                                iconAnchor: [18, 18]
                            })
                        }).bindPopup(`<b>${selectedPlaces[i].name}</b><br>${selectedPlaces[i].location}`);
                    },
                    containerClassName: 'route-instructions'
                }).addTo(map);
                
                // Обработка событий маршрута
                routingControl.on('routesfound', function(e) {
                    const routes = e.routes;
                    if (routes && routes.length > 0) {
                        const summary = routes[0].summary;
                        
                        // Расчет расстояния в км
                        const distanceKm = summary.totalDistance / 1000;
                        // Расчет времени (примерно 30 км/ч в городе)
                        const timeMinutes = Math.round(summary.totalTime / 60);
                        
                        // Обновляем статистику
                        document.getElementById('routeStats').style.display = 'grid';
                        document.getElementById('totalPlaces').textContent = selectedPlaces.length;
                        document.getElementById('totalDistance').textContent = distanceKm.toFixed(1);
                        document.getElementById('totalTime').textContent = timeMinutes;
                    }
                });
                
                routingControl.on('routingerror', function(e) {
                    console.error('Ошибка маршрутизации:', e);
                    showNotification('Не удалось построить маршрут', true);
                });
            }
            
            // Фильтрация по категориям
            document.getElementById('categoryTabs').addEventListener('click', function(e) {
                const tab = e.target.closest('.category-tab');
                if (!tab) return;
                
                document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                const category = tab.dataset.category;
                
                if (category === 'all') {
                    cardStack = [...allPlaces];
                } else {
                    cardStack = allPlaces.filter(p => p.category === category);
                }
                
                currentCardIndex = 0;
                renderCards();
                showNotification(`Показаны: ${tab.textContent.trim()}`);
            });
            
            // Кнопки управления карточками
            document.getElementById('prevCardBtn').addEventListener('click', function() {
                showNotification('Функция в разработке');
            });
            
            document.getElementById('randomCardBtn').addEventListener('click', function() {
                if (cardStack.length > 0) {
                    const randomIndex = Math.floor(Math.random() * cardStack.length);
                    cardStack = [cardStack[randomIndex], ...cardStack.filter((_, i) => i !== randomIndex)];
                    renderCards();
                }
            });
            
            document.getElementById('resetCardsBtn').addEventListener('click', function() {
                cardStack = [...allPlaces];
                renderCards();
                showNotification('Список сброшен');
            });
            
            // Кнопки управления маршрутом
            document.getElementById('clearRouteBtn').addEventListener('click', function() {
                if (selectedPlaces.length > 0) {
                    selectedPlaces = [];
                    localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
                    updateSelectedPlaces();
                    updateRouteOnMap();
                    showNotification('Маршрут очищен');
                }
            });
            
            document.getElementById('saveRouteBtn').addEventListener('click', function() {
                if (selectedPlaces.length === 0) {
                    showNotification('Добавьте места в маршрут', true);
                    return;
                }
                
                let savedRoutes = JSON.parse(localStorage.getItem('saved_routes')) || [];
                savedRoutes.push({
                    name: `Маршрут - ${new Date().toLocaleDateString('ru-RU')}`,
                    places: selectedPlaces,
                    date: new Date().toISOString()
                });
                localStorage.setItem('saved_routes', JSON.stringify(savedRoutes));
                showNotification('✓ Маршрут сохранён!');
            });
            
            // Фильтрация карты
            function initMapFilters() {
                if (!map) return;
                
                document.querySelectorAll('.map-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.map-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        
                        const category = this.dataset.category;
                        
                        // Очистка маркеров
                        if (map.markers) {
                            map.markers.forEach(m => map.removeLayer(m));
                            map.markers = [];
                        }
                        
                        let placesToShow = [];
                        if (category === 'all') {
                            placesToShow = allPlaces;
                        } else {
                            placesToShow = allPlaces.filter(p => p.category === category);
                        }
                        
                        // Добавление маркеров с фильтрацией по категории
                        const categoryColors = {
                            'restaurants': '#ff6b6b',
                            'museums': '#4ecdc4',
                            'parks': '#2e8d53',
                            'attractions': '#ffc107',
                            'hotels': '#9b59b6',
                            'cafes': '#e67e22'
                        };
                        
                        const categoryIcons = {
                            'restaurants': 'bi-cup-hot',
                            'museums': 'bi-building',
                            'parks': 'bi-tree',
                            'attractions': 'bi-star',
                            'hotels': 'bi-hotel',
                            'cafes': 'bi-coffee'
                        };
                        
                        placesToShow.forEach((place) => {
                            const color = categoryColors[place.category] || '#2e8d53';
                            const iconClass = categoryIcons[place.category] || 'bi-geo-alt';
                            
                            const icon = L.divIcon({
                                className: 'category-marker',
                                html: `<div style="
                                    background: ${color};
                                    color: white;
                                    width: 36px;
                                    height: 36px;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    border: 3px solid white;
                                    box-shadow: 0 3px 8px rgba(0,0,0,0.3);
                                    font-size: 18px;
                                "><i class="bi ${iconClass}"></i></div>`,
                                iconSize: [36, 36],
                                iconAnchor: [18, 18]
                            });
                            
                            const marker = L.marker(place.coords, { icon: icon }).addTo(map);
                            marker.bindPopup(`
                                <div style="min-width: 200px;">
                                    <h3 style="color: #1b5031; margin-bottom: 8px;">${place.name}</h3>
                                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 6px;">
                                        <i class="bi bi-geo-alt"></i> ${place.location}
                                    </p>
                                    <p style="color: #ffc107; font-size: 0.9rem; margin-bottom: 8px;">
                                        ⭐ ${place.rating} (${place.reviews} отзывов)
                                    </p>
                                    <p style="color: #555; font-size: 0.85rem;">${place.description}</p>
                                    <button onclick="addToRouteFromCard(${place.id})" style="
                                        margin-top: 10px;
                                        padding: 8px 16px;
                                        background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
                                        color: white;
                                        border: none;
                                        border-radius: 20px;
                                        cursor: pointer;
                                        font-weight: 600;
                                        width: 100%;
                                    ">
                                        <i class="bi bi-plus-circle"></i> Добавить в маршрут
                                    </button>
                                </div>
                            `);
                            map.markers.push(marker);
                        });
                        
                        // Центрируем карту на отображаемых местах
                        if (placesToShow.length > 0) {
                            const group = new L.featureGroup(placesToShow.map(p => 
                                L.latLng(p.coords[0], p.coords[1])
                            ));
                            map.fitBounds(group.getBounds().pad(0.2));
                        }
                    });
                });
            }
            
            // Уведомление
            function showNotification(message, isError = false) {
                const notification = document.createElement('div');
                notification.className = 'toast-notification';
                notification.style.background = isError ? '#ff6b6b' : '#2e8d53';
                notification.innerHTML = `<i class="bi ${isError ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill'}"></i> ${message}`;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 2500);
            }
            
            // Проверка авторизации
            const authButton = document.getElementById('authButton');
            const currentUser = JSON.parse(localStorage.getItem('current_user'));
            
            if (currentUser) {
                authButton.textContent = currentUser.name || 'Профиль';
                authButton.href = 'profile.php';
            }
            
            // Инициализация карточек
            initCards();
            
            // Инициализация карты
            initMap();
            
            // Инициализация фильтров карты
            setTimeout(function() {
                initMapFilters();
            }, 100);
            
            // Обновление интерфейса после инициализации
            setTimeout(function() {
                updateSelectedPlaces();
                updateRouteOnMap();
            }, 200);
        });
    </script>
</body>
</html>