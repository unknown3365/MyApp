<?php
session_start(); 

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        $_SESSION['login_error'] = "Заполните все поля";
        header("Location: login.php"); // Перенаправляем обратно на форму логина
        exit();
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE login = ? AND password = ?");
        $stmt->bind_param("ss", $login, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id']; // Сохраняем идентификатор пользователя в сессии
            $_SESSION['login'] = $login;

            header("Location: index.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Неверные данные пользователя";
            header("Location: login.php"); // Перенаправляем обратно на форму логина
            exit();
        }
    }
} else {
    // Если кто-то пытается получить доступ к этому скрипту напрямую, вместо отправки формы
    $_SESSION['login_error'] = "Доступ запрещен";
    header("Location: login.php"); // Перенаправляем обратно на форму логина
    exit();
}
?>
