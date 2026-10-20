<?php
// Проверяем наличие куки 'User'
if (!isset($_COOKIE['User'])) {
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Требуется авторизация</title>
    <!-- Подключаем ваши стили -->
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        /* Принудительно темная тема для страницы авторизации по умолчанию */
        body {
            background-color: #2c2c2c !important;
            color: #ffffff !important;
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        /* Контейнер авторизации */
        .auth-container {
            background-color: #1a1a1a;
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border: 2px solid #3a3a3a;
        }
        
        .auth-container h1 {
            color: #ffffff;
            margin-bottom: 30px;
            font-weight: 700;
        }
        
        .auth-container p {
            color: #cccccc;
            font-size: 1.2rem;
            margin-bottom: 40px;
        }
        
        /* Стили для ссылок */
        .auth-container a {
            color: #6cb4ff;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            padding: 12px 30px;
            border: 2px solid #6cb4ff;
            border-radius: 10px;
            display: inline-block;
            margin: 10px;
        }
        
        .auth-container a:hover {
            background-color: #6cb4ff;
            color: #1a1a1a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 180, 255, 0.3);
        }
        
        /* Кнопка смены темы */
        .theme-toggle-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ffffff;
            border: 2px solid #ffffff;
            color: #1a1a1a;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .theme-toggle-btn:hover {
            background-color: #e0e0e0;
            transform: scale(1.1);
        }
        
        /* Светлая тема (переключаемая) */
        body.light-theme {
            background-color: #f8f9fa !important;
            color: #333333 !important;
        }
        
        body.light-theme .auth-container {
            background-color: #ffffff;
            border-color: #dee2e6;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        body.light-theme .auth-container h1 {
            color: #333333;
        }
        
        body.light-theme .auth-container p {
            color: #666666;
        }
        
        body.light-theme .auth-container a {
            color: #0d6efd;
            border-color: #0d6efd;
        }
        
        body.light-theme .auth-container a:hover {
            background-color: #0d6efd;
            color: #ffffff;
        }
        
        body.light-theme .theme-toggle-btn {
            background-color: #343a40;
            border-color: #343a40;
            color: #ffffff;
        }
        
        body.light-theme .theme-toggle-btn:hover {
            background-color: #495057;
        }
        
        /* Логотип */
        .auth-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 3px solid #6cb4ff;
        }
    </style>
</head>
<body>
    <!-- Кнопка смены темы -->
    <button class="theme-toggle-btn" id="theme-toggle" title="Сменить тему">☀️</button>
    
    <div class="auth-container">
        <!-- Логотип -->
        <img src="logo160x160.jpg" alt="Логотип" class="auth-logo">
        
        <h1>Доступ ограничен</h1>
        <p>
            <a href="/registration.php">Зарегистрируйтесь</a> 
            или 
            <a href="/login.php">войдите</a>, 
            чтобы просматривать контент!
        </p>
    </div>

    <!-- Скрипт для переключения темы -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeBtn = document.getElementById('theme-toggle');
            const body = document.body;
            
            // Проверяем сохраненную тему
            const savedTheme = localStorage.getItem('theme');
            
            // Если сохранена светлая тема, применяем её
            if (savedTheme === 'light') {
                body.classList.add('light-theme');
                themeBtn.textContent = '';
            }
            
            // Обработчик клика на кнопку
            themeBtn.addEventListener('click', () => {
                body.classList.toggle('light-theme');
                
                if (body.classList.contains('light-theme')) {
                    themeBtn.textContent = '🌙';
                    localStorage.setItem('theme', 'light');
                } else {
                    themeBtn.textContent = '☀️';
                    localStorage.setItem('theme', 'dark');
                }
            });
        });
    </script>
</body>
</html>
<?php
} else {
    // Если куки есть, показываем основной контент
    include 'profile.php';
}
?>
