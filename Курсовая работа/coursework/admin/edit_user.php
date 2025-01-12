<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../main.php"); 
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../main.php"); 
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "animal_salon");

if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    $stmt = $mysqli->prepare("SELECT id, first_name, last_name, gender, phone, email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($id, $first_name, $last_name, $gender, $phone, $email, $role);
    $stmt->fetch();
    $stmt->close();
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['id']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, gender = ?, phone = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $first_name, $last_name, $gender, $phone, $email, $role, $user_id);

    if ($stmt->execute()) {
        header("Location: clients.php");
    } else {
        echo "Ошибка при обновлении пользователя: " . $stmt->error;
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
    <title>Редактировать пользователя</title>
    <link rel="stylesheet" href="assets/css/create_s_css.css">
</head>
<body>
    <div class="container">
        <h1>Редактировать пользователя</h1>
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            <label for="first_name">Имя:</label>
            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>

            <label for="last_name">Фамилия:</label>
            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>

            <label for="gender">Пол:</label>
            <select id="gender" name="gender" required>
                <option value="Мужской" <?= $gender === 'Мужской' ? 'selected' : '' ?>>Мужской</option>
                <option value="Женский" <?= $gender === 'Женский' ? 'selected' : '' ?>>Женский</option>
            </select>

            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

            <label for="role">Роль:</label>
            <select id="role" name="role" required>
                <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>Пользователь</option>
                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Администратор</option>
            </select>

            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>
</html>
