<?php
require_once('db.php');

$link = mysqli_connect('127.0.0.1', 'root', 'Qwe123123', 'first');

if (isset($_COOKIE['User'])) {
    header("Location: profile.php");
    exit();
}

if (isset($_POST['submit'])) {
    $login = $_POST['login'];
    $pass  = $_POST['password'];

    if (!$login || !$pass) {
        die('Пожалуйста введите все значения!');
    }

    // УЯЗВИМОСТЬ SQLi — конкатенация напрямую
    $sql = "SELECT * FROM users WHERE username='$login' AND password='$pass'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) == 1) {
        setcookie("User", $login, time() + 7200, "/");
        header('Location: profile.php');
        exit();
    } else {
        echo "Не правильное имя или пароль";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5" style="max-width:500px;">
    <h2 class="text-center">Вход</h2>
    <form method="POST" action="/login.php">
        <div class="mb-3">
            <label>Логин</label>
            <input type="text" name="login" class="form-control">
        </div>
        <div class="mb-3">
            <label>Пароль</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Войти</button>
    </form>
    <p class="mt-3 text-center"><a href="/registration.php">Нет аккаунта? Зарегистрироваться</a></p>
</div>
</body>
</html>