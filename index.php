<?php
require_once 'includes/auth_functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <link rel="icon" href="img/logoosn.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>Помощник для вас : Туры по городам и странам</title>
</head>
<body>

    <?php include 'includes/header.php'; ?>
    
    <section class="banner">
        <div class="banner-left">
            <p style="color: rgb(0, 0, 0); width:500px;">Путешествуй и открывай мир и <b style="color: #30794c;">Себя</b> в нём</p>
            <p style="color: rgb(0, 0, 0); font-size: 25px; width: 500px;">Пройди опрос и подбери для себя наиболее удобный маршрут, если созданный маршрут не удовлетворяет можно создать свой личный</p>
            <a href="#surveyBlock" style="color: #1c5633;" class="oprosbtn">Пройти опрос <i class="bi bi-arrow-up-right"></i></a>
        </div>
        <div class="banner-right">
            <img class="foto1" src="img/yaponia.jpg" alt="">
            <img class="foto2" src="img/piter.jpg" alt="">
            <img class="foto3" src="img/kaliningrad.jpg" alt="">
        </div>
    </section>

    <?php include 'includes/main-content.php'; ?>
    <?php include 'includes/footer.php'; ?>

  <script src="script.js"></script>
</body>
</html>
