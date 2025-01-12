<?php
// Подключение к базе данных
$host = 'localhost'; // Хост сервера
$username = 'root'; // Имя пользователя MySQL
$password = ''; // Пароль пользователя MySQL
$dbname = 'animal_salon'; // Имя базы данных

// Создаем соединение
$conn = new mysqli($host, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
?>
