<?php
require_once __DIR__ . '/auth_functions.php';
?>
<header class="header" id="mainHeader">
    <div class="header-left">
        <a href="index.php">Главная</a>
        <a href="about.php">О нас</a>
        <a href="planner.php">Конструктор маршрутов</a>
    </div>
    <div class="header-logo"><img src="img/logo.png" alt=""></div>
    <div class="header-right"> 
        <?php if (isLoggedIn()): ?>
            <a style="margin-right: 20px; margin-top:11px;" href="locals.php" id="localsLink">Места от жителей</a>
            <a style="margin-right: 20px; margin-top:11px;" href="profile.php">
                <i class="bi bi-person-circle"></i> <?= htmlspecialchars(getCurrentUser()['name']) ?>
            </a>
            <a class="lihka" href="auth/logout.php">Выйти</a>
        <?php else: ?>
            <a class="lihka" id="authButton" href="auth/login.php">Войти</a>
        <?php endif; ?>
    </div>
</header>
