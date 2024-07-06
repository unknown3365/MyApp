<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>O'DARGO | Каталог</title>

    <script src="catalogue.js"></script>
    <link rel="icon" type="images/x-icon" href="img/letter-d.ico">
    <link rel="stylesheet" href="catalogue.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300..700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italiana&family=Playwrite+NZ:wght@100..400&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

</head>

<body>
    <div class="intro">
<?php include_once('header.php'); ?>
        <div class="gradient">
            <div class="container">
                <div class="gradient_text">
                    Каталог
                </div>
            </div>
        </div>

        <div class="main_photo"></div>
        <div class="main">
            <div class="container">
            <header class="filters_header">
                    <nav>
                        <div class="filters">

                            <ul>
                                <li><a>Сортировать по &blacktriangledown;</a>


                                    <ul>
                                        <li data-f="all" class="li">Тип товара &blacktriangledown;
                                            <ul>
                                                <li data-f="laptop" class="li">Ноутбуки</li>
                                                <li data-f="headphone" class="li">Наушники</li>
                                                <li data-f="phone" class="li">Смартфоны</li>
                                                <li data-f ="otpusk" class ="li"> Отпуск</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                    </nav>
                </header>
                
            <?php
include 'db.php'; 

// получение товаров по категории
function getProductsByCategory($conn, $categoryId) {
    $stmt = $conn->prepare('SELECT * FROM products WHERE CategoryID = ?');
    $stmt->bind_param('i', $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// отображение блока товаров
function displayProducts($products, $categoryName, $categoryId) {
    $classMap = [
        1 => 'phone',
        2 => 'laptop',
        3 => 'headphone',
        6 => 'otpusk'
    ];
    $class = isset($classMap[$categoryId]) ? $classMap[$categoryId] : '';
       echo '<div class="items ' . htmlspecialchars($class) . '">'; 
    echo '<div class="block_name"><p>' . htmlspecialchars($categoryName) . '</p></div>';

    foreach ($products as $product) 
    {
        echo '<a href="item.php?id=' . htmlspecialchars($product['ProductID']) . '" class="item-link">';
        echo '<div class="item">';
        echo '<div class="photo">';
        if (!empty($product['ImagePath'])) {
            echo '<img src="' . htmlspecialchars($product['ImagePath']) . '" alt="' . htmlspecialchars($product['ProductName']) . '" width="100%" height="100%" style="object-fit: contain;">';
        }
        echo '</div>';
        echo '</a>';
        echo '<div class="name">';
        echo '<p>' . htmlspecialchars($product['ProductName']) . '</p>';
        echo '</div>';
        echo '<div class="price">';
        echo '<p>' . htmlspecialchars($product['Price']) . ' руб</p>';
        echo '</div>';
        echo '</div>';
        
    }
    echo '</div>';
}

// категорий и их ID
$categories = [
    6 => 'Отпуск',
    1 => 'Смартфоны',
    2 => 'Ноутбуки',
    3 => 'Наушники'
 
];

// вывод блоков товаров для каждой категории
foreach ($categories as $categoryId => $categoryName) {
    $products = getProductsByCategory($conn, $categoryId);
    displayProducts($products, $categoryName, $categoryId);
}
?>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="footer_line"></div>
            <div class="rights">
                <p>Все права защищены © 2024, O'Dargo</p>
            </div>
        </div>
    </div>
    
    <script src="catalogue.js" defer></script>
</body>

</html>
