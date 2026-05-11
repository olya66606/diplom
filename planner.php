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
        
        /* Category Tabs Navigation */
        .category-tabs {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .category-tab {
            padding: 14px 32px;
            border-radius: 50px;
            border: 2px solid #e8ecf1;
            background: white;
            cursor: pointer;
            font-weight: 700;
            font-family: 'Mulish', sans-serif;
            transition: all 0.3s;
            color: #666;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .category-tab:hover {
            border-color: #2e8d53;
            background: #f0fff4;
            transform: translateY(-2px);
        }
        
        .category-tab.active {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 8px 25px rgba(46,141,83,0.35);
            transform: translateY(-3px);
        }
        
        .category-tab .tab-count {
            background: rgba(255,255,255,0.25);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
        }
        
        .category-tab.active .tab-count {
            background: rgba(255,255,255,0.35);
        }
        
        /* Carousel Navigation */
        .carousel-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .carousel-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #e8ecf1;
            background: white;
            color: #2e8d53;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .carousel-btn:hover {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            border-color: transparent;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(46,141,83,0.3);
        }
        
        .carousel-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
            transform: none;
        }
        
        .carousel-counter {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2e8d53;
        }
        
        /* Carousel Container */
        .carousel-wrapper {
            position: relative;
            overflow: hidden;
            padding: 20px 0;
        }
        
        .carousel-track {
            display: flex;
            gap: 30px;
            transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            padding: 0 20px;
        }
        
        .carousel-card {
            flex: 0 0 420px;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
            transition: all 0.3s;
            cursor: grab;
        }
        
        .carousel-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
        }
        
        .carousel-card:active {
            cursor: grabbing;
        }
        
        .card-image {
            height: 300px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .card-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.7) 100%);
        }
        
        .card-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 6px 20px rgba(46,141,83,0.45);
            z-index: 2;
            backdrop-filter: blur(10px);
        }
        
        .card-category {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255,255,255,0.98);
            color: #2e8d53;
            padding: 10px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            z-index: 2;
        }
        
        .card-rating-overlay {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2;
        }
        
        .card-rating-badge {
            background: rgba(255,255,255,0.98);
            padding: 10px 18px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        
        .card-rating-badge .stars {
            color: #ffc107;
            font-size: 1.2rem;
            letter-spacing: 2px;
        }
        
        .card-rating-badge .rating-value {
            font-size: 1.2rem;
            font-weight: 800;
            color: #1b5031;
        }
        
        .card-rating-badge .rating-count {
            font-size: 0.85rem;
            color: #888;
        }
        
        .card-content {
            padding: 28px;
        }
        
        .card-title {
            font-size: 1.7rem;
            color: #1b5031;
            font-weight: 800;
            margin-bottom: 10px;
            line-height: 1.25;
        }
        
        .card-location {
            color: #666;
            font-size: 1rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .card-description {
            color: #666;
            font-size: 1rem;
            line-height: 1.65;
            margin-bottom: 18px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .card-review {
            background: linear-gradient(135deg, #f8f9fc 0%, #e8ecf1 100%);
            padding: 18px;
            border-radius: 18px;
            font-style: italic;
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
            border-left: 4px solid #2e8d53;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .card-actions {
            display: flex;
            gap: 20px;
            justify-content: center;
            padding-top: 20px;
            border-top: 2px solid #f0f2f5;
        }
        
        .card-action-btn {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            background: white;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        
        .card-action-btn:hover {
            transform: scale(1.2) translateY(-5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.2);
        }
        
        .card-action-btn:active {
            transform: scale(0.95);
        }
        
        .btn-dislike {
            color: #ff6b6b;
            border: 2px solid #ffe0e0;
        }
        
        .btn-dislike:hover {
            background: #ff6b6b;
            border-color: #ff6b6b;
            color: white;
            box-shadow: 0 8px 25px rgba(255,107,107,0.45);
        }
        
        .btn-like {
            color: #2e8d53;
            border: 2px solid #d4f0e4;
        }
        
        .btn-like:hover {
            background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 8px 25px rgba(46,141,83,0.45);
        }
        
        .btn-add {
            color: #2e8d53;
            border: 2px solid #d4f0e4;
        }
        
        .btn-add:hover {
            background: #2e8d53;
            border-color: #2e8d53;
            color: white;
            box-shadow: 0 8px 25px rgba(46,141,83,0.45);
        }
        
        /* Tooltip на кнопках */
        .card-action-btn::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            background: rgba(0,0,0,0.85);
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.2s;
            letter-spacing: 0.5px;
        }
        
        .card-action-btn:hover::after {
            opacity: 1;
            transform: translateX(-50%) translateY(-8px);
        }
        
        /* Stack Indicator */
        .stack-indicator {
            text-align: center;
            color: #888;
            font-size: 0.85rem;
            margin-top: 10px;
            margin-bottom: 15px;
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
            
            .cards-stack-section {
                padding: 20px;
            }
            
            .carousel-card {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .card-image {
                height: 260px;
            }
            
            .card-title {
                font-size: 1.4rem;
            }
            
            .card-content {
                padding: 20px;
            }
            
            .card-action-btn {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
            
            .carousel-btn {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }
            
            .route-stats {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .category-tabs {
                gap: 10px;
            }
            
            .category-tab {
                padding: 10px 20px;
                font-size: 0.9rem;
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

        <!-- Карусель мест -->
        <div class="cards-stack-section">
            <div class="carousel-nav">
                <button class="carousel-btn" id="prevCarouselBtn" onclick="moveCarousel(-1)">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <span class="carousel-counter" id="carouselCounter">1 / 10</span>
                <button class="carousel-btn" id="nextCarouselBtn" onclick="moveCarousel(1)">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
            <div class="carousel-wrapper">
                <div class="carousel-track" id="carouselTrack">
                    <!-- Карточки будут добавлены через JS -->
                </div>
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
            },
            'japan': {
                center: [35.6762, 139.6503],
                zoom: 10,
                restaurants: [
                    {
                        id: 1,
                        name: 'Ресторан "Суши Мастер"',
                        location: 'Токио, район Гиндза',
                        coords: [35.6719, 139.7650],
                        rating: 4.8,
                        reviews: 542,
                        description: 'Традиционные суши и сашими от шеф-повара.',
                        review: 'Лучшие суши в Токио!',
                        image: 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=600',
                        price: '5000-10000 ¥'
                    }
                ],
                museums: [
                    {
                        id: 101,
                        name: 'Национальный музей Токио',
                        location: 'Парк Уэно',
                        coords: [35.7188, 139.7767],
                        rating: 4.7,
                        reviews: 3421,
                        description: 'Крупнейшая коллекция японского искусства.',
                        review: 'Невероятная экспозиция!',
                        image: 'https://images.unsplash.com/photo-1524413840807-0c3cb6fa165d?w=600',
                        price: '1000 ¥'
                    }
                ],
                parks: [
                    {
                        id: 201,
                        name: 'Парк Уэно',
                        location: 'Токио',
                        coords: [35.7148, 139.7739],
                        rating: 4.8,
                        reviews: 12543,
                        description: 'Знаменитый парк с сакурой весной.',
                        review: 'Лучшее место для ханами!',
                        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=600',
                        price: 'Бесплатно'
                    }
                ],
                attractions: [
                    {
                        id: 301,
                        name: 'Храм Сэнсо-дзи',
                        location: 'Асакуса',
                        coords: [35.7148, 139.7967],
                        rating: 4.9,
                        reviews: 25432,
                        description: 'Древнейший храм Токио.',
                        review: 'Великолепная атмосфера!',
                        image: 'https://images.unsplash.com/photo-1528360983277-13d9b152c6d4?w=600',
                        price: 'Бесплатно'
                    }
                ],
                hotels: [
                    {
                        id: 401,
                        name: 'Отель "Цукишира"',
                        location: 'Токио',
                        coords: [35.6654, 139.7830],
                        rating: 4.6,
                        reviews: 1876,
                        description: 'Современный отель в центре.',
                        review: 'Отличный сервис!',
                        image: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600',
                        price: 'от 15000 ¥/ночь'
                    }
                ],
                cafes: [
                    {
                        id: 501,
                        name: 'Кафе "Антенна"',
                        location: 'Сибуя',
                        coords: [35.6595, 139.7004],
                        rating: 4.5,
                        reviews: 987,
                        description: 'Традиционные японские десерты.',
                        review: 'Вкусный моти!',
                        image: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600',
                        price: '500-1500 ¥'
                    }
                ]
            }
        };

        // Инициализация
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем данные из localStorage
            const savedData = JSON.parse(localStorage.getItem('selected_city'));
            const cityId = savedData?.cityId || 'saint-petersburg';
            const city = placesData[cityId];
            
            // Заполняем информацию о поездке
            if (savedData) {
                document.getElementById('cityName').textContent = savedData.cityName || 'Санкт-Петербург';
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
                renderCarousel();
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
            
            // Карусель
            let currentCarouselIndex = 0;
            
            // Отрисовка карусели
            function renderCarousel() {
                const track = document.getElementById('carouselTrack');
                track.innerHTML = '';
                
                cardStack.forEach((place, index) => {
                    const card = document.createElement('div');
                    card.className = 'carousel-card';
                    
                    const stars = '★'.repeat(Math.floor(place.rating)) + (place.rating % 1 >= 0.5 ? '½' : '');
                    
                    card.innerHTML = `
                        <div class="card-image" style="background-image: url('${place.image}')">
                            <div class="card-image-overlay"></div>
                            <span class="card-badge">${place.price || 'Цена по запросу'}</span>
                            <span class="card-category"><i class="bi ${getCategoryIcon(place.category)}"></i> ${getCategoryName(place.category)}</span>
                            <div class="card-rating-overlay">
                                <div class="card-rating-badge">
                                    <span class="stars">${stars}</span>
                                    <span class="rating-value">${place.rating}</span>
                                    <span class="rating-count">(${place.reviews})</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">${place.name}</h3>
                            <div class="card-location"><i class="bi bi-geo-alt"></i> ${place.location}</div>
                            <p class="card-description">${place.description}</p>
                            <div class="card-review">"${place.review}"</div>
                            <div class="card-actions">
                                <button class="card-action-btn btn-dislike" onclick="dislikeCard(${index})" data-tooltip="Пропустить" title="Пропустить"><i class="bi bi-x-lg"></i></button>
                                <button class="card-action-btn btn-like" onclick="likeCard(${index})" data-tooltip="Нравится" title="❤️ Нравится - добавить в список"><i class="bi bi-heart-fill"></i></button>
                                <button class="card-action-btn btn-add" onclick="addToRouteFromCard(${place.id})" data-tooltip="Добавить" title="➕ На карту и в список"><i class="bi bi-plus-lg"></i></button>
                            </div>
                        </div>
                    `;
                    
                    track.appendChild(card);
                });
                
                updateCarouselCounter();
                updateCarouselButtons();
            }
            
            // Движение карусели
            window.moveCarousel = function(direction) {
                const track = document.getElementById('carouselTrack');
                const cardWidth = 450; // 420px + 30px gap
                
                currentCarouselIndex += direction;
                
                // Ограничения
                const maxIndex = Math.max(0, cardStack.length - 3);
                currentCarouselIndex = Math.max(0, Math.min(currentCarouselIndex, maxIndex));
                
                track.style.transform = `translateX(-${currentCarouselIndex * cardWidth}px)`;
                
                updateCarouselCounter();
                updateCarouselButtons();
            };
                
            // Обновление счётчика
            function updateCarouselCounter() {
                const counter = document.getElementById('carouselCounter');
                if (counter) {
                    counter.textContent = `${currentCarouselIndex + 1} / ${cardStack.length}`;
                }
            }
            
            // Обновление кнопок
            function updateCarouselButtons() {
                const prevBtn = document.getElementById('prevCarouselBtn');
                const nextBtn = document.getElementById('nextCarouselBtn');
                
                if (prevBtn) prevBtn.disabled = currentCarouselIndex === 0;
                if (nextBtn) {
                    const maxIndex = Math.max(0, cardStack.length - 3);
                    nextBtn.disabled = currentCarouselIndex >= maxIndex;
                }
            }
            
            // Лайк карточки
            window.likeCard = function(cardIndex) {
                const place = cardStack[cardIndex];
                selectedPlaces.push(place);
                localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
                updateSelectedPlaces();
                showNotification(`❤️ ${place.name} добавлено в список`);
            };
                
            // Дизлайк карточки
            window.dislikeCard = function(cardIndex) {
                const place = cardStack[cardIndex];
                cardStack.splice(cardIndex, 1);
                renderCarousel();
                showNotification(`❌ ${place.name} пропущено`);
            };
                
            // Добавить на карту и в список
            window.addToRouteFromCard = function(placeId) {
                const place = allPlaces.find(p => p.id === placeId);
                if (place && !selectedPlaces.find(p => p.id === placeId)) {
                    selectedPlaces.push(place);
                    localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
                    updateSelectedPlaces();
                    updateRouteOnMap();
                    
                    // Центрируем карту на месте
                    if (map) {
                        map.setView(place.coords, 16);
                    }
                    
                    showNotification(`➕ ${place.name} добавлено в маршрут!`);
                } else if (place) {
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
                
                currentCarouselIndex = 0;
                renderCarousel();
                showNotification(`Показаны: ${tab.textContent.trim()}`);
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
