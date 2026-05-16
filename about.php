<?php
require_once 'includes/auth_functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <link rel="icon" href="img/logoosn.png" type="image/x-icon" style="width: 100px;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>О нас | Туры Везде</title>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <section class="about" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Мы помогаем путешественникам открывать мир</h2>
                    <p>Туры везде — это команда профессиональных путешественников и экспертов по маршрутам, которая уже более 10 лет помогает людям открывать мир с комфортом и удовольствием.</p>
                    
                    <div class="videlit">
                        <p>Мы верим, что идеальное путешествие начинается с правильно спланированного маршрута, учитывающего ваши интересы, бюджет и предпочтения.</p>
                    </div>
                    
                    <p>Наша миссия — сделать планирование путешествия простым и увлекательным. Мы предлагаем как готовые маршруты, проверенные тысячами туристов, так и помогаем создать полностью индивидуальный план, отражающий вашу уникальную мечту о путешествии.</p>
                    
                    <p>С нами вы сможете избежать распространенных ошибок, сэкономить время и деньги, а также открыть для себя места, которые обычно остаются за пределами стандартных туристических путеводителей.</p>

                    <a href="planner.php" class="cta-button" id="createRouteBtn">Создать свой маршрут</a>
                </div>
                
                <div class="about-image">
                    <img src="img/abiut.jpg" alt="О нас">
                </div>
            </div>
        </div>
    </section>

    <section class="cartochki" id="cartochki">
        <div class="cartochki-container">
            <h2>Почему выбирают нас</h2>
            
            <div class="cartochki-grid">
                <div class="cartochki-card">
                    <div class="cartochki-icon">
                       <img src="img/aboutloc.jpg" alt="">
                    </div>
                    <h3 style="color: #1b5031;">Индивидуальные маршруты</h3>
                    <p>Мы создаем маршруты с учетом ваших интересов, бюджета и предпочтений. Каждое путешествие уникально, как и вы.</p>
                </div>

                <div class="cartochki-card">
                    <div class="cartochki-icon">
                        <img src="img/abouttime.jpg" alt="">
                    </div>
                    <h3 style="color: #1b5031;">Поддержка 24/7</h3>
                    <p>Наша команда поддержки доступна круглосуточно на протяжении всего вашего путешествия для решения любых вопросов.</p>
                </div>

                <div class="cartochki-card">
                    <div class="cartochki-icon">
                         <img src="img/aboutprice.jpg" alt="">
                    </div>
                    <h3 style="color: #1b5031;">Лучшие цены</h3>
                    <p>Мы сотрудничаем напрямую с поставщиками услуг, что позволяет нам предлагать выгодные цены без скрытых комиссий.</p>
                </div>

                <div class="cartochki-card">
                    <div class="cartochki-icon">
                        <img src="img/aboutgid.jpg" alt="">
                    </div>
                    <h3 style="color: #1b5031;">Локальные эксперты</h3>
                    <p>Наши гиды и эксперты — местные жители, которые знают все секреты и скрытые жемчужины каждого направления.</p>
                </div>
                
                <div class="cartochki-card">
                    <div class="cartochki-icon">
                       <img src="img/aboutbez.jpg" alt="">
                    </div>
                    <h3 style="color: #1b5031;">Безопасность и надежность</h3>
                    <p>Мы тщательно проверяем всех партнеров и обеспечиваем безопасность каждого аспекта вашего путешествия.</p>
                </div>

                <div class="cartochki-card">
                    <div class="cartochki-icon">
                     <img src="img/aboutdysha.jpg" alt="">
                    </div>
                    <h3 style="color: #1b5031;">Путешествия с душой</h3>
                    <p>Мы вкладываем душу в каждый маршрут, потому что сами являемся страстными путешественниками и любим свое дело.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>

<style>

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 150px 20px;
    }

    .cartochki-container >h2 {
        font-size: 2.0rem;
        margin-bottom: 20px;
        color: #1b5031;
        margin-top: 100px;
    }

    p {
        font-size: 1.1rem;
        margin-bottom: 15px;
        color: #555;
    }

    .about {
        background-color: #fff;
    }

    .about-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }


    .videlit {
        background-color: #e3f7ee;
        padding: 15px;
        border-left: 4px solid #aff5cf;
        margin: 25px 0;
    }

    .videlit p {
        margin-bottom: 0;
        font-style: italic;
    }

    .about-image {
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .about-image:hover {
        transform: translateY(-5px);
    }


    .about-image img {
        width: 100%;
        height: auto;
        display: block;
    }




    .cartochki{
        display: flex;
        width: 100%;
        margin: 0 auto;
        justify-content: center;
        margin-bottom: 100px;
    }

    .cartochki h2 {
        text-align: center;
        margin-bottom: 50px;
    }

    .cartochki h2::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .cartochki-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .cartochki-card {
        background-color: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .cartochki-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .cartochki-icon>img  {
        width: 80px;
        height: 80px;
        background-color: #e6f4f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        color: #1a5f7a;
        font-size: 2rem;
    }

    .cartochki-card h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #1a5f7a;
    }

    .cartochki-card p {
        color: #666;
    }

    .cta-button {
        display: inline-block;
        background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
        color: white;
        padding: 12px 30px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        margin-top: 20px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .cta-button:hover {
        background:  linear-gradient(135deg, #266d59 0%, #399741 100%);
        transform: scale(1.05);
    }

    </style>