<?php 

session_start();

require_once('connectdb.php');
require('function.php');
if (empty($_SESSION['user_id'])) {
	header("location: /authorization.php");
}

$data = $_POST;
$id = $_SESSION['user_id']['id'];
$query = "SELECT * FROM users WHERE id='$id'";

$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

$errorsUpdate = [];

if (isset($data['submit_user_name'])) {
	if (mb_strlen($data['user_name']) > 100 || mb_strlen($data['user_name']) < 3) {
        $errorsUpdate[] = 'Длина имени должна быть больше 2 и меньше 100 символов';
    }
    $queryName = mysqli_query($link, "SELECT COUNT(id) as count FROM users WHERE full_name='$data[user_name]'");
    $userName = mysqli_fetch_array($queryName, MYSQLI_ASSOC);
    if($userName['count'] > 0) {
        $errorsUpdate[] = "Пользователь с таким именем уже существует в базе данных";
    }
} 

if (isset($data['submit_email'])) {
	if (mb_strlen($data['email']) > 255) {
        $errorsUpdate[] = 'Длина почтового ящика превышает допустимый лимит в 255 символов';
    }
    $queryEmail = mysqli_query($link, "SELECT COUNT(id) as count FROM users WHERE email='$data[email]'");
    $userEmail = mysqli_fetch_array($queryEmail, MYSQLI_ASSOC);
    if ($userEmail['count'] > 0) {
        $errorsUpdate[] = "Пользователь с такой электронной почтой существует";
    }
}

if (isset($data['submit_password'])) {
	if ($data['password'] !== $data['password_confirm']) {
		$errorsUpdate[] = "Введенные вами пароли не совпадают";
	}
	if (mb_strlen($data['password']) < 6 || mb_strlen($data['password']) > 64) {
        $errorsUpdate[] = 'Длина пароля не может быть меньше 6 и больше 64 символов';
    }
}

$_SESSION['updateErrors'] = $errorsUpdate;

if (isset($_SESSION['updateErrors'])) {
	header('Location: profile.php');
}

if (empty($_SESSION['updateErrors'])) {

if (isset($data['submit_avatar'])) {
	$avatar = $_FILES['avatar'];

if (avatarSecurity($avatar)) loadAvatar($avatar);
	$_SESSION['messageAvatar'] = "Изменение аватара прошло успешно!";
}

if (isset($data['submit_user_name'])) {
	$user_name = $data['user_name'];
	$user_name = htmlspecialchars($user_name);
	$user_name = urldecode($user_name);
	$user_name = trim($user_name);
	$queryName = "UPDATE users SET full_name='$user_name' WHERE id='$id'";
	mysqli_query($link, $queryName);
	$_SESSION['messageName'] = "Изменение имени прошло успешно. Ваше новое имя:$user_name";
}

if (isset($data['submit_email'])) {
	$email = $data['email'];
	$email = htmlspecialchars($email);
	$email = urldecode($email);
	$email = trim($email);
	$queryEmail = "UPDATE users SET email='$email' WHERE id='$id'";
	mysqli_query($link, $queryEmail);
	$_SESSION['messageEmail'] = "Изменение электронной почты прошло успешно. Ваш новый почтовый ящик:$email";
}

if (isset($data['submit_password'])) {
	$password = $data['password'];
	$password = htmlspecialchars($password);
	$password = urldecode($password);
	$password = trim($password);
	$password = (md5(SALT . $password));
	$queryPassword = "UPDATE users SET password='$password' WHERE id='$id'";
	mysqli_query($link, $queryPassword);
	$_SESSION['messagePassword'] = "Изменение пароля прошло успешно!";
} 

}

header('Location: profile.php');