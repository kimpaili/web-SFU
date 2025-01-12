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

// Получение текущих данных пользователя
$stmt = $mysqli->prepare("SELECT first_name, last_name, gender, phone, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $gender, $phone, $email);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_gender = $_POST['gender'];
    $new_phone = $_POST['phone'];
    $new_email = $_POST['email'];
    $redirect_url = $_POST['redirect_url']; // Получаем URL для возврата

    $update_stmt = $mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, gender = ?, phone = ?, email = ? WHERE id = ?");
    $update_stmt->bind_param("sssssi", $new_first_name, $new_last_name, $new_gender, $new_phone, $new_email, $user_id);

    if ($update_stmt->execute()) {
        header("Location: $redirect_url"); // Перенаправляем обратно
        exit;
    } else {
        $error_message = "Ошибка при обновлении данных: " . $update_stmt->error;
    }

    $update_stmt->close();
}

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать профиль</title>
    <link rel="stylesheet" href="assets/css/edit.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать профиль</h1>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        <form action="edit_profile.php" method="POST">
    <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER']) ?>">
    
    <label for="first_name">Имя</label>
    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>

    <label for="last_name">Фамилия</label>
    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>

    <label for="gender">Пол</label>
    <select id="gender" name="gender" required>
        <option value="Male" <?= $gender === 'Male' ? 'selected' : '' ?>>Мужской</option>
        <option value="Female" <?= $gender === 'Female' ? 'selected' : '' ?>>Женский</option>
    </select>

    <label for="phone">Телефон</label>
    <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

    <button type="submit">Сохранить</button>
</form>
        <div class="back-button">
        <a href="user_services.php">
            <button>Назад</button>
        </a>
        </div> 
    </div>
</body>
</html>
