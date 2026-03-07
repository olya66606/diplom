/**
 * JavaScript для интерактивного блока планирования путешествия
 */

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