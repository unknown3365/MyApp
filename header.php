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
        session_start();

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