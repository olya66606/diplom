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
            <a href="locals.php" id="localsLink" class="header-link">Места от жителей</a>
            <?php if (isAdmin()): ?>
                <a href="admin/dashboard.php" class="header-link header-link-admin">
                    <i class="bi bi-gear-fill"></i> Админка
                </a>
            <?php endif; ?>
            <a href="profile.php" class="header-link">
                <i class="bi bi-person-circle"></i> <?= htmlspecialchars(getCurrentUser()['name']) ?>
            </a>
        <?php else: ?>
            <a class="lihka" id="authButton" href="auth/login.php">Войти</a>
        <?php endif; ?>
    </div>
</header>

