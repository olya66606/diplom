
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
                    price: '25 000',
                    duration: 3,
                    badge: 'Популярный'
                },
                {
                    id: 2,
                    title: 'Петербург - культурная столица',
                    image: 'img/dostopro.jpg',
                    location: 'Санкт-Петербург',
                    rating: 4.9,
                    reviews: 98,
                    description: 'Музеи, театры, дворцы. Русский музей, Мариинский театр, Юсуповский дворец.',
                    price: '32 000',
                    duration: 4,
                    badge: 'Хит'
                },
                {
                    id: 3,
                    title: 'Пригороды Петербурга',
                    image: 'img/petergof.webp',
                    location: 'Петергоф, Царское село',
                    rating: 4.7,
                    reviews: 156,
                    description: 'Петергоф, Царское село, Павловск. Фонтаны и дворцово-парковые ансамбли.',
                    price: '28 000',
                    duration: 2,
                    badge: 'Экскурсионный'
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
                    price: '22 000',
                    duration: 3,
                    badge: 'Исторический'
                },
                {
                    id: 5,
                    title: 'Куршская коса',
                    image: 'img/kurshskaya.jpg',
                    location: 'Куршская коса',
                    rating: 4.9,
                    reviews: 112,
                    description: 'Национальный парк, Танцующий лес, Высота Эфа, птичья станция.',
                    price: '18 000',
                    duration: 1,
                    badge: 'Природный'
                },
                {
                    id: 6,
                    title: 'Калининградские форты',
                    image: 'img/fort.jpg',
                    location: 'Калининград',
                    rating: 4.6,
                    reviews: 67,
                    description: 'Форт №11, Форт №5, Фридландские ворота, Башня Врангеля.',
                    price: '20 000',
                    duration: 2,
                    badge: 'Фортификационный'
                }
            ],

       
        };

        // Функция для получения названия города
        function getCityDisplayName(cityId) {
            const cities = {
                'saint-petersburg': 'Санкт-Петербург',
                'kaliningrad': 'Калининград',
            };
            return cities[cityId] || 'Санкт-Петербург';
        }

    // Функция загрузки туров
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
        <div class="tour-card">
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
                    <div class="tour-price">${tour.price} ₽ <span>за чел.</span></div>
                    <div class="tour-duration"><i class="bi bi-clock"></i> ${tour.duration} дня</div>
                </div>
                <div class="tour-actions">
                    <a href="planner.html?city=${cityId}" class="tour-btn tour-btn-primary">Выбрать</a>
                    <button class="tour-btn tour-btn-secondary"><i class="bi bi-bookmark"></i></button>
                </div>
            </div>
        </div>
    `).join('');
    
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

            // Проверка авторизации
            const currentUser = JSON.parse(localStorage.getItem('current_user'));
            const localsLink = document.getElementById('localsLink');
            const authButton = document.getElementById('authButton');

            if (currentUser) {
                if (localsLink) localsLink.style.display = 'inline-block';
                if (authButton) {
                    authButton.textContent = currentUser.name || 'Профиль';
                    authButton.href = 'profile.html';
                }
            } else {
                if (localsLink) localsLink.style.display = 'none';
                if (authButton) {
                    authButton.textContent = 'Войти';
                    authButton.href = 'login.html';
                }
            }

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






 // Логика для отображения кнопки "Места от жителей" и изменения кнопки входа
        document.addEventListener('DOMContentLoaded', function() {
            const currentUser = JSON.parse(localStorage.getItem('current_user'));
            const localsLink = document.getElementById('localsLink');
            const authButton = document.getElementById('authButton');

            if (currentUser) {
                // Пользователь залогинен
                if (localsLink) {
                    localsLink.style.display = 'inline-block'; // Показываем ссылку
                }
                if (authButton) {
                    authButton.textContent = currentUser.name || 'Профиль';
                    authButton.href = 'profile.html'; // Меняем ссылку на личный кабинет
                }
            } else {
                // Пользователь не залогинен
                if (localsLink) {
                    localsLink.style.display = 'none'; // Скрываем ссылку
                }
                if (authButton) {
                    authButton.textContent = 'Войти';
                    authButton.href = 'login.html';
                }
            }
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

// Функция загрузки туров (без автоматической прокрутки)
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
        <div class="tour-card">
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
                    <div class="tour-price">${tour.price} ₽ <span>за чел.</span></div>
                    <div class="tour-duration"><i class="bi bi-clock"></i> ${tour.duration} дня</div>
                </div>
                <div class="tour-actions">
                    <a href="planner.html?city=${cityId}" class="tour-btn tour-btn-primary">Выбрать</a>
                    <button class="tour-btn tour-btn-secondary"><i class="bi bi-bookmark"></i></button>
                </div>
            </div>
        </div>
    `).join('');
    
    // ПОКАЗЫВАЕМ блок с турами (без прокрутки!)
    if (toursContainer) {
        toursContainer.classList.remove('hidden');
        // scrollIntoView удален - страница не прокручивается
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
        modal.style.display = 'flex';  // ИЛИ modal.classList.add('show');
    }
});

// Закрытие модального окна
const closeModal = document.querySelector('.close-modal');
if (closeModal) {
    closeModal.addEventListener('click', function() {
        const modal = document.getElementById('myModal');
        if (modal) {
            modal.style.display = 'none';  // ИЛИ modal.classList.remove('show');
        }
    });
}

// Закрытие при клике вне модального окна
window.addEventListener('click', function(event) {
    const modal = document.getElementById('myModal');
    if (event.target === modal) {
        modal.style.display = 'none';  // ИЛИ modal.classList.remove('show');
    }
});