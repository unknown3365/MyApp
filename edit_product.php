<?php
session_start();
require_once('db.php');

// Получаем ID продукта
$productID = $_GET['id'];

// Если форма была отправлена, обновляем данные продукта
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $categoryID = $_POST['categoryID'];
    $brandID = $_POST['brandID'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];
    $description = $_POST['description'];
    $imagePath = $_POST['existingImagePath'];

    // Проверка на наличие нового файла изображения
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $imagePath = $targetFile; // Обновляем путь к изображению
    }

    $stmt = $conn->prepare("UPDATE products SET ProductName = ?, CategoryID = ?, BrandID = ?, Price = ?, StockQuantity = ?, Description = ?, ImagePath = ? WHERE ProductID = ?");
    $stmt->bind_param("siidissi", $productName, $categoryID, $brandID, $price, $stockQuantity, $description, $imagePath, $productID);
    $stmt->execute();
    $stmt->close();

    header("Location: products.php");
    exit();
}

// Получаем текущие данные продукта
$stmt = $conn->prepare("SELECT ProductName, CategoryID, BrandID, Price, StockQuantity, Description, ImagePath FROM products WHERE ProductID = ?");
$stmt->bind_param("i", $productID);
$stmt->execute();
$stmt->bind_result($productName, $categoryID, $brandID, $price, $stockQuantity, $description, $imagePath);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование продукта</title>
</head>
<body>
    <h2>Редактирование продукта</h2>
    <form action="edit_product.php?id=<?php echo $productID; ?>" method="post" enctype="multipart/form-data">
        <label for="productName">Название продукта:</label>
        <input type="text" id="productName" name="productName" value="<?php echo $productName; ?>" required><br><br>
        
        <label for="categoryID">Категория:</label>
        <input type="text" id="categoryID" name="categoryID" value="<?php echo $categoryID; ?>" required><br><br>
        
        <label for="brandID">Бренд:</label>
        <input type="text" id="brandID" name="brandID" value="<?php echo $brandID; ?>" required><br><br>
        
        <label for="price">Цена:</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo $price; ?>" required><br><br>
        
        <label for="stockQuantity">Количество на складе:</label>
        <input type="number" id="stockQuantity" name="stockQuantity" value="<?php echo $stockQuantity; ?>" required><br><br>
        
        <label for="description">Описание:</label>
        <textarea id="description" name="description" ><?php echo $description; ?></textarea><br><br>
        
        <label for="image">Изображение:</label>
        <input type="file" id="image" name="image"><br><br>
        <img src="<?php echo $imagePath; ?>" alt="Current Image" style="max-width: 100px; max-height: 100px;"><br><br>
        <input type="hidden" name="existingImagePath" value="<?php echo $imagePath; ?>">
        
        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
