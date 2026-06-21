<?php
require_once '../includes/auth_functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    
    // Валидация
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Все поля обязательны для заполнения';
    } elseif (!isset($_POST['agree_policy'])) {
        $error = 'Необходимо принять политику конфиденциальности';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Неверный формат email';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен быть не менее 6 символов';
    } elseif ($password !== $passwordConfirm) {
        $error = 'Пароли не совпадают';
    } else {
        $result = registerUser($name, $email, $password);
        
        if ($result['success']) {
            // Автоматический вход после регистрации
            $loginResult = loginUser($email, $password);
            if ($loginResult['success']) {
                header('Location: ../index.php');
                exit;
            }
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
    <title>Регистрация | Туры Везде</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Mulish', sans-serif;
            background:  linear-gradient(135deg, #266d59 0%, #3a8340 100%);
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
            max-width: 550px;
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
        .success-message {
            color: #28a745;
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
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 10px;
        }
        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            min-width: 20px;
            margin-top: 3px;
            accent-color: #1b5031;
            cursor: pointer;
            border-radius: 4px;
        }
        .checkbox-group label {
            margin-bottom: 0;
            font-weight: 400;
            font-size: 0.9rem;
            color: #555;
            cursor: pointer;
            line-height: 1.5;
        }
        .checkbox-group label a {
            color: #1b5031;
            text-decoration: underline;
        }
        .checkbox-group label a:hover {
            color: #2e8d53;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            animation: fadeIn 0.3s ease;
        }
        .modal-content h3 {
            color: #1b5031;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .modal-content p {
            color: #555;
            line-height: 1.7;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            background: none;
            border: none;
            transition: color 0.3s;
        }
        .modal-close:hover {
            color: #1b5031;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Регистрация</h2>
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" id="name" name="name" placeholder="Иван" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="your@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" placeholder="Минимум 6 символов" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Повторите пароль</label>
                <input type="password" id="password_confirm" name="password_confirm" placeholder="Повторите пароль" required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="agree_policy" name="agree_policy" required>
                <label for="agree_policy">Я соглашаюсь с <a href="#" onclick="document.getElementById('policyModal').classList.add('active'); return false;">политику конфиденциальности</a></label>
            </div>
            <button type="submit" class="btn">Зарегистрироваться</button>
        </form>
        <div class="auth-link">
            Уже есть аккаунт? <a href="login.php">Войти</a>
        </div>
        <div class="back-home">
            <a href="../index.php"><i class="bi bi-arrow-left"></i> На главную</a>
        </div>
    </div>

    <div id="policyModal" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
        <div class="modal-content">
            <button class="modal-close" onclick="document.getElementById('policyModal').classList.remove('active')">&times;</button>
            <h3>Политика конфиденциальности</h3>
            <p><strong>1. Сбор данных.</strong> Мы собираем имя и email, указанные при регистрации, исключительно для создания и управления учётной записью.</p>
            <p><strong>2. Использование данных.</strong> Ваши персональные данные не передаются третьим лицам и не используются для маркетинговых рассылок без вашего согласия.</p>
            <p><strong>3. Хранение данных.</strong> Мы храним ваши данные до момента удаления учётной записи. Вы можете запросить удаление данных в любой момент.</p>
            <p><strong>4. Безопасность.</strong> Мы принимаем необходимые меры для защиты ваших данных от несанкционированного доступа.</p>
            <p><strong>5. Изменения политики.</strong> Мы оставляем за собой право вносить изменения в настоящую политику с уведомлением через сайт.</p>
        </div>
    </div>

    <script>
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('policyModal').classList.remove('active');
            }
        });
    </script>
</body>
</html>
