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
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Конструктор маршрутов | Туры Везде</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; }
        body { 
            font-family: 'Mulish', sans-serif; 
            background: linear-gradient(135deg, #bcddff54, #98dbb8a1); 
        }
        .planner-container {
             max-width: 1400px; 
             margin: 20px auto; 
             padding: 0 20px; 
            }

        .info-block, .map-section, .cards-section, .selected-places-section {
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
            height: 450px; 
            width: 100%; 
            border-radius: 20px; 
            border: 3px solid #e8ecf1; 
        }

        .category-tabs { 
            display: flex; 
            gap: 12px; 
            justify-content: center; 
            margin-bottom: 20px; 
            flex-wrap: wrap; 
        }
        .category-tab { 
            padding: 12px 24px; 
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
            gap: 8px; 
            font-size: 0.95rem; 
        }
        .category-tab:hover { 
            border-color: #2e8d53; 
            background: #f0fff4; 
            transform: translateY(-2px); 
        }
        .category-tab.active { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            border-color: transparent; 
            color: white; 
            box-shadow: 0 8px 25px rgba(46,141,83,0.35); 
            transform: translateY(-3px); 
        }

        .carousel-nav { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 20px; 
            margin-bottom: 15px; 
        }
        .carousel-btn { 
            width: 45px; 
            height: 45px; 
            border-radius: 50%; 
            border: 2px solid #e8ecf1; 
            background: white;
            color: #2e8d53; 
            font-size: 1.3rem; 
            cursor: pointer; 
            transition: all 0.3s; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .carousel-btn:hover { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
             border-color: transparent; 
             color: white; 
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

        .carousel-wrapper { 
            overflow: hidden; 
            padding: 10px 0; 
        }
        .carousel-track { 
            display: flex; 
            gap: 20px; 
            transition: transform 0.4s ease; 
        }
        .carousel-card { 
            flex: 0 0 300px; 
            background: white; 
            border-radius: 16px; 
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08); 
            transition: all 0.3s; 
            border: 2px solid   #2e8d53; 
        }
        .carousel-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
            border-color: #2e8d53; 
        }
        .card-category-badge { 
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
            font-weight: 700; margin-bottom: 12px; }
        .card-title { 
            font-size: 1.15rem; 
            color: #1b5031; 
            font-weight: 800; 
            margin-bottom: 8px; 
            line-height: 1.3; 
        }
        .card-location { 
            color: #666; 
            font-size: 0.85rem; 
            margin-bottom: 8px; 
            display: flex; 
            align-items: center; 
            gap: 6px; 
        }
        .card-rating { 
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
            background: #fff9e6; 
            padding: 6px 12px; 
            border-radius: 12px; 
            font-size: 0.85rem; 
            font-weight: 700; 
            color: #1b5031; 
            margin-bottom: 10px; 
        }
        .card-rating .stars { 
            color: #ffc107; 
        }
        .card-price { 
            display: inline-block; 
            background: #f0fff4; 
            color: #2e8d53; 
            padding: 6px 12px; 
            border-radius: 12px; 
            font-size: 0.85rem; 
            font-weight: 700; 
            margin-bottom: 12px; 
        }
        .card-description { 
            color: #666; 
            font-size: 0.85rem; 
            line-height: 1.5; 
            margin-bottom: 12px; 
            display: -webkit-box; 
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical; 
            overflow: hidden; 
        }
        .card-actions { 
            display: flex; 
            gap: 8px; 
            justify-content: center; 
            padding-top: 12px; 
            border-top: 1px solid #f0f2f5; 
        }
        .card-action-btn { 
            flex: 1; 
            padding: 10px; 
            border-radius: 12px; 
            border: none; 
            cursor: pointer;
            font-weight: 600; 
            font-family: 'Mulish', sans-serif; 
            transition: all 0.3s; 
            display: flex;
            align-items: center; 
            justify-content: center; 
            gap: 6px; 
            font-size: 0.85rem; 
        }
        .btn-like { 
            background: #f0fff4; 
            color: #2e8d53; 
            border: 2px solid #d4f0e4; 
        }
        .btn-like:hover { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white;
            border-color: transparent; 
        }
        .btn-add { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
        }
        .btn-add:hover { 
            transform: scale(1.05); 
            box-shadow: 0 5px 15px rgba(46,141,83,0.4); 
        }

        .selected-places-list { 
            display: flex; 
            flex-direction: column; 
            gap: 10px; 
        }
        .selected-place-item { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 12px 15px;
            background: #f8f9fc; 
            border-radius: 12px; 
            border-left: 4px solid #2e8d53; 
            transition: all 0.2s; 
        }
        .selected-place-item:hover 
        { 
            background: #f0f2f5; 
            transform: translateX(3px); 
        }
        .place-info { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .place-number { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white;
            width: 28px; 
            height: 28px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-weight: 700; 
            font-size: 0.85rem; 
        }
        .remove-place-btn { 
            background: none; 
            border: none; 
            color: #ff6b6b; 
            font-size: 1.1rem; 
            cursor: pointer; 
            transition: all 0.2s; 
        }
        .remove-place-btn:hover { 
            ransform: scale(1.2); 
        }

        .route-stats { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
            padding: 18px;
            border-radius: 16px; 
            margin-bottom: 18px; 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 12px; 
        }
        .stat-item { 
            text-align: center; 
        }
        .stat-value { 
            font-size: 1.6rem; 
            font-weight: 800; 
        }
        .stat-label { 
            font-size: 0.75rem; 
            opacity: 0.9; 
        }

        .action-buttons { 
            display: flex; 
            gap: 12px; 
            margin-top: 18px; 
        }
        .action-btn { 
            flex: 1; 
            padding: 14px; 
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
            font-size: 0.95rem; 
        }
        .btn-primary { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
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

        .toast-notification { 
            position: fixed; 
            bottom: 30px; 
            right: 30px; 
            background: #2e8d53; 
            color: white;
            padding: 14px 24px; 
            border-radius: 50px; 
            font-weight: 500; 
            z-index: 2000;
            animation: slideInRight 0.3s ease; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.2); 
        }
        @keyframes slideInRight { 
            from { 
                transform: translateX(100%);
                opacity: 0; 
                } to 
                { transform: translateX(0);
                 opacity: 1; 
                } 
            }

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

        /* ===== Модальное окно параметров ===== */
        .edit-params-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 20px auto 0;
            padding: 12px 28px;
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-family: 'Mulish', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(46,141,83,0.3);
        }
        .edit-params-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46,141,83,0.4);
        }
        .params-modal {
            display: none;
            position: fixed;
            z-index: 3000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            align-items: flex-start;
            justify-content: center;
            padding-top: 80px;
            backdrop-filter: blur(5px);
        }
        .params-modal.show {
            display: flex;
            animation: modalFadeIn 0.3s ease;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .params-modal-content {
            background: white;
            border-radius: 24px;
            width: 90%;
            max-width: 520px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            animation: modalSlideDown 0.3s ease;
        }
        @keyframes modalSlideDown {
            from { transform: translateY(-40px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .params-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 28px 16px;
            border-bottom: 2px solid #e8ecf1;
        }
        .params-modal-header h3 {
            color: #1b5031;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .close-params-modal {
            font-size: 28px;
            cursor: pointer;
            color: #999;
            width: 36px; height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }
        .close-params-modal:hover {
            background: #f0f2f5;
            color: #333;
        }
        .params-modal-body {
            padding: 24px 28px;
        }
        .param-group {
            margin-bottom: 22px;
        }
        .param-group label {
            display: block;
            font-weight: 600;
            color: #1b5031;
            margin-bottom: 10px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .param-group label i {
            color: #2e8d53;
        }
        .param-select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e8ecf1;
            border-radius: 16px;
            font-size: 1rem;
            font-family: 'Mulish', sans-serif;
            background: white;
            transition: all 0.3s;
            cursor: pointer;
        }
        .param-select:focus {
            border-color: #2e8d53;
            box-shadow: 0 0 0 3px rgba(46,141,83,0.1);
            outline: none;
        }
        .travelers-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .traveler-option {
            flex: 1;
            min-width: 60px;
            padding: 12px;
            border: 2px solid #e8ecf1;
            border-radius: 14px;
            background: white;
            font-family: 'Mulish', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: #444;
            cursor: pointer;
            transition: all 0.3s;
        }
        .traveler-option:hover {
            border-color: #2e8d53;
            background: #f0fff4;
        }
        .traveler-option.selected {
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 5px 15px rgba(46,141,83,0.3);
        }
        .param-group input[type="range"] {
            width: 100%;
            height: 6px;
            -webkit-appearance: none;
            background: #e8ecf1;
            border-radius: 10px;
            margin: 10px 0;
        }
        .param-group input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 22px; height: 22px;
            background: #2e8d53;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(46,141,83,0.4);
        }
        .budget-display {
            text-align: center;
            font-weight: 700;
            color: #2e8d53;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        .budget-presets {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .budget-preset {
            padding: 8px 16px;
            border: 2px solid #e8ecf1;
            border-radius: 12px;
            background: white;
            font-family: 'Mulish', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: #555;
            cursor: pointer;
            transition: all 0.3s;
        }
        .budget-preset:hover {
            border-color: #2e8d53;
            background: #f0fff4;
            color: #2e8d53;
        }
        .dates-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .param-date {
            width: 100%;
            padding: 14px;
            border: 2px solid #e8ecf1;
            border-radius: 16px;
            font-size: 1rem;
            font-family: 'Mulish', sans-serif;
            transition: all 0.3s;
        }
        .param-date:focus {
            border-color: #2e8d53;
            outline: none;
        }
        .params-modal-footer {
            display: flex;
            gap: 12px;
            padding: 16px 28px 24px;
            border-top: 1px solid #e8ecf1;
        }
        .modal-btn {
            flex: 1;
            padding: 14px;
            border-radius: 50px;
            font-family: 'Mulish', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .modal-btn-primary {
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(46,141,83,0.3);
        }
        .modal-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46,141,83,0.4);
        }
        .modal-btn-secondary {
            background: #f8f9fc;
            color: #666;
            border: 2px solid #e8ecf1;
        }
        .modal-btn-secondary:hover {
            background: #e8ecf1;
        }

        @media (max-width: 768px) {
            .params-modal {
                padding-top: 60px;
                align-items: flex-end;
            }
            .params-modal-content {
                border-radius: 24px 24px 0 0;
                max-height: 90vh;
                width: 100%;
            }
            .dates-grid {
                grid-template-columns: 1fr;
            }
            .carousel-card { 
                flex: 0 0 280px; 
            }
            .card-image { 
                height: 180px; 
            }
            .route-stats { 
                grid-template-columns: 1fr; 
            }
            .action-buttons { 
                flex-direction: column; 
            }
            .category-tabs { 
                gap: 8px; 
            }
            .category-tab { 
                padding: 10px 16px; 
                font-size: 0.85rem; 
            }
            #map { 
                height: 350px; 
            }
        }
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
                    <div class="city-info-text"><h4>Город</h4><p id="cityName">Загрузка...</p></div>
                </div>
                <div class="city-info-item">
                    <i class="bi bi-people-fill"></i>
                    <div class="city-info-text"><h4>Гостей</h4><p id="travelersCount">1 чел.</p></div>
                </div>
                <div class="city-info-item">
                    <i class="bi bi-wallet2-fill"></i>
                    <div class="city-info-text"><h4>Бюджет</h4><p id="budgetAmount">30 000 ₽</p></div>
                </div>
                <div class="city-info-item">
                    <i class="bi bi-calendar-fill"></i>
                    <div class="city-info-text"><h4>Даты</h4><p id="travelDates">не выбраны</p></div>
                </div>
            </div>
            <button class="edit-params-btn" id="editParamsBtn">
                <i class="bi bi-pencil-square"></i> Изменить параметры
            </button>
        </div>

        <!-- Модальное окно изменения параметров -->
        <div id="paramsModal" class="params-modal">
            <div class="params-modal-content">
                <div class="params-modal-header">
                    <h3><i class="bi bi-sliders"></i> Параметры поездки</h3>
                    <span class="close-params-modal">&times;</span>
                </div>
                <div class="params-modal-body">
                    <div class="param-group">
                        <label><i class="bi bi-geo-alt-fill"></i> Город</label>
                        <select id="modalCitySelect" class="param-select">
                            <option value="saint-petersburg">Санкт-Петербург</option>
                            <option value="kaliningrad">Калининград</option>
                        </select>
                    </div>
                    <div class="param-group">
                        <label><i class="bi bi-people-fill"></i> Количество гостей</label>
                        <div class="travelers-options">
                            <button class="traveler-option" data-value="1">1</button>
                            <button class="traveler-option" data-value="2">2</button>
                            <button class="traveler-option" data-value="3-5">3-5</button>
                            <button class="traveler-option" data-value="6+">6+</button>
                        </div>
                    </div>
                    <div class="param-group">
                        <label><i class="bi bi-wallet2-fill"></i> Бюджет (₽)</label>
                        <input type="range" id="modalBudgetSlider" min="10000" max="200000" value="30000" step="5000">
                        <div class="budget-display"><span id="modalBudgetValue">30 000</span> ₽</div>
                        <div class="budget-presets">
                            <button class="budget-preset" data-value="20000">20 000</button>
                            <button class="budget-preset" data-value="50000">50 000</button>
                            <button class="budget-preset" data-value="100000">100 000</button>
                            <button class="budget-preset" data-value="150000">150 000</button>
                        </div>
                    </div>
                    <div class="param-group">
                        <label><i class="bi bi-calendar-fill"></i> Даты</label>
                        <div class="dates-grid">
                            <input type="date" id="modalStartDate" class="param-date">
                            <input type="date" id="modalEndDate" class="param-date">
                        </div>
                    </div>
                </div>
                <div class="params-modal-footer">
                    <button class="modal-btn modal-btn-secondary" id="cancelParamsBtn">Отмена</button>
                    <button class="modal-btn modal-btn-primary" id="saveParamsBtn">
                        <i class="bi bi-check-lg"></i> Сохранить
                    </button>
                </div>
            </div>
        </div>

        <!-- Карта -->
        <div class="map-section">
            <div class="section-header">
                <h2><i class="bi bi-map-fill"></i> Карта маршрута</h2>
            </div>
            <div id="map"></div>
        </div>

        <!-- Карточки мест -->
        <div class="cards-section">
            <div class="section-header">
                <h2><i class="bi bi-grid-3x3"></i> Выберите места</h2>
            </div>
            <div class="category-tabs" id="categoryTabs">
                <button class="category-tab active" data-category="all"><i class="bi bi-grid"></i> Все</button>
                <button class="category-tab" data-category="restaurants"><i class="bi bi-cup-hot"></i> Рестораны</button>
                <button class="category-tab" data-category="museums"><i class="bi bi-building"></i> Музеи</button>
                <button class="category-tab" data-category="parks"><i class="bi bi-tree"></i> Парки</button>
                <button class="category-tab" data-category="attractions"><i class="bi bi-star"></i> Достопримечательности</button>
                <button class="category-tab" data-category="hotels"><i class="bi bi-hotel"></i> Отели</button>
                <button class="category-tab" data-category="cafes"><i class="bi bi-coffee"></i> Кафе</button>
            </div>
            <div class="carousel-nav">
                <button class="carousel-btn" id="prevBtn" onclick="moveCarousel(-1)"><i class="bi bi-chevron-left"></i></button>
                <span class="carousel-counter" id="carouselCounter">1 / 1</span>
                <button class="carousel-btn" id="nextBtn" onclick="moveCarousel(1)"><i class="bi bi-chevron-right"></i></button>
            </div>
            <div class="carousel-wrapper">
                <div class="carousel-track" id="carouselTrack"></div>
            </div>
        </div>

        <!-- Выбранные места -->
        <div class="selected-places-section">
            <div class="section-header">
                <h2><i class="bi bi-list-check"></i> Ваш маршрут</h2>
            </div>
            <div id="routeStats" class="route-stats" style="display: none;">
                <div class="stat-item"><div class="stat-value" id="totalDistance">0</div><div class="stat-label">км</div></div>
                <div class="stat-item"><div class="stat-value" id="totalTime">0</div><div class="stat-label">мин</div></div>
                <div class="stat-item"><div class="stat-value" id="totalPlaces">0</div><div class="stat-label">мест</div></div>
            </div>
            <div class="selected-places-list" id="selectedPlacesList">
                <p style="text-align: center; color: #999; padding: 20px;"><i class="bi bi-compass"></i> Добавьте места в маршрут</p>
            </div>
            <div class="action-buttons">
                <button class="action-btn btn-secondary" id="clearRouteBtn"><i class="bi bi-trash-fill"></i> Очистить</button>
                <button class="action-btn btn-primary" id="saveRouteBtn"><i class="bi bi-save-fill"></i> Сохранить</button>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script>
        // ====== ДАННЫЕ ======
        const placesData = {
            'saint-petersburg': {
                center: [59.9343, 30.3351], zoom: 12,
                restaurants: [
                    { id: 1, name: 'Ресторан "Север"', location: 'Невский проспект, 15', coords: [59.9375, 30.3280], rating: 4.8, reviews: 342, description: 'Авторская кухня с северным колоритом.', price: '2500-4000 ₽' },
                    { id: 2, name: 'Бистро "Амбар"', location: 'ул. Рубинштейна, 7', coords: [59.9350, 30.3350], rating: 4.6, reviews: 218, description: 'Современное бистро с европейской кухней.', price: '1500-3000 ₽' },
                    { id: 3, name: 'Кофейня "Зерно"', location: 'Лиговский проспект, 53', coords: [59.9280, 30.3180], rating: 4.9, reviews: 156, description: 'Спешелти кофе и домашняя выпечка.', price: '300-800 ₽' }
                ],
                museums: [
                    { id: 101, name: 'Государственный Эрмитаж', location: 'Дворцовая площадь, 2', coords: [59.9402, 30.3141], rating: 4.9, reviews: 15420, description: 'Один из крупнейших музеев мира.', price: '500 ₽' },
                    { id: 102, name: 'Русский музей', location: 'Инженерная ул., 4', coords: [59.9376, 30.3325], rating: 4.7, reviews: 8934, description: 'Крупнейшая коллекция русского искусства.', price: '400 ₽' }
                ],
                parks: [
                    { id: 201, name: 'Екатерининский парк', location: 'г. Пушкин', coords: [59.7146, 30.3969], rating: 4.8, reviews: 12543, description: 'Парк в стиле барокко.', price: 'Бесплатно' },
                    { id: 202, name: 'Александровский сад', location: 'Марсово поле, 1', coords: [59.9385, 30.3250], rating: 4.5, reviews: 3421, description: 'Центральный городской парк.', price: 'Бесплатно' }
                ],
                attractions: [
                    { id: 301, name: 'Храм Спаса на Крови', location: 'наб. канала Грибоедова, 2Б', coords: [59.9401, 30.3287], rating: 4.9, reviews: 18765, description: 'Великолепный храм с мозаиками.', price: '250 ₽' },
                    { id: 302, name: 'Исаакиевский собор', location: 'Исаакиевская площадь, 4', coords: [59.9340, 30.3062], rating: 4.8, reviews: 21543, description: 'Один из крупнейших соборов мира.', price: '300 ₽' }
                ],
                hotels: [
                    { id: 401, name: 'Астория', location: 'Исаакиевская площадь, 4', coords: [59.9335, 30.3055], rating: 4.7, reviews: 2341, description: 'Люксовый отель в центре.', price: 'от 15000 ₽' }
                ],
                cafes: [
                    { id: 501, name: 'Кафе "Булочная"', location: 'ул. Рубинштейна, 18', coords: [59.9342, 30.3365], rating: 4.6, reviews: 1876, description: 'Свежая выпечка и кофе.', price: '200-600 ₽' }
                ]
            },
            'kaliningrad': {
                center: [54.7104, 20.5110], zoom: 12,
                restaurants: [
                    { id: 1, name: 'Ресторан "Финка"', location: 'пр. Мира, 8', coords: [54.7127, 20.5095], rating: 4.8, reviews: 854, description: 'Авторская кухня, морепродукты.', price: '2000-4000 ₽' },
                    { id: 2, name: 'Рыбная деревня', location: 'наб. Петра Великого', coords: [54.7104, 20.5200], rating: 4.6, reviews: 1243, description: 'Традиционные рыбные блюда.', price: '1500-3000 ₽' }
                ],
                museums: [
                    { id: 101, name: 'Музей Мирового океана', location: 'наб. Петра Великого, 1', coords: [54.7136, 20.5226], rating: 4.9, reviews: 12421, description: 'Крупнейший морской музей России.', price: '500 ₽' },
                    { id: 102, name: 'Дом Канта', location: 'остров Канта, 1', coords: [54.7189, 20.5235], rating: 4.7, reviews: 3241, description: 'Музей философа И. Канта.', price: '300 ₽' },
                    { id: 103, name: 'Художественный музей', location: 'пр. Мира, 22', coords: [54.7095, 20.5080], rating: 4.6, reviews: 2156, description: 'Русское и западноевропейское искусство.', price: '400 ₽' }
                ],
                parks: [
                    { id: 201, name: 'Парк Юности', location: 'ул. А. Невского, 42', coords: [54.6950, 20.5300], rating: 4.5, reviews: 4521, description: 'Крупный парк с аттракционами.', price: 'Бесплатно' },
                    { id: 202, name: 'Лесной парк', location: 'ул. Лесная', coords: [54.7250, 20.4950], rating: 4.7, reviews: 2341, description: 'Уютный парк для прогулок.', price: 'Бесплатно' }
                ],
                attractions: [
                    { id: 301, name: 'Кёнигсбергский собор', location: 'остров Канта, 1', coords: [54.7192, 20.5242], rating: 4.9, reviews: 18765, description: 'Готический собор XIII века.', price: 'Бесплатно' },
                    { id: 302, name: 'Форт №5', location: 'ул. Генерала Оленичева', coords: [54.6820, 20.4750], rating: 4.8, reviews: 5432, description: 'Форт XIX века с музеем.', price: '350 ₽' },
                    { id: 303, name: 'Африка', location: 'ул. Дмитрия Онуфриева, 7', coords: [54.7280, 20.5350], rating: 4.6, reviews: 3214, description: 'Уникальный архитектурный комплекс.', price: 'Бесплатно' },
                    { id: 304, name: 'Зелёный мост', location: 'река Преголя', coords: [54.7070, 20.5150], rating: 4.4, reviews: 1876, description: 'Исторический мост с видами.', price: 'Бесплатно' }
                ],
                hotels: [
                    { id: 401, name: 'Royal Hotel', location: 'ул. А. Невского, 34', coords: [54.6980, 20.5200], rating: 4.7, reviews: 1543, description: 'Современный отель в центре.', price: 'от 5000 ₽' },
                    { id: 402, name: 'Хаятт Ридженци', location: 'ул. Октябрьская, 2', coords: [54.7050, 20.5080], rating: 4.8, reviews: 2341, description: 'Премиум отель с спа.', price: 'от 10000 ₽' }
                ],
                cafes: [
                    { id: 501, name: 'Кофемания', location: 'ул. Профессора Баранова, 8', coords: [54.7115, 20.5105], rating: 4.6, reviews: 987, description: 'Авторский кофе и десерты.', price: '300-800 ₽' },
                    { id: 502, name: 'Кафе "Рыбачий кот"', location: 'наб. Петра Великого', coords: [54.7108, 20.5195], rating: 4.5, reviews: 765, description: 'Кафе с видом на реку.', price: '400-1000 ₽' }
                ]
            }
        };

        const categoryIcons = { restaurants: 'bi-cup-hot', museums: 'bi-building', parks: 'bi-tree', attractions: 'bi-star', hotels: 'bi-hotel', cafes: 'bi-coffee' };
        const categoryNames = { restaurants: 'Ресторан', museums: 'Музей', parks: 'Парк', attractions: 'Достопримечательность', hotels: 'Отель', cafes: 'Кафе' };
        const categoryColors = { restaurants: '#ff6b6b', museums: '#4ecdc4', parks: '#2e8d53', attractions: '#ffc107', hotels: '#9b59b6', cafes: '#e67e22' };

        // ====== СОСТОЯНИЕ ======
        let map = null, routingControl = null;
        let selectedPlaces = JSON.parse(localStorage.getItem('selected_places')) || [];
        let allPlaces = [], filteredPlaces = [];
        let carouselIndex = 0;

        // ====== ИНИЦИАЛИЗАЦИЯ ======
        document.addEventListener('DOMContentLoaded', function() {
            const savedData = JSON.parse(localStorage.getItem('selected_city'));
            const cityId = savedData?.cityId || 'saint-petersburg';
            const city = placesData[cityId] || placesData['saint-petersburg'];

            // Заполняем инфо
            if (savedData) {
                document.getElementById('cityName').textContent = savedData.cityName || 'Калининград';
                document.getElementById('travelersCount').textContent = (savedData.travelers || '1') + ' чел.';
                document.getElementById('budgetAmount').textContent = (savedData.budgetFormatted || '30 000') + ' ₽';
                document.getElementById('travelDates').textContent = savedData.dates || 'не выбраны';
            } else {
                document.getElementById('cityName').textContent = 'Калининград';
            }

            // Собираем все места
            allPlaces = [
                ...city.restaurants.map(p => ({...p, category: 'restaurants'})),
                ...city.museums.map(p => ({...p, category: 'museums'})),
                ...city.parks.map(p => ({...p, category: 'parks'})),
                ...city.attractions.map(p => ({...p, category: 'attractions'})),
                ...city.hotels.map(p => ({...p, category: 'hotels'})),
                ...city.cafes.map(p => ({...p, category: 'cafes'}))
            ];
            filteredPlaces = [...allPlaces];

            // Инициализация карты (отложенная)
            requestAnimationFrame(() => initMap(city));

            // Инициализация карточек
            renderCarousel();
            updateSelectedPlaces();
            updateRouteOnMap();

            // Табы категорий
            document.getElementById('categoryTabs').addEventListener('click', function(e) {
                const tab = e.target.closest('.category-tab');
                if (!tab) return;
                document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                const cat = tab.dataset.category;
                filteredPlaces = cat === 'all' ? [...allPlaces] : allPlaces.filter(p => p.category === cat);
                carouselIndex = 0;
                renderCarousel();
            });

            // Кнопки маршрута
            document.getElementById('clearRouteBtn').addEventListener('click', function() {
                if (selectedPlaces.length === 0) return;
                selectedPlaces = [];
                localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
                updateSelectedPlaces();
                updateRouteOnMap();
                showNotification('Маршрут очищен');
            });

            document.getElementById('saveRouteBtn').addEventListener('click', function() {
                if (selectedPlaces.length === 0) { showNotification('Добавьте места', true); return; }
                const routes = JSON.parse(localStorage.getItem('saved_routes')) || [];
                routes.push({
                    name: `Маршрут - ${new Date().toLocaleDateString('ru-RU')}`,
                    places: selectedPlaces,
                    date: new Date().toISOString(),
                    source: 'planner'
                });
                localStorage.setItem('saved_routes', JSON.stringify(routes));
                showNotification('✓ Маршрут сохранён!');
            });

            // Авторизация
            const authBtn = document.getElementById('authButton');
            const user = JSON.parse(localStorage.getItem('current_user'));
            if (user && authBtn) { authBtn.textContent = user.name || 'Профиль'; authBtn.href = 'profile.php'; }
        });

        // ====== КАРТА ======
        function initMap(city) {
            if (!document.getElementById('map')) return;
            map = L.map('map', { center: city.center, zoom: city.zoom, zoomControl: true });
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap', maxZoom: 18
            }).addTo(map);
            map.routeMarkers = [];
        }

        // ====== КАРТОЧКИ ======
        function renderCarousel() {
            const track = document.getElementById('carouselTrack');
            track.innerHTML = '';

            filteredPlaces.forEach((place) => {
                const stars = '★'.repeat(Math.floor(place.rating)) + (place.rating % 1 >= 0.5 ? '½' : '');
                const card = document.createElement('div');
                card.className = 'carousel-card';
                card.innerHTML = `
                    <div class="card-category-badge">
                        <i class="bi ${categoryIcons[place.category]}"></i> ${categoryNames[place.category]}
                    </div>
                    <h3 class="card-title">${place.name}</h3>
                    <div class="card-location"><i class="bi bi-geo-alt"></i> ${place.location}</div>
                    <div class="card-rating"><span class="stars">${stars}</span> ${place.rating}</div>
                    <div class="card-price">${place.price}</div>
                    <p class="card-description">${place.description}</p>
                    <div class="card-actions">
                        <button class="card-action-btn btn-like" onclick="likePlace(${place.id})"><i class="bi bi-heart-fill"></i> В список</button>
                        <button class="card-action-btn btn-add" onclick="addPlace(${place.id})"><i class="bi bi-plus-lg"></i> В маршрут</button>
                    </div>
                `;
                track.appendChild(card);
            });

            updateCarouselUI();
        }

        function updateCarouselUI() {
            const track = document.getElementById('carouselTrack');
            const cardWidth = 340;
            const maxIndex = Math.max(0, filteredPlaces.length - Math.floor(track.parentElement.offsetWidth / cardWidth));
            carouselIndex = Math.min(carouselIndex, maxIndex);
            track.style.transform = `translateX(-${carouselIndex * cardWidth}px)`;
            document.getElementById('carouselCounter').textContent = `${filteredPlaces.length > 0 ? carouselIndex + 1 : 0} / ${filteredPlaces.length}`;
            document.getElementById('prevBtn').disabled = carouselIndex === 0;
            document.getElementById('nextBtn').disabled = carouselIndex >= maxIndex || filteredPlaces.length === 0;
        }

        window.moveCarousel = function(dir) {
            const track = document.getElementById('carouselTrack');
            const cardWidth = 340;
            const maxIndex = Math.max(0, filteredPlaces.length - Math.floor(track.parentElement.offsetWidth / cardWidth));
            carouselIndex = Math.max(0, Math.min(carouselIndex + dir, maxIndex));
            updateCarouselUI();
        };

        // ====== ДЕЙСТВИЯ С МЕСТАМИ ======
        window.likePlace = function(id) {
            const place = allPlaces.find(p => p.id === id);
            if (!place) return;
            showNotification(`❤️ ${place.name} понравилось`);
        };

        window.addPlace = function(id) {
            const place = allPlaces.find(p => p.id === id);
            if (!place) return;
            if (selectedPlaces.find(p => p.id === id)) { showNotification('Уже в маршруте', true); return; }
            selectedPlaces.push(place);
            localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
            updateSelectedPlaces();
            updateRouteOnMap();
            if (map) map.setView(place.coords, 15);
            showNotification(`➕ ${place.name} добавлено`);
        };

        window.removePlace = function(id) {
            selectedPlaces = selectedPlaces.filter(p => p.id !== id);
            localStorage.setItem('selected_places', JSON.stringify(selectedPlaces));
            updateSelectedPlaces();
            updateRouteOnMap();
            showNotification('Место удалено');
        };

        // ====== СПИСОК И МАРШРУТ ======
        function updateSelectedPlaces() {
            const container = document.getElementById('selectedPlacesList');
            if (selectedPlaces.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #999; padding: 20px;"><i class="bi bi-compass"></i> Добавьте места в маршрут</p>';
                return;
            }
            container.innerHTML = selectedPlaces.map((place, i) => `
                <div class="selected-place-item">
                    <div class="place-info">
                        <span class="place-number">${i + 1}</span>
                        <div>
                            <strong>${place.name}</strong>
                            <div style="font-size: 0.8rem; color: #666; margin-top: 2px;">
                                <i class="bi ${categoryIcons[place.category]}"></i> ${categoryNames[place.category]}
                            </div>
                        </div>
                    </div>
                    <button class="remove-place-btn" onclick="removePlace(${place.id})"><i class="bi bi-x-circle-fill"></i></button>
                </div>
            `).join('');
        }

        function updateRouteOnMap() {
            if (!map) return;

            if (routingControl) { map.removeControl(routingControl); routingControl = null; }
            if (map.routeMarkers) { map.routeMarkers.forEach(m => map.removeLayer(m)); }
            map.routeMarkers = [];

            if (selectedPlaces.length === 0) {
                document.getElementById('routeStats').style.display = 'none';
                return;
            }

            document.getElementById('routeStats').style.display = 'grid';
            document.getElementById('totalPlaces').textContent = selectedPlaces.length;

            if (selectedPlaces.length === 1) {
                const p = selectedPlaces[0];
                const m = L.marker(p.coords, { icon: L.divIcon({ className: 'route-marker route-marker-start', html: '<i class="bi bi-geo-alt-fill"></i>', iconSize: [36, 36], iconAnchor: [18, 18] }) }).addTo(map);
                m.bindPopup(`<b>${p.name}</b>`).openPopup();
                map.routeMarkers = [m];
                map.setView(p.coords, 15);
                document.getElementById('totalDistance').textContent = '0';
                document.getElementById('totalTime').textContent = '0';
                return;
            }

            const waypoints = selectedPlaces.map(p => L.latLng(p.coords[0], p.coords[1]));
            routingControl = L.Routing.control({
                waypoints: waypoints,
                routeWhileDragging: false,
                showAlternatives: false,
                fitSelectedRoutes: true,
                show: false,
                lineOptions: { styles: [{ color: '#2e8d53', weight: 5, opacity: 0.9 }] },
                createMarker: function(i, wp, n) {
                    let cls = 'route-marker', html = i + 1;
                    if (i === 0) { cls += ' route-marker-start'; html = '<i class="bi bi-flag-fill"></i>'; }
                    else if (i === n - 1) { cls += ' route-marker-end'; html = '<i class="bi bi-flag-fill"></i>'; }
                    return L.marker(wp, { icon: L.divIcon({ className: cls, html: html, iconSize: [32, 32], iconAnchor: [16, 16] }) })
                        .bindPopup(`<b>${selectedPlaces[i].name}</b>`);
                }
            }).addTo(map);

            routingControl.on('routesfound', function(e) {
                const s = e.routes[0].summary;
                document.getElementById('totalDistance').textContent = (s.totalDistance / 1000).toFixed(1);
                document.getElementById('totalTime').textContent = Math.round(s.totalTime / 60);
            });
        }

        // ====== УТИЛИТЫ ======
        function showNotification(msg, isError) {
            const n = document.createElement('div');
            n.className = 'toast-notification';
            n.style.background = isError ? '#ff6b6b' : '#2e8d53';
            n.innerHTML = `<i class="bi ${isError ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill'}"></i> ${msg}`;
            document.body.appendChild(n);
            setTimeout(() => n.remove(), 2500);
        }

        // ====== МОДАЛЬНОЕ ОКНО ПАРАМЕТРОВ ======
        let currentParams = {};

        document.getElementById('editParamsBtn')?.addEventListener('click', function() {
            const savedData = JSON.parse(localStorage.getItem('selected_city')) || {};
            currentParams = {
                cityId: savedData.cityId || 'saint-petersburg',
                travelers: savedData.travelers || '1',
                budget: savedData.budget || 30000,
                startDate: savedData.startDate || '',
                endDate: savedData.endDate || ''
            };

            document.getElementById('modalCitySelect').value = currentParams.cityId;
            document.getElementById('modalBudgetSlider').value = currentParams.budget;
            document.getElementById('modalBudgetValue').textContent = Number(currentParams.budget).toLocaleString('ru-RU');
            document.getElementById('modalStartDate').value = currentParams.startDate;
            document.getElementById('modalEndDate').value = currentParams.endDate;

            document.querySelectorAll('.traveler-option').forEach(btn => {
                btn.classList.toggle('selected', btn.dataset.value === currentParams.travelers);
            });

            document.getElementById('paramsModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        });

        function closeParamsModal() {
            document.getElementById('paramsModal').classList.remove('show');
            document.body.style.overflow = '';
        }

        document.querySelector('.close-params-modal')?.addEventListener('click', closeParamsModal);
        document.getElementById('cancelParamsBtn')?.addEventListener('click', closeParamsModal);
        document.getElementById('paramsModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeParamsModal();
        });

        document.querySelectorAll('.traveler-option').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.traveler-option').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
                currentParams.travelers = this.dataset.value;
            });
        });

        document.getElementById('modalBudgetSlider')?.addEventListener('input', function() {
            document.getElementById('modalBudgetValue').textContent = Number(this.value).toLocaleString('ru-RU');
            currentParams.budget = this.value;
        });

        document.querySelectorAll('.budget-preset').forEach(btn => {
            btn.addEventListener('click', function() {
                const val = this.dataset.value;
                document.getElementById('modalBudgetSlider').value = val;
                document.getElementById('modalBudgetValue').textContent = Number(val).toLocaleString('ru-RU');
                currentParams.budget = val;
            });
        });

        document.getElementById('modalStartDate')?.addEventListener('change', function() {
            currentParams.startDate = this.value;
        });
        document.getElementById('modalEndDate')?.addEventListener('change', function() {
            currentParams.endDate = this.value;
        });

        document.getElementById('saveParamsBtn')?.addEventListener('click', function() {
            const cityId = document.getElementById('modalCitySelect').value;
            const cityNames = { 'saint-petersburg': 'Санкт-Петербург', 'kaliningrad': 'Калининград' };
            
            const surveyData = {
                cityId: cityId,
                cityName: cityNames[cityId] || 'Санкт-Петербург',
                travelers: currentParams.travelers || '1',
                budget: currentParams.budget || 30000,
                budgetFormatted: Number(currentParams.budget).toLocaleString('ru-RU'),
                startDate: currentParams.startDate || '',
                endDate: currentParams.endDate || '',
                dates: (currentParams.startDate && currentParams.endDate) 
                    ? `${currentParams.startDate} — ${currentParams.endDate}` 
                    : 'не выбраны',
                interests: currentParams.interests || 'Достопримечательности'
            };

            localStorage.setItem('selected_city', JSON.stringify(surveyData));

            document.getElementById('cityName').textContent = surveyData.cityName;
            document.getElementById('travelersCount').textContent = surveyData.travelers + ' чел.';
            document.getElementById('budgetAmount').textContent = surveyData.budgetFormatted + ' ₽';
            document.getElementById('travelDates').textContent = surveyData.dates;

            closeParamsModal();
            showNotification('✓ Параметры обновлены');

            setTimeout(() => location.reload(), 500);
        });
    </script>
</body>
</html>
