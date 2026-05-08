<?php
/**
 * API для сохранения маршрута пользователя
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

if (!$input || !isset($input['route']) || !is_array($input['route'])) {
    echo json_encode(['success' => false, 'message' => 'Некорректные данные маршрута']);
    exit;
}

$user = getCurrentUser();
$pdo = getDbConnection();

try {
    // Удаляем старый маршрут
    $stmt = $pdo->prepare("DELETE FROM user_routes WHERE user_id = ?");
    $stmt->execute([$user['id']]);
    
    // Сохраняем новый маршрут
    $stmt = $pdo->prepare("INSERT INTO user_routes (user_id, place_name, place_order) VALUES (?, ?, ?)");
    
    foreach ($input['route'] as $index => $place) {
        $stmt->execute([$user['id'], $place['name'] ?? $place, $index + 1]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Маршрут сохранен']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка: ' . $e->getMessage()]);
}
