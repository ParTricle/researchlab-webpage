<?php
if (!isset($_COOKIE['User'])) {
    header("Location: login.php");
    exit();
}
require_once('db.php'); // $link уже здесь и работает!

if (isset($_POST['submit'])) {
    // 1. Защита от XSS: удаляем HTML теги
    $title     = strip_tags($_POST['title']);
    $main_text = strip_tags($_POST['text']);

    if (!$title || !$main_text) {
        die("Заполните все поля");
    }

    // 2. Защита от SQLi: экранируем данные
    $title_safe     = mysqli_real_escape_string($link, $title);
    $main_text_safe = mysqli_real_escape_string($link, $main_text);

    $sql = "INSERT INTO posts (title, main_text) VALUES ('$title_safe', '$main_text_safe')";
    if (!mysqli_query($link, $sql)) {
        die("Не удалось добавить пост: " . mysqli_error($link));
    }

    // 3. Защита от PHPi: правильная проверка файла
    if (!empty($_FILES["file"]["name"])) {
        $errors = [];
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Ошибка при загрузке файла.';
        }

        // Проверка реального MIME-типа (не доверяем $_FILES["file"]["type"])
        $allowedTypes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $_FILES['file']['tmp_name']);
        finfo_close($finfo);

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Недопустимый тип файла.';
        }

        // Проверка реального размера
        $maxFileSize = 102400; // 100 КБ
        $realFileSize = filesize($_FILES['file']['tmp_name']);
        if ($realFileSize > $maxFileSize) {
            $errors[] = 'Файл слишком большой (макс. 100 КБ).';
        }

        if (empty($errors)) {
            $tempPath = $_FILES['file']['tmp_name'];
            $newFilename = uniqid() . '_' . basename($_FILES['file']['name']);
            $destinationPath = 'upload/' . $newFilename;

            if (move_uploaded_file($tempPath, $destinationPath)) {
                $id = mysqli_insert_id($link);
                $fname_safe = mysqli_real_escape_string($link, $newFilename);
                mysqli_query($link, "UPDATE posts SET filename='$fname_safe' WHERE id=$id");
                echo "Файл загружен успешно: " . $destinationPath . "<br>";
            } else {
                $errors[] = 'Не удалось переместить файл.';
            }
        }
        
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . '<br>';
            }
        }
    }
    echo "Пост успешно добавлен!<br>";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Сайт-визитка: Косткин Ярослав Алексеевич</title>
<link rel="icon" type="image/jpeg" href="logo160x160.jpg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="logo-container">
<img src="logo160x160.jpg" alt="Логотип" class="site-logo">
<span class="logo-text">MyPortfolio</span>
<button id="theme-toggle" class="theme-btn" title="Сменить тему">🌙</button>
</div>
<header class="container text-center py-4">
<h1 class="display-5 fw-bold">Информация о Разработчике</h1>
</header>
<main class="container">
<div class="row justify-content-center">
<div class="col-md-8 text-center">
<div class="my-photo-css"></div>
<div class="text-center mt-4 mb-2">
<a href="/index.php" class="btn btn-success btn-lg">📖 Перейти ко всем постам</a>
</div>
<p class="name-text fs-4 fw-bold mt-3">Косткин Ярослав Алексеевич</p>
<section class="about-section mt-4 p-4 bg-light rounded">
<h2>Обо мне</h2>
<p>Я, начинающий веб-разработчик(котик). Изучаю HTML, CSS, JavaScript и основы работы с серверами. Люблю решать сложные задачи и создавать удобные интерфейсы.</p>
</section>
<section class="skills-section mt-4 p-4 bg-light rounded">
<div class="skills-container">
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
<div class="photo-wrapper">
<div class="my-photo-css skills-photo" id="cat-button"></div>
</div>
</div>
</section>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="fullscreen-gif" id="fullscreen-gif">
<img src="celebration.gif" alt="Празднование">
</div>
</body>
</html>
