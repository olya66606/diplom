<?php
require_once 'includes/auth_functions.php';

// Защита страницы - только для авторизованных пользователей
requireLogin();

$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <link rel="icon" href="/img/logoosn.png" type="image/x-icon" style="width: 100px;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>Личный кабинет | Туры Везде</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Mulish', sans-serif; background: linear-gradient(135deg, #bcddff54, #98dbb8a1); padding: 20px; }
        .profile-container { max-width: 800px; margin: 80px auto 20px; background: white; border-radius: 30px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        h1 { color: #1b5031; margin-bottom: 30px; border-bottom: 3px solid #e3f7ee; padding-bottom: 15px; }
        .user-info { background: #e3f7ee; padding: 20px; border-radius: 20px; margin-bottom: 30px; }
        .user-info p { font-size: 1.2rem; margin-bottom: 10px; }
        .route-section h2 { color: #333; margin-bottom: 20px; }
        .route-item { background: #f8f9fa; padding: 15px; border-radius: 12px; margin-bottom: 10px; border-left: 4px solid #2e8d53; }
        .logout-btn { background: #e74c3c; color: white; border: none; padding: 12px 25px; border-radius: 50px; font-size: 1rem; cursor: pointer; margin-top: 20px; }
        .logout-btn:hover { background: #c0392b; }
        .back-link { margin-top: 20px; display: inline-block; color: #2e8d53; text-decoration: none; }

        /* Стили для футера */
        footer {
            background-color: #ffffff;
            padding: 40px 0 20px;
            margin-top: auto;
        }

        .footer-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-b;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-top {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-section {
            display: flex;
            flex-direction: column;
        }

        .footer-logo {
            margin-bottom: 20px;
        }

        .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #273f3c;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            transition: color 0.3s;
        }
 
        .contact-list {
            width: 300px;
            text-align: center;
            margin-left: -30px;
        }

        .logo-link:hover {
            color: #273f3c;
        }

        .logo-icon {
            font-size: 2.2rem;
            margin-right: 10px;
            color: #273f3c;
        }

        .logo-text {
            font-size: 1.8rem;
        }

        .footer-description {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #273f3c;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #22352b;
            color: #273f3c;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .contact-icon {
            font-size: 1.2rem;
            color: #273f3c;
            margin-right: 12px;
            margin-top: 3px;
            width: 20px;
        }

        .contact-text {
            color: #050505;
            line-height: 1.5;
        }

        .phone-link, .address-text {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .phone-link:hover {
            color: #3498db;
        }

        .social-text {
            margin-top: 5px;
            font-size: 0.85rem;
            color: #000000;
        }

        .newsletter-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .newsletter-input {
            padding: 12px 15px;
            border: none;
            border-radius: 4px;
            background-color: #62af89a9;
            color: #ffffff;
            font-size: 1rem;
        }

        .newsletter-input::placeholder {
            color: rgb(0, 0, 0);
        }

        .newsletter-btn {
            padding: 12px 15px;
            background-color: #3a805f;
            color: #264436;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .newsletter-btn:hover {
            background-color: #4d8172;
        }

        .footer-bottom {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid #34495e;
            text-align: center;
        }

        .copyright {
            color: #000000;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .footer-link {
            color: #000000;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .header {
            padding: 0 25px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 auto;
            width: 1850px;
            background-color: white;
            transition: all 0.3s ease;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
            width: 800px;
        }

        .header a {
            color: #246d3e;
            text-decoration: none;
            font-size: 23px;
            transition: color 0.3s ease;
            font-family: "Mulish", sans-serif;
            font-weight: 500;
        }

        .header a:hover {
            color: #267946;
        }

        .header-logo>img {
            margin: 0 auto;
            height: 70px;
            width: 100px;
            display: flex;
            margin-right: 350px;
        }

        .header-right>.lihka {
            background: #00a3c400;
            color: #246d3e;
            border: 2px solid #246d3e;
            border-radius: 50px;
            font-family: "Mulish", sans-serif;
            font-weight: 500;
            border-radius: 50px;
            padding: 10px;
            font-size: 23px;
            width: 200px;
            text-align: center;
        }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="profile-container">
        <h1><i class="bi bi-person-circle"></i> Личный кабинет</h1>
        <div class="user-info">
            <p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Дата регистрации:</strong> <?= date('d.m.Y', strtotime($user['created_at'] ?? 'now')) ?></p>
        </div>
        <div class="route-section">
            <h2><i class="bi bi-signpost-split"></i> Ваш сохраненный маршрут</h2>
            <div id="userRoute">
                <p>Здесь будет отображаться ваш маршрут...</p>
            </div>
        </div>
        <button class="logout-btn" id="logoutBtn">Выйти</button>
        <br>
        <a href="index.php" class="back-link"><i class="bi bi-arrow-left"></i> На главную</a>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');

            logoutBtn.addEventListener('click', function() {
                if (confirm('Вы уверены, что хотите выйти?')) {
                    window.location.href = 'auth/logout.php';
                }
            });
        });
    </script>
</body>
</html>
