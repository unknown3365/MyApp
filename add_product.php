<?php
session_start();
require_once('db.php');

// Обработка POST-запроса для добавления нового продукта
$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $categoryID = intval($_POST['categoryID']); // Преобразуем в целое число
    $brandID = intval($_POST['brandID']); // Преобразуем в целое число
    $price = floatval($_POST['price']); // Преобразуем в число с плавающей точкой
    $stockQuantity = intval($_POST['stockQuantity']); // Преобразуем в целое число
    $description = $_POST['description'];

    // Обработка загрузки изображения
    $imagePath = ''; // По умолчанию
    if ($_FILES['image']['error'] === 0) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile;
        } else {
            $errorMsg = "Ошибка при загрузке изображения.";
        }
    }

    // Подготовка и выполнение запроса на вставку
    $insertStmt = $conn->prepare("INSERT INTO products (ProductName, CategoryID, BrandID, Price, StockQuantity, Description, ImagePath) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("siidiss", $productName, $categoryID, $brandID, $price, $stockQuantity, $description, $imagePath);
    
    if ($insertStmt->execute()) {
        // Успешно добавлено, перенаправляем на страницу управления продуктами
        header("Location: products.php");
        exit();
    } else {
        $errorMsg = "Ошибка при добавлении продукта: " . $conn->error;
    }

    $insertStmt->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление нового продукта</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-top: 5px;
            margin-bottom: 10px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Добавление нового продукта</h2>
        <?php if (!empty($errorMsg)) { ?>
            <p style="color: red;"><?php echo $errorMsg; ?></p>
        <?php } ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="productName">Название продукта:</label>
            <input type="text" id="productName" name="productName" required>

            <label for="categoryID">Категория:</label>
            <select id="categoryID" name="categoryID" required>
                <option value="">Выберите категорию</option>
                <?php
                $result = $conn->query("SELECT CategoryID, CategoryName FROM categories");
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['CategoryID'] . '">' . $row['CategoryName'] . '</option>';
                }
                ?>
            </select>

            <label for="brandID">Бренд:</label>
            <select id="brandID" name="brandID" required>
                <option value="">Выберите бренд</option>
                <?php
                $result = $conn->query("SELECT BrandID, BrandName FROM brands");
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['BrandID'] . '">' . $row['BrandName'] . '</option>';
                }
                ?>
            </select>

            <label for="price">Цена:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="stockQuantity">Количество на складе:</label>
            <input type="number" id="stockQuantity" name="stockQuantity" required>

            <label for="description">Описание:</label>
            <textarea id="description" name="description" rows="4"></textarea>

            <label for="image">Изображение:</label>
            <input type="file" id="image" name="image">

            <button type="submit">Добавить продукт</button>
        </form>
        <br>
        <a href="products.php">Отмена</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
