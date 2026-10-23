<?php
if (!isset($_COOKIE['User'])) {
    header("Location: login.php");
    exit();
}
require_once('db.php');
$link = mysqli_connect('127.0.0.1', 'root', 'Qwe123123', 'first');

if (isset($_POST['submit'])) {
    $title     = $_POST['title'];
    $main_text = $_POST['text'];

    if (!$title || !$main_text) {
        die("Заполните все поля");
    }

    // УЯЗВИМОСТЬ SQLi — прямая подстановка
    $sql = "INSERT INTO posts (title, main_text) VALUES ('$title', '$main_text')";
    if (!mysqli_query($link, $sql)) {
        die("Не удалось добавить пост");
    }

    // УЯЗВИМОСТЬ PHPi — проверка только по Content-Type
    if (!empty($_FILES["file"]["name"])) {
        if (((@$_FILES["file"]["type"] == "image/gif") ||
             (@$_FILES["file"]["type"] == "image/jpeg") ||
             (@$_FILES["file"]["type"] == "image/jpg") ||
             (@$_FILES["file"]["type"] == "image/pjpeg") ||
             (@$_FILES["file"]["type"] == "image/x-png") ||
             (@$_FILES["file"]["type"] == "image/png")) &&
             (@$_FILES["file"]["size"] < 102400)) {

            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
            $fname = $_FILES["file"]["name"];
            // сохраним имя файла в посте
            $id = mysqli_insert_id($link);
            mysqli_query($link, "UPDATE posts SET filename='$fname' WHERE id=$id");
            echo "Load in: upload/" . $fname;
        } else {
            echo "upload failed!";
        }
    }

    echo "Пост успешно добавлен!";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт-визитка: Косткин Ярослав Алексеевич</title>
    <link rel="icon" type="image/jpeg" href="logo160x160.jpg">
    <!-- 1. Подключение нестандартного шрифта (Google Fonts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- 2. Подключение Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 3. Подключение ваших собственных стилей -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Логотип сайта -->
    <div class="logo-container">
        <!-- Замените logo.png на ваш файл логотипа, или используйте текст -->
        <img src="logo160x160.jpg" alt="Логотип" class="site-logo">
        <span class="logo-text">MyPortfolio</span>
		
		<!-- Кнопка смены темы (по умолчанию иконка луны) -->
		<button id="theme-toggle" class="theme-btn" title="Сменить тему">🌙</button>
    </div>

    <!-- Верхняя строка с информацией о ФИО -->
    <header class="container text-center py-4">
        <h1 class="display-5 fw-bold">Информация о Разработчике</h1>
    </header>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                
                <!-- 4. ВАЖНО: Картинка теперь добавляется через CSS (фон этого div) -->
                <div class="my-photo-css"></div>
                
                <p class="name-text fs-4 fw-bold mt-3">Косткин Ярослав Алексеевич</p>
                
                <section class="about-section mt-4 p-4 bg-light rounded">
                    <h2>Обо мне</h2>
                    <p>Я, начинающий веб-разработчик(котик). Изучаю HTML, CSS, JavaScript и основы работы с серверами. Люблю решать сложные задачи и создавать удобные интерфейсы.</p>
                </section>

                <section class="skills-section mt-4 p-4 bg-light rounded">
					<div class="skills-container">
						<!-- Левая часть: Текст о навыках -->
						<div class="skills-text">
							<h2>Мои навыки</h2>
							<ul class="list-group list-group-flush text-start">
								<li class="list-group-item bg-light">HTML и семантическая верстка</li>
								<li class="list-group-item bg-light">CSS и адаптивный дизайн</li>
								<li class="list-group-item bg-light">Основы JavaScript</li>
								<li class="list-group-item bg-light">Работа с Git</li>
								<li class="list-group-item bg-light">Походы к холодильнику</li>
								<li class="list-group-item bg-light">Вайб кукодинг</li>
							</ul>
						</div>
						
						<!-- Правая часть: Картинка через CSS -->
						<div class="photo-wrapper">
							<div class="my-photo-css skills-photo" id="cat-button"></div>
							
						</div>
					</div>
				</section>
				<!-- === ФОРМА СОЗДАНИЯ ПОСТА === -->
				<section class="post-form-section mt-4 p-4 bg-light rounded">
					<h2>Создать пост</h2>
					<form method="POST" action="/profile.php" enctype="multipart/form-data" name="upload">
						<div class="mb-3">
							<label class="form-label">Заголовок</label>
							<input type="text" name="title" class="form-control" required>
						</div>
						<div class="mb-3">
							<label class="form-label">Текст поста</label>
							<textarea name="text" class="form-control" rows="4" required></textarea>
						</div>
						<div class="mb-3">
							<label class="form-label">Картинка (до 100 КБ)</label>
							<input type="file" name="file" class="form-control">
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Сохранить</button>
					</form>
				</section>
            </div>
        </div>
    </main>
    <script src="script.js"></script>
    <!-- Bootstrap JS (опционально, для интерактивных компонентов) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Контейнер для полноэкранной гифки -->
	<div class="fullscreen-gif" id="fullscreen-gif">
		<img src="celebration.gif" alt="Празднование">
	</div>

</html>
</body>
</html>