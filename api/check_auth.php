<?php
/**
 * API для проверки авторизации
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/auth_functions.php';

if (isLoggedIn()) {
    echo json_encode([
        'authenticated' => true,
        'user' => getCurrentUser()
    ]);
} else {
    echo json_encode(['authenticated' => false]);
}
