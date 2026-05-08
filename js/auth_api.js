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
