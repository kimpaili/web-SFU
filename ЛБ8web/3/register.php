<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["name"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $birthdate = $_POST["birth"];
    echo "Регистрация завершена";
}
    ?>