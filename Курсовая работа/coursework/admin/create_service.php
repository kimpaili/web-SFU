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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $price = $_POST['price'];
    $available_times = $_POST['available_times']; 

    $mysqli = new mysqli("localhost", "root", "", "animal_salon");

    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("INSERT INTO services (name, description, price, start_date, end_date, available_times) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsss", $name, $description, $price, $start_date, $end_date, $available_times);

    if ($stmt->execute()) {
        header("Location: services.php");
    } else {
        echo "Ошибка при создании услуги: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>