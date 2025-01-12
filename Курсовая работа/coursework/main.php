<?php
session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Успешная аутентификация
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;

            // Редирект на страницу в зависимости от роли
            if ($role === 'admin') {
                header("Location: admin/services.php");
            } elseif ($role === 'user') {
                header("Location: user/user_services.php");
            } else {
                // На случай неизвестной роли
                $error_message = "Неизвестная роль пользователя.";
            }
            exit;
        } else {
            // Неверный пароль
            $error_message = "Неверный пароль.";
        }
    } else {
        // Пользователь не найден
        $error_message = "Пользователь с таким email не найден.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOPA Salon</title>
    <link rel="stylesheet" href="assets/css/main_style.css">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <h1>SOPA Salon ♡</h1>
            <p>Soft Paws Salon</p>
        </div>
        <nav class="header-right">
            <a href="#login">Войти</a>
            <a href="#about">О салоне</a>
            <a href="#contacts">Контакты</a>
        </nav>
    </header>

    <section id="login" class="login-section">
        <div class="login-container">
            <h2>Вход</h2>
            <form action="main.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Войти</button>
                <p><a class=reg href="user\register.html">Регистрация</a></p>
            </form>
        </div>
    </section>

    <section id="about" class="about-section">
        <h2>О салоне</h2>
        <p>Добро пожаловать в SOPA Salon – лучший салон красоты для ваших питомцев! Мы предлагаем профессиональный уход за шерстью, стрижки и многое другое.</p>
        <p>Наши услуги выбирают тысячи довольных клиентов. Присоединяйтесь к ним и подарите своему питомцу безупречный вид!</p>
    </section>

    <section id="contacts" class="contacts-section">
        <h2>Контакты</h2>
        <p>+7(391)000-66-11 – Гастюнина Полина Владимировна ♡ tg - @sopasalon ♡ 2024-2025</p>
    </section>
</body>
</html>
