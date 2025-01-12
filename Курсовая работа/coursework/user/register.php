<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Пароли не совпадают!";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $mysqli = new mysqli("localhost", "root", "", "animal_salon");

    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("INSERT INTO users (first_name, last_name, gender, phone, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $gender, $phone, $email, $hashed_password);
    
    if ($stmt->execute()) {
        header("Location: ../main.php");
        exit;
    } else {
        echo "Ошибка при регистрации: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
