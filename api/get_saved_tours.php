<?php
/**
 * API для получения сохраненных туров пользователя
 */

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';

$response = ['tours' => []];

// Проверяем авторизацию
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $pdo = getDbConnection();
    
    // Получаем сохраненные туры пользователя
    $stmt = $pdo->prepare("
        SELECT * FROM user_saved_tours 
        WHERE user_id = ? 
        ORDER BY created_at DESC
    ");
    
    $stmt->execute([$user_id]);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $response['tours'] = $tours;
} catch (PDOException $e) {
    error_log('Ошибка получения сохраненных туров: ' . $e->getMessage());
}

echo json_encode($response);
