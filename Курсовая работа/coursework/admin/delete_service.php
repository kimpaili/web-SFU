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

if (isset($_GET['id'])) {
    $service_id = intval($_GET['id']);

    $mysqli = new mysqli("localhost", "root", "", "animal_salon");

    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("DELETE FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);

    if ($stmt->execute()) {
        header("Location: services.php");
    } else {
        echo "Ошибка при удалении услуги: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
} else {
    header("Location: services.php");
    exit;
}
?>
