<?php
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../main.php"); // Возврат на страницу входа, если роль не admin
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "animal_salon");

if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT id, name, description, price, start_date, end_date, available_times FROM services");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Услуги</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="admin-panel">
        <nav>
            <a href="create_service.html">Создать услугу</a>
            <a href="services.php" class="active">Услуги</a>
            <a href="clients.php">Пользователи</a>
            <a href="appointments.php">Записи</a>
            <a href="reviews.php">Отзывы</a>
            <a href="logout.php">Выход</a>
        </nav>
        <div class="content">
            <h1>Услуги</h1>
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Цена</th>
                        <th>Дата начала</th>
                        <th>Дата конца</th>
                        <th>Доступные времена</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($service = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($service['name']) ?></td>
                            <td><?= htmlspecialchars($service['description']) ?></td>
                            <td><?= htmlspecialchars($service['price']) ?></td>
                            <td><?= htmlspecialchars($service['start_date']) ?></td>
                            <td><?= htmlspecialchars($service['end_date']) ?></td>
                            <td><?= htmlspecialchars($service['available_times']) ?></td>
                            <td>
                                <a href="edit_service.php?id=<?= $service['id'] ?>">Редактировать</a>
                                <a href="delete_service.php?id=<?= $service['id'] ?>" onclick="return confirm('Удалить услугу?')">Удалить</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
$mysqli->close();
?>
