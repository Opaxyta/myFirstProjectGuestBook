<?php 

session_start();

include_once('connectdb.php');
if (empty($_SESSION['user_id'])) {
	header('Location: authorization.php');
}

$id = $_SESSION['user_id']['id'];

if (isset($_POST['password_delete'])) {
	$password = md5(SALT . $_POST['password_delete']);
	$check_user = mysqli_query($link, "SELECT * FROM users WHERE id = '$id' AND password = '$password'");
	if (mysqli_num_rows($check_user) > 0) {
		$queryDelete = "DELETE FROM users WHERE id = '$id'";
		mysqli_query($link, $queryDelete);
		$_SESSION['messageDelete'] = 'Аккаунт был успешно удален';
		$_SESSION['user_id'] = null;
		header('Location: registration.php');
	} else {
		$_SESSION['messageNoDelete'] = 'Не удалось удалить аккаунт, т.к. введенный вами пароль не совпадает';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Удаление аккаунта</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body class="background">
	<img class="imgUpper" src="uploads/imageDel.jpg" alt="">
	<nav>
		<ul>
			<li><a href="profile.php">Вернуться в профиль</a></li>
			<li><a href="index.php">Вернуться к странице с комментариями</a></li>
		</ul>
	</nav>
	<h1 class="h1delProfile">Для удаления аккаунта просто введите свой пароль</h1>
	<form class="boxDel" action="#" method="POST">
		<p>
			<div>
				<label>Введите пароль</label>
			<div>
				<input type="password" name="password_delete" placeholder="Введите пароль">
			</div>
			</div>
			<div>
			<button type="submit">Удалить аккаунт</button>
			</div>
			<span class="errors"> <?php if (isset($_SESSION['messageNoDelete'])) {
				echo $_SESSION['messageNoDelete']; }
				unset($_SESSION['messageNoDelete']); ?>	
			</span>
		</p>
	</form>
	<h2 class="h2Delete">Проект реализован Малашенко Романом Игоревичем в 2021 году</h2>
</body>
</html>