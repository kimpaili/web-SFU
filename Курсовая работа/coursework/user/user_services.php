<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../main.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интерфейс пользователя</title>
    <link rel="stylesheet" href="assets/css/user_services.css">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <h1>SOPA Salon ♡</h1>
            <p>Soft Paws Salon</p>
        </div>
        <nav class="header-right">
            <a href="#services">Услуги</a>
            <a href="user_appointments.php">Записи</a>
            <a href="#review">Оставить отзыв</a>
            <a href="edit_profile.php">Изменить профиль</a>
            <a href="logout.php">Выход</a>
        </nav>
    </header>


    <section id="services" class="services-section">
        <h2 class="serv_h2">Запишитесь к нам 🐇 мы позаботимся о Вашем питомце!!</h2>
        <div class="services-container">

            <?php
            $mysqli = new mysqli("localhost", "root", "", "animal_salon");

            if ($mysqli->connect_error) {
                die("Ошибка подключения: " . $mysqli->connect_error);
            }

            $result = $mysqli->query("SELECT * FROM services");
            while ($service = $result->fetch_assoc()): ?>
                <div class="service">
                    <h3><?= $service['name'] ?></h3>
                    <p>Цена: <?= $service['price'] ?> ₽</p>
                    <form action="book_service.php" method="POST">
                        <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                        <label for="appointment_date">Дата:</label>
                        <input type="date" name="appointment_date" required>
                        <label for="appointment_time">Время:</label>
                        <select name="appointment_time" required>
                            <?php
                            $times = explode(',', $service['available_times']);
                            foreach ($times as $time) {
                                echo "<option value='$time'>$time</option>";
                            }
                            ?>
                        </select>
                        <button type="submit">Записаться</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section id="review" class="review-section">
    <h2>Оставить отзыв ୨୧</h2>
    <form action="submit_review.php" method="POST">
        <textarea name="review_content" rows="5" placeholder="Ваш отзыв..." required></textarea>
        <button type="submit">♡ Отправить ♡</button>
    </form>
    </section>

    <footer class="contacts-section">
        <p>+7 (391) 000-66-11 – Гастюнина Полина Владимировна ♡ tg - @sopasalon ♡ 2024-2025</p>
    </footer>
</body>
</html>
