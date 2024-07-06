<?php
session_start();
require_once('db.php');

// Функция для получения имени бренда по его ID
function getBrandName($conn, $brandID) {
    $stmt = $conn->prepare("SELECT BrandName FROM brands WHERE BrandID = ?");
    $stmt->bind_param("i", $brandID);
    $stmt->execute();
    $stmt->bind_result($brandName);
    $stmt->fetch();
    $stmt->close();
    return $brandName;
}

// Функция для получения имени категории по ее ID
function getCategoryName($conn, $categoryID) {
    $stmt = $conn->prepare("SELECT CategoryName FROM categories WHERE CategoryID = ?");
    $stmt->bind_param("i", $categoryID);
    $stmt->execute();
    $stmt->bind_result($categoryName);
    $stmt->fetch();
    $stmt->close();
    return $categoryName;
}

// Получаем список всех продуктов
$stmt = $conn->prepare("SELECT ProductID, ProductName, CategoryID, BrandID, Price, StockQuantity, Description, ImagePath FROM products");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление продуктами</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
            text-decoration: none;
            background-color: #f2f2f2;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <a href="index.php" class="logout">Выход</a>
    <h2>Управление продуктами</h2>
    <a href="add_product.php">Добавить новый продукт</a>
    <br><br>
<form action="add_category.php" method="POST">
<input type="text" name="categoryName" placeholder="Введите название категории">
<button type="submit">Добавить категорию</button>
</form>
<br>
<form action="add_brand.php" method="POST">
<input type="text" name="brandName" placeholder="Введите название бренда">
<button type="submit">Добавить бренд</button>
</form>
<br>
    <table>
        <tr>
            <th>Название продукта</th>
            <th>Категория</th>
            <th>Бренд</th>
            <th>Цена</th>
            <th>Количество на складе</th>
            <th>Описание</th>
            <th>Изображение</th>
            <th>Действия</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['ProductName']; ?></td>
                <td><?php echo getCategoryName($conn, $row['CategoryID']); ?></td>
                <td><?php echo getBrandName($conn, $row['BrandID']); ?></td>
                <td><?php echo $row['Price']; ?></td>
                <td><?php echo $row['StockQuantity']; ?></td>
                <td><?php echo $row['Description']; ?></td>
                <td><img src="<?php echo $row['ImagePath']; ?>" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>

                <td>
                    <a href="edit_product.php?id=<?php echo $row['ProductID']; ?>">Редактировать</a>
                    <a href="delete_product.php?id=<?php echo $row['ProductID']; ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
