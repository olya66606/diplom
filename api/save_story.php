<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../includes/auth_functions.php';

$method = $_SERVER['REQUEST_METHOD'];

// Получение историй
if ($method === 'GET') {
    $city = $_GET['city'] ?? 'saint-petersburg';
    $approved = isset($_GET['approved']) ? (int)$_GET['approved'] : 1;
    
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT * FROM user_stories WHERE city = ? AND is_approved = ? ORDER BY created_at DESC");
    $stmt->execute([$city, $approved]);
    $stories = $stmt->fetchAll();
    
    echo json_encode($stories);
    exit;
}

// Отправка истории
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $author = trim($data['author'] ?? '');
    $city = trim($data['city'] ?? '');
    $category = trim($data['category'] ?? '');
    $placeName = trim($data['placeName'] ?? '');
    $placeAddress = trim($data['placeAddress'] ?? '');
    $title = trim($data['title'] ?? '');
    $text = trim($data['text'] ?? '');
    
    if (empty($author) || empty($city) || empty($category) || empty($placeName) || empty($placeAddress) || empty($title) || empty($text)) {
        echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения']);
        exit;
    }
    
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("INSERT INTO user_stories (user_id, author, city, category, place_name, place_address, title, text) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $userId = $_SESSION['user_id'] ?? null;
    $stmt->execute([$userId, $author, $city, $category, $placeName, $placeAddress, $title, $text]);
    
    echo json_encode(['success' => true, 'message' => 'История отправлена на модерацию']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Неверный метод запроса']);
