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
        @media (max-width: 768px) { .banner h1 { font-size: 2rem; } .form-row { grid-template-columns: 1fr; } .places-section h2 { font-size: 1.8rem; } }
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
        
        <div class="swiper placesSwiper">
            <div class="swiper-wrapper" id="placesWrapper">
                <!-- Места будут загружаться динамически -->
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <?php if (isLoggedIn()): ?>
    <section class="review-form-section" id="reviewForm">
        <h2>💬 Поделись своим секретным местом</h2>
        <p>Расскажи о месте, которое знают только местные жители. Твой отзыв увидят другие путешественники.</p>
        
        <form id="reviewFormElement">
            <div class="form-group">
                <label for="placeSelect">📍 Выберите место</label>
                <select class="form-control" id="placeSelect" required>
                    <option value="" disabled selected>— Выберите место из списка —</option>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="authorName">👤 Ваше имя</label>
                    <input type="text" class="form-control" id="authorName" placeholder="Как к вам обращаться?" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="authorCity">🏙️ Ваш город</label>
                    <input type="text" class="form-control" id="authorCity" placeholder="Например: Москва">
                </div>
            </div>

            <div class="form-group">
                <label for="reviewText">📝 Ваш отзыв</label>
                <textarea class="form-control" id="reviewText" rows="4" placeholder="Поделитесь впечатлениями о месте..." required></textarea>
            </div>
            
            <button type="submit" class="submit-btn" id="submitReview">
                <i class="bi bi-send"></i> Отправить отзыв
            </button>
        </form>
    </section>
    <?php else: ?>
    <section class="review-form-section" id="reviewForm">
        <h2>💬 Оставьте отзыв</h2>
        <p>Для того чтобы оставить отзыв, необходимо <a href="auth/login.php" style="color: #2e8d53; font-weight: 600;">войти в аккаунт</a> или <a href="auth/register.php" style="color: #2e8d53; font-weight: 600;">зарегистрироваться</a>.</p>
        <div style="text-align: center;">
            <a href="auth/login.php" class="submit-btn" style="display: inline-flex; width: auto; padding: 16px 40px;">
                <i class="bi bi-box-arrow-in-right"></i> Войти
            </a>
        </div>
    </section>
    <?php endif; ?>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citiesPlaces = {
                'saint-petersburg': {
                    name: 'Санкт-Петербург',
                    places: [
                        { id: 1, name: 'Двор Капеллы', image: 'https://images.unsplash.com/photo-1559598467-f8b76c8155d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'ул. Большая Конюшенная, 11', rating: 4.8, reviews: 43, description: 'Скрытый от глаз туристов дворик в самом центре города.', reviewsList: [{ author: 'Анна С.', date: '2 дня назад', rating: 5, text: 'Потрясающее место!' }, { author: 'Михаил', date: '1 неделя назад', rating: 4, text: 'Красиво, но в выходные много людей.' }] },
                        { id: 2, name: 'Новая Голландия', image: 'https://images.unsplash.com/photo-1513326738677-b964603b136d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'наб. Адмиралтейского канала, 2', rating: 4.9, reviews: 67, description: 'Остров с парком, арт-пространством и кафе.', reviewsList: [{ author: 'Дмитрий', date: '3 дня назад', rating: 5, text: 'Живу рядом, хожу сюда каждый день.' }] },
                        { id: 3, name: 'Севкабель Порт', image: 'https://images.unsplash.com/photo-1514912885225-b8c7c2b44b2a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'Кожевенная линия, 40', rating: 4.7, reviews: 89, description: 'Креативное пространство на Васильевском острове.', reviewsList: [{ author: 'Екатерина', date: '5 дней назад', rating: 5, text: 'Отличное место для прогулок!' }] }
                    ]
                },
                'kaliningrad': {
                    name: 'Калининград',
                    places: [
                        { id: 101, name: 'Рыбная деревня', image: 'https://images.unsplash.com/photo-1598908311172-d99e5e9b8c1c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'ул. Октябрьская', rating: 4.8, reviews: 56, description: 'Квартал в довоенном стиле.', reviewsList: [{ author: 'Алексей', date: '1 неделя назад', rating: 5, text: 'Очень атмосферное место.' }] },
                        { id: 102, name: 'Амалиенау', image: 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'район Амалиенау', rating: 4.9, reviews: 34, description: 'Старый немецкий район с виллами.', reviewsList: [{ author: 'Иван', date: '3 дня назад', rating: 5, text: 'Лучшее место для прогулок.' }] }
                    ]
                },
                'kazan': {
                    name: 'Казань',
                    places: [
                        { id: 201, name: 'Двор Земледельцев', image: 'https://images.unsplash.com/photo-1598908311172-d99e5e9b8c1c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'ул. Бутлерова, 27', rating: 4.8, reviews: 78, description: 'Знаменитое здание с большим деревом в центре.', reviewsList: [{ author: 'Рустем', date: '4 дня назад', rating: 5, text: 'Очень красиво!' }, { author: 'Лилия', date: '2 недели назад', rating: 4, text: 'Интересная архитектура.' }] },
                        { id: 202, name: 'Улица Баумана', image: 'https://images.unsplash.com/photo-1513326738677-b964603b136d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'ул. Баумана', rating: 4.9, reviews: 234, description: 'Главная пешеходная улица Казани.', reviewsList: [{ author: 'Светлана', date: '1 день назад', rating: 5, text: 'Отличное место для прогулок.' }] },
                        { id: 203, name: 'Остров Свияжск', image: 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', address: 'остров Свияжск', rating: 4.9, reviews: 156, description: 'Исторический остров-заповедник.', reviewsList: [{ author: 'Александр', date: '5 дней назад', rating: 5, text: 'Уникальное место!' }] }
                    ]
                }
            };

            const selectedCityId = localStorage.getItem('selected_city_for_locals') || 'saint-petersburg';
            const cityData = citiesPlaces[selectedCityId] || citiesPlaces['saint-petersburg'];

            document.getElementById('cityBadge').innerHTML = `<i class="bi bi-geo-alt-fill"></i> ${cityData.name}`;
            document.getElementById('placesTitle').textContent = cityData.name;

            const placesWrapper = document.getElementById('placesWrapper');
            const placeSelect = document.getElementById('placeSelect');

            if (cityData.places && cityData.places.length > 0) {
                placesWrapper.innerHTML = '';
                cityData.places.forEach(place => {
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
                    
                    const slide = document.createElement('div');
                    slide.className = 'swiper-slide';
                    slide.innerHTML = `<div class="place-card"><div class="place-image" style="background-image: url('${place.image}')"><span class="place-city"><i class="bi bi-geo-alt-fill"></i> ${cityData.name}</span></div><div class="place-content"><h3>${place.name}</h3><div class="place-location"><i class="bi bi-pin-map-fill"></i><span>${place.address}</span></div><div class="place-rating"><div class="stars">${starsHtml}</div><span class="rating-value">${place.rating}</span><span class="reviews-count">(${place.reviews} отзывов)</span></div><p class="place-description">${place.description}</p><div class="reviews-section">${reviewsHtml}</div></div></div>`;
                    placesWrapper.appendChild(slide);
                    
                    const option = document.createElement('option');
                    option.value = place.id;
                    option.textContent = `${cityData.name}: ${place.name}`;
                    if(placeSelect) placeSelect.appendChild(option);
                });

                new Swiper('.placesSwiper', { slidesPerView: 1, spaceBetween: 25, loop: true, pagination: { el: '.swiper-pagination', clickable: true }, navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }, breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 2 } } });
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
