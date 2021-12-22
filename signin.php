<?php 

session_start();

require_once('connectdb.php');
if (!empty($_SESSION['user_id'])) {
	header('Location: index.php');
}

$errors = [];

if (!empty($_POST)) {
    if (empty($_POST['login'])) {
        $errors[] = 'Пожалуйста, укажите логин или электронную почту';
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Пожалуйста, укажите пароль для входа';
    }
    if (empty($errors)) {
        $login = $_POST['login'];
        $password = md5(SALT . $_POST['password']);
        $check_user = mysqli_query($link, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    if (mysqli_num_rows($check_user) > 0) {

        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user_id'] = [
            "id" => $user['id'],
            "full_name" => $user['full_name'],
            "avatar" => $user['avatar'],
            "email" => $user['email'],
            "login" => $user['login']
        ];
        unset($_SESSION['authLogin']);
        header('Location: index.php');

    } else {
        $_SESSION['errors'] = 'Не верный логин или пароль';
        $_SESSION['authLogin'] = $_POST['login'];
        header('Location: authorization.php'); 
    }

    }
}