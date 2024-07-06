<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE ProductID=$id";
if ($conn->query($sql) === TRUE) {
    header("Location: products.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
