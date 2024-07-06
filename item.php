<?php
include 'db.php'; 
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Fetch product details from the database
    $sql = "SELECT products.ProductID, products.ProductName, products.Price, products.Description, products.ImagePath,
                   brands.BrandName, categories.CategoryName
            FROM products
            JOIN brands ON products.BrandID = brands.BrandID
            JOIN categories ON products.CategoryID = categories.CategoryID
            WHERE products.ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display product details
        $product = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <title>O'DARGO | <?php echo htmlspecialchars($product['ProductName']); ?></title>
            <link rel="icon" type="images/x-icon" href="img/letter-d.ico">
            <link rel="stylesheet" href="item.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300..700&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Italiana&family=Playwrite+NZ:wght@100..400&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
        </head>
        <body>
            <div class="intro">
               
               
               
                     <header class="header">
        <a href="index.php" class="logo">O'Dargo</a>
<nav class="nav">
    <ul>
        <li><a href="catalogue.php">Каталог</a>
<!--
            <ul>
                <li><a href="javascript:void(0);">Ноутбуки &blacktriangledown;</a>
                    <ul>
                        <li><a href="#">Apple</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);">Наушники &blacktriangledown;</a>
                    <ul>
                        <li><a href="#">Sony</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);">Смартфоны &blacktriangledown;</a>
                    <ul>
                        <li><a href="#">Samsung</a></li>
                        <li><a href="#">Apple</a></li>
                    </ul>
                </li>
            </ul>
-->
        </li>
        <li><a href="about.php">О нас</a></li>
        <li><a href="contacts.php">Контакты</a></li>

        <?php
//        session_start();

        if (isset($_SESSION['user_id']) && isset($_SESSION['login'])) {
            // Подключаемся к базе данных для получения пути к аватару
            require_once('db.php');
            $login = $_SESSION['login'];
            $stmt = $conn->prepare("SELECT imagepath FROM users WHERE login = ?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $avatarPath = htmlspecialchars($user['imagepath'] ?? 'path/to/default/avatar.png');

            echo '<li class="user-dropdown">
                    <a href="#" class="icon">
                        <img src="' . $avatarPath . '" alt="User Avatar" width="21" height="21">
                    </a>
                    <ul class="dropdown-content">';

            if ($login === 'admin') {
                echo '<li><a href="products.php">Admin</a></li>';
            } else {
                echo '<li><a href="cart.php">Корзина</a></li>';
                echo '<li><a href="account.php">Мой аккаунт</a></li>';
            }

            echo '      <li><a href="logout.php">Выход&hookrightarrow;</a></li>
                    </ul>
                  </li>';

            $stmt->close();
            $conn->close();
        } else {
            echo '<li><a href="login.php" class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="white" d="M12 3c2.21 0 4 1.79 4 4s-1.79 4-4 4s-4-1.79-4-4s1.79-4 4-4m4 10.54c0 1.06-.28 3.53-2.19 6.29L13 15l.94-1.88c-.62-.07-1.27-.12-1.94-.12s-1.32.05-1.94.12L11 15l-.81 4.83C8.28 17.07 8 14.6 8 13.54c-2.39.7-4 1.96-4 3.46v4h16v-4c0-1.5-1.6-2.76-4-3.46"/>
                    </svg>
                </a></li>';
        }
        ?>
    </ul>
</nav>

<!-- Скрипт для управления выпадающим списком -->
<script>
    var userDropdowns = document.querySelectorAll('.user-dropdown');

    userDropdowns.forEach(function(userDropdown) {
        var userIcon = userDropdown.querySelector('.icon');
        var dropdownContent = userDropdown.querySelector('.dropdown-content');

        userIcon.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdownContent.classList.toggle('show');
        });

        document.addEventListener('click', function(event) {
            if (!userDropdown.contains(event.target)) {
                dropdownContent.classList.remove('show');
            }
        });
    });
</script>

        </header>
                <div class="gradient">
                    <div class="container">
                        <div class="gradient_text">
                            <?php echo htmlspecialchars($product['ProductName']); ?>
                        </div>
                    </div>
                </div>
                <div class="main_photo">
                </div>
                <div class="main">
                    <div class="container">
                        <div class="item_main">
                            <div class="photo">
                                <?php if (!empty($product['ImagePath'])) { ?>
                                    <img src="<?php echo htmlspecialchars($product['ImagePath']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" width="300" height="300" style="object-fit: contain;">
                                <?php } ?>
                            </div>
                            <div class="text">
                                <div class="name">
                                    <p><?php echo htmlspecialchars($product['ProductName']); ?></p>
                                </div>
                                <div class="price">
                                    <p><?php echo htmlspecialchars($product['Price']); ?> руб</p>
                                </div>
                                <hr>
                                <div class="desc">
                                    <p>Описание</p>
                                    <p><?php echo nl2br(htmlspecialchars($product['Description'])); ?></p>
                                </div>
                                <form  action="cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['ProductID']); ?>">
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['ProductName']); ?>">
                                    <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['Price']); ?>">
                                    <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['ImagePath']); ?>">
                                    <button type="submit" class="button1">В корзину</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="container">
                    <div class="footer_line"></div>
                    <div class="rights">
                        <p>Все права защищены © 2024, O'DARGO</p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}

?>
