<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../main.php");
    exit;
}

require '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $review_content = trim($_POST['review_content']);

    if (!empty($review_content)) {
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, content) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $review_content);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Спасибо за ваш отзыв! Он успешно отправлен.');
                    window.location.href = 'user_services.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Ошибка при отправке отзыва. Попробуйте снова.');
                    window.history.back();
                  </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
                alert('Отзыв не может быть пустым.');
                window.history.back();
              </script>";
    }
}
?>
