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
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Истории местных | Туры Везде</title>
    <style> 
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        body { 
            font-family: 'Mulish', sans-serif; 
            background: linear-gradient(135deg, #bcddff54, #98dbb8a1);  
        }

        .banner {
            background: url(img/fonbaner.jpg);
            background-size: cover;
            background-position: center;
            width: 100%; min-height: 320px; 
            display: flex; align-items: center; justify-content: center;
            text-align: center;
        }
        
        .foto4{
            width: 500px;
            height: 500px;
            border-radius: 50px;
            margin: -13px -28px 100px 50px;
        }
        .foto5{
            width: 500px;
            height: 300px;
            border-radius: 50px;
            margin: 35px -400px 500px 100px;
        }
        .foto6{
            width: 500px;
            height: 300px;
            border-radius: 50px;
            margin: 500px 10px 100px 101px;
        }

        .banner-content { 
            max-width: 800px; 
            color:black; 
            margin-left:100px;
        }
        .banner h1 { 
            font-size: 2.8rem; 
            margin-bottom: 16px; 
            font-weight: 800; 
        }
        .banner p { 
            font-size: 1.15rem; 
            opacity: 0.95; 
            margin-bottom: 28px; 
            line-height: 1.6; 
        }
        .banner-stats { 
            display: flex; 
            gap: 70px; 
            justify-content: center; 
            flex-wrap: wrap; 
        }
        .banner-stat { 
            background: rgba(255,255,255,0.15); 
            backdrop-filter: blur(10px); 
            padding: 12px 28px; 
            border-radius: 50px; 
            font-weight: 600; 
            border: 1px solid rgba(255,255,255,0.25); 
        }

        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 0 20px; 
        }

        .section { 
            margin: 50px 0; 
        }
        .section-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 28px; flex-wrap: 
            wrap; gap: 15px; 
        }
        .section-header h2 { 
            color: #1b5031; 
            font-size: 1.8rem; 
            font-weight: 700; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }

   

        .carousel-nav { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 20px; 
            margin-bottom: 20px; 
        }
        .carousel-btn { 
            width: 45px; 
            height: 45px; 
            border-radius: 50%; 
            border: 2px solid #e8ecf1; 
            background: white;
            color: #2e8d53; 
            font-size: 1.3rem; 
            cursor: pointer;
            transition: all 0.3s; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .carousel-btn:hover { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            border-color: transparent; 
            color: white; 
        }
        .carousel-btn:disabled { 
            opacity: 0.3; 
            cursor: not-allowed; 
            transform: none; 
        }
        .carousel-counter { 
            font-size: 1.1rem; 
            font-weight: 700; 
            color: #2e8d53; 
        }
        .carousel-wrapper { 
            overflow: hidden; 
            padding: 10px 0; 
        }
        .carousel-track { 
            display: flex; 
            gap: 20px; 
            transition: transform 0.4s ease; 
        }

        .story-card { 
            flex: 0 0 380px; 
            background: white; 
            border-radius: 24px; 
            padding: 28px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            transition: all 0.3s; 
            border: 2px solid transparent; 
            display: flex; 
            flex-direction: column; 
        }
        .story-card:hover { 
            transform: translateY(-6px); 
            box-shadow: 0 16px 40px rgba(0,0,0,0.1); 
            border-color: #d4f0e4; 
        }

        .story-header { 
            display: flex; 
            align-items: center; 
            gap: 14px; 
            margin-bottom: 18px; 
        }
        .story-avatar { 
            width: 52px; height: 52px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-size: 1.4rem; 
            font-weight: 800; 
            color: white; 
            lex-shrink: 0; 
        }
        .story-meta { 
            flex: 1; 
        }
        .story-author { 
            font-weight: 700; 
            color: #1b5031; 
            font-size: 1rem; 
        }
        .story-city-date { 
            font-size: 0.8rem; 
            color: #888; 
            margin-top: 2px; 
        }
        .story-category-badge { 
            padding: 5px 14px; 
            border-radius: 20px; 
            font-size: 0.75rem; 
            font-weight: 700;
            background: #f0fff4; 
            color: #2e8d53; 
            border: 1px solid #d4f0e4; 
        }

        .story-title { 
            font-size: 1.25rem; 
            color: #1b5031; 
            font-weight: 800; 
            margin-bottom: 10px; 
            line-height: 1.3; 
        }
        .story-text { 
            color: #555; 
            font-size: 0.92rem; 
            line-height: 1.7; 
            margin-bottom: 18px; 
            flex: 1; 
        }

        .story-place { 
            background: linear-gradient(135deg, #f8f9fc 0%, #e8ecf1 100%); 
            padding: 14px 18px; 
            border-radius: 16px; 
            margin-bottom: 18px; 
        }
        .story-place-name { 
            font-weight: 700; 
            color: #1b5031; 
            font-size: 0.95rem; 
            margin-bottom: 4px; 
            display: flex; 
            align-items: center; 
            gap: 8px; 
        }
    
        .story-place-address { 
        font-size: 0.82rem; 
        color: #666; 
    }

        .story-actions { 
            display: flex; 
            gap: 10px; 
            padding-top: 16px; 
            border-top: 1px solid #f0f2f5; 
        }
        .story-btn { 
            flex: 1; 
            padding: 10px; 
            border-radius: 14px; 
            border: none; 
            cursor: pointer; 
            font-weight: 600;
            font-family: 'Mulish', sans-serif; 
            transition: all 0.3s; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 6px; 
            font-size: 0.85rem; 
        }
        .btn-like { 
            background: #fff5f5; 
            color: #ff6b6b; 
            border: 2px solid #ffe0e0; 
        }
        .btn-like:hover, .btn-like.liked { 
            background: #ff6b6b; 
            color: white; 
            border-color: transparent; 
        }
        .btn-save { 
            background: #f0fff4; 
            color: #2e8d53; 
            border: 2px solid #d4f0e4; 
        }
        .btn-save:hover { b
        ackground: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
        color: white; 
        border-color: transparent; 
    }

        .bloggers-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
            gap: 24px; 
        }
        .blogger-card { 
            background: white; 
            border-radius: 24px; 
            padding: 28px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            transition: all 0.3s; 
            border: 2px solid transparent; 
        }
        .blogger-card:hover { 
            transform: translateY(-6px); 
            box-shadow: 0 16px 40px rgba(0,0,0,0.1); 
            border-color: #d4f0e4; 
        }

        .blogger-header { 
            display: flex; 
            align-items: center; 
            gap: 16px; 
            margin-bottom: 20px; 
        }
        .blogger-avatar { 
            width: 64px; 
            height: 64px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-size: 1.6rem; 
            font-weight: 800; 
            color: white; 
            flex-shrink: 0; 
        }
        .blogger-info { 
            flex: 1; 
        }
        .blogger-name { 
            font-weight: 800; 
            color: #1b5031; 
            font-size: 1.15rem; 
        }
        .blogger-role { 
            font-size: 0.85rem; 
            color: #2e8d53; 
            font-weight: 600; 
            margin-top: 2px; 
        }

        .blogger-title { 
            font-size: 1.1rem; 
            color: #1b5031; 
            font-weight: 700; 
            margin-bottom: 14px; 
        }
        .blogger-places { 
            display: flex; 
            flex-direction: 
            column; 
            gap: 10px; }
        .blogger-place { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 12px 14px; 
            background: #f8f9fc; 
            border-radius: 14px; 
            transition: all 0.3s; 
        }
        .blogger-place:hover { 
            background: #f0fff4; 
        }
        .blogger-place-num { 
            width: 32px; 
            height: 32px; 
            border-radius: 50%;
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%);
            color: white; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: 800; 
            font-size: 0.85rem; 
            flex-shrink: 0; 
        }
        .blogger-place-info { 
            flex: 1; 
        }
        .blogger-place-name { 
            font-weight: 700; 
            color: #1b5031; 
            font-size: 0.92rem; 
        }
        .blogger-place-desc { 
            font-size: 0.8rem; 
            color: #888; 
            margin-top: 2px; 
        }
        .blogger-place-save { 
            width: 36px; height: 36px;
            border-radius: 50%; 
            border: 2px solid #d4f0e4; 
            background: white;
            color: #2e8d53; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            transition: all 0.3s; 
            flex-shrink: 0; 
        }
        .blogger-place-save:hover { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
            border-color: transparent; 
        }

    
        .form-section { 
            background: white; 
            border-radius: 24px; 
            padding: 40px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.06); 
            margin-bottom: 60px; 
        }
        .form-section h2 { 
            color: #1b5031; 
            font-size: 1.6rem; 
            font-weight: 700; 
            margin-bottom: 8px; 
            text-align: center; 
        }
        .form-section > p { 
            text-align: center; 
            color: #666; 
            margin-bottom: 30px; 
            font-size: 0.95rem; 
        }
        .form-grid { 
            display: grid; 
            grid-template-columns: 1fr 1fr;
            gap: 20px; 
            }
        .form-group { 
            margin-bottom: 20px; 
        }
        .form-group label { 
            display: block; 
            font-weight: 600; 
            color: #333; 
            margin-bottom: 8px; 
            font-size: 0.9rem; 
        }
        .form-control { 
            width: 100%; 
            padding: 14px 18px; 
            border: 2px solid #e8ecf1; 
            border-radius: 16px; 
            font-size: 1rem;
            font-family: 'Mulish', sans-serif; 
            background: white; 
            transition: all 0.3s; 
        }

    
        .submit-btn { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
            border: none; 
            padding: 16px 30px;
            border-radius: 50px; 
            font-size: 1.05rem; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 10px; 
            font-family: 'Mulish', sans-serif; 
            margin-top: 10px; 
        }

        .toast-notification { 
            position: fixed; 
            bottom: 30px; right: 30px;
             background: #2e8d53; 
            color: white;
            padding: 14px 24px; 
            border-radius: 50px; 
            font-weight: 500; 
            z-index: 2000;
            animation: slideInRight 0.3s ease; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.2); 
        }
        @keyframes slideInRight { 
            from { 
                transform: translateX(100%); 
                opacity: 0; } 
                to { 
                    transform: translateX(0); 
                    opacity: 1; 
                } 
            }

        .empty-state { 
            text-align: center; 
            padding: 60px 20px; 
            background: white; 
            border-radius: 24px; 
        }
        .empty-state i { 
            font-size: 3.5rem; 
            color: #2e8d53; 
            margin-bottom: 20px; 
        }
        .empty-state h3 { 
            ont-size: 1.5rem; 
            color: #1b5031; 
            margin-bottom: 10px; 
        }
        .empty-state p { 
            color: #666; 
        }

        @media (max-width: 768px) {
            .banner h1 { 
                font-size: 2rem; 
            }
            .section-header h2 { 
                font-size: 1.4rem; 
            }
            .story-card { 
                flex: 0 0 300px; 
                padding: 20px; 
            }
            .form-section { 
                padding: 24px; 
            }
            .carousel-nav { 
                gap: 12px; 
            }

            .bloggers-grid { 
                grid-template-columns: 1fr; 
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="banner">
        <img class="foto4" src="img/tokio.webp" alt="">
           
            
        <div class="banner-content">
            <h1>📖 Истории местных</h1>
            <p>Не гидбуки, а настоящие истории от людей, которые живут в этом городе. Где пить кофе, гулять ночью и находить себя.</p>
            <div class="banner-stats">
                <div class="banner-stat"><i class="bi bi-people-fill"></i> <span id="authorsCount">12</span> авторов</div>
                <div class="banner-stat"><i class="bi bi-journal-text"></i> <span id="storiesCount">48</span> историй</div>
            </div>
        </div>
        <img class="foto5" src="img/sever.webp" alt="">
         <img class="foto6" src="img/osaka.jpg" alt="">
    </section>

    <div class="container">
        <!-- Подборки от блогеров -->
        <section class="section">
            <div class="section-header">
                <h2><i class="bi bi-stars"></i> Места от жителей</h2>
            </div>
            <div class="bloggers-grid" id="bloggersGrid"></div>
        </section>

        <!-- Форма -->
        <section class="section">
            <div class="form-section">
                <h2><i class="bi bi-pen-fill"></i> Поделись своей историей</h2>
                <p>Расскажи о любимом месте в твоём городе. Почему оно особенное?</p>
                <form id="storyForm">
                    <p style="text-align: center; color: #2e8d53; font-weight: 600; margin-bottom: 20px;">
                        <i class="bi bi-geo-alt-fill"></i> Твоя история будет опубликована для <span id="formCityName">Санкт-Петербурга</span>
                    </p>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Твоё имя</label>
                            <input type="text" class="form-control" id="authorName" placeholder="Например, Аня" required>
                        </div>
                        <div class="form-group">
                            <label>Категория</label>
                            <select class="form-control form-select" id="storyCategory" required>
                                <option value="">Выбери категорию</option>
                                <option value="coffee">Кофе и завтраки</option>
                                <option value="walk">Прогулки</option>
                                <option value="secret">Секретные места</option>
                                <option value="romantic">Романтика</option>
                                <option value="food">Еда</option>
                                <option value="view">Виды</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Название места</label>
                            <input type="text" class="form-control" id="placeName" placeholder="Например, кофейня Дабл Би" required>
                        </div>
                        <div class="form-group">
                            <label>Адрес</label>
                            <input type="text" class="form-control" id="placeAddress" placeholder="Например, Невский проспект, 10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Заголовок истории</label>
                        <input type="text" class="form-control" id="storyTitle" placeholder="Например, Где я пью лучший капучино" required>
                    </div>
                    <div class="form-group">
                        <label>История</label>
                        <textarea class="form-control" id="storyText" placeholder="Расскажи, почему это место тебе дорого. Что здесь особенного? Когда лучше приходить?" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn"><i class="bi bi-send-fill"></i> Опубликовать историю</button>
                </form>
            </div>
        </section>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
       
        const categoryConfig = {
            coffee:  { icon: 'bi-cup-hot', label: 'Кофе', color: '#8B4513', bg: '#fdf5ef' },
            walk:    { icon: 'bi-person-walking', label: 'Прогулки', color: '#2e8d53', bg: '#f0fff4' },
            secret:  { icon: 'bi-key', label: 'Секретное', color: '#9b59b6', bg: '#f9f0ff' },
            romantic:{ icon: 'bi-heart', label: 'Романтика', color: '#e91e63', bg: '#fff0f5' },
            food:    { icon: 'bi-shop', label: 'Еда', color: '#e67e22', bg: '#fff8f0' },
            view:    { icon: 'bi-sunset', label: 'Виды', color: '#3498db', bg: '#f0f8ff' }
        };

        const avatarColors = ['#2e8d53', '#e67e22', '#9b59b6', '#e91e63', '#3498db', '#16a085', '#d35400'];

        let stories = JSON.parse(localStorage.getItem('locals_stories')) || [];
        let likedStories = JSON.parse(localStorage.getItem('liked_stories')) || {};
        let carouselIndex = 0;

        // Определяем выбранный город
        const savedData = JSON.parse(localStorage.getItem('selected_city'));
        const currentCityId = savedData?.cityId || 'saint-petersburg';
        const cityNames = {
            'saint-petersburg': 'Санкт-Петербург',
            'kaliningrad': 'Калининград',
            'moscow': 'Москва',
            'sochi': 'Сочи'
        };
        const currentCityName = cityNames[currentCityId] || 'Санкт-Петербург';

        // Фильтруем истории по городу
        function getCityStories() {
            return stories.filter(s => s.city === currentCityId);
        }


        const bloggersData = [
            {
                id: 'anna-spb', name: 'Анна Петрова', city: 'saint-petersburg', cityName: 'Санкт-Петербург',
                role: 'Гид по Питеру · 5 лет в городе', avatarColor: '#e91e63',
                socials: {},
                title: 'Топ-5 мест для вдохновения',
                places: [
                    { name: 'Эрмитаж', desc: 'Лучшее время — четверг утром, без очередей' },
                    { name: 'Петропавловская крепость', desc: 'Закат здесь волшебный' },
                    { name: 'Новая Голландия', desc: 'Современное искусство и кофе' },
                    { name: 'Кунсткамера', desc: 'Самая необычная коллекция города' },
                    { name: 'Смежный мост', desc: 'Мой секретный вид на Неву' }
                ]
            },
            {
                id: 'dima-spb', name: 'Дмитрий Козлов', city: 'saint-petersburg', cityName: 'Санкт-Петербург',
                role: 'Фотограф · Знаю каждый двор', avatarColor: '#3498db',
                socials: {},
                title: '5 фотолокаций, о которых мало кто знает',
                places: [
                    { name: 'Двор-колодец на Рубинштейна', desc: 'Идеальная симметрия' },
                    { name: 'Крыша Галереи', desc: 'Панорама всего центра' },
                    { name: 'Мало-Калинкин мост', desc: 'Отражения в воде' },
                    { name: 'Парадная на Васильевском', desc: 'Винтажный интерьер' },
                    { name: 'Заброшенная фабрика', desc: 'Индустриальная эстетика' }
                ]
            },
            {
                id: 'masha-spb', name: 'Мария Лебедева', city: 'saint-petersburg', cityName: 'Санкт-Петербург',
                role: 'Архитектор · Обожаю старину', avatarColor: '#9b59b6',
                socials: {},
                title: 'Тайны старых доходных домов',
                places: [
                    { name: 'Дом Бака на Вознесенском', desc: 'Готика в центре Питера' },
                    { name: 'Доходный дом Лидваль', desc: 'Северный модерн' },
                    { name: 'Дом со львами', desc: 'Скульптуры на фасаде' },
                    { name: 'Дворец Белосельских-Белозерских', desc: 'Малоизвестный дворец' },
                    { name: 'Дом компании Зингер', desc: 'Не только книжный магазин' }
                ]
            },
            {
                id: 'oleg-spb', name: 'Олег Смирнов', city: 'saint-petersburg', cityName: 'Санкт-Петербург',
                role: 'Бариста · Ищу лучший кофе', avatarColor: '#e67e22',
                socials: {},
                title: '5 кофеен, где варят с душой',
                places: [
                    { name: '«Дабл Би» на Рубинштейна', desc: 'Обжарка на месте' },
                    { name: '«Север» на Грибоедова', desc: 'Молочные альтернативы' },
                    { name: '«Птичка» на Восстания', desc: 'Уютный дворик' },
                    { name: '«ДоМо» на Лиговском', desc: 'Рисовый латте' },
                    { name: '«Кофе и книги»', desc: 'Тихое место для чтения' }
                ]
            },
            {
                id: 'sveta-spb', name: 'Светлана Иванова', city: 'saint-petersburg', cityName: 'Санкт-Петербург',
                role: 'Ночная сова · Знаю тайные бары', avatarColor: '#9b59b6',
                socials: {},
                title: '5 мест для вечерних прогулок',
                places: [
                    { name: 'Бар «Кабинет»', desc: 'Тайный вход через книжный' },
                    { name: 'Крыша на Лиговском', desc: 'Вид на огни ночного города' },
                    { name: 'Набережная Фонтанки', desc: 'Фонари и отражения в воде' },
                    { name: 'Дворец Танцев', desc: 'Джаз по четвергам' },
                    { name: 'Лофт «Этажи»', desc: 'Молодёжная атмосфера' }
                ]
            },
            {
                id: 'igor-spb', name: 'Игорь Волков', city: 'saint-petersburg', cityName: 'Санкт-Петербург',
                role: 'Велогид · Возлю по крышам', avatarColor: '#16a085',
                socials: {},
                title: '5 лучших смотровых площадок',
                places: [
                    { name: 'Колоннада Исаакия', desc: 'Классика, но стоит того' },
                    { name: 'Мансарда на Невском', desc: '360 градусов центра' },
                    { name: 'Стрелка Васильевского', desc: 'Бесплатно и красиво' },
                    { name: 'Лахта Центр', desc: 'Современный вид на залив' },
                    { name: 'Новая Голландия', desc: 'Крыша с видом на канал' }
                ]
            },
            {
                id: 'katya-kgd', name: 'Екатерина Волкова', city: 'kaliningrad', cityName: 'Калининград',
                role: 'Блогер · Люблю свой город', avatarColor: '#e91e63',
                socials: {},
                title: 'Калининград глазами местной',
                places: [
                    { name: 'Куршская коса', desc: 'Топ-1 для меня — природа балтики' },
                    { name: 'Форт №5', desc: 'История, которая трогает' },
                    { name: 'Рыбная деревня', desc: 'Атмосфера старого Кёнигсберга' },
                    { name: 'Музей янтаря', desc: 'Гордость региона' },
                    { name: 'Озеро Верхнее', desc: 'Лучшие закаты в городе' }
                ]
            },
            {
                id: 'sergey-kgd', name: 'Сергей Панов', city: 'kaliningrad', cityName: 'Калининград',
                role: 'Рыбак и гурман', avatarColor: '#2e8d53',
                socials: {},
                title: 'Где поесть настоящую балтийку',
                places: [
                    { name: 'Рыбный рынок на Октябрьской', desc: 'Свежайшая рыба с утра' },
                    { name: 'Кафе «Балтика»', desc: 'Лучший уха в городе' },
                    { name: 'Закусочная у моста', desc: 'Копчёный лосось — бомба' },
                    { name: 'Ресторан на набережной', desc: 'Вид + креветки' },
                    { name: 'Домашняя кухня бабы Нины', desc: 'Секретное место местных' }
                ]
            },
            {
                id: 'lena-kgd', name: 'Елена Кравцова', city: 'kaliningrad', cityName: 'Калининград',
                role: 'Историк · Знаю каждый камень', avatarColor: '#3498db',
                socials: {},
                title: '5 исторических мест, о которых не пишут путеводители',
                places: [
                    { name: 'Бранденбургские ворота', desc: 'Малоизвестные, но красивые' },
                    { name: 'Дом советов', desc: 'История недостроя' },
                    { name: 'Фридландские ворота', desc: 'Музей внутри' },
                    { name: 'Руины кирхи', desc: 'Атмосфера старой Пруссии' },
                    { name: 'Парк победы', desc: 'Тихое место для размышлений' }
                ]
            },
            {
                id: 'anton-kgd', name: 'Антон Морозов', city: 'kaliningrad', cityName: 'Калининград',
                role: 'Велосипедист · Исследую окрестности', avatarColor: '#16a085',
                socials: {},
                title: '5 маршрутов для вело-прогулок',
                places: [
                    { name: 'Вдоль Преголи', desc: 'Ровная дорога и виды' },
                    { name: 'Куршская коса', desc: 'Лес и море рядом' },
                    { name: 'Светлогорск', desc: 'Холмы и канатная дорога' },
                    { name: 'Зеленоградск', desc: 'Набережная и коты' },
                    { name: 'Янтарный', desc: 'Пляж и карьер' }
                ]
            },
            {
                id: 'nina-kgd', name: 'Нина Соколова', city: 'kaliningrad', cityName: 'Калининград',
                role: 'Морячка · Люблю Балтику', avatarColor: '#e74c3c',
                socials: {},
                title: '5 лучших пляжей области',
                places: [
                    { name: 'Пляж в Янтарном', desc: 'Белый песок и чистейшая вода' },
                    { name: 'Светлогорск', desc: 'Пляж с пирсом и променад' },
                    { name: 'Зеленоградск', desc: 'Пляж с видом на мол' },
                    { name: 'Балтийская коса', desc: 'Дикий пляж без толп' },
                    { name: 'Пионерский', desc: 'Спокойное море для детей' }
                ]
            },
            {
                id: 'maxim-kgd', name: 'Максим Лебедев', city: 'kaliningrad', cityName: 'Калининград',
                role: 'Охотник за закатами · Фотограф', avatarColor: '#f39c12',
                socials: {},
                title: '5 мест для идеального заката',
                places: [
                    { name: 'Маяк в Балтийске', desc: 'Последний луч над морем' },
                    { name: 'Озеро Верхнее', desc: 'Отражение в воде' },
                    { name: 'Куршская коса', desc: 'Закат над дюнами' },
                    { name: 'Набережная у Рыбной деревни', desc: 'Городской закат с бокалом' },
                    { name: 'Пирс в Светлогорске', desc: 'Романтика у моря' }
                ]
            }
        ];

        function renderBloggers() {
            const grid = document.getElementById('bloggersGrid');
            const cityBloggers = bloggersData.filter(b => b.city === currentCityId);

            if (cityBloggers.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <i class="bi bi-stars"></i>
                        <h3>Пока нет подборок от блогеров</h3>
                        <p>Скоро добавим!</p>
                    </div>`;
                return;
            }

            grid.innerHTML = cityBloggers.map(blogger => `
                <div class="blogger-card">
                    <div class="blogger-header">
                        <div class="blogger-avatar" style="background: ${blogger.avatarColor};">${blogger.name.charAt(0)}</div>
                        <div class="blogger-info">
                            <div class="blogger-name">${blogger.name}</div>
                            <div class="blogger-role">${blogger.role}</div>
                        </div>
                    </div>
                    <div class="blogger-title">${blogger.title}</div>
                    <div class="blogger-places">
                        ${blogger.places.map((place, i) => `
                            <div class="blogger-place">
                                <div class="blogger-place-num">${i + 1}</div>
                                <div class="blogger-place-info">
                                    <div class="blogger-place-name">${place.name}</div>
                                    <div class="blogger-place-desc">${place.desc}</div>
                                </div>
                                <button class="blogger-place-save" onclick="saveBloggerPlace('${place.name}', '${place.desc}', '${blogger.city}')" title="В маршрут">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `).join('');
        }

        window.saveBloggerPlace = function(name, desc, city) {
            let savedPlaces = JSON.parse(localStorage.getItem('selected_places')) || [];
            const placeId = 'blogger_' + name.replace(/\s+/g, '_').toLowerCase();
            if (!savedPlaces.find(p => p.id === placeId)) {
                savedPlaces.push({
                    id: placeId,
                    name: name,
                    location: cityNames[city] || city,
                    coords: [0, 0],
                    rating: 5,
                    reviews: 0,
                    description: desc,
                    category: 'attractions'
                });
                localStorage.setItem('selected_places', JSON.stringify(savedPlaces));
                showNotification('✓ Добавлено в маршрут');
            } else {
                showNotification('Уже в маршруте', true);
            }
        };

        // ====== РЕНДЕР ИСТОРИЙ ======
        function renderStories() {
            stories = JSON.parse(localStorage.getItem('locals_stories')) || [];
            const track = document.getElementById('storiesTrack');
            const cityStories = getCityStories();

            document.getElementById('cityBadge').innerHTML = `<i class="bi bi-geo-alt-fill"></i> ${currentCityName}`;
            document.getElementById('placesTitle').textContent = currentCityName;
            document.getElementById('formCityName').textContent = currentCityName;
            document.getElementById('storiesCount').textContent = cityStories.length;
            document.getElementById('authorsCount').textContent = new Set(cityStories.map(s => s.author)).size;
            document.getElementById('citiesCount').textContent = new Set(stories.map(s => s.city)).size;

            carouselIndex = 0;

            if (cityStories.length === 0) {
                track.innerHTML = `
                    <div class="empty-state" style="flex: 0 0 100%;">
                        <i class="bi bi-journal-x"></i>
                        <h3>Пока нет историй из ${currentCityName}</h3>
                        <p>Стань первым — поделись своим местом ниже!</p>
                    </div>`;
                document.getElementById('carouselCounter').textContent = '0 / 0';
                document.getElementById('prevBtn').disabled = true;
                document.getElementById('nextBtn').disabled = true;
                return;
            }

            track.innerHTML = cityStories.map(story => {
                const cfg = categoryConfig[story.category] || categoryConfig.coffee;
                const avatarColor = avatarColors[story.author.length % avatarColors.length];
                const isLiked = likedStories[story.id];
                return `
                    <div class="story-card">
                        <div class="story-header">
                            <div class="story-avatar" style="background: ${avatarColor};">${story.author.charAt(0)}</div>
                            <div class="story-meta">
                                <div class="story-author">${story.author}</div>
                                <div class="story-city-date">${story.cityName} · ${story.date}</div>
                            </div>
                            <div class="story-category-badge" style="background: ${cfg.bg}; color: ${cfg.color}; border-color: ${cfg.color}22;">
                                <i class="bi ${cfg.icon}"></i> ${cfg.label}
                            </div>
                        </div>
                        <h3 class="story-title">${story.title}</h3>
                        <p class="story-text">${story.text}</p>
                        <div class="story-place">
                            <div class="story-place-name"><i class="bi bi-geo-alt-fill" style="color: #2e8d53;"></i> ${story.placeName}</div>
                            <div class="story-place-address">${story.placeAddress}</div>
                        </div>
                        <div class="story-actions">
                            <button class="story-btn btn-like ${isLiked ? 'liked' : ''}" onclick="toggleLike(${story.id})">
                                <i class="bi bi-${isLiked ? 'heart-fill' : 'heart'}"></i> ${story.likes + (isLiked ? 1 : 0)}
                            </button>
                            <button class="story-btn btn-save" onclick="savePlace(${story.id})">
                                <i class="bi bi-bookmark-plus"></i> Сохранить
                            </button>
                        </div>
                    </div>
                `;
            }).join('');

            requestAnimationFrame(updateCarouselUI);
        }

  
        function updateCarouselUI() {
            const track = document.getElementById('storiesTrack');
            const cards = track.querySelectorAll('.story-card');
            if (cards.length === 0) return;

            const cardWidth = cards[0].offsetWidth + 20;
            const maxIndex = Math.max(0, cards.length - getVisibleCards());

            carouselIndex = Math.min(Math.max(carouselIndex, 0), maxIndex);
            track.style.transform = `translateX(-${carouselIndex * cardWidth}px)`;

            document.getElementById('carouselCounter').textContent = `${Math.min(carouselIndex + 1, cards.length)} / ${cards.length}`;
            document.getElementById('prevBtn').disabled = carouselIndex === 0;
            document.getElementById('nextBtn').disabled = carouselIndex >= maxIndex;
        }

        function getVisibleCards() {
            if (window.innerWidth < 768) return 1;
            if (window.innerWidth < 1200) return 2;
            return 3;
        }

        window.moveCarousel = function(dir) {
            carouselIndex += dir;
            updateCarouselUI();
        };

        window.addEventListener('resize', () => { carouselIndex = 0; updateCarouselUI(); });


        window.toggleLike = function(id) {
            const story = stories.find(s => s.id === id);
            if (!story) return;
            if (likedStories[id]) {
                delete likedStories[id];
            } else {
                likedStories[id] = true;
            }
            localStorage.setItem('liked_stories', JSON.stringify(likedStories));
            renderStories();
        };

        window.savePlace = function(id) {
            const story = stories.find(s => s.id === id);
            if (!story) return;
            let savedPlaces = JSON.parse(localStorage.getItem('selected_places')) || [];
            if (!savedPlaces.find(p => p.id === id + 1000)) {
                savedPlaces.push({
                    id: id + 1000,
                    name: story.placeName,
                    location: story.placeAddress,
                    coords: [0, 0],
                    rating: 5,
                    reviews: 0,
                    description: story.text.substring(0, 80) + '...',
                    category: story.category === 'coffee' ? 'cafes' : story.category === 'food' ? 'restaurants' : 'attractions'
                });
                localStorage.setItem('selected_places', JSON.stringify(savedPlaces));
                showNotification('✓ Место сохранено в маршрут');
            } else {
                showNotification('Уже в маршруте', true);
            }
        };


        document.getElementById('storyForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const newStory = {
                id: Date.now(),
                author: document.getElementById('authorName').value,
                city: currentCityId,
                cityName: currentCityName,
                title: document.getElementById('storyTitle').value,
                text: document.getElementById('storyText').value,
                placeName: document.getElementById('placeName').value,
                placeAddress: document.getElementById('placeAddress').value,
                category: document.getElementById('storyCategory').value,
                date: 'только что',
                likes: 0
            };

            stories.unshift(newStory);
            localStorage.setItem('locals_stories', JSON.stringify(stories));

            this.reset();
            renderStories();
            showNotification('✓ История опубликована!');
        });

  
        function showNotification(msg, isError) {
            const n = document.createElement('div');
            n.className = 'toast-notification';
            n.style.background = isError ? '#ff6b6b' : '#2e8d53';
            n.innerHTML = `<i class="bi ${isError ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill'}"></i> ${msg}`;
            document.body.appendChild(n);
            setTimeout(() => n.remove(), 2500);
        }

        // ====== ИНИЦИАЛИЗАЦИЯ ======
        document.addEventListener('DOMContentLoaded', function() {
            const saved = localStorage.getItem('locals_stories');
            if (!saved || saved === '[]') {
                const defaults = [
                    { id: 1, author: 'Аня М.', city: 'saint-petersburg', cityName: 'Санкт-Петербург', title: 'Где я пью лучший капучино по утрам', text: 'Каждое воскресенье я прихожу сюда в 9 утра. Пока город ещё спит, сажусь у окна с видом на канал. Кофе здесь варят с любовью, а круассаны — хрустящие, как во Франции. Это мой личный ритуал перед новой неделей.', placeName: 'Кофейня «Зерно»', placeAddress: 'Лиговский проспект, 53', category: 'coffee', date: '3 дня назад', likes: 24 },
                    { id: 2, author: 'Дима К.', city: 'saint-petersburg', cityName: 'Санкт-Петербург', title: 'Секретный двор, который не найти на карте', text: 'Между двух старых домов на Васильевском есть проход. Если свернуть туда — попадаешь во двор с настоящим виноградом и коваными скамейками. Здесь тихо, хотя в 50 метрах — оживлённая улица. Местные старики играют в шахматы, а я читаю книги.', placeName: 'Двор на 7-й линии', placeAddress: '7-я линия В.О., д. 16', category: 'secret', date: '5 дней назад', likes: 56 },
                    { id: 3, author: 'Маша Л.', city: 'saint-petersburg', cityName: 'Санкт-Петербург', title: 'Прогулка, которая лечит от грусти', text: 'Когда на душе тяжело — я иду от Летнего сада до стрелки Васильевского. Путь занимает час, но за ним — целая жизнь. Мосты, вода, фонари. Особенно в дождь. Питер не красив несмотря на дождь — он красив благодаря ему.', placeName: 'Набережная Невы', placeAddress: 'от Летнего сада до стрелки В.О.', category: 'walk', date: '4 дня назад', likes: 67 },
                    { id: 4, author: 'Катя В.', city: 'kaliningrad', cityName: 'Калининград', title: 'Наше место для закатов', text: 'Мы с парнем каждую пятницу едем на набережную. Там есть одна скамейка — наша. С неё видно мост и реку, и когда солнце садится, всё заливает оранжевым. Мы приносим пиццу, садимся и молча смотрим. Это лучше любого кино.', placeName: 'Набережная озера Верхнее', placeAddress: 'ул. Дзержинского', category: 'romantic', date: '1 неделю назад', likes: 41 },
                    { id: 5, author: 'Сергей П.', city: 'kaliningrad', cityName: 'Калининград', title: 'Рыбный рынок, где всё по-настоящему', text: 'Забудьте про супермаркеты. В субботу утром я еду на рынок у Рыбной деревни. Прямо с причала — копчёная рыба, свежие креветки, домашний хлеб. Продавцы знают меня по имени. Это душа города, не только еда.', placeName: 'Рыбный рынок', placeAddress: 'ул. Октябрьская, рядом с Рыбной деревней', category: 'food', date: '2 дня назад', likes: 33 },
                    { id: 6, author: 'Игорь Н.', city: 'kaliningrad', cityName: 'Калининград', title: 'Крыша, откуда видно весь город', text: 'Мало кто знает, что в торговом центре на площади Победы есть выход на крышу. Бесплатно. Сверху видно собор, озеро и закат. Я привёл туда друзей из Москвы — они обалдели. Главное — приходить до 20:00, пока не закрыли.', placeName: 'Смотровая на крыше', placeAddress: 'пл. Победы, ТЦ «Европа»', category: 'view', date: '1 день назад', likes: 89 }
                ];
                localStorage.setItem('locals_stories', JSON.stringify(defaults));
            }

            document.getElementById('formCityName').textContent = currentCityName;

            renderBloggers();
            renderStories();

            const authBtn = document.getElementById('authButton');
            const user = JSON.parse(localStorage.getItem('current_user'));
            if (user && authBtn) { authBtn.textContent = user.name || 'Профиль'; authBtn.href = 'profile.php'; }
        });
    </script>
</body>
</html>
