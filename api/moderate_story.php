<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();

$method = $_SERVER['REQUEST_METHOD'];
$pdo = getDbConnection();

try {
    if ($method === 'GET') {
        $city = $_GET['city'] ?? 'all';
        $status = $_GET['status'] ?? 'pending';
        
        $where = [];
        $params = [];
        
        if ($city !== 'all') {
            $where[] = "city = ?";
            $params[] = $city;
        }
        
        if ($status === 'pending') {
            $where[] = "is_approved = 0";
        } elseif ($status === 'approved') {
            $where[] = "is_approved = 1";
        }
        
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $stmt = $pdo->prepare("SELECT * FROM user_stories $whereSql ORDER BY created_at DESC");
        $stmt->execute($params);
        $stories = $stmt->fetchAll();
        
        echo json_encode($stories);
        exit;
    }
    
    if ($method === 'POST') {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['success' => false, 'message' => 'Неверный формат данных']);
            exit;
        }
        
        $action = $data['action'] ?? '';
        $storyId = isset($data['id']) ? (int)$data['id'] : 0;
        
        if (!$storyId) {
            echo json_encode(['success' => false, 'message' => 'ID истории не указан']);
            exit;
        }
        
        if ($action === 'approve') {
            $stmt = $pdo->prepare("UPDATE user_stories SET is_approved = 1 WHERE id = ?");
            $result = $stmt->execute([$storyId]);
            
            if ($result && $stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'История одобрена']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Не удалось найти историю для одобрения']);
            }
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM user_stories WHERE id = ?");
            $result = $stmt->execute([$storyId]);
            
            if ($result && $stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'История удалена']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Не удалось найти историю для удаления']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Неизвестное действие: ' . htmlspecialchars($action)]);
        }
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Неверный метод запроса']);
} catch (PDOException $e) {
    error_log('Moderation error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
