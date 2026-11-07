<?php
$servername = "mysql";
$username   = "researchlab_user";
$password   = "researchlab_pass";
$dbName     = "researchlab";

// 1. Подключение к серверу и сразу к БД
$link = mysqli_connect($servername, $username, $password, $dbName);

if (!$link) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
}

// 2. Создание таблиц ТОЛЬКО если их еще нет (данные не удаляются!)
$sql_users = "CREATE TABLE IF NOT EXISTS users(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($link, $sql_users);

$sql_posts = "CREATE TABLE IF NOT EXISTS posts(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    main_text TEXT NOT NULL,
    filename VARCHAR(255) DEFAULT NULL
)";
mysqli_query($link, $sql_posts);

// ВАЖНО: Мы НЕ вызываем mysqli_close(), чтобы $link был доступен во всех файлах!
?>
