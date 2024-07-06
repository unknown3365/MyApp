<a href="index.php" class="logo">O'Dargo</a>
<nav class="nav">
    <ul>
        <li><a href="catalogue.php">Каталог &blacktriangledown;</a>
            <ul>
                <li><a href="#">Ноутбуки &blacktriangledown;</a>
                    <ul>
                        <li><a href="#">Apple</a></li>
                    </ul>
                </li>
                <li><a href="#">Наушники &blacktriangledown;</a>
                    <ul>
                        <li><a href="#">Sony</a></li>
                    </ul>
                </li>
                <li><a href="#">Смартфоны &blacktriangledown;</a>
                    <ul>
                        <li><a href="#">Samsung</a></li>
                        <li><a href="#">Apple</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="about.php">О нас</a></li>
        <li><a href="contacts.php">Контакты</a></li>
        
        <!-- PHP код для проверки авторизации пользователя и вывода аватарки -->
        <?php
        // Проверяем, установлена ли переменная сессии для логина пользователя
        if (isset($_SESSION['login'])) {
            // Подключаемся к базе данных для получения пути к аватару
            require_once('db.php');
            $login = $_SESSION['login'];
            $stmt = $conn->prepare("SELECT imagepath FROM users WHERE login = ?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $avatarPath = $user['imagepath'] ?? 'path/to/default/avatar.png'; // Путь к аватарке или путь по умолчанию

            echo '<li class="user-dropdown">
                    <a href="#" class="icon">
                        <img src="' . htmlspecialchars($avatarPath) . '" alt="User Avatar" width="21" height= 21">
                    </a>
                    <ul class="dropdown-content">';
            
            // Если пользователь является администратором
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
            // В случае, если логин не установлен (например, пользователь не авторизован), оставляем пустой элемент
            echo '<li><a href="login.php" class="icon"></a></li>';
        }
        ?>
    </ul>
</nav>

<!-- Скрипт для управления выпадающим списком -->
<script>
    // Находим все элементы с классом "user-dropdown"
    var userDropdowns = document.querySelectorAll('.user-dropdown');

    // Для каждого элемента добавляем обработчик события клика
    userDropdowns.forEach(function(userDropdown) {
        var userIcon = userDropdown.querySelector('.icon'); // Иконка пользователя
        var dropdownContent = userDropdown.querySelector('.dropdown-content'); // Список с выпадающим контентом

        // Обработчик события клика по иконке пользователя
        userIcon.addEventListener('click', function(event) {
            event.stopPropagation(); // Остановка распространения события клика

            // Переключение класса для отображения/скрытия выпадающего контента
            dropdownContent.classList.toggle('show');
        });

        // Закрытие выпадающего списка при клике за его пределами
        document.addEventListener('click', function(event) {
            if (!userDropdown.contains(event.target)) {
                dropdownContent.classList.remove('show');
            }
        });
    });
</script>
