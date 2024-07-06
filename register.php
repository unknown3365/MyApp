
<?php
/*
session_start();

*/
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>O'DARGO | Регистрация</title>
    <link rel="icon" type="images/x-icon" href="img/letter-d.ico">
    <link rel="stylesheet" href="register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italiana&family=Playwrite+NZ:wght@100..400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

    <!--<style>
        .message {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .message.error {
            background-color: red;
            color: white;
        }
    </style>-->
</head>

<body>
    <div class="intro">
<?php include_once('header.php'); ?>
        <div class="gradient">
            <div class="container">
                <div class="gradient_text">
                    Регистрация
                </div>
            </div>
        </div>

        <div class="login">
            <div class="container">
                <div class="login_text">
                    <p class="auth">Регистрация</p>
                    <p class="question">Уже есть аккаунт?</p>
                    <p><a href="login.php" class="login_link">Войти</a></p>
                </div>
                <form class="login_form" action="register_process.php" method="post" enctype="multipart/form-data">
                    <input type="text" class="text" placeholder="Имя" name="login">
                    <input type="email" class="email" placeholder="Почта" name="email">
                    <input type="password" class="password" placeholder="Пароль" name="password">
                    <input type="password" class="password" placeholder="Повторите пароль" name="repeatpassword">
                    
                    <label for="file-upload" class="button1">
                        Аватар
                        <input type="file" id="file-upload" name="avatar" accept="image/*">
                    </label>

                    <br>
                    <button class="button1" type="submit">Создать</button>
                </form>


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

    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='message {$_SESSION['message_type']}'>{$_SESSION['message']}</div>";
        echo "
        <script>
            setTimeout(function() {
                var msg = document.querySelector('.message');
                if (msg) {
                    msg.style.display = 'none';
                }
            }, 3000);
        </script>";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    ?>
</body>

</html>
