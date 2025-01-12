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
        reviews.id, 
        users.first_name, 
        users.last_name, 
        reviews.content, 
        reviews.created_at 
    FROM reviews
    JOIN users ON reviews.user_id = users.id
    ORDER BY reviews.created_at DESC
");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $review_id = intval($_POST['delete_id']);
    $stmt = $mysqli->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $review_id);

    if ($stmt->execute()) {
        header("Location: reviews.php");
        exit;
    } else {
        echo "Ошибка при удалении отзыва: " . $stmt->error;
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
    <title>Отзывы</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="admin-panel">
        <nav>
            <a href="create_service.html">Создать услугу</a>
            <a href="services.php">Услуги</a>
            <a href="clients.php">Пользователи</a>
            <a href="appointments.php">Записи</a>
            <a href="reviews.php" class="active">Отзывы</a>
            <a href="logout.php">Выход</a>
        </nav>
        <div class="content">
            <h1>Отзывы</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя пользователя</th>
                        <th>Отзыв</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($review = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $review['id'] ?></td>
                            <td><?= htmlspecialchars($review['first_name']) . ' ' . htmlspecialchars($review['last_name']) ?></td>
                            <td><?= htmlspecialchars($review['content']) ?></td>
                            <td><?= htmlspecialchars($review['created_at']) ?></td>
                            <td>
                                <form action="reviews.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?= $review['id'] ?>">
                                    <button type="submit" onclick="return confirm('Удалить этот отзыв?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
