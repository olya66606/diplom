<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 

<div class="survey-block" id="surveyBlock">
    <div class="survey-container">
        <div class="survey-main-header">
            <h1 class="survey-main-title">Пройди опрос и мы поможем тебе</h1>
            <p class="survey-main-subtitle">Расскажи о своих планах - мы подберем лучший маршрут</p>
        </div>
        
        <div class="survey-card-wrapper">
            <div class="survey-questions-area">

                <div class="progress-indicator">
                    <div class="progress-steps">
                        <span class="step active" data-step="1">1</span>
                        <span class="step-line"></span>
                        <span class="step" data-step="2">2</span>
                        <span class="step-line"></span>
                        <span class="step" data-step="3">3</span>
                        <span class="step-line"></span>
                        <span class="step" data-step="4">4</span>
                        <span class="step-line"></span>
                        <span class="step" data-step="5">5</span>
                    </div>
                    <div class="progress-text">
                        <span id="current-step-text">Шаг 1 из 5</span>
                    </div>
                </div>

                <!-- Вопрос 1: Город -->
                <div class="question-card active" data-step="1">
                    <div class="question-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h3 class="question-title">Куда хочешь отправиться?</h3>
                    <p class="question-desc">Выбери город для твоего путешествия</p>
                    <div class="question-options">
                        <div class="city-buttons">
                            <button class="city-option" data-city="saint-petersburg">
                                <i class="bi bi-building"></i> Санкт-Петербург
                            </button>
                            <button class="city-option" data-city="kaliningrad">
                                <i class="bi bi-tree"></i> Калининград
                            </button>  
                            <button class="city-option" data-city="japan">
                                <i class="bi bi-flag"></i> Япония
                            </button>
                            <button class="city-option" data-city="moscow">
                                <i class="bi bi-star"></i> Москва
                            </button>
                          
                            <button class="city-option" data-city="sochi">
                                <i class="bi bi-sun"></i> Сочи
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 2: Количество человек -->
                <div class="question-card" data-step="2">
                    <div class="question-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="question-title">Сколько вас?</h3>
                    <p class="question-desc">Укажи количество путешественников</p>
                    <div class="question-options">
                        <div class="travelers-buttons">
                            <button class="travelers-option" data-travelers="1">1</button>
                            <button class="travelers-option" data-travelers="2">2</button>
                            <button class="travelers-option" data-travelers="3-5">3-5</button>
                            <button class="travelers-option" data-travelers="6+">6+</button>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 3: Бюджет -->
                <div class="question-card" data-step="3">
                    <div class="question-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h3 class="question-title">Какой бюджет?</h3>
                    <p class="question-desc">Выбери комфортную сумму на поездку</p>
                    <div class="question-options">
                        <div class="budget-slider-container">
                            <div class="budget-values">
                                <span>10 000 ₽</span>
                                <span id="budget-value-display">30 000 ₽</span>
                                <span>200 000 ₽</span>
                            </div>
                            <input type="range" id="budget-step" min="10000" max="200000" value="30000" step="5000">
                            <div class="budget-presets">
                                <button class="budget-preset" data-budget="20000">20 000 ₽</button>
                                <button class="budget-preset" data-budget="50000">50 000 ₽</button>
                                <button class="budget-preset" data-budget="100000">100 000 ₽</button>
                                <button class="budget-preset" data-budget="150000">150 000 ₽</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 4: Даты -->
                <div class="question-card" data-step="4">
                    <div class="question-icon">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <h3 class="question-title">Когда планируешь?</h3>
                    <p class="question-desc">Выбери даты поездки</p>
                    <div class="question-options">
                        <div class="dates-container">
                            <div class="date-input-group">
                                <label>Дата начала</label>
                                <input type="date" id="start-date-step" class="date-input">
                            </div>
                            <div class="date-input-group">
                                <label>Дата окончания</label>
                                <input type="date" id="end-date-step" class="date-input">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Вопрос 5: Интересы -->
                <div class="question-card" data-step="5">
                    <div class="question-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <h3 class="question-title">Что интересует?</h3>
                    <p class="question-desc">Выбери то, что хочешь увидеть</p>
                    <div class="question-options">
                        <div class="interests-buttons">
                            <button class="interest-option" data-interest="Достопримечательности">
                                <i class="bi bi-buildings"></i> Достопримечательности
                            </button>
                            <button class="interest-option" data-interest="Музеи">
                                <i class="bi bi-bank"></i> Музеи
                            </button>
                            <button class="interest-option" data-interest="Парки">
                                <i class="bi bi-flower1"></i> Парки
                            </button>
                            <button class="interest-option" data-interest="Еда">
                                <i class="bi bi-cup-straw"></i> Еда
                            </button>
                            <button class="interest-option" data-interest="Шоппинг">
                                <i class="bi bi-bag"></i> Шоппинг
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Кнопки навигации -->
                <div class="navigation-buttons">
                    <button id="prev-btn" class="nav-btn nav-prev" disabled>
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button id="next-btn" class="nav-btn nav-next">
                         <i class="bi bi-arrow-right"></i>
                    </button>
                    <button style="text-align: center; width: 150px;" id="submit-survey-btn" class="nav-btn nav-submit" style="display: none;">
                        Подобрать маршрут
                    </button>
                </div>
            </div>

            <!-- Правая панель - сводка -->
            <div class="survey-summary-container">
                <h2 class="survey-summary-title">Твой выбор</h2>
                <div id="summary-content" class="survey-summary-content">
                    <div class="summary-item">
                        <span class="summary-label">Город:</span>
                        <span class="summary-value" id="summary-country">не выбран</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Человек:</span>
                        <span class="summary-value" id="summary-travelers">не выбрано</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Бюджет:</span>
                        <span class="summary-value"><span id="summary-budget">30 000</span> ₽</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Даты:</span>
                        <span class="summary-value" id="summary-dates">не выбраны</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Интересы:</span>
                        <span class="summary-value" id="summary-interests">не выбраны</span>
                    </div>
                </div>
                <div class="survey-summary-footer">
                    <button type="button" id="reset-form" class="reset-btn">
                        <i class="bi bi-arrow-repeat"></i> Сбросить всё
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <div class="modal-header-custom">
            <h3><i class="bi bi-receipt"></i> Детали вашей поездки</h3>
        </div>
        <div id="modal-body"></div>
        <div class="modal-footer-custom">
            <a href="planner.php" class="modal-btn modal-btn-primary">
                <i class="bi bi-map-fill"></i> Перейти в конструктор
            </a>
        </div>
    </div>
</div>


<div class="tours-container hidden" id="toursContainer">
    <div class="section-header">
        <h1 id="tours-title">Популярные туры</h1>
        <p id="tours-subtitle">Откройте для себя лучшие маршруты</p>
    </div>
    <div class="tours-grid" id="tours-grid">
        <!-- Туры будут загружаться динамически -->
    </div>
</div>


<div class="vivod" id="tourStatsContainer">
    <h1>Статистика и информация о турах</h1>
    
    <div class="stats-grid">
        <!-- Ряд 1 -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-value" id="statDuration">6 дней</div>
            <div class="stat-label">Рекомендуемая длительность</div>
            <div class="stat-desc" id="statDurationDesc">максимальное комфортное число дней</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-chat-dots"></i>
            </div>
            <div class="stat-value" id="statReviews">85+</div>
            <div class="stat-label">Отзывы клиентов</div>
            <div class="stat-desc">положительных отзывов о турах</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-star-fill"></i>
            </div>
            <div class="stat-value" id="statRating">8.7</div>
            <div class="stat-label">Уровень удовлетворенности</div>
            <div class="stat-desc">средняя оценка туров (из 10)</div>
        </div>

        <!-- Ряд 2 -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-graph-up"></i>
            </div>
            <div class="stat-value" id="statFillRate">65%</div>
            <div class="stat-label">Заполненность туров</div>
            <div class="stat-desc">туров заполнены на ближайший месяц</div>
            <div class="stat-bars">
                <div class="stat-bar">
                    <span>Весна</span>
                    <div class="bar"><div class="bar-fill" id="barSpring" style="width: 85%"></div></div>
                    <span id="springPercent">85%</span>
                </div>
                <div class="stat-bar">
                    <span>Лето</span>
                    <div class="bar"><div class="bar-fill" id="barSummer" style="width: 92%"></div></div>
                    <span id="summerPercent">92%</span>
                </div>
                <div class="stat-bar">
                    <span>Зима</span>
                    <div class="bar"><div class="bar-fill" id="barWinter" style="width: 45%"></div></div>
                    <span id="winterPercent">45%</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-pie-chart"></i>
            </div>
            <div class="stat-value" id="statTopCategory">Город 42%</div>
            <div class="stat-label">Предпочтения туристов</div>
            <div class="stat-desc">распределение по типам туров</div>
            <div class="stat-pie" id="categoriesPie">
                <div class="pie-item">
                    <div class="pie-color" style="background: #29e486"></div>
                    <span id="pieCategory1">Город 42%</span>
                </div>
                <div class="pie-item">
                    <div class="pie-color" style="background: #207936"></div>
                    <span id="pieCategory2">Поселки 28%</span>
                </div>
                <div class="pie-item">
                    <div class="pie-color" style="background: #1e7036"></div>
                    <span id="pieCategory3">Область 30%</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-value">Критерии выбора</div>
            <div class="stat-label">Что важно для туристов</div>
            <ul class="criteria-list">
                <li><i class="bi bi-check-lg"></i> Соответствие цены и качества</li>
                <li><i class="bi bi-check-lg"></i> Положительные отзывы</li>
                <li><i class="bi bi-check-lg"></i> Комфортные условия</li>
                <li><i class="bi bi-check-lg"></i> Интересная программа</li>
                <li><i class="bi bi-check-lg"></i> Безопасность и надежность</li>
            </ul>
        </div>
    </div>
</div>


<script src="js/script.js"></script>
</body>
</html>