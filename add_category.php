<?php
session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName'];

    // Подготовка запроса
    $stmt = $conn->prepare("INSERT INTO categories (CategoryName) VALUES (?)");
    $stmt->bind_param("s", $categoryName);

    // Выполнение запроса
    if ($stmt->execute()) {
        echo "Категория успешно добавлена.";
    } else {
        echo "Ошибка при добавлении категории: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
