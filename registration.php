<?php
// Подключаем единую конфигурацию БД (не создаем новых соединений!)
require_once('db.php'); 

if (isset($_COOKIE['User'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!$email || !$username || !$password) {
        die('Пожалуйста введите все значения!');
    }

    // ЗАЩИТА ОТ SQLi: экранируем специальные символы
    $email_safe    = mysqli_real_escape_string($link, $email);
    $username_safe = mysqli_real_escape_string($link, $username);
    $password_safe = mysqli_real_escape_string($link, $password);

    $sql = "INSERT INTO users (email, username, password) VALUES ('$email_safe', '$username_safe', '$password_safe')";
    
    if (!mysqli_query($link, $sql)) {
        echo "Ошибка регистрации: " . mysqli_error($link);
    } else {
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Регистрация</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5" style="max-width:500px;">
<h2 class="text-center">Регистрация</h2>
<form method="POST" action="/registration.php">
<div class="mb-3">
<label>Email</label>
<input type="text" name="email" class="form-control" required>
</div>
<div class="mb-3">
<label>Логин</label>
<input type="text" name="username" class="form-control" required>
</div>
<div class="mb-3">
<label>Пароль</label>
<input type="password" name="password" class="form-control" required>
</div>
<button type="submit" name="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
</form>
<p class="mt-3 text-center"><a href="/login.php">Уже есть аккаунт? Войти</a></p>
</div>
</body>
</html>
