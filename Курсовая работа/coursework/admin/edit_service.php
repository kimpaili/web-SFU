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
    $service_id = intval($_GET['id']);

    $stmt = $mysqli->prepare("SELECT name, description, price, start_date, end_date, available_times FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $stmt->bind_result($name, $description, $price, $start_date, $end_date, $available_times);
    $stmt->fetch();
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = intval($_POST['id']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $available_times = $_POST['available_times'];

    $stmt = $mysqli->prepare("UPDATE services SET name = ?, description = ?, price = ?, start_date = ?, end_date = ?, available_times = ? WHERE id = ?");
    $stmt->bind_param("ssdsssi", $name, $description, $price, $start_date, $end_date, $available_times, $service_id);

    if ($stmt->execute()) {
        header("Location: services.php");
    } else {
        echo "Ошибка при обновлении услуги: " . $stmt->error;
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
    <title>Редактировать услугу</title>
    <link rel="stylesheet" href="assets/css/create_s_css.css">
</head>
<body>
    <div class="back-button">
        <a href="services.php">
            <button>Назад</button>
        </a>
    </div>
    <div class="container">
        <h1>Редактировать услугу</h1>
        <form action="edit_service.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($service_id) ?>">
            
            <label for="name">Название:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
            
            <label for="description">Описание:</label>
            <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($description) ?></textarea>
            
            <label for="start_date">Дата начала действия:</label>
            <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" required>
            
            <label for="end_date">Дата конца действия:</label>
            <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" required>
            
            <label for="price">Цена:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($price) ?>" required>

            <label for="available_times">Доступные временные интервалы (через запятую):</label>
            <input type="text" id="available_times" name="available_times" value="<?= htmlspecialchars($available_times) ?>" required>
            
            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>
</html>
