<?php
// Подключаем файл с настройками базы данных
include 'db.php';

// Начинаем сессию
session_start();

// Функция добавления товара в корзину
function addToCart($product_id, $product_name, $product_price, $product_image) {
    // Создаем элемент корзины
    $cart_item = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'product_price' => $product_price,
        'product_image' => $product_image,
        'quantity' => 1
    ];

    // Проверяем, есть ли уже такой товар в корзине
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1; // Увеличиваем количество
    } else {
        $_SESSION['cart'][$product_id] = $cart_item; // Добавляем новый товар в корзину
    }
}

// Функция оформления заказа
function placeOrder($customer_id, $order_comment) {
    global $servername, $username, $password, $dbname;

    // Создаем соединение
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверяем соединение
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Начинаем транзакцию
    $conn->begin_transaction();

    // Инициализируем $stmt для корректной работы finally блока
    $stmt = null;

    try {
        // Вычисляем общую сумму заказа
        $total_amount = array_sum(array_column($_SESSION['cart'], 'product_price'));

        // Вставляем запись в таблицу orders
        $stmt = $conn->prepare("INSERT INTO orders (CustomerID, OrderDate, ShippingAddress, TotalAmount) VALUES (?, current_timestamp(), ?, ?)");
        $stmt->bind_param("isd", $customer_id, $order_comment, $total_amount);
        $stmt->execute();

        // Получаем ID последнего вставленного заказа
        $order_id = $conn->insert_id;

        // Вставляем записи в таблицу order_details
        $stmt = $conn->prepare("INSERT INTO order_details (OrderID, ProductID, Quantity, UnitPrice) VALUES (?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $unit_price = $item['product_price'];

            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $unit_price);
            $stmt->execute();
        }

        // Подтверждаем транзакцию
        $conn->commit();

        // Очищаем корзину после успешного оформления заказа
        unset($_SESSION['cart']);

        // Устанавливаем флаг успешного оформления заказа для вывода на странице
        $_SESSION['order_success'] = true;
    } catch (Exception $e) {
        // Откатываем транзакцию в случае ошибки
        $conn->rollback();

        // Устанавливаем флаг неудачного оформления заказа для вывода на странице
        $_SESSION['order_success'] = false;
    } finally {
        // Закрываем $stmt, если он был инициализирован
        if ($stmt instanceof mysqli_stmt) {
            $stmt->close();
        }

        // Закрываем соединение
        $conn->close();
    }
}

// Обработка добавления товара в корзину при отправке формы с товара
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = htmlspecialchars($_POST['product_id']);
    $product_name = htmlspecialchars($_POST['product_name']);
    $product_price = htmlspecialchars($_POST['product_price']);
    $product_image = htmlspecialchars($_POST['product_image']);
    
    addToCart($product_id, $product_name, $product_price, $product_image);
}

// Обработка оформления заказа при отправке формы с комментарием
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_comment'])) {
    $order_comment = htmlspecialchars($_POST['order_comment']);

    // Получаем ID пользователя из сессии
    if (isset($_SESSION['user_id'])) {
        $customer_id = $_SESSION['user_id'];
        placeOrder($customer_id, $order_comment); // Вызываем функцию оформления заказа
    } else {
        // В случае отсутствия ID пользователя в сессии можно предпринять дополнительные меры,
        // например, перенаправление на страницу входа или обработку ошибки.
        // Например:
        header("Location: login.php");
        // exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>O'DARGO | Корзина</title>
    <link rel="icon" type="image/x-icon" href="img/letter-d.ico">
    <link rel="stylesheet" href="cart.css">
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
                    Корзина
                </div>
            </div>
        </div>
        <div class="main">
            <div class="container">
                <div class="cart_header">
                    <div class="header_product">Имя продукта</div>
                    <div class="header_total">Всего</div>
                </div>
                <?php if (!empty($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="cart_main">
                            <div class="main_photo">
                                <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" width="100%" height="100%" style="object-fit: contain;">
                            </div>
                            <div class="main_text">
                                <p><?php echo htmlspecialchars($item['product_name']); ?></p>
                            </div>
                            <div class="main_total">
                                <p><?php echo htmlspecialchars($item['product_price'] * $item['quantity']); ?> руб</p>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                    <p><a href="catalogue.php" class="continue">Продолжить покупки</a></p>
                <?php else: ?>
                    <p>Ваша корзина пуста.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="cart_footer">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="order_comm"><textarea name="order_comment" class="input_text" placeholder="Комментарий к заказу"></textarea></div>
                <?php if (!empty($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <div class="total_amount">
                        <p>Всего: <?php echo array_sum(array_column($_SESSION['cart'], 'product_price')); ?> руб</p>
                    </div>
                    <button type="submit" onclick="orderClick()" class = "button1">Оформить заказ</button>
                <?php endif; ?>
            </form>
            <?php if (isset($_SESSION['order_success'])): ?>
                <?php if ($_SESSION['order_success']): ?>
                    <div class="order">Заказ оформлен!</div>
                <?php else: ?>
                    <div class="order">Ошибка при оформлении заказа.</div>
                <?php endif; ?>
                <?php unset($_SESSION['order_success']); ?>
            <?php endif; ?>
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
    
            <script defer>
    
function orderClick() {
  alert("В разработке")
}
    </script>
</body>

</html>
