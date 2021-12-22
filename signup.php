<?php 

session_start();

require_once('connectdb.php');
if (!empty($_SESSION['user_id'])) {
	header('Location: index.php');
}

$errors = [];
if (!empty($_POST)) {
    if (mb_strlen($_POST['full_name']) > 100 || mb_strlen($_POST['full_name']) < 3) {
        $errors[] = 'Длина имени должна быть больше 2 и меньше 100 символов';
    }
    if (mb_strlen($_POST['email']) > 255) {
        $errors[] = 'Длина почтового ящика превышает допустимый лимит в 255 символов';
    }
    if (mb_strlen($_POST['password']) < 6 || mb_strlen($_POST['password']) > 64) {
        $errors[] = 'Длина пароля не может быть меньше 6 и больше 64 символов';
    }
    if ($_POST['password'] !== $_POST['password_confirm']) {
        $errors[] = 'Указанные вами пароли не совпадают, повторите попытку ввода';
    }

    $queryLogin = mysqli_query($link, "SELECT COUNT(id) as count FROM users WHERE login='$_POST[login]'");
    $userLogin = mysqli_fetch_array($queryLogin, MYSQLI_ASSOC);
    if($userLogin['count'] > 0) {
        $errors[] = "Пользователь с таким логином уже существует в базе данных";
    }

    $queryEmail = mysqli_query($link, "SELECT COUNT(id) as count FROM users WHERE email='$_POST[email]'");
    $userEmail = mysqli_fetch_array($queryEmail, MYSQLI_ASSOC);
    if ($userEmail['count'] > 0) {
        $errors[] = "Пользователь с такой электронной почтой существует";
    }
    $queryFullName = mysqli_query($link, "SELECT COUNT(id) as count FROM users WHERE full_name='$_POST[full_name]'");
    $userFullName = mysqli_fetch_array($queryFullName, MYSQLI_ASSOC);
    if ($userFullName['count'] > 0) {
        $errors[] = "Пользователь с таким именем существует";
    }
    if (isset($errors)) {
        $_SESSION['regErrors'] = $errors;
        $_SESSION['regFull_name'] = $_POST['full_name'];
        $_SESSION['regLogin'] = $_POST['login'];
        $_SESSION['regEmail'] = $_POST['email'];
        header('Location: registration.php');
    }


            
    if (empty($errors)) {
        $full_name = $_POST['full_name'];
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $avatar = 'avatar.jpeg';

        $full_name = htmlspecialchars($full_name);
        $login = htmlspecialchars($login);
        $email = htmlspecialchars($email);
        $user = htmlspecialchars($user);

        $full_name = urldecode($full_name);
        $login = urldecode($login);
        $email = urldecode($email);
        $user = urldecode($user);

        $full_name = trim($full_name);
        $login = trim($login);
        $email = trim($email);
        $user = trim($user);

        $password = md5(SALT . $password);

        mysqli_query($link, "INSERT INTO `users` (`full_name`, `login`, `email`, `password`, `avatar`) VALUES ('$full_name', '$login', '$email', '$password', '$avatar')");

        $_SESSION['trueReg'] = 'Регистрация прошла успешно! Осталось только авторизоваться';
        unset($_SESSION['regErrors']);
        unset($_SESSION['regFull_name']);
        unset($_SESSION['regLogin']);
        unset($_SESSION['regEmail']);
        header('Location: authorization.php');
    }
}