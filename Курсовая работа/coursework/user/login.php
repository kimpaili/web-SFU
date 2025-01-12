<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $mysqli = new mysqli("localhost", "root", "", "animal_salon");

    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: admin/services.php"); 
            } else {
                header("Location: main.php");
            }
            exit;
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь с таким email не найден!";
    }

    $stmt->close();
    $mysqli->close();
}
?>
