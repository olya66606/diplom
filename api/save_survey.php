<?php
/**
 * API для сохранения данных опроса
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/auth_functions.php';

// Проверяем авторизацию
if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Разрешен только POST метод']);
    exit;
}

// Получаем данные
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Некорректные данные']);
    exit;
}

$user = getCurrentUser();

try {
    saveUserSurvey($user['id'], $input);
    echo json_encode(['success' => true, 'message' => 'Данные опроса сохранены']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка: ' . $e->getMessage()]);
}
