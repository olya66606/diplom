
// Данные для туров
const toursData = {
            'saint-petersburg': [
                {
                    id: 1,
                    title: 'Классический Петербург',
                    image: 'img/piter.jpg',
                    location: 'Санкт-Петербург',
                    rating: 4.8,
                    reviews: 124,
                    description: 'Главные достопримечательности: Эрмитаж, Петропавловская крепость, Исаакиевский собор, Невский проспект.',
                    price: '25000',
                    duration: 3,
                    badge: 'Популярный',
                    places: ['Эрмитаж - один из крупнейших музеев мира', 'Петропавловская крепость - исторический центр', 'Исаакиевский собор - величественный храм', 'Невский проспект - главная улица', 'Храм Спаса на Крови'],
                    includes: ['Проживание в отеле 4*', 'Экскурсии с гидом', 'Трансфер', 'Входные билеты'],
                    schedule: ['День 1: Прибытие, Невский проспект', 'День 2: Эрмитаж, Петропавловская крепость', 'День 3: Исаакиевский собор, отправление'],
                    totalTime: '18-20 часов',
                    groupSize: 'до 15 человек',
                    difficulty: 'Легкий'
                },
                {
                    id: 2,
                    title: 'Петербург - культурная столица',
                    image: 'img/dostopro.jpg',
                    location: 'Санкт-Петербург',
                    rating: 4.9,
                    reviews: 98,
                    description: 'Музеи, театры, дворцы. Русский музей, Мариинский театр, Юсуповский дворец.',
                    price: '32000',
                    duration: 4,
                    badge: 'Хит',
                    places: ['Русский музей', 'Мариинский театр', 'Юсуповский дворец', 'Новая Голландия', 'Летний сад'],
                    includes: ['Проживание в отеле 5*', 'Билеты в Мариинский театр', 'Гид-искусствовед', 'Ужины в ресторанах'],
                    schedule: ['День 1: Русский музей', 'День 2: Юсуповский дворец, театр', 'День 3: Новая Голландия', 'День 4: Отправление'],
                    totalTime: '22-25 часов',
                    groupSize: 'до 12 человек',
                    difficulty: 'Легкий'
                },
                {
                    id: 3,
                    title: 'Пригороды Петербурга',
                    image: 'img/petergof.webp',
                    location: 'Петергоф, Царское село',
                    rating: 4.7,
                    reviews: 156,
                    description: 'Петергоф, Царское село, Павловск. Фонтаны и дворцово-парковые ансамбли.',
                    price: '28000',
                    duration: 2,
                    badge: 'Экскурсионный',
                    places: ['Петергоф с фонтанами', 'Царское село', 'Екатерининский дворец', 'Янтарная комната', 'Павловск'],
                    includes: ['Проживание 4*', 'Трансфер на автобусе', 'Экскурсии с гидом', 'Входные билеты'],
                    schedule: ['День 1: Петергоф, Кронштадт', 'День 2: Царское село, Павловск'],
                    totalTime: '14-16 часов',
                    groupSize: 'до 20 человек',
                    difficulty: 'Средний'
                }
            ],
            'kaliningrad': [
                {
                    id: 4,
                    title: 'Кёнигсберг - Калининград',
                    image: 'img/kaliningrad.jpg',
                    location: 'Калининград',
                    rating: 4.7,
                    reviews: 89,
                    description: 'Кафедральный собор, остров Канта, Рыбная деревня, Музей янтаря.',
                    price: '22000',
                    duration: 3,
                    badge: 'Исторический',
                    places: ['Кафедральный собор', 'Остров Канта', 'Рыбная деревня', 'Музей янтаря', 'Форт №5'],
                    includes: ['Проживание в центре', 'Экскурсии с гидом', 'Дегустация янтаря', 'Обеды'],
                    schedule: ['День 1: Собор, Канта, Рыбная деревня', 'День 2: Музей янтаря, Форт', 'День 3: Отправление'],
                    totalTime: '12-14 часов',
                    groupSize: 'до 15 человек',
                    difficulty: 'Легкий'
                },
                {
                    id: 5,
                    title: 'Куршская коса',
                    image: 'img/kyrshckaya.webp',
                    location: 'Куршская коса',
                    rating: 4.9,
                    reviews: 112,
                    description: 'Национальный парк, Танцующий лес, Высота Эфа, птичья станция.',
                    price: '18000',
                    duration: 1,
                    badge: 'Природный',
                    places: ['Танцующий лес', 'Высота Эфа', 'Птичья станция', 'Зеленоградск', 'Озеро Лебедь'],
                    includes: ['Трансфер из Калининграда', 'Экскурсия по нац. парку', 'Подъем на высоту Эфа', 'Обед'],
                    schedule: ['День 1: Танцующий лес, Высота Эфа, возвращение'],
                    totalTime: '8-10 часов',
                    groupSize: 'до 10 человек',
                    difficulty: 'Средний'
                },
                {
                    id: 6,
                    title: 'Калининградские форты',
                    image: 'img/fort.webp',
                    location: 'Калининград',
                    rating: 4.6,
                    reviews: 67,
                    description: 'Форт №11, Форт №5, Фридландские ворота, Башня Врангеля.',
                    price: '20000',
                    duration: 2,
                    badge: 'Фортификационный',
                    places: ['Форт №11 Дёнхофф', 'Форт №5', 'Фридландские ворота', 'Башня Врангеля', 'Башня Кёниг'],
                    includes: ['Трансфер между фортами', 'Гид-историк', 'Входные билеты', 'Фотосессия'],
                    schedule: ['День 1: Форт №11, Форт №5, ворота', 'День 2: Башни, отправление'],
                    totalTime: '10-12 часов',
                    groupSize: 'до 12 человек',
                    difficulty: 'Средний'
                }
            ],
            'kaliningrad': [
                {
                    id: 7,
                    title: 'Калининград - Наследие Восточной Пруссии',
                    image: 'img/kaliningrad1.jpg',
                    location: 'Калининград',
                    rating: 4.8,
                    reviews: 456,
                    description: 'Уникальный город на стыке европейской и российской культуры. Собор, форты, янтарь.',
                    price: '25000',
                    duration: 3,
                    badge: 'Популярный',
                    places: ['Кёнигсбергский собор', 'Форт №5', 'Музей Мирового океана', 'Остров Канта'],
                    includes: ['Проживание в отеле 3*', 'Экскурсии с гидом', 'Входные билеты', 'Завтраки'],
                    schedule: ['День 1: Собор и остров Канта', 'День 2: Музей Мирового океана', 'День 3: Форт №5'],
                    totalTime: '18-20 часов',
                    groupSize: 'до 15 человек',
                    difficulty: 'Легкий'
                },
                {
                    id: 8,
                    title: 'Янтарный край - Полное погружение',
                    image: 'img/kaliningrad2.jpg',
                    location: 'Калининград и область',
                    rating: 4.9,
                    reviews: 378,
                    description: 'Куршская коса, янтарный завод, форты и соборы. Полное погружение в историю региона.',
                    price: '35000',
                    duration: 4,
                    badge: 'Хит',
                    places: ['Куршская коса', 'Янтарный завод', 'Зелёный мост', 'Форт №11'],
                    includes: ['Проживание 3*', 'Трансфер', 'Экскурсии с гидом', 'Питание'],
                    schedule: ['День 1: Куршская коса', 'День 2: Янтарь и заводы', 'День 3: Форты города', 'День 4: Отправление'],
                    totalTime: '22-24 часа',
                    groupSize: 'до 12 человек',
                    difficulty: 'Средний'
                },
                {
                    id: 9,
                    title: 'Военная история Калининграда',
                    image: 'img/kaliningrad3.jpg',
                    location: 'Калининград',
                    rating: 4.7,
                    reviews: 289,
                    description: 'Система фортов Кёнигсберга, бункеры и военная архитектура.',
                    price: '22000',
                    duration: 3,
                    badge: 'Эксклюзивный',
                    places: ['Форт №5', 'Форт №11', 'Башня Врангеля', 'Замковый холм'],
                    includes: ['Проживание', 'Трансфер на автобусе', 'Экскурсии с военным историком', 'Трапеза в ресторане'],
                    schedule: ['День 1: Форт №5 и №11', 'День 2: Башни города', 'День 3: Замок и отправление'],
                    totalTime: '16-18 часов',
                    groupSize: 'до 10 человек',
                    difficulty: 'Средний'
                }
            ]
        };

// Функция для получения названия города
function getCityDisplayName(cityId) {
    const cities = {
        'saint-petersburg': 'Санкт-Петербург',
        'kaliningrad': 'Калининград',
    };
    return cities[cityId] || 'Санкт-Петербург';
}
    
// Функция расчёта статистики по турам
function calculateTourStats(cityId) {
    const tours = toursData[cityId] || toursData['saint-petersburg'];
    
    if (tours.length === 0) {
        return null;
    }
    
    // Расчёт статистики
    const totalTours = tours.length;
    const totalReviews = tours.reduce((sum, tour) => sum + tour.reviews, 0);
    const avgRating = (tours.reduce((sum, tour) => sum + tour.rating, 0) / totalTours).toFixed(1);
    const minPrice = Math.min(...tours.map(t => parseInt(t.price)));
    const maxPrice = Math.max(...tours.map(t => parseInt(t.price)));
    const avgPrice = Math.round(tours.reduce((sum, tour) => sum + parseInt(tour.price), 0) / totalTours);
    const totalDays = tours.reduce((sum, tour) => sum + tour.duration, 0);
    const avgDuration = (totalDays / totalTours).toFixed(1);
    
    // Распределение по категориям (badges)
    const categories = {};
    tours.forEach(tour => {
        const badge = tour.badge || 'Другое';
        categories[badge] = (categories[badge] || 0) + 1;
    });
    
    return {
        totalTours,
        totalReviews,
        avgRating,
        minPrice,
        maxPrice,
        avgPrice,
        avgDuration,
        categories
    };
}

// Функция обновления статистики в блоке vivod
function updateTourStatsBlock(cityId) {
    const stats = calculateTourStats(cityId);
    const cityName = getCityDisplayName(cityId);
    
    if (!stats) return;
    
    // Обновляем значения статистики
    const statDuration = document.getElementById('statDuration');
    const statDurationDesc = document.getElementById('statDurationDesc');
    const statReviews = document.getElementById('statReviews');
    const statRating = document.getElementById('statRating');
    const statFillRate = document.getElementById('statFillRate');
    const barSpring = document.getElementById('barSpring');
    const barSummer = document.getElementById('barSummer');
    const barWinter = document.getElementById('barWinter');
    const springPercent = document.getElementById('springPercent');
    const summerPercent = document.getElementById('summerPercent');
    const winterPercent = document.getElementById('winterPercent');
    const statTopCategory = document.getElementById('statTopCategory');
    const pieCategory1 = document.getElementById('pieCategory1');
    const pieCategory2 = document.getElementById('pieCategory2');
    const pieCategory3 = document.getElementById('pieCategory3');
    
    // Длительность тура
    if (statDuration) {
        statDuration.textContent = `${stats.avgDuration} дн.`;
    }
    if (statDurationDesc) {
        statDurationDesc.textContent = `средняя длительность туров в ${cityName}`;
    }
    
    // Отзывы
    if (statReviews) {
        statReviews.textContent = `${stats.totalReviews}+`;
    }
    
    // Рейтинг
    if (statRating) {
        statRating.textContent = stats.avgRating;
    }
    
    // Заполненность (имитация на основе сезона)
    const fillRate = Math.floor(60 + Math.random() * 30); // 60-90%
    if (statFillRate) {
        statFillRate.textContent = `${fillRate}%`;
    }
    
    // Бары по сезонам (случайные значения вокруг fillRate)
    const springFill = Math.min(95, Math.max(40, fillRate + (Math.random() * 20 - 10)));
    const summerFill = Math.min(95, Math.max(50, fillRate + (Math.random() * 20 - 5)));
    const winterFill = Math.min(95, Math.max(30, fillRate + (Math.random() * 20 - 20)));
    
    if (barSpring) barSpring.style.width = `${springFill}%`;
    if (barSummer) barSummer.style.width = `${summerFill}%`;
    if (barWinter) barWinter.style.width = `${winterFill}%`;
    
    if (springPercent) springPercent.textContent = `${Math.round(springFill)}%`;
    if (summerPercent) summerPercent.textContent = `${Math.round(summerFill)}%`;
    if (winterPercent) winterPercent.textContent = `${Math.round(winterFill)}%`;
    
    // Категории туров
    const categoryEntries = Object.entries(stats.categories);
    if (categoryEntries.length > 0) {
        // Сортируем по количеству
        categoryEntries.sort((a, b) => b[1] - a[1]);
        
        const totalCategories = categoryEntries.reduce((sum, [, count]) => sum + count, 0);
        
        if (categoryEntries[0]) {
            const topCat = categoryEntries[0];
            const topPercent = Math.round((topCat[1] / totalCategories) * 100);
            if (statTopCategory) {
                statTopCategory.textContent = `${topCat[0]} ${topPercent}%`;
            }
        }
        
        // Обновляем pie chart
        if (categoryEntries[0]) {
            const cat1 = categoryEntries[0];
            const pct1 = Math.round((cat1[1] / totalCategories) * 100);
            if (pieCategory1) pieCategory1.textContent = `${cat1[0]} ${pct1}%`;
        }
        
        if (categoryEntries[1]) {
            const cat2 = categoryEntries[1];
            const pct2 = Math.round((cat2[1] / totalCategories) * 100);
            if (pieCategory2) pieCategory2.textContent = `${cat2[0]} ${pct2}%`;
        } else {
            if (pieCategory2) pieCategory2.textContent = 'Стандарт 28%';
        }
        
        if (categoryEntries[2]) {
            const cat3 = categoryEntries[2];
            const pct3 = Math.round((cat3[1] / totalCategories) * 100);
            if (pieCategory3) pieCategory3.textContent = `${cat3[0]} ${pct3}%`;
        } else {
            if (pieCategory3) pieCategory3.textContent = 'Эксклюзив 30%';
        }
    }

    // Показываем блок (убираем hidden если был)
    const vivodBlock = document.getElementById('tourStatsContainer');
    if (vivodBlock) {
        vivodBlock.style.display = 'block';
    }
}

// Функция загрузки туров (для старого опроса)
function loadTours(cityId) {
    const toursGrid = document.getElementById('tours-grid');
    const toursTitle = document.getElementById('tours-title');
    const toursSubtitle = document.getElementById('tours-subtitle');
    const toursContainer = document.getElementById('toursContainer');
    
    const cityName = getCityDisplayName(cityId);
    
    toursTitle.textContent = `Популярные туры в ${cityName}`;
    toursSubtitle.textContent = `Откройте для себя лучшие маршруты по ${cityName}`;
    
    const tours = toursData[cityId] || toursData['saint-petersburg'];
    
    toursGrid.innerHTML = tours.map(tour => `
        <div class="tour-card" style="height: 100%;">
            <div class="tour-image" style="background-image: url('${tour.image}')">
                <span class="tour-badge">${tour.badge}</span>
            </div>
            <div class="tour-content">
                <h3>${tour.title}</h3>
                <div class="tour-location"><i class="bi bi-geo-alt"></i> ${tour.location}</div>
                <div class="tour-rating">
                    <div class="stars">${'★'.repeat(Math.floor(tour.rating))}${tour.rating % 1 >= 0.5 ? '½' : ''}</div>
                    <span>${tour.rating} (${tour.reviews} отзывов)</span>
                </div>
                <p class="tour-description">${tour.description}</p>
                <div class="tour-meta">
                    <div class="tour-price">${parseInt(tour.price).toLocaleString('ru-RU')} ₽ <span>за чел.</span></div>
                    <div class="tour-duration"><i class="bi bi-clock"></i> ${tour.duration} дня</div>
                </div>
                <div class="tour-actions">
                    <button class="tour-btn tour-btn-primary" onclick="showTourDetails(${tour.id})">Получить подробнее</button>
                    <button class="tour-btn tour-btn-secondary" onclick="saveTour(${tour.id})"><i class="bi bi-bookmark"></i></button>
                </div>
            </div>
        </div>
    `).join('');
    
    // Обновляем статистику
    updateTourStatsBlock(cityId);
    
    // ПОКАЗЫВАЕМ блок с турами (убираем класс hidden)
    if (toursContainer) {
        toursContainer.classList.remove('hidden');
        // Плавно прокручиваем к турам
        setTimeout(() => {
            toursContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }
}
        // Логика опроса
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем элементы
            const countrySelect = document.getElementById('country');
            const travelersRadios = document.querySelectorAll('input[name="travelers"]');
            const budgetRange = document.getElementById('budget');
            const budgetSpan = document.getElementById('budget-value');
            const startDate = document.getElementById('start-date');
            const endDate = document.getElementById('end-date');
            const interestCheckboxes = document.querySelectorAll('input[name="interests"]');
            const additionalInfo = document.getElementById('additional-info');

            // Элементы сводки
            const summaryCountry = document.getElementById('summary-country');
            const summaryTravelers = document.getElementById('summary-travelers');
            const summaryBudget = document.getElementById('summary-budget');
            const summaryDates = document.getElementById('summary-dates');
            const summaryInterests = document.getElementById('summary-interests');
            const summaryAdditional = document.getElementById('summary-additional');
            
            const resetBtn = document.getElementById('reset-form');
            const submitBtn = document.getElementById('submit-btn');
            const modal = document.getElementById('myModal');
            const modalBody = document.getElementById('modal-body');
            const closeModal = document.querySelector('.close-modal');

            // Функция обновления сводки
            function updateSummary() {
                const selectedCity = countrySelect.value;
                summaryCountry.textContent = getCityDisplayName(selectedCity);
                
                let travelersValue = '1';
                travelersRadios.forEach(radio => {
                    if (radio.checked) travelersValue = radio.value;
                });
                summaryTravelers.textContent = travelersValue;
                
                // Обновление бюджета
                const budgetVal = budgetRange.value;
                budgetSpan.textContent = Number(budgetVal).toLocaleString('ru-RU') + ' ₽';
                summaryBudget.textContent = Number(budgetVal).toLocaleString('ru-RU');
                
                // Даты
                if (startDate.value && endDate.value) {
                    summaryDates.textContent = `${startDate.value} — ${endDate.value}`;
                } else {
                    summaryDates.textContent = 'не выбраны';
                }
                
                // Интересы
                let selected = [];
                interestCheckboxes.forEach(cb => {
                    if (cb.checked) selected.push(cb.value);
                });
                summaryInterests.textContent = selected.length > 0 ? selected.join(', ') : 'Ничего не выбрано';
                
                // Доп info
                summaryAdditional.textContent = additionalInfo.value.trim() || '—';
                
                // Загружаем туры для выбранного города
                loadTours(selectedCity);
            }

            // Обработчики событий
            countrySelect.addEventListener('change', updateSummary);
            travelersRadios.forEach(radio => radio.addEventListener('change', updateSummary));
            budgetRange.addEventListener('input', updateSummary);
            startDate.addEventListener('change', updateSummary);
            endDate.addEventListener('change', updateSummary);
            interestCheckboxes.forEach(cb => cb.addEventListener('change', updateSummary));
            additionalInfo.addEventListener('input', updateSummary);

            // Сброс формы
            resetBtn.addEventListener('click', function() {
                countrySelect.value = 'saint-petersburg';
                travelersRadios.forEach(radio => { radio.checked = (radio.value === '1'); });
                budgetRange.value = 30000;
                startDate.value = '';
                endDate.value = '';
                interestCheckboxes.forEach((cb, index) => { cb.checked = (index === 0); });
                additionalInfo.value = '';
                updateSummary();
            });

            // Отправка формы - СОХРАНЯЕМ ВСЕ ДАННЫЕ В localStorage
            submitBtn.addEventListener('click', function() {
                const cityId = countrySelect.value;
                const cityName = getCityDisplayName(cityId);
                
                // Получаем все значения
                let travelersValue = '1';
                travelersRadios.forEach(radio => {
                    if (radio.checked) travelersValue = radio.value;
                });
                
                let selectedInterests = [];
                interestCheckboxes.forEach(cb => {
                    if (cb.checked) selectedInterests.push(cb.value);
                });
                
                // Формируем объект с данными
                const surveyData = {
                    cityId: cityId,
                    cityName: cityName,
                    travelers: travelersValue,
                    budget: budgetRange.value,
                    budgetFormatted: Number(budgetRange.value).toLocaleString('ru-RU'),
                    startDate: startDate.value,
                    endDate: endDate.value,
                    dates: (startDate.value && endDate.value) ? `${startDate.value} — ${endDate.value}` : 'не выбраны',
                    interests: selectedInterests.join(', ') || 'Достопримечательности',
                    additional: additionalInfo.value.trim() || '—'
                };
                
                // СОХРАНЯЕМ В localStorage
                localStorage.setItem('selected_city', JSON.stringify(surveyData));
                
                // Показываем модальное окно
                modalBody.innerHTML = `
                    <p><strong>Город:</strong> ${cityName}</p>
                    <p><strong>Человек:</strong> ${travelersValue}</p>
                    <p><strong>Бюджет:</strong> ${surveyData.budgetFormatted} ₽</p>
                    <p><strong>Даты:</strong> ${surveyData.dates}</p>
                    <p><strong>Интересы:</strong> ${surveyData.interests}</p>
                    <p><strong>Доп. инфо:</strong> ${surveyData.additional}</p>
                    <p><em>Данные сохранены! Перейдите в конструктор для построения маршрута.</em></p>
                `;
                modal.style.display = 'flex';
            });

    

























            
// Отправка формы - СОХРАНЯЕМ ВСЕ ДАННЫЕ В localStorage
submitBtn.addEventListener('click', function() {
    const cityId = countrySelect.value;
    const cityName = getCityDisplayName(cityId);
    
    // Получаем все значения
    let travelersValue = '1';
    travelersRadios.forEach(radio => {
        if (radio.checked) travelersValue = radio.value;
    });
    
    let selectedInterests = [];
    interestCheckboxes.forEach(cb => {
        if (cb.checked) selectedInterests.push(cb.value);
    });
    
    // Формируем объект с данными
    const surveyData = {
        cityId: cityId,
        cityName: cityName,
        travelers: travelersValue,
        budget: budgetRange.value,
        budgetFormatted: Number(budgetRange.value).toLocaleString('ru-RU'),
        startDate: startDate.value,
        endDate: endDate.value,
        dates: (startDate.value && endDate.value) ? `${startDate.value} — ${endDate.value}` : 'не выбраны',
        interests: selectedInterests.join(', ') || 'Достопримечательности',
        additional: additionalInfo.value.trim() || '—'
    };
    
    // СОХРАНЯЕМ В localStorage для planner.html
    localStorage.setItem('selected_city', JSON.stringify(surveyData));
    
    // СОХРАНЯЕМ ТОЛЬКО ГОРОД для locals.html
    localStorage.setItem('selected_city_for_locals', cityId);
    
    // Показываем модальное окно
    modalBody.innerHTML = `
        <p><strong>Город:</strong> ${cityName}</p>
        <p><strong>Человек:</strong> ${travelersValue}</p>
        <p><strong>Бюджет:</strong> ${surveyData.budgetFormatted} ₽</p>
        <p><strong>Даты:</strong> ${surveyData.dates}</p>
        <p><strong>Интересы:</strong> ${surveyData.interests}</p>
        <p><strong>Доп. инфо:</strong> ${surveyData.additional}</p>
        <p><em>Данные сохранены! Перейдите в конструктор для построения маршрута.</em></p>
    `;
    modal.style.display = 'flex';
});

            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Проверка авторизации через API
            fetch('/api/check_auth.php')
                .then(response => response.json())
                .then(data => {
                    const localsLink = document.getElementById('localsLink');
                    const authButton = document.getElementById('authButton');

                    if (data.authenticated) {
                        // Пользователь залогинен
                        if (localsLink) localsLink.style.display = 'inline-block';
                        if (authButton) {
                            authButton.textContent = 'Выйти';
                            authButton.href = '/auth/logout.php';
                        }
                    } else {
                        // Пользователь не залогинен
                        if (localsLink) localsLink.style.display = 'none';
                        if (authButton) {
                            authButton.textContent = 'Войти';
                            authButton.href = '/auth/login.php';
                        }
                    }
                })
                .catch(error => {
                    console.error('Ошибка проверки авторизации:', error);
                });

            // Устанавливаем минимальные даты
            const today = new Date().toISOString().split('T')[0];
            if (startDate) startDate.min = today;
            if (endDate) endDate.min = today;
            
            // Инициализация - загружаем туры для СПб по умолчанию
            updateSummary();
        });
  

document.addEventListener('DOMContentLoaded', function() {
    // =========================================
    // ПОЛУЧАЕМ ССЫЛКИ НА ЭЛЕМЕНТЫ ФОРМЫ
    // =========================================
    const countrySelect = document.getElementById('country');
    const travelersRadios = document.querySelectorAll('input[name="travelers"]');
    const budgetRange = document.getElementById('budget');
    const budgetSpan = document.getElementById('budget-value');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const interestCheckboxes = document.querySelectorAll('input[name="interests"]');
    const additionalInfo = document.getElementById('additional-info');

    // =========================================
    // ЭЛЕМЕНТЫ ДЛЯ ДУБЛИРОВАНИЯ (САММАРИ)
    // =========================================
    const summaryCountry = document.getElementById('summary-country');
    const summaryTravelers = document.getElementById('summary-travelers');
    const summaryBudget = document.getElementById('summary-budget');
    const summaryDates = document.getElementById('summary-dates');
    const summaryInterests = document.getElementById('summary-interests');
    const summaryAdditional = document.getElementById('summary-additional');

    // =========================================
    // КНОПКИ И МОДАЛКА
    // =========================================
    const resetBtn = document.getElementById('reset-form');
    const submitBtn = document.getElementById('submit-btn');
    const detailsBtn = document.getElementById('details-btn');
    const modal = document.getElementById('myModal');
    const modalBody = document.getElementById('modal-body');
    const closeModal = document.querySelector('.close-modal');

    // =========================================
    // ФУНКЦИИ ОБНОВЛЕНИЯ
    // =========================================

    /**
     * Обновляет значение бегунка и дублирует его
     */
    function updateBudget() {
        const val = budgetRange.value;
        budgetSpan.textContent = val;
        summaryBudget.textContent = val;
    }

    /**
     * Собирает выбранные интересы (чекбоксы) в строку
     */
    function getSelectedInterests() {
        let selected = [];
        interestCheckboxes.forEach(cb => {
            if (cb.checked) {
                selected.push(cb.value);
            }
        });
        return selected.length > 0 ? selected.join(', ') : 'Ничего не выбрано';
    }

    /**
     * Форматирует даты для вывода
     */
    function getFormattedDates() {
        if (startDate.value && endDate.value) {
            // Можно отформатировать даты, если нужно (например, из YYYY-MM-DD в DD.MM.YYYY)
            // Пока оставим как есть
            return `${startDate.value} — ${endDate.value}`;
        } else if (startDate.value) {
            return `${startDate.value} (только начало)`;
        } else if (endDate.value) {
            return `${endDate.value} (только конец)`;
        } else {
            return 'не выбраны';
        }
    }

    /**
     * Главная функция обновления всей дублирующей информации (summary)
     * Вызывается при любом изменении в форме.
     */
    function updateSummary() {
        // Страна
        summaryCountry.textContent = countrySelect.options[countrySelect.selectedIndex]?.text || '—';

        // Количество человек (находим выбранный radio)
        let travelersValue = '1'; // По умолчанию
        travelersRadios.forEach(radio => {
            if (radio.checked) {
                travelersValue = radio.value;
            }
        });
        summaryTravelers.textContent = travelersValue;

        // Бюджет (обновляется и в span, и в summary)
        updateBudget();

        // Даты
        summaryDates.textContent = getFormattedDates();

        // Интересы
        summaryInterests.textContent = getSelectedInterests();

        // Доп. информация
        summaryAdditional.textContent = additionalInfo.value.trim() || '—';
    }

    // =========================================
    // ОБРАБОТЧИКИ СОБЫТИЙ ДЛЯ АКТУАЛИЗАЦИИ SUMMARY
    // =========================================
    countrySelect.addEventListener('change', updateSummary);
    travelersRadios.forEach(radio => radio.addEventListener('change', updateSummary));
    budgetRange.addEventListener('input', updateSummary); // input для плавного обновления
    startDate.addEventListener('change', updateSummary);
    endDate.addEventListener('change', updateSummary);
    interestCheckboxes.forEach(cb => cb.addEventListener('change', updateSummary));
    additionalInfo.addEventListener('input', updateSummary);

    // =========================================
    // КНОПКА СБРОСА
    // =========================================
    resetBtn.addEventListener('click', function() {
        // Сбрасываем форму до исходного состояния (можно и form.reset(), но проще вручную задать начальные)
        countrySelect.value = 'Италия';

        // Сбрасываем radio
        travelersRadios.forEach(radio => {
            radio.checked = (radio.value === '1');
        });

        // Сбрасываем бюджет
        budgetRange.value = 500;

        // Сбрасываем даты
        startDate.value = '';
        endDate.value = '';

        // Сбрасываем чекбоксы: первый оставляем отмеченным, остальные снимаем
        interestCheckboxes.forEach((cb, index) => {
            cb.checked = (index === 0); // только первый (Достопримечательности) чекнут
        });

        // Сбрасываем текст
        additionalInfo.value = '';

        // После сброса данных обязательно обновляем интерфейс!
        updateSummary();
    });

    // =========================================
    // КНОПКА ОТПРАВИТЬ (МОДАЛКА)
    // =========================================
    submitBtn.addEventListener('click', function() {
        // Собираем все данные для модального окна в читабельном виде
        const country = summaryCountry.textContent;
        const travelers = summaryTravelers.textContent;
        const budget = summaryBudget.textContent;
        const dates = summaryDates.textContent;
        const interests = summaryInterests.textContent;
        const additional = summaryAdditional.textContent;

        const message = `
            <p><strong>Страна:</strong> ${country}</p>
            <p><strong>Человек:</strong> ${travelers}</p>
            <p><strong>Бюджет:</strong> $${budget}</p>
            <p><strong>Даты:</strong> ${dates}</p>
            <p><strong>Интересы:</strong> ${interests}</p>
            <p><strong>Доп. инфо:</strong> ${additional}</p>
            <hr>
            <p><em>Спасибо! Ваша заявка отправлена (демо).</em></p>
        `;

        modalBody.innerHTML = message;
        modal.style.display = 'flex'; // Показываем модальное окно
    });

    // =========================================
    // КНОПКА ПОДРОБНЕЕ (переход на следующий блок)
    // =========================================
    detailsBtn.addEventListener('click', function() {
      window.location.href = '/tours-container';  

    });

    // =========================================
    // ЗАКРЫТИЕ МОДАЛЬНОГО ОКНА
    // =========================================
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Закрытие модалки при клике на фон (вне контента)
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // =========================================
    // ИНИЦИАЛИЗАЦИЯ: заполняем summary при загрузке
    // =========================================
    updateSummary();

    // Устанавливаем минимальные даты для полей date (сегодняшнее число)
    const today = new Date().toISOString().split('T')[0];
    if (startDate) startDate.min = today;
    if (endDate) endDate.min = today;
});







// =========================================
// НОВЫЙ СТИЛЬНЫЙ ОПРОС (КАРТОЧКИ)
// =========================================

// Данные ответов
let answers = {
    city: null,
    travelers: null,
    budget: 30000,
    startDate: null,
    endDate: null,
    interests: []
};

let currentStep = 1;
const totalSteps = 5;

// Функция обновления сводки
function updateSurveySummary() {
    const cityName = answers.city ? getCityDisplayName(answers.city) : 'не выбран';
    document.getElementById('summary-country').textContent = cityName;
    document.getElementById('summary-travelers').textContent = answers.travelers || 'не выбрано';
    document.getElementById('summary-budget').textContent = answers.budget.toLocaleString('ru-RU');
    
    let datesText = 'не выбраны';
    if (answers.startDate && answers.endDate) {
        datesText = `${answers.startDate} — ${answers.endDate}`;
    }
    document.getElementById('summary-dates').textContent = datesText;
    
    let interestsText = answers.interests.length > 0 ? answers.interests.join(', ') : 'не выбраны';
    document.getElementById('summary-interests').textContent = interestsText;
}

// Переход на шаг
function goToStep(step) {
    document.querySelectorAll('.question-card').forEach((card, i) => {
        card.classList.toggle('active', i + 1 === step);
    });
    document.querySelectorAll('.step').forEach((s, i) => {
        s.classList.toggle('active', i + 1 === step);
    });
    document.getElementById('current-step-text').textContent = `Шаг ${step} из ${totalSteps}`;
    document.getElementById('prev-btn').disabled = step === 1;
    
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-survey-btn');
    if (step === totalSteps) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'flex';
    } else {
        nextBtn.style.display = 'flex';
        submitBtn.style.display = 'none';
    }
    currentStep = step;
}

// Функция загрузки туров (для нового опроса - без прокрутки)
function loadToursWithShow(cityId) {
    const toursGrid = document.getElementById('tours-grid');
    const toursTitle = document.getElementById('tours-title');
    const toursSubtitle = document.getElementById('tours-subtitle');
    const toursContainer = document.getElementById('toursContainer');
    
    const cityName = getCityDisplayName(cityId);
    
    toursTitle.textContent = `Популярные туры в ${cityName}`;
    toursSubtitle.textContent = `Откройте для себя лучшие маршруты по ${cityName}`;
    
    const tours = toursData[cityId] || toursData['saint-petersburg'];
    
    toursGrid.innerHTML = tours.map(tour => `
        <div class="tour-card" style="height: 100%;">
            <div class="tour-image" style="background-image: url('${tour.image}')">
                <span class="tour-badge">${tour.badge}</span>
            </div>
            <div class="tour-content">
                <h3>${tour.title}</h3>
                <div class="tour-location"><i class="bi bi-geo-alt"></i> ${tour.location}</div>
                <div class="tour-rating">
                    <div class="stars">${'★'.repeat(Math.floor(tour.rating))}${tour.rating % 1 >= 0.5 ? '½' : ''}</div>
                    <span>${tour.rating} (${tour.reviews} отзывов)</span>
                </div>
                <p class="tour-description">${tour.description}</p>
                <div class="tour-meta">
                    <div class="tour-price">${parseInt(tour.price).toLocaleString('ru-RU')} ₽ <span>за чел.</span></div>
                    <div class="tour-duration"><i class="bi bi-clock"></i> ${tour.duration} дня</div>
                </div>
                <div class="tour-actions">
                    <button class="tour-btn tour-btn-primary" onclick="showTourDetails(${tour.id})">Получить подробнее</button>
                    <button class="tour-btn tour-btn-secondary" onclick="saveTour(${tour.id})"><i class="bi bi-bookmark"></i></button>
                </div>
            </div>
        </div>
    `).join('');
    
    // Обновляем статистику
    updateTourStatsBlock(cityId);
    
    // ПОКАЗЫВАЕМ блок с турами (без прокрутки!)
    if (toursContainer) {
        toursContainer.classList.remove('hidden');
    }
}

// Инициализация нового опроса
function initNewSurvey() {
    // Обработчики выбора города
    document.querySelectorAll('.city-option').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.city-option').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
            answers.city = this.dataset.city;
            updateSurveySummary();
            loadToursWithShow(answers.city); // Теперь показывает туры
        });
    });
    
    // Обработчики выбора количества человек
    document.querySelectorAll('.travelers-option').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.travelers-option').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
            answers.travelers = this.dataset.travelers;
            updateSurveySummary();
        });
    });
    
    // Бюджет
    const budgetSlider = document.getElementById('budget-step');
    const budgetDisplay = document.getElementById('budget-value-display');
    if (budgetSlider) {
        budgetSlider.addEventListener('input', function() {
            answers.budget = parseInt(this.value);
            budgetDisplay.textContent = answers.budget.toLocaleString('ru-RU') + ' ₽';
            updateSurveySummary();
        });
    }
    
    // Пресеты бюджета
    document.querySelectorAll('.budget-preset').forEach(btn => {
        btn.addEventListener('click', function() {
            const val = parseInt(this.dataset.budget);
            if (budgetSlider) {
                budgetSlider.value = val;
                answers.budget = val;
                budgetDisplay.textContent = val.toLocaleString('ru-RU') + ' ₽';
                updateSurveySummary();
            }
        });
    });
    
    // Даты
    const startDateInput = document.getElementById('start-date-step');
    const endDateInput = document.getElementById('end-date-step');
    if (startDateInput) {
        startDateInput.addEventListener('change', function() {
            answers.startDate = this.value;
            updateSurveySummary();
        });
    }
    if (endDateInput) {
        endDateInput.addEventListener('change', function() {
            answers.endDate = this.value;
            updateSurveySummary();
        });
    }
    
    // Интересы
    document.querySelectorAll('.interest-option').forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('selected');
            const interest = this.dataset.interest;
            if (answers.interests.includes(interest)) {
                answers.interests = answers.interests.filter(i => i !== interest);
            } else {
                answers.interests.push(interest);
            }
            updateSurveySummary();
        });
    });
    
    // Кнопки навигации
    document.getElementById('next-btn')?.addEventListener('click', () => {
        if (currentStep < totalSteps) goToStep(currentStep + 1);
    });
    document.getElementById('prev-btn')?.addEventListener('click', () => {
        if (currentStep > 1) goToStep(currentStep - 1);
    });
    
    // Кнопка отправки
    document.getElementById('submit-survey-btn')?.addEventListener('click', function() {
        const cityId = answers.city || 'saint-petersburg';
        const cityName = getCityDisplayName(cityId);
        
        const surveyData = {
            cityId: cityId,
            cityName: cityName,
            travelers: answers.travelers || '1',
            budget: answers.budget,
            budgetFormatted: answers.budget.toLocaleString('ru-RU'),
            startDate: answers.startDate,
            endDate: answers.endDate,
            dates: (answers.startDate && answers.endDate) ? `${answers.startDate} — ${answers.endDate}` : 'не выбраны',
            interests: answers.interests.join(', ') || 'Достопримечательности'
        };
        
        localStorage.setItem('selected_city', JSON.stringify(surveyData));
        localStorage.setItem('selected_city_for_locals', cityId);
        
        const modalBody = document.getElementById('modal-body');
        if (modalBody) {
            modalBody.innerHTML = `
                <p><strong>Город:</strong> ${cityName}</p>
                <p><strong>Человек:</strong> ${answers.travelers || '1'}</p>
                <p><strong>Бюджет:</strong> ${answers.budget.toLocaleString('ru-RU')} ₽</p>
                <p><strong>Даты:</strong> ${surveyData.dates}</p>
                <p><strong>Интересы:</strong> ${surveyData.interests}</p>
                <p><em>Данные сохранены! Перейдите в конструктор.</em></p>
            `;
        }
        const modal = document.getElementById('myModal');
        if (modal) modal.style.display = 'flex';
    });
    
    // Кнопка сброса
    document.getElementById('reset-form')?.addEventListener('click', function() {
        // Сброс данных
        answers = {
            city: null,
            travelers: null,
            budget: 30000,
            startDate: null,
            endDate: null,
            interests: []
        };
        
        // Сброс UI
        document.querySelectorAll('.city-option, .travelers-option, .interest-option').forEach(btn => {
            btn.classList.remove('selected');
        });
        if (budgetSlider) {
            budgetSlider.value = 30000;
            budgetDisplay.textContent = '30 000 ₽';
        }
        if (startDateInput) startDateInput.value = '';
        if (endDateInput) endDateInput.value = '';
        
        updateSurveySummary();
        goToStep(1);
        
        // СКРЫВАЕМ блок с турами
        const toursContainer = document.getElementById('toursContainer');
        if (toursContainer) {
            toursContainer.classList.add('hidden');
        }
    });
    
    // Установка минимальных дат
    const today = new Date().toISOString().split('T')[0];
    if (startDateInput) startDateInput.min = today;
    if (endDateInput) endDateInput.min = today;
    
    // Инициализация
    updateSurveySummary();
    goToStep(1);
}

// Запускаем новый опрос после загрузки страницы
document.addEventListener('DOMContentLoaded', function() {
    // Проверяем, есть ли элементы нового опроса
    if (document.querySelector('.question-card')) {
        initNewSurvey();
    }
});


// Открытие модального окна (в обработчике submit-survey-btn)
document.getElementById('submit-survey-btn')?.addEventListener('click', function() {
    // ... код сохранения данных ...
    
    const modal = document.getElementById('myModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
});

// Закрытие модального окна
const closeModal = document.querySelector('.close-modal');
if (closeModal) {
    closeModal.addEventListener('click', function() {
        const modal = document.getElementById('myModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
}

// Закрытие при клике вне модального окна
window.addEventListener('click', function(event) {
    const modal = document.getElementById('myModal');
    if (event.target === modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
});
















// =========================================
// МОДАЛЬНОЕ ОКНО ТУРА + СОХРАНЕНИЕ
// =========================================

let tourModal = null;

function showTourDetails(tourId) {
    // Находим тур по ID
    const allTours = Object.values(toursData).flat();
    const tour = allTours.find(t => t.id === tourId);
    
    if (!tour) return;
    
    // Создаем модальное окно если нет
    if (!tourModal) {
        tourModal = document.createElement('div');
        tourModal.id = 'tourModal';
        tourModal.className = 'tour-modal';
        tourModal.innerHTML = '<div class="tour-modal-content"><span class="tour-modal-close">&times;</span><div class="tour-modal-body"></div></div>';
        document.body.appendChild(tourModal);
        
        tourModal.querySelector('.tour-modal-close').addEventListener('click', () => {
            tourModal.style.display = 'none';
        });
        
        tourModal.addEventListener('click', (e) => {
            if (e.target === tourModal) tourModal.style.display = 'none';
        });
    }
    
    const modalBody = tourModal.querySelector('.tour-modal-body');
    modalBody.innerHTML = `
        <div class="tour-modal-header">
            <div class="tour-modal-image" style="background-image: url('${tour.image}')"></div>
            <div class="tour-modal-info">
                <h2>${tour.title}</h2>
                <div class="tour-modal-meta">
                    <span class="tour-badge">${tour.badge}</span>
                    <span class="tour-rating"><i class="bi bi-star-fill"></i> ${tour.rating} (${tour.reviews})</span>
                </div>
            </div>
        </div>
        <div class="tour-modal-body-content">
            <div class="tour-modal-section">
                <h3><i class="bi bi-map"></i> Места программы</h3>
                <ul class="tour-places-list">${tour.places.map(p => `<li><i class="bi bi-geo-alt"></i> ${p}</li>`).join('')}</ul>
            </div>
            <div class="tour-modal-section">
                <h3><i class="bi bi-check-circle"></i> Что входит</h3>
                <ul class="tour-includes-list">${tour.includes.map(i => `<li><i class="bi bi-check-lg"></i> ${i}</li>`).join('')}</ul>
            </div>
            <div class="tour-modal-section">
                <h3><i class="bi bi-calendar-event"></i> Программа по дням</h3>
                <div class="tour-schedule">${tour.schedule.map((d, i) => `<div class="schedule-day"><strong>День ${i+1}:</strong> ${d}</div>`).join('')}</div>
            </div>
            <div class="tour-modal-stats">
                <div class="tour-stat"><i class="bi bi-clock-history"></i><div><strong>Время:</strong><span>${tour.totalTime}</span></div></div>
                <div class="tour-stat"><i class="bi bi-people"></i><div><strong>Группа:</strong><span>${tour.groupSize}</span></div></div>
                <div class="tour-stat"><i class="bi bi-pedestrian"></i><div><strong>Нагрузка:</strong><span>${tour.difficulty}</span></div></div>
                <div class="tour-stat"><i class="bi bi-cash-coin"></i><div><strong>Цена:</strong><span>${parseInt(tour.price).toLocaleString('ru-RU')} ₽</span></div></div>
            </div>
            <div class="tour-modal-actions">
                <button class="tour-modal-btn-save" onclick="saveTour(${tour.id})"><i class="bi bi-bookmark-check"></i> Сохранить тур</button>
                <button class="tour-modal-btn-close">Закрыть</button>
            </div>
        </div>
    `;
    
    tourModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    tourModal.querySelector('.tour-modal-btn-close').addEventListener('click', () => {
        tourModal.style.display = 'none';
        document.body.style.overflow = '';
    });
}

function saveTour(tourId) {
    // Проверяем авторизацию
    fetch('/api/check_auth.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                // Если не авторизован, сохраняем в localStorage
                saveTourToLocal(tourId);
                return;
            }
            
            // Если авторизован, сохраняем через API
            const allTours = Object.values(toursData).flat();
            const tour = allTours.find(t => t.id === tourId);
            if (!tour) return;
            
            fetch('/api/save_tour.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    tour_id: tour.id,
                    tour_title: tour.title,
                    tour_image: tour.image,
                    tour_price: tour.price,
                    tour_duration: tour.duration
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Также сохраняем в localStorage для резерва
                    saveTourToLocal(tourId);
                    showTourNotification('Тур сохранён в личном кабинете!');
                } else {
                    // Если API не работает, сохраняем в localStorage
                    saveTourToLocal(tourId);
                    showTourNotification('Тур сохранён (локально)');
                }
            })
            .catch(error => {
                // При ошибке сохраняем в localStorage
                saveTourToLocal(tourId);
                showTourNotification('Тур сохранён (локально)');
            });
        })
        .catch(error => {
            // Если не можем проверить авторизацию, сохраняем в localStorage
            saveTourToLocal(tourId);
            showTourNotification('Тур сохранён (локально)');
        });
}

// Сохранение тура в localStorage
function saveTourToLocal(tourId) {
    const allTours = Object.values(toursData).flat();
    const tour = allTours.find(t => t.id === tourId);
    if (!tour) return;
    
    let savedTours = JSON.parse(localStorage.getItem('saved_routes')) || [];
    
    // Проверяем, нет ли уже такого тура
    const exists = savedTours.find(t => t.id === tourId);
    if (exists) {
        showTourNotification('Тур уже сохранён!', true);
        return;
    }
    
    // Добавляем тур
    savedTours.push({
        id: tour.id,
        name: tour.title,
        image: tour.image,
        price: tour.price,
        duration: tour.duration,
        places: tour.places || [],
        date: new Date().toISOString(),
        source: 'main-page' // источник: главная страница
    });
    
    localStorage.setItem('saved_routes', JSON.stringify(savedTours));
    showTourNotification('Тур сохранён в личный кабинет!');
}

// Уведомление о сохранении
function showTourNotification(message) {
    // Удаляем старые уведомления
    const oldNotifications = document.querySelectorAll('.tour-save-notification');
    oldNotifications.forEach(n => n.remove());
    
    const notification = document.createElement('div');
    notification.className = 'tour-save-notification';
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











/**
 * JS Функции для работы с API аутентификации
 */

// Сохранение данных опроса
async function saveSurveyData(data) {
    try {
        const response = await fetch('/api/save_survey.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Ошибка сохранения опроса:', error);
        return { success: false, message: 'Ошибка сети' };
    }
}

// Сохранение маршрута
async function saveRoute(route) {
    try {
        const response = await fetch('/api/save_route.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ route: route })
        });
        
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Ошибка сохранения маршрута:', error);
        return { success: false, message: 'Ошибка сети' };
    }
}

// Проверка авторизации (через API)
async function checkAuth() {
    try {
        const response = await fetch('/api/check_auth.php');
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Ошибка проверки авторизации:', error);
        return { authenticated: false };
    }
}