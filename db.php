<?php
$servername = "127.0.0.1";
$username   = "root";          // замени на своего пользователя
$password   = "Qwe123123";      // замени на свой пароль
$dbName     = "first";         // имя БД (как в задании)

// Подключение к серверу
$link = mysqli_connect($servername, $username, $password);
if (!$link) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Создание БД
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if (!mysqli_query($link, $sql)) {
    echo "Не удалось создать БД";
}
mysqli_close($link);

// Подключение к созданной БД
$link = mysqli_connect($servername, $username, $password, $dbName);
if (!$link) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
}

// Таблица пользователей
$sql = "CREATE TABLE IF NOT EXISTS users(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(15) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(20) NOT NULL
)";
if (!mysqli_query($link, $sql)) {
    echo "Не удалось создать таблицу Users";
}

// Таблица постов (добавляем поле filename для файлов из PHPi)
$sql = "CREATE TABLE IF NOT EXISTS posts(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    main_text TEXT NOT NULL,
    filename VARCHAR(255) DEFAULT NULL
)";
if (!mysqli_query($link, $sql)) {
    echo "Не удалось создать таблицу Posts";
}

mysqli_close($link);
?>
