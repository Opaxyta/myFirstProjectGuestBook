<?php 

session_start();
require_once('connectdb.php');
if (empty($_SESSION['user_id'])) {
	header('Location: authorization.php');
}

$id = $_SESSION['user_id']['id'];
$user_name = $_SESSION['user_id']['full_name'];
$login = $_SESSION['user_id']['login'];
$email = $_SESSION['user_id']['email'];
$avatar = $_SESSION['user_id']['avatar'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Профиль</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body class="background">
	<img class="imgUpper" src="uploads/imageProf.jpg" alt="">
		<nav>
			<ul>
				<li><a href="index.php">Вернуться к комменатариям</a></li>
				<li><a href="logout.php">Выйти из аккаунта</a></li>
				<li><a href="deleteprofile.php">Удалить аккаунт</a></li>
			</ul>
		</nav>
	<h1 class="h1Profile"> Данные профиля </h1>
		<aside class="infoProfile">
			<div>
				ID → <?=$id?>
			</div>
			<div>
				Имя → <?=$user_name?>
			</div>
			<div>
				Логин → <?=$login?>
			</div>
			<div>
				Почта → <?=$email?>
			</div>
			<div>
				↓ Аватар ↓
			</div>
			<img src="uploads/<?=$avatar?>" alt="Увы, аватар потерялся">
		</aside>
	<h2 class="h2Profile">Изменение данных профиля</h2>
		<form class="boxUpdateProfile" action="updateProfile.php" method="POST" enctype="multipart/form-data">
			<div>
			<?php   if (isset($_SESSION['updateErrors'])):
            			foreach ($_SESSION['updateErrors'] as $error): ?>
                 			<p class="errors"><?=$error; ?></p>
            <?php endforeach; endif; unset($_SESSION['updateErrors']) ?>     
			</div>
			<div>
				<p>Имя:
					<input type="text" name="user_name" placeholder="Введите имя">
						<button type="submit" name="submit_user_name" value="submit">Изменить имя</button>
							<span><?php if (isset($_SESSION['messageName'])) {
								echo $_SESSION['messageName']; } 
								unset($_SESSION['messageName']) ?></span>
				</p>
			</div>
			<div>
				<p>Почта:
					<input type="email" name="email" placeholder="Введите адрес почты">
						<button type="submit" name="submit_email" value="submit">Изменить адрес электронной почты</button>
						<span><?php if (isset($_SESSION['messageEmail'])) {
								echo $_SESSION['messageEmail']; } 
								unset($_SESSION['messageEmail']) ?></span>
				</p>
			</div>
			<div>
				<p>Пароль:
					<input type="password" name="password" placeholder="Введите пароль">
					<input type="password" name="password_confirm" placeholder="Повторите пароль">
						<button type="submit" name="submit_password" value="submit">Изменить пароль</button>
						<span><?php if (isset($_SESSION['messagePassword'])) {
								echo $_SESSION['messagePassword']; } 
								unset($_SESSION['messagePassword']) ?></span>
				</p>
			</div>
			<div>
				<p>Аватар:
					<input type="file" name="avatar">
					<button type="submit" name="submit_avatar" value="submit">Изменить Аватар</button>
					<span><?php if (isset($_SESSION['messageAvatar'])) {
								echo $_SESSION['messageAvatar']; } 
								unset($_SESSION['messageAvatar']) ?></span>
				</p>
			</div>
			<p>
				<button type="reset" value="reset">Очистить введенные данные</button>
			</p>
		</form>
</body>
</html>