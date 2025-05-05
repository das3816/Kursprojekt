<?php
$servername = "localhost";
$username = "root";  // Если ты используешь XAMPP, то по умолчанию это root
$password = "";      // Если ты не изменял пароль, оставь пустым
$dbname = "grizetka";  // Имя базы данных

// Создаем подключение
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}
?>
