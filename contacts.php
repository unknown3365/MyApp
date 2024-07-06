<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>O'DARGO | Контакты</title>
    <link rel="icon" type="images/x-icon" href="img/letter-d.ico">
    <link rel="stylesheet" href="contacts.css">
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
                    Контакты

                </div>

            </div>
        </div>

        <div class="login">
            <div class="container">
                <div class="login_text">
                    <p class="auth">Контакты</p>
                    <p class="question">
                        Свяжитесь с нами
                    </p>


                </div>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d8982.436906533267!2d37.5398169!3d55.7479184!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54bdd017303b9%3A0xd1f63f945a2450c2!2z0JzQvtGB0LrQstCwINCh0LjRgtC4!5e0!3m2!1sru!2scz!4v1719736470095!5m2!1sru!2scz" width="700" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="contact_form">

                    <div class="login_form">

                        <p class="auth">
                            Контактная форма
                        </p>

                        <input type="text" class="text" placeholder="ФИО">
                        <input type="email" class="text" placeholder="Почта">
                        <input type="text" class="email" placeholder="Номер телефона">
                        <input type="text" class="password" placeholder="Комментарий">
                        <div class="button1" onclick="orderClick()">Отправить</div>
                    </div>
                </div>
                
                <div class="order">Функция недоступна!</div>
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
    
        <script defer>
    
function orderClick() {
  document.querySelector('.order').classList.add('order_done');
}
    </script>
</body>

</html>
