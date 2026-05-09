<?php
/**
 * API для удаления сохраненного тура
 */

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';

$response = ['success' => false, 'message' => ''];

// Проверяем авторизацию
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    $response['message'] = 'Пользователь не авторизован';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];

// Получаем данные из запроса
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !$input['tour_id']) {
    $response['message'] = 'Недостаточно данных';
    echo json_encode($response);
    exit;
}

$tour_id = $input['tour_id'];

try {
    $pdo = getDbConnection();
    
    // Проверяем, принадлежит ли тур пользователю (ищем по tour_id, а не по id записи)
    $stmt = $pdo->prepare("
        SELECT id FROM user_saved_tours 
        WHERE tour_id = ? AND user_id = ?
    ");
    
    $stmt->execute([$tour_id, $user_id]);
    
    if (!$stmt->fetch()) {
        $response['message'] = 'Тур не найден в сохраненных';
        echo json_encode($response);
        exit;
    }
    
    // Удаляем тур по tour_id
    $stmt = $pdo->prepare("
        DELETE FROM user_saved_tours 
        WHERE tour_id = ? AND user_id = ?
    ");
    
    $stmt->execute([$tour_id, $user_id]);
    
    $response['success'] = true;
    $response['message'] = 'Тур успешно удален';
} catch (PDOException $e) {
    $response['message'] = 'Ошибка при удалении: ' . $e->getMessage();
}

echo json_encode($response);
