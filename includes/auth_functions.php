<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';

function registerUser($name, $email, $password) {
    $pdo = getDbConnection();
    

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Пользователь с таким email уже существует'];
    }
 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    
    try {
        $stmt->execute([$name, $email, $hashedPassword]);
        return ['success' => true, 'message' => 'Регистрация успешна'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Ошибка при регистрации: ' . $e->getMessage()];
    }
}

function loginUser($email, $password) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if (!$user) {
        return ['success' => false, 'message' => 'Неверный email или пароль'];
    }
    
    if (!password_verify($password, $user['password'])) {
        return ['success' => false, 'message' => 'Неверный email или пароль'];
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    
    return ['success' => true, 'message' => 'Вход выполнен успешно', 'user' => [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email']
    ]];
}


function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getCurrentUser() {
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        return null;
    }
    
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if ($user) {
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        return $user;
    }
    
    return null;
}

function logoutUser() {
    if (session_status() !== PHP_SESSION_NONE) {
        $_SESSION = array();
        session_destroy();
    }
}


function isAdmin() {
    if (!isLoggedIn()) {
        return false;
    }
    
    if (!isset($_SESSION['user_role'])) {
        $user = getCurrentUser();
        if (!$user) return false;
    }
    
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}


function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /index.php');
        exit;
    }
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /auth/login.php');
        exit;
    }
}

function saveUserRoute($userId, $placeName, $placeOrder) {
    $pdo = getDbConnection();
    

    $stmt = $pdo->prepare("DELETE FROM user_routes WHERE user_id = ?");
    $stmt->execute([$userId]);

    $stmt = $pdo->prepare("INSERT INTO user_routes (user_id, place_name, place_order) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $placeName, $placeOrder]);
    
    return true;
}


function getUserRoute($userId) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("SELECT place_name, place_order FROM user_routes WHERE user_id = ? ORDER BY place_order");
    $stmt->execute([$userId]);
    
    return $stmt->fetchAll();
}


function saveUserSurvey($userId, $data) {
    $pdo = getDbConnection();
    
   
    $stmt = $pdo->prepare("DELETE FROM user_surveys WHERE user_id = ?");
    $stmt->execute([$userId]);
    
    $stmt = $pdo->prepare("INSERT INTO user_surveys (user_id, city, travelers, budget, start_date, end_date, interests) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $userId,
        $data['city'] ?? null,
        $data['travelers'] ?? null,
        $data['budget'] ?? null,
        $data['start_date'] ?? null,
        $data['end_date'] ?? null,
        json_encode($data['interests'] ?? [])
    ]);
    
    return true;
}
