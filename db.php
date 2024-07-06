<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electronics_store";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
