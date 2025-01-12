<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../main.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mysqli = new mysqli("localhost", "root", "", "animal_salon");

    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $service_id = $mysqli->real_escape_string($_POST['service_id']);
    $appointment_date = $mysqli->real_escape_string($_POST['appointment_date']);
    $appointment_time = $mysqli->real_escape_string($_POST['appointment_time']);

    $query = "SELECT * FROM appointments 
              WHERE service_id = ? 
              AND appointment_date = ? 
              AND appointment_time = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iss", $service_id, $appointment_date, $appointment_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
            alert('Извините, это время уже занято. Пожалуйста, выберите другое время или дату.');
            window.history.back();
        </script>";
    } else {
        $insert_query = "INSERT INTO appointments (user_id, service_id, appointment_date, appointment_time) 
                         VALUES (?, ?, ?, ?)";
        $insert_stmt = $mysqli->prepare($insert_query);
        $insert_stmt->bind_param("iiss", $user_id, $service_id, $appointment_date, $appointment_time);

        if ($insert_stmt->execute()) {
            echo "<script>
                alert('Запись успешно создана! Спасибо за выбор нашего салона.');
                window.location.href = 'user_services.php'; // Возврат на пользовательскую страницу
            </script>";
        } else {
            echo "<script>
                alert('Ошибка при создании записи. Пожалуйста, попробуйте снова.');
                window.history.back();
            </script>";
        }
        $insert_stmt->close();
    }

    $stmt->close();
    $mysqli->close();
} else {
    header("Location: ../main.php");
    exit;
}
