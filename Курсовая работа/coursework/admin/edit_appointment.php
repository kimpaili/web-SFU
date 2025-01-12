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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $appointment_id = intval($_GET['id']);

    $stmt = $mysqli->prepare("
        SELECT 
            appointments.id, 
            appointments.user_id, 
            appointments.service_id, 
            appointments.appointment_date, 
            appointments.appointment_time 
        FROM appointments
        WHERE id = ?
    ");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $stmt->bind_result($id, $user_id, $service_id, $appointment_date, $appointment_time);
    $stmt->fetch();
    $stmt->close();
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = intval($_POST['id']);
    $user_id = intval($_POST['user_id']);
    $service_id = intval($_POST['service_id']);
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $stmt = $mysqli->prepare("
        UPDATE appointments 
        SET user_id = ?, service_id = ?, appointment_date = ?, appointment_time = ? 
        WHERE id = ?
    ");
    $stmt->bind_param("iissi", $user_id, $service_id, $appointment_date, $appointment_time, $appointment_id);

    if ($stmt->execute()) {
        header("Location: appointments.php");
    } else {
        echo "Ошибка при обновлении записи: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать запись</title>
    <link rel="stylesheet" href="assets/css/create_s_css.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать запись</h1>
        <form action="edit_appointment.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            <label for="user_id">Пользователь:</label>
            <input type="number" id="user_id" name="user_id" value="<?= htmlspecialchars($user_id) ?>" required>

            <label for="service_id">Услуга:</label>
            <input type="number" id="service_id" name="service_id" value="<?= htmlspecialchars($service_id) ?>" required>

            <label for="appointment_date">Дата записи:</label>
            <input type="date" id="appointment_date" name="appointment_date" value="<?= htmlspecialchars($appointment_date) ?>" required>

            <label for="appointment_time">Время записи:</label>
            <input type="time" id="appointment_time" name="appointment_time" value="<?= htmlspecialchars($appointment_time) ?>" required>

            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>
</html>
