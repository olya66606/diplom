<?php
require_once '../includes/auth_functions.php';

// Если пользователь уже авторизован - перенаправляем на главную
if (isLoggedIn()) {
    header('Location: ../index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Заполните все поля';
    } else {
        $result = loginUser($email, $password);
        
        if ($result['success']) {
            header('Location: ../index.php');
            exit;
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="icon" href="../img/logoosn.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>Вход | Туры Везде</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Mulish', sans-serif;
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .auth-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn { 
            from { 
            opacity: 0; 
            transform: translateY(-20px); 
        } 
            to { 
            opacity: 1;
            transform: translateY(0); 
            }
     }
        h2 {
            color: #1b5031;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2rem;
            border-bottom: 3px solid #e3f7ee;
            padding-bottom: 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 1rem;
        }
        input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e3f7ee;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: 'Mulish', sans-serif;
        }
        input:focus {
            outline: none;
            border-color: #2e8d53;
            box-shadow: 0 0 0 3px rgba(46, 141, 83, 0.2);
        }
        .btn {
            width: 100%;
            padding: 15px;
            background: #1b5031;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            font-family: 'Mulish', sans-serif;
        }
        .btn:hover {
            background: #2e8d53;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .auth-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }
        .auth-link a {
            color: #1b5031;
            text-decoration: none;
            font-weight: 600;
        }
        .auth-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #e74c3c;
            margin-top: 10px;
            text-align: center;
            font-weight: 500;
        }
        .back-home {
            text-align: center;
            margin-top: 20px;
        }
        .back-home a {
            color: #777;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Вход</h2>
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="your@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn">Войти</button>
        </form>
        <div class="auth-link">
            Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
        </div>
        <div class="back-home">
            <a href="../index.php"><i class="bi bi-arrow-left"></i> На главную</a>
        </div>
    </div>
</body>
</html>
