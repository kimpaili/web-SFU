<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../main.php");
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "animal_salon");

if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $stmt = $mysqli->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $appointment_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Запись успешно удалена.');
            window.location.href = 'user_appointments.php';
        </script>";
    } else {
        echo "Ошибка удаления записи: " . $stmt->error;
    }

    $stmt->close();
}

$stmt = $mysqli->prepare("SELECT a.id, s.name, a.appointment_date, a.appointment_time 
                          FROM appointments a
                          JOIN services s ON a.service_id = s.id
                          WHERE a.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои записи</title>
    <link rel="stylesheet" href="assets/css/user_services.css">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <h1>SOPA Salon ♡</h1>
            <p>Soft Paws Salon</p>
        </div>
        <nav class="header-right">
            <a href="user_services.php">Услуги</a>
            <a href="user_appointments.php">Записи</a>
            <a href="#review">Оставить отзыв</a>
            <a href="edit_profile.php">Изменить профиль</a>
            <a href="logout.php">Выход</a>
        </nav>
    </header>

    <section id="appointments" class="services-section">
        <h2>Мои записи</h2>
        <p style="background-color: rgba(255, 255, 255, 0.8); 
          border-radius: 8px; 
          padding: 20px; 
          display: inline-block;">Если вы хотите изменить запись, пожалуйста, позвоните нашему менеджеру ♡
        </p>

        <div class="services-container">
            <?php while ($appointment = $result->fetch_assoc()): ?>
                <div class="service">
                    <h3><?= htmlspecialchars($appointment['name']) ?></h3>
                    <p>Дата: <?= htmlspecialchars($appointment['appointment_date']) ?></p>
                    <p>Время: <?= htmlspecialchars($appointment['appointment_time']) ?></p>
                    <form action="user_appointments.php" method="POST">
                        <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                        <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить запись?');">Удалить</button>
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
