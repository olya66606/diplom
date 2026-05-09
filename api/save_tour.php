<?php
/**
 * API для сохранения тура в личном кабинете пользователя
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

if (!$input) {
    $response['message'] = 'Неверный формат данных';
    echo json_encode($response);
    exit;
}

$tour_id = $input['tour_id'] ?? null;
$tour_title = $input['tour_title'] ?? '';
$tour_image = $input['tour_image'] ?? '';
$tour_price = $input['tour_price'] ?? '';
$tour_duration = $input['tour_duration'] ?? '';

// Проверка обязательных полей
if (!$tour_id || empty($tour_title)) {
    $response['message'] = 'Недостаточно данных для сохранения';
    echo json_encode($response);
    exit;
}

$pdo = getDbConnection();

// Проверяем, не сохранен ли уже этот тур
$stmt = $pdo->prepare("SELECT id FROM user_saved_tours WHERE user_id = ? AND tour_id = ?");
$stmt->execute([$user_id, $tour_id]);

if ($stmt->fetch()) {
    $response['success'] = true;
    $response['message'] = 'Тур уже сохранен';
    echo json_encode($response);
    exit;
}

// Сохраняем тур
try {
    $stmt = $pdo->prepare("
        INSERT INTO user_saved_tours (user_id, tour_id, tour_title, tour_image, tour_price, tour_duration, created_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    
    $stmt->execute([$user_id, $tour_id, $tour_title, $tour_image, $tour_price, $tour_duration]);
    
    $response['success'] = true;
    $response['message'] = 'Тур успешно сохранен';
} catch (PDOException $e) {
    $response['message'] = 'Ошибка при сохранении: ' . $e->getMessage();
}

echo json_encode($response);
