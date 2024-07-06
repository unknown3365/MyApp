<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>O'DARGO | Авторизация</title>
    <link rel="icon" type="images/x-icon" href="img/letter-d.ico">
    <link rel="stylesheet" href="login.css">
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
                    Аккаунт
                </div>

            </div>
        </div>

        <div class="login">
            <div class="container">
                <div class="login_text">
                    <p class="auth">Авторизация</p>
                    <p class="question">
                        Еще не имеете аккаунта?
                    </p>
                    <p>
                        <a href="register.php" class="register_link">Создать аккаунт</a>
                    </p>

                </div>

                <form class="login_form" action = "login_process.php" method = "post">
                    <input type="text" class="email" placeholder="Имя" name ="login">
                    <input type="password" class="password" placeholder="Пароль" name = "password">
                    <br>
                    <button type = "submit" class = button1> BОЙТИ</button>
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
</body>

</html>
