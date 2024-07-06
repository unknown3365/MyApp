<?php
session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brandName = $_POST['brandName'];

    // Подготовка запроса
    $stmt = $conn->prepare("INSERT INTO brands (BrandName) VALUES (?)");
    $stmt->bind_param("s", $brandName);

    // Выполнение запроса
    if ($stmt->execute()) {
        echo "Бренд успешно добавлен.";
    } else {
        echo "Ошибка при добавлении бренда: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
