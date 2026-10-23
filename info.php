<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "PHP OK<br>";
echo "MySQL extension: " . (extension_loaded('mysqli') ? "OK" : "НЕТ") . "<br>";

$link = @mysqli_connect('127.0.0.1', 'root', 'Qwe123123', 'first');
if (!$link) {
    echo "Ошибка подключения: " . mysqli_connect_error();
} else {
    echo "Подключение к БД OK";
}
