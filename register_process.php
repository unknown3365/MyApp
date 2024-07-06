<?php
session_start();
require_once('db.php');

$login = $_POST['login'];
$password = $_POST['password'];
$repeatpass = $_POST['repeatpassword'];
$email = $_POST['email'];
$avatar_path = null; // Initialize avatar_path

if (empty($login) || empty($password) || empty($repeatpass) || empty($email)) {
    $_SESSION['message'] = "Заполните все поля";
    $_SESSION['message_type'] = 'error';
} else {
    if ($password != $repeatpass) {
        $_SESSION['message'] = "Пароли не совпадают";
        $_SESSION['message_type'] = 'error';
    } else {
        // Проверка на существование пользователя
        $check_stmt = $conn->prepare("SELECT * FROM `users` WHERE login = ?");
        $check_stmt->bind_param("s", $login);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['message'] = "Такой пользователь существует";
            $_SESSION['message_type'] = 'error';
        } else {
            // Handle avatar upload
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
                $avatar_dir = 'uploads/avatars/';
                $avatar_path = $avatar_dir . basename($_FILES['avatar']['name']);
                
                // Ensure the uploads directory exists
                if (!is_dir($avatar_dir)) {
                    mkdir($avatar_dir, 0777, true);
                }

                // Move the uploaded file to the target directory
                if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
                    $_SESSION['message'] = "Ошибка загрузки аватара.";
                    $_SESSION['message_type'] = 'error';
                    header("Location: register.php");
                    exit();
                }
            }

            // Insert user into the database
            $stmt = $conn->prepare("INSERT INTO `users` (login, password, email, imagepath) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $login, $password, $email, $avatar_path);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Успешно";
                $_SESSION['message_type'] = 'success';
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['message'] = "Ошибка: " . $conn->error;
                $_SESSION['message_type'] = 'error';
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}
$conn->close();
header("Location: register.php");
exit();
?>
