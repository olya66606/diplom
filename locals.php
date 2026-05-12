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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Места от жителей | Туры Везде</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Mulish', sans-serif; background: linear-gradient(135deg, #bcddff54, #98dbb8a1); }
        .banner { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); width: 100%; min-height: 350px; margin-top: 70px; display: flex; align-items: center; justify-content: center; text-align: center; color: white; padding: 60px 20px; }
        .banner-content { max-width: 800px; }
        .banner h1 { font-size: 3rem; margin-bottom: 20px; font-weight: 700; }
        .banner p { font-size: 1.2rem; opacity: 0.95; margin-bottom: 30px; }
        .city-badge { display: inline-block; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: 12px 35px; border-radius: 50px; font-weight: 600; font-size: 1.2rem; border: 2px solid rgba(255,255,255,0.3); }
        .places-section { max-width: 1400px; margin: 80px auto; padding: 0 20px; }
        .places-section h2 { font-size: 2.5rem; color: #1b5031; margin-bottom: 50px; text-align: center; font-weight: 700; }
        .swiper { padding: 20px 0 60px; }
        .place-card { background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); height: 100%; transition: all 0.3s ease; }
        .place-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .place-card.liked { border: 3px solid #2e8d53; }
        .place-card.liked .like-btn { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; border-color: transparent; }
        .like-btn { position: absolute; bottom: 15px; right: 15px; width: 50px; height: 50px; border-radius: 50%; border: 2px solid white; background: white; color: #ff6b6b; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 3; }
        .like-btn:hover { transform: scale(1.15); box-shadow: 0 6px 20px rgba(0,0,0,0.3); }
        .like-btn i { transition: all 0.3s; }
        .place-card.liked .like-btn i { transform: scale(1.2); }
        .like-count { position: absolute; bottom: 15px; left: 15px; background: rgba(255,255,255,0.95); padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 0.85rem; color: #2e8d53; box-shadow: 0 3px 10px rgba(0,0,0,0.15); z-index: 3; display: flex; align-items: center; gap: 5px; }
        
        /* Коллекции и фильтры */
        .collections-tabs { display: flex; gap: 12px; justify-content: center; margin-bottom: 40px; flex-wrap: wrap; }
        .collection-tab { padding: 12px 28px; border-radius: 50px; border: 2px solid #e8ecf1; background: white; cursor: pointer; font-weight: 600; font-family: 'Mulish', sans-serif; transition: all 0.3s; color: #666; display: flex; align-items: center; gap: 8px; font-size: 0.95rem; }
        .collection-tab:hover { border-color: #2e8d53; background: #f0fff4; transform: translateY(-2px); }
        .collection-tab.active { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); border-color: transparent; color: white; box-shadow: 0 8px 25px rgba(46,141,83,0.35); transform: translateY(-3px); }
        .collection-tab .tab-badge { background: rgba(255,255,255,0.3); padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; }
        
        /* Дополнительная информация о месте */
        .place-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e8ecf1; }
        .place-info-item { background: #f8f9fc; padding: 10px; border-radius: 12px; text-align: center; }
        .place-info-item i { font-size: 1.3rem; color: #2e8d53; margin-bottom: 5px; display: block; }
        .place-info-item span { font-size: 0.75rem; color: #666; font-weight: 500; display: block; }
        .place-info-item .value { font-size: 0.85rem; font-weight: 700; color: #1b5031; margin-top: 3px; display: block; }
        .peak-hours { display: flex; gap: 4px; margin-top: 8px; justify-content: center; }
        .peak-bar { width: 12px; height: 20px; border-radius: 3px; background: #e8ecf1; }
        .peak-bar.high { background: linear-gradient(180deg, #ff6b6b 0%, #ee5253 100%); }
        .peak-bar.medium { background: linear-gradient(180deg, #ffc107 0%, #ff9800 100%); }
        .peak-bar.low { background: linear-gradient(180deg, #2e8d53 0%, #4ecdc4 100%); }
        .peak-label { font-size: 0.7rem; color: #999; margin-top: 4px; }
        .place-image { height: 230px; background-size: cover; background-position: center; position: relative; }
        .place-city { position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; padding: 6px 18px; border-radius: 30px; font-weight: 600; font-size: 0.8rem; }
        .place-content { padding: 25px; }
        .place-content h3 { font-size: 1.5rem; color: #1b5031; margin-bottom: 10px; font-weight: 700; }
        .place-location { display: flex; align-items: center; gap: 8px; color: #2e8d53; margin-bottom: 15px; font-size: 0.9rem; }
        .place-rating { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .stars { color: #ffc107; }
        .rating-value { font-weight: 600; color: #333; }
        .reviews-count { color: #98dbb8; font-weight: 500; }
        .place-description { color: #666; line-height: 1.6; margin-bottom: 20px; font-size: 0.95rem; }
        .reviews-section { border-top: 1px solid #e8ecf1; padding-top: 20px; margin-top: 10px; }
        .review-item { background: #f8f9fc; padding: 15px; border-radius: 16px; margin-bottom: 12px; border-left: 3px solid #2e8d53; }
        .review-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 8px; }
        .review-author { font-weight: 600; color: #333; font-size: 0.9rem; }
        .review-date { color: #999; font-size: 0.8rem; }
        .review-text { color: #555; font-style: italic; font-size: 0.9rem; line-height: 1.5; }
        .review-form-section { max-width: 700px; margin: 80px auto; padding: 40px; background: white; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .review-form-section h2 { font-size: 2rem; color: #1b5031; margin-bottom: 15px; text-align: center; font-weight: 700; }
        .review-form-section p { text-align: center; color: #666; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #333; margin-bottom: 8px; font-size: 0.95rem; }
        .form-control { width: 100%; padding: 14px 18px; border: 2px solid #e8ecf1; border-radius: 16px; font-size: 1rem; font-family: 'Mulish', sans-serif; background: white; transition: all 0.3s; }
        .form-control:focus { outline: none; border-color: #2e8d53; box-shadow: 0 0 0 3px rgba(46,141,83,0.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .submit-btn { background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; border: none; padding: 16px 30px; border-radius: 50px; font-size: 1.1rem; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; font-family: 'Mulish', sans-serif; }
        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(46,141,83,0.3); }
        .swiper-button-next, .swiper-button-prev { color: #2e8d53; background: white; width: 45px; height: 45px; border-radius: 50%; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .swiper-button-next:after, .swiper-button-prev:after { font-size: 18px; font-weight: bold; }
        .swiper-pagination-bullet { background: #2e8d53; opacity: 0.5; }
        .swiper-pagination-bullet-active { background: #2e8d53; opacity: 1; }
        .no-places { text-align: center; padding: 50px; background: white; border-radius: 24px; }
        .no-places i { font-size: 4rem; color: #2e8d53; margin-bottom: 20px; }
        .no-places h3 { font-size: 1.8rem; color: #1b5031; margin-bottom: 15px; }
        .no-places p { color: #666; margin-bottom: 25px; }
        .no-places .btn { display: inline-block; padding: 12px 35px; background: linear-gradient(135deg, #2e8d53 0%, #4ecdc4 100%); color: white; text-decoration: none; border-radius: 50px; font-weight: 600; transition: all 0.3s; }
        .no-places .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(46,141,83,0.3); }
        .places-filter-info { background: #f0fff4; padding: 15px 25px; border-radius: 16px; display: inline-block; margin: 0 auto; }
        .places-filter-info i { margin-right: 8px; }
        @media (max-width: 768px) { 
            .banner h1 { font-size: 2rem; } 
            .form-row { grid-template-columns: 1fr; } 
            .places-section h2 { font-size: 1.8rem; }
            .collections-tabs { gap: 8px; }
            .collection-tab { padding: 10px 20px; font-size: 0.85rem; }
            .collection-tab .tab-badge { display: none; }
            .place-info-grid { grid-template-columns: repeat(2, 1fr); }
            .place-info-item { padding: 8px; }
            .peak-hours { gap: 2px; }
            .peak-bar { width: 8px; }
            .places-filter-info { font-size: 0.9rem; padding: 10px 15px; }
        }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>
    <section class="banner">
        <div class="banner-content">
            <h1>✨ Секретные места от жителей</h1>
            <p>Только аутентичные локации, которые знают местные. Никаких туристических троп — только настоящие жемчужины.</p>
            <div class="city-badge" id="cityBadge">
                <i class="bi bi-geo-alt-fill"></i> Санкт-Петербург
            </div>
        </div>
    </section>

    <section class="places-section">
        <h2>🏠 <span id="placesTitle">Санкт-Петербург</span> глазами местных</h2>
        
        <!-- Коллекции от жителей -->
        <div class="collections-tabs" id="collectionsTabs">
            <button class="collection-tab active" data-collection="all">
                <i class="bi bi-grid-3x3"></i> Все места
            </button>
            <button class="collection-tab" data-collection="first-visit">
                <i class="bi bi-star"></i> Для первого визита <span class="tab-badge" id="firstVisitCount">0</span>
            </button>
            <button class="collection-tab" data-collection="romantic">
                <i class="bi bi-heart"></i> Романтические <span class="tab-badge" id="romanticCount">0</span>
            </button>
            <button class="collection-tab" data-collection="photospot">
                <i class="bi bi-camera"></i> Для фотосессий <span class="tab-badge" id="photoCount">0</span>
            </button>
            <button class="collection-tab" data-collection="family">
                <i class="bi bi-people"></i> Детские <span class="tab-badge" id="familyCount">0</span>
            </button>
            <button class="collection-tab" data-collection="quiet">
                <i class="bi bi-moon"></i> Спокойные <span class="tab-badge" id="quietCount">0</span>
            </button>
            <button class="collection-tab" data-collection="top-week">
                <i class="bi bi-trophy-fill"></i> Топ недели 🔥 <span class="tab-badge" id="topWeekCount">0</span>
            </button>
        </div>
        
        <div class="swiper placesSwiper">
            <div class="swiper-wrapper" id="placesWrapper">
                <!-- Места будут загружаться динамически -->
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citiesPlaces = {
                'saint-petersburg': {
                    name: 'Санкт-Петербург',
                    places: [
                        { id: 1, name: 'Двор Капеллы', image: 'https://images.unsplash.com/photo-1559598467-f8b76c8155d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'ул. Большая Конюшенная, 11', rating: 4.8, reviews: 43, likes: 156, description: 'Скрытый от глаз туристов дворик в самом центре города.', collections: ['quiet', 'photospot', 'winter', 'christmas'], bestTime: 'Утро (8-10)', peakHours: [1, 2, 3, 4, 5, 6, 7, 6, 5, 4, 3, 2], accessible: true, parking: false, petFriendly: true, reviewsList: [{ author: 'Анна С.', date: '2 дня назад', rating: 5, text: 'Потрясающее место!' }, { author: 'Михаил', date: '1 неделя назад', rating: 4, text: 'Красиво, но в выходные много людей.' }] },
                        { id: 2, name: 'Новая Голландия', image: 'https://images.unsplash.com/photo-1513326738677-b964603b136d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'наб. Адмиралтейского канала, 2', rating: 4.9, reviews: 67, likes: 234, description: 'Остров с парком, арт-пространством и кафе.', collections: ['first-visit', 'family', 'photospot', 'spring', 'summer', 'terraces'], bestTime: 'День (12-16)', peakHours: [1, 2, 3, 5, 7, 8, 8, 7, 6, 5, 4, 3], accessible: true, parking: true, petFriendly: true, reviewsList: [{ author: 'Дмитрий', date: '3 дня назад', rating: 5, text: 'Живу рядом, хожу сюда каждый день.' }] },
                        { id: 3, name: 'Севкабель Порт', image: 'https://images.unsplash.com/photo-1514912885225-b8c7c2b44b2a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'Кожевенная линия, 40', rating: 4.7, reviews: 89, likes: 189, description: 'Креативное пространство на Васильевском острове.', collections: ['first-visit', 'photospot', 'romantic', 'spring', 'summer', 'autumn', 'terraces', 'winterwalks'], bestTime: 'Вечер (17-20)', peakHours: [1, 1, 2, 3, 4, 6, 8, 9, 8, 7, 5, 3], accessible: true, parking: true, petFriendly: false, reviewsList: [{ author: 'Екатерина', date: '5 дней назад', rating: 5, text: 'Отличное место для прогулок!' }] },
                        { id: 4, name: 'Крыша Hotel Indigo', image: 'https://images.unsplash.com/photo-1530521954074-e64f6810b32d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'Набережная Макалова, 2', rating: 4.9, reviews: 45, likes: 312, description: 'Панорамная смотровая площадка с видом на город.', collections: ['romantic', 'photospot', 'first-visit', 'spring', 'summer', 'autumn', 'terraces'], bestTime: 'Вечер (19-22)', peakHours: [1, 1, 1, 2, 3, 4, 6, 8, 9, 9, 8, 6], accessible: false, parking: false, petFriendly: false, reviewsList: [{ author: 'Алексей', date: '1 день назад', rating: 5, text: 'Лучший вид на закат!' }] },
                        { id: 5, name: 'Музей-мастерская М.В. Ломоносова', image: 'https://images.unsplash.com/photo-1565060169197-9f8da0877f0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'Михайловский сад, 2', rating: 4.8, reviews: 38, likes: 98, description: 'Уникальная коллекция фаянсовых изделий.', collections: ['first-visit', 'quiet', 'family', 'spring', 'autumn'], bestTime: 'День (11-15)', peakHours: [1, 1, 2, 4, 6, 7, 6, 5, 4, 3, 2, 1], accessible: true, parking: false, petFriendly: false, reviewsList: [{ author: 'Ольга', date: '4 дня назад', rating: 5, text: 'Великолепные изделия ручной работы!' }] }
                    ]
                },
                'kaliningrad': {
                    name: 'Калининград',
                    places: [
                        { id: 101, name: 'Рыбная деревня', image: 'https://images.unsplash.com/photo-1598908311172-d99e5e9b8c1c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'ул. Октябрьская', rating: 4.8, reviews: 56, likes: 178, description: 'Квартал в довоенном стиле.', collections: ['first-visit', 'photospot', 'family', 'spring', 'summer', 'autumn', 'christmas'], bestTime: 'День (10-16)', peakHours: [1, 2, 3, 5, 7, 8, 8, 7, 6, 4, 3, 2], accessible: true, parking: true, petFriendly: true, reviewsList: [{ author: 'Алексей', date: '1 неделя назад', rating: 5, text: 'Очень атмосферное место.' }] },
                        { id: 102, name: 'Амалиенау', image: 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'район Амалиенау', rating: 4.9, reviews: 34, likes: 145, description: 'Старый немецкий район с виллами.', collections: ['quiet', 'photospot', 'romantic', 'spring', 'autumn', 'winterwalks'], bestTime: 'Утро (8-12)', peakHours: [1, 1, 2, 3, 4, 5, 5, 4, 3, 3, 2, 1], accessible: true, parking: true, petFriendly: true, reviewsList: [{ author: 'Иван', date: '3 дня назад', rating: 5, text: 'Лучшее место для прогулок.' }] }
                    ]
                },
                'japan': {
                    name: 'Япония',
                    places: [
                        { id: 201, name: 'Храм Сэнсо-дзи', image: 'https://images.unsplash.com/photo-1564858051047-2f213095da05?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'Асакуса, Токио', rating: 4.9, reviews: 1234, likes: 2456, description: 'Древнейший храм Токио с воротами Раймон.', collections: ['first-visit', 'photospot', 'quiet', 'spring', 'autumn', 'christmas'], bestTime: 'Раннее утро (6-8)', peakHours: [3, 5, 7, 8, 8, 7, 6, 5, 5, 6, 7, 6], accessible: true, parking: false, petFriendly: false, reviewsList: [{ author: 'Yuki', date: '2 дня назад', rating: 5, text: 'Невероятная атмосфера!' }, { author: 'Takeshi', date: '1 неделя назад', rating: 5, text: 'Лучший храм в Токио.' }] },
                        { id: 202, name: 'Район Шибуя', image: 'https://images.unsplash.com/photo-1542051841857-5f90071e7989?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'Шибуя, Токио', rating: 4.8, reviews: 2345, likes: 3789, description: 'Знаменитый перекресток и неоновые огни.', collections: ['first-visit', 'photospot', 'romantic', 'spring', 'summer', 'autumn', 'winter', 'christmas', 'terraces'], bestTime: 'Вечер (18-22)', peakHours: [2, 2, 3, 4, 5, 7, 8, 9, 9, 8, 7, 6], accessible: true, parking: false, petFriendly: false, reviewsList: [{ author: 'Hiroshi', date: '3 дня назад', rating: 5, text: 'Очень красиво вечером!' }] },
                        { id: 203, name: 'Бамбуковый лес Араторити', image: 'https://images.unsplash.com/photo-1493976040807-0c3cb6fa165d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'Арасияма, Киото', rating: 4.9, reviews: 987, likes: 1876, description: 'Уникальный бамбуковый лес в Киото.', collections: ['quiet', 'romantic', 'photospot', 'spring', 'summer', 'autumn', 'winterwalks'], bestTime: 'Утро (7-9)', peakHours: [2, 4, 6, 8, 8, 7, 6, 5, 4, 3, 2, 2], accessible: true, parking: true, petFriendly: true, reviewsList: [{ author: 'Kenji', date: '5 дней назад', rating: 5, text: 'Успокаивающая атмосфера!' }] },
                        { id: 204, name: 'Храм Кийомидзу-дера', image: 'https://images.unsplash.com/photo-1528360983277-13d9b152c6d4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'Киото', rating: 4.9, reviews: 1567, likes: 2234, description: 'Древний буддийский храм с деревянной террасой.', collections: ['first-visit', 'photospot', 'family', 'spring', 'summer', 'autumn', 'winter'], bestTime: 'Утро (6-9)', peakHours: [3, 5, 7, 8, 8, 7, 6, 5, 4, 3, 2, 1], accessible: false, parking: true, petFriendly: false, reviewsList: [{ author: 'Akiko', date: '2 дня назад', rating: 5, text: 'Великолепно в сезон сакуры!' }] }
                    ]
                }
            };

            const selectedCityId = localStorage.getItem('selected_city_for_locals') || 'saint-petersburg';
            const cityData = citiesPlaces[selectedCityId] || citiesPlaces['saint-petersburg'];

            document.getElementById('cityBadge').innerHTML = `<i class="bi bi-geo-alt-fill"></i> ${cityData.name}`;
            document.getElementById('placesTitle').textContent = cityData.name;

            const placesWrapper = document.getElementById('placesWrapper');
            const placeSelect = document.getElementById('placeSelect');
            let currentCollection = 'all';
            let likedPlaces = JSON.parse(localStorage.getItem('liked_places') || '{}');

            if (cityData.places && cityData.places.length > 0) {
                // Подсчет для бейджей
                document.getElementById('firstVisitCount').textContent = cityData.places.filter(p => p.collections?.includes('first-visit')).length;
                document.getElementById('romanticCount').textContent = cityData.places.filter(p => p.collections?.includes('romantic')).length;
                document.getElementById('photoCount').textContent = cityData.places.filter(p => p.collections?.includes('photospot')).length;
                document.getElementById('familyCount').textContent = cityData.places.filter(p => p.collections?.includes('family')).length;
                document.getElementById('quietCount').textContent = cityData.places.filter(p => p.collections?.includes('quiet')).length;
                document.getElementById('topWeekCount').textContent = cityData.places.filter(p => p.likes > 200).length;

                // Обработчик кликов по коллекциям
                document.querySelectorAll('.collection-tab').forEach(tab => {
                    tab.addEventListener('click', function() {
                        document.querySelectorAll('.collection-tab').forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        currentCollection = this.dataset.collection || this.dataset.season;
                        renderPlaces();
                    });
                });

                // Подсчет сезонных бейджей
                function updateSeasonCounts() {
                    document.getElementById('winterCount').textContent = cityData.places.filter(p => p.collections?.includes('winter')).length;
                    document.getElementById('springCount').textContent = cityData.places.filter(p => p.collections?.includes('spring')).length;
                    document.getElementById('summerCount').textContent = cityData.places.filter(p => p.collections?.includes('summer')).length;
                    document.getElementById('autumnCount').textContent = cityData.places.filter(p => p.collections?.includes('autumn')).length;
                    document.getElementById('christmasCount').textContent = cityData.places.filter(p => p.collections?.includes('christmas')).length;
                    document.getElementById('terracesCount').textContent = cityData.places.filter(p => p.collections?.includes('terraces')).length;
                    document.getElementById('winterwalksCount').textContent = cityData.places.filter(p => p.collections?.includes('winterwalks')).length;
                }
                updateSeasonCounts();

                // Функция фильтрации по сезону
                window.filterBySeason = function(season) {
                    document.querySelectorAll('.collection-tab').forEach(t => t.classList.remove('active'));
                    document.querySelector(`[data-season="${season}"]`).classList.add('active');
                    currentCollection = season;
                    renderPlaces();
                };

                renderPlaces();

                function renderPlaces() {
                    let filteredPlaces = [...cityData.places];
                    
                    // Фильтрация по коллекции
                    if (currentCollection !== 'all') {
                        if (currentCollection === 'top-week') {
                            filteredPlaces = filteredPlaces.filter(p => p.likes > 200).sort((a, b) => b.likes - a.likes);
                        } else {
                            filteredPlaces = filteredPlaces.filter(p => p.collections?.includes(currentCollection));
                        }
                    } else {
                        // Сортировка по рейтингу по умолчанию
                        filteredPlaces.sort((a, b) => b.rating - a.rating);
                    }

                    // Обновление описания сезона
                    const seasonDescriptions = {
                        'all': 'Все лучшие места города',
                        'winter': '❄️ Лучшие места для посещения зимой',
                        'spring': '🌸 Лучшие места для посещения весной',
                        'summer': '☀️ Лучшие места для посещения летом',
                        'autumn': '🍂 Лучшие места для посещения осенью',
                        'christmas': '🎄 Рождественские огни и новогодняя атмосфера',
                        'terraces': '🌞 Летние террасы кафе и ресторанов',
                        'winterwalks': '⛄ Идеальные места для зимних прогулок'
                    };
                    document.getElementById('seasonDescription').textContent = seasonDescriptions[currentCollection] || 'Лучшие места';

                    placesWrapper.innerHTML = '';
                    
                    filteredPlaces.forEach(place => {
                        const isLiked = likedPlaces[place.id];
                        const fullStars = Math.floor(place.rating);
                        const hasHalf = place.rating % 1 >= 0.5;
                        let starsHtml = '';
                        for (let i = 0; i < fullStars; i++) starsHtml += '<i class="bi bi-star-fill"></i>';
                        if (hasHalf) starsHtml += '<i class="bi bi-star-half"></i>';
                        
                        const reviewsHtml = place.reviewsList.map(review => {
                            let reviewStars = '';
                            for (let i = 0; i < review.rating; i++) reviewStars += '<i class="bi bi-star-fill"></i>';
                            return `<div class="review-item"><div class="review-header"><span class="review-author"><i class="bi bi-person-circle"></i> ${review.author}</span><span class="review-date">${review.date}</span></div><div class="stars" style="font-size: 0.85rem;">${reviewStars}</div><div class="review-text">${review.text}</div></div>`;
                        }).join('');
                        
                        // Часы пик
                        const peakHoursHtml = place.peakHours ? `
                            <div class="peak-hours">
                                ${place.peakHours.slice(0, 12).map((level, i) => {
                                    let className = 'low';
                                    if (level >= 7) className = 'high';
                                    else if (level >= 4) className = 'medium';
                                    return `<div class="peak-bar ${className}" style="height: ${level * 3}px;" title="${i}:00 - ${level * 10}%"></div>`;
                                }).join('')}
                            </div>
                            <div class="peak-label">08:00 - 19:00</div>
                        ` : '';
                        
                        const placeInfoHtml = `
                            <div class="place-info-grid">
                                <div class="place-info-item">
                                    <i class="bi bi-clock-history"></i>
                                    <span>Лучшее время</span>
                                    <div class="value">${place.bestTime || 'Любое'}</div>
                                </div>
                                <div class="place-info-item">
                                    <i class="bi bi-calendar-week"></i>
                                    <span>Часы пик</span>
                                    ${peakHoursHtml}
                                </div>
                                <div class="place-info-item">
                                    <i class="bi bi-wheelchair"></i>
                                    <span>Доступность</span>
                                    <div class="value">${place.accessible ? 'Да' : 'Нет'}</div>
                                </div>
                                <div class="place-info-item">
                                    <i class="bi bi-car-front"></i>
                                    <span>Парковка</span>
                                    <div class="value">${place.parking ? 'Есть' : 'Нет'}</div>
                                </div>
                                <div class="place-info-item">
                                    <i class="bi bi-paw-fill"></i>
                                    <span>Pet-friendly</span>
                                    <div class="value">${place.petFriendly ? 'Да' : 'Нет'}</div>
                                </div>
                            </div>
                        `;
                        
                        const slide = document.createElement('div');
                        slide.className = 'swiper-slide';
                        slide.innerHTML = `
                            <div class="place-card ${isLiked ? 'liked' : ''}" data-place-id="${place.id}">
                                <div class="place-image" style="background-image: url('${place.image}')">
                                    <span class="place-city"><i class="bi bi-geo-alt-fill"></i> ${cityData.name}</span>
                                    <button class="like-btn" onclick="toggleLike(${place.id})">
                                        <i class="bi bi-${isLiked ? 'heart-fill' : 'heart'}"></i>
                                    </button>
                                    <div class="like-count">
                                        <i class="bi bi-heart-fill"></i>
                                        <span>${place.likes + (isLiked ? 1 : 0)}</span>
                                    </div>
                                </div>
                                <div class="place-content">
                                    <h3>${place.name}</h3>
                                    <div class="place-location"><i class="bi bi-pin-map-fill"></i><span>${place.address}</span></div>
                                    <div class="place-rating">
                                        <div class="stars">${starsHtml}</div>
                                        <span class="rating-value">${place.rating}</span>
                                        <span class="reviews-count">(${place.reviews} отзывов)</span>
                                    </div>
                                    <p class="place-description">${place.description}</p>
                                    ${placeInfoHtml}
                                    <div class="reviews-section">${reviewsHtml}</div>
                                </div>
                            </div>
                        `;
                        placesWrapper.appendChild(slide);
                        
                        const option = document.createElement('option');
                        option.value = place.id;
                        option.textContent = `${cityData.name}: ${place.name}`;
                        if(placeSelect) placeSelect.appendChild(option);
                    });

                    // Перезапуск Swiper
                    if (window.placesSwiper) {
                        window.placesSwiper.destroy();
                    }
                    window.placesSwiper = new Swiper('.placesSwiper', { 
                        slidesPerView: 1, 
                        spaceBetween: 25, 
                        loop: false,
                        pagination: { el: '.swiper-pagination', clickable: true }, 
                        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }, 
                        breakpoints: { 
                            768: { slidesPerView: 2 }, 
                            1024: { slidesPerView: 2 } 
                        } 
                    });
                }

                // Функция лайка
                window.toggleLike = function(placeId) {
                    const place = cityData.places.find(p => p.id === placeId);
                    if (!place) return;

                    if (likedPlaces[placeId]) {
                        delete likedPlaces[placeId];
                    } else {
                        likedPlaces[placeId] = true;
                    }

                    localStorage.setItem('liked_places', JSON.stringify(likedPlaces));
                    renderPlaces();
                };
            } else {
                placesWrapper.innerHTML = `<div class="swiper-slide"><div class="no-places"><i class="bi bi-geo-alt-fill"></i><h3>Нет мест для этого города</h3><p>Мы пока собираем секретные места для ${cityData.name}.</p><a href="index.php#surveyBlock" class="btn">Выбрать другой город</a></div></div>`;
            }

            const reviewForm = document.getElementById('reviewFormElement');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Спасибо! Ваш отзыв будет опубликован после проверки модератором.');
                    reviewForm.reset();
                });
            }
        });
    </script>
</body>
</html>
