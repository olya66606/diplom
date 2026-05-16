<?php
require_once __DIR__ . '/../includes/auth_functions.php';
requireAdmin();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Модерация историй | Админ-панель</title>
    <style>
        .admin-stories { 
            max-width: 1400px; 
            margin: 100px auto; 
            padding: 0 20px; 
        }
        .admin-page-header { 
            text-align: center; 
            margin-bottom: 50px; 
        }
        .admin-page-header h1 { 
            font-size: 2.5rem; 
            color: #1b5031; 
            margin-bottom: 15px; 
            font-weight: 700; 
        }
        .admin-page-header p { 
            font-size: 1.2rem; 
            color: #666; 
        }
        .admin-alert { 
            padding: 15px 20px; 
            border-radius: 16px; 
            margin-bottom: 25px; 
            font-weight: 500; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            background: #d4edda; 
            color: #155724; 
            border: 2px solid #28a745; 
        }
        .admin-stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }
        .admin-stat-card { 
            background: white; 
            border-radius: 20px; 
            padding: 24px; 
            text-align: center; 
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
         }
        .admin-stat-value { 
            font-size: 2.2rem; 
            font-weight: 800; 
            color: #2e8d53; 
        }
        .admin-stat-label { 
            font-size: 0.95rem; 
            color: #666; 
            margin-top: 6px; 
            font-weight: 600; 
        }
        .admin-card { 
            background: white; 
            border-radius: 24px; 
            padding: 35px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        }
        .admin-filters { 
            display: flex;
            gap: 15px; 
            margin-bottom: 30px; 
            flex-wrap: wrap; 
        }
        .admin-filter-btn {
             padding: 12px 24px; 
             border-radius: 50px; 
             text-decoration: none;
             color: #666; 
             font-weight: 600; 
             transition: all 0.3s; 
             font-family: 'Mulish', sans-serif; 
             border: 2px solid #e8ecf1; 
             background: #f8f9fc; 
             cursor: pointer; 
            }
        .admin-filter-btn:hover { 
            background: #e8ecf1; 
            transform: translateY(-2px); 
        }
        .admin-filter-btn.active { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
            border-color: transparent; 
        }
        .admin-story-item { 
            border: 1px solid #e8ecf1; 
            border-radius: 20px; 
            padding: 25px; 
            margin-bottom: 20px; 
            transition: all 0.3s; 
        }
        .admin-story-item:hover { 
            box-shadow: 0 5px 20px rgba(0,0,0,0.08); 
            transform: translateY(-2px); 
        }
        .admin-story-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start; 
            margin-bottom: 15px; 
            flex-wrap: wrap; 
            gap: 15px; 
        }
        .admin-story-author-info { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
        }
        .admin-story-avatar {
             width: 45px; 
             height: 45px; 
             border-radius: 50%; 
             background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
             color: white; 
             display: flex; 
             align-items: center; 
             justify-content: center; 
             font-weight: 700; 
             font-size: 1.2rem; 
            }
        .admin-story-author-name { 
            font-weight: 700; 
            color: #1b5031; 
            font-size: 1.1rem; 
        }
        .admin-story-city { 
            color: #666; 
            font-size: 0.95rem; 
        }
        .admin-story-category { 
            padding: 6px 16px; 
            border-radius: 30px; 
            font-size: 0.85rem; 
            font-weight: 600; 
            background: #f0fff4; 
            color: #2e8d53; 
            border: 1px solid #d4f0e4; 
        }
        .admin-story-title { 
            font-size: 1.2rem; 
            font-weight: 700; 
            color: #1b5031; 
            margin: 12px 0 8px; 
        }
        .admin-story-text { 
            color: #555; 
            line-height: 1.7; 
            margin: 10px 0; 
            font-size: 1rem; 
        }
        .admin-story-place { 
            background: linear-gradient(135deg, #f8f9fc 0%, #e8ecf1 100%); 
            padding: 12px 16px; 
            border-radius: 14px; 
            margin: 12px 0; 
        }
        .admin-story-place-name { 
            font-weight: 700; 
            color: #1b5031; 
            font-size: 0.95rem; 
        }
        .admin-story-place-address { 
            font-size: 0.85rem; 
            color: #666; 
            margin-top: 2px; 
        }
        .admin-story-meta { 
            display: flex; 
            gap: 20px; 
            font-size: 0.9rem; 
            color: #999; 
            margin: 15px 0; 
            flex-wrap: wrap; 
        }
        .admin-story-actions { 
            display: flex; 
            gap: 12px; 
            flex-wrap: wrap; 
        }
        .admin-story-btn { 
            padding: 12px 24px; 
            border-radius: 50px;
            border: none; 
            cursor: pointer; 
            font-weight: 600;
             transition: all 0.3s; 
             font-family: 'Mulish', sans-serif; 
             display: inline-flex; 
             align-items: center; 
             gap: 8px; font-size: 0.95rem; 
             text-decoration: none; 
            }
        .admin-story-btn-delete { 
            background: #ff6b6b; 
            color: white; 
        }
        .admin-story-btn-delete:hover { 
            background: #ee5253; 
            transform: translateY(-2px); 
        }
        .admin-story-btn-edit { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 
            color: white; 
        }
        .admin-story-btn-edit:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(46,141,83,0.4); 
        }
        .admin-nav-buttons { 
            display: flex; 
            gap: 15px; 
            justify-content: center; 
            margin-top: 30px; 
        }
        .admin-nav-btn { 
            padding: 14px 32px; 
            border-radius: 50px; 
            font-weight: 600; 
            transition: all 0.3s; 
            font-family: 'Mulish', sans-serif; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-size: 1rem; 
            text-decoration: none; 
        }
        .admin-nav-btn-primary { 
            background: linear-gradient(135deg, #266d59 0%, #3a8340 100%); 

            color: white; }
        .admin-nav-btn-primary:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(46,141,83,0.4); 
        }
        .admin-nav-btn-secondary { 
            background: #f8f9fc; 
            color: #666; 
            border: 2px solid #e8ecf1; 
        }
        .admin-nav-btn-secondary:hover { 
            background: #e8ecf1; 
            transform: translateY(-2px); 
        }
        .empty-state { 
            text-align: center; 
            padding: 60px 20px; 
        }
        .empty-state i { 
            font-size: 3rem;
             color: #ccc; 
             margin-bottom: 15px; 
            }
        .empty-state h3 { 
            color: #999; 
            font-weight: 600; 
        }
        @media (max-width: 768px) { 
            .admin-stories {
                 margin: 60px auto; 
                } 
                .admin-page-header h1 { 
                    font-size: 1.8rem; 
                }
                 .admin-card { 
                    padding: 20px;
                 } 
                 .admin-story-header { 
                    flex-direction: column; 
                } 
            }
    </style>
</head>
<body>
    <div class="admin-stories">
        <div class="admin-page-header">
            <h1><i class="bi bi-journal-text"></i> Модерация историй</h1>
            <p>Управляйте историями местных жителей из locals</p>
        </div>

        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="admin-stat-value" id="statTotal">0</div>
                <div class="admin-stat-label">Всего историй</div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-value" id="statSPb">0</div>
                <div class="admin-stat-label">Санкт-Петербург</div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-value" id="statKgd">0</div>
                <div class="admin-stat-label">Калининград</div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-value" id="statOther">0</div>
                <div class="admin-stat-label">Другие города</div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-filters">
                <button class="admin-filter-btn active" onclick="setFilter('all')" id="filter-all">
                    <i class="bi bi-grid"></i> Все истории
                </button>
                <button class="admin-filter-btn" onclick="setFilter('saint-petersburg')" id="filter-spb">
                    <i class="bi bi-building"></i> Санкт-Петербург
                </button>
                <button class="admin-filter-btn" onclick="setFilter('kaliningrad')" id="filter-kgd">
                    <i class="bi bi-water"></i> Калининград
                </button>
            </div>

            <div id="storiesList"></div>
        </div>

        <div class="admin-nav-buttons">
            <a href="dashboard.php" class="admin-nav-btn admin-nav-btn-secondary"><i class="bi bi-arrow-left"></i> Назад в панель</a>
            <a href="../locals.php" class="admin-nav-btn admin-nav-btn-primary"><i class="bi bi-journal-text"></i> На страницу</a>
        </div>
    </div>

    <script>
        const cityNames = {
            'saint-petersburg': 'Санкт-Петербург',
            'kaliningrad': 'Калининград',
            'moscow': 'Москва',
            'sochi': 'Сочи'
        };
        const categoryNames = {
            coffee: 'Кофе', walk: 'Прогулки', secret: 'Секретное',
            romantic: 'Романтика', food: 'Еда', view: 'Виды'
        };

        let currentFilter = 'all';

        function loadStories() {
            return JSON.parse(localStorage.getItem('locals_stories')) || [];
        }

        function saveStories(stories) {
            localStorage.setItem('locals_stories', JSON.stringify(stories));
        }

        function updateStats(stories) {
            document.getElementById('statTotal').textContent = stories.length;
            document.getElementById('statSPb').textContent = stories.filter(s => s.city === 'saint-petersburg').length;
            document.getElementById('statKgd').textContent = stories.filter(s => s.city === 'kaliningrad').length;
            document.getElementById('statOther').textContent = stories.filter(s => s.city !== 'saint-petersburg' && s.city !== 'kaliningrad').length;
        }

        function setFilter(filter) {
            currentFilter = filter;
            document.querySelectorAll('.admin-filter-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('filter-' + (filter === 'all' ? 'all' : filter === 'saint-petersburg' ? 'spb' : 'kgd')).classList.add('active');
            renderStories();
        }

        function deleteStory(id) {
            let stories = loadStories().filter(s => s.id !== id);
            saveStories(stories);
            renderStories();
            updateStats(stories);
        }

        function renderStories() {
            let stories = loadStories();
            updateStats(stories);

            if (currentFilter !== 'all') {
                stories = stories.filter(s => s.city === currentFilter);
            }

            const container = document.getElementById('storiesList');

            if (stories.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h3>Историй не найдено</h3>
                    </div>`;
                return;
            }

            container.innerHTML = stories.map(story => `
                <div class="admin-story-item">
                    <div class="admin-story-header">
                        <div class="admin-story-author-info">
                            <div class="admin-story-avatar">${story.author.charAt(0).toUpperCase()}</div>
                            <div>
                                <div class="admin-story-author-name">${story.author}</div>
                                <div class="admin-story-city"><i class="bi bi-geo-alt"></i> ${story.cityName || cityNames[story.city] || story.city}</div>
                            </div>
                        </div>
                        <span class="admin-story-category">
                            <i class="bi bi-tag"></i> ${categoryNames[story.category] || story.category}
                        </span>
                    </div>

                    <div class="admin-story-title">${story.title}</div>
                    <p class="admin-story-text">${story.text}</p>

                    <div class="admin-story-place">
                        <div class="admin-story-place-name"><i class="bi bi-shop"></i> ${story.placeName}</div>
                        <div class="admin-story-place-address"><i class="bi bi-geo-alt"></i> ${story.placeAddress}</div>
                    </div>

                    <div class="admin-story-meta">
                        <span><i class="bi bi-calendar"></i> ${story.date}</span>
                        <span><i class="bi bi-heart"></i> ${story.likes} лайков</span>
                        <span><i class="bi bi-hash"></i> ID: ${story.id}</span>
                    </div>

                    <div class="admin-story-actions">
                        <button class="admin-story-btn admin-story-btn-delete" onclick="deleteStory(${story.id})">
                            <i class="bi bi-trash"></i> Удалить
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // Загружаем при старте
        renderStories();
    </script>
</body>
</html>
