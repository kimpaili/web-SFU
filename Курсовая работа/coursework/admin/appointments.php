<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../main.php"); // Возврат на страницу входа
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../main.php"); // Возврат на страницу входа, если роль не admin
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "animal_salon");

if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

$result = $mysqli->query("
    SELECT 
        appointments.id, 
        users.first_name, 
        users.last_name, 
        services.name AS service_name, 
        appointments.appointment_date, 
        appointments.appointment_time
    FROM appointments
    JOIN users ON appointments.user_id = users.id
    JOIN services ON appointments.service_id = services.id
");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записи</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="admin-panel">
        <nav>
            <a href="create_service.html">Создать услугу</a>
            <a href="services.php">Услуги</a>
            <a href="clients.php">Пользователи</a>
            <a href="appointments.php" class="active">Записи</a>
            <a href="reviews.php">Отзывы</a>
            <a href="logout.php">Выход</a>
        </nav>
        <div class="content">
            <h1>Записи</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя пользователя</th>
                        <th>Услуга</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($appointment = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $appointment['id'] ?></td>
                            <td><?= htmlspecialchars($appointment['last_name'] . ' ' . $appointment['first_name']) ?></td>
                            <td><?= htmlspecialchars($appointment['service_name']) ?></td>
                            <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                            <td><?= htmlspecialchars($appointment['appointment_time']) ?></td>
                            <td>
                                <a href="edit_appointment.php?id=<?= $appointment['id'] ?>">Редактировать</a>
                                <a href="delete_appointment.php?id=<?= $appointment['id'] ?>" onclick="return confirm('Удалить запись?')">Удалить</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php $mysqli->close(); ?>
