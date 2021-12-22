<?php 

session_start();

$id = $_SESSION['user_id']['id'];
$avatar_id = $_SESSION['user_id']['avatar'];
$user_name = $_SESSION['user_id']['full_name'];

require_once("connectdb.php");
if (empty($_SESSION['user_id'])) {
	header("location: /authorization.php");
}
if (!empty($_POST['comment'])) {
	$comment = $_POST['comment'];
	$queryComment = "INSERT INTO comment (`user_id`, `user_name`, `comment`, `avatar_id`) VALUES ('$id', '$user_name', '$comment', '$avatar_id')";
	mysqli_query($link, $queryComment);
}

require_once("pages.php");
				
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Страница комментариев</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body class="background">
	<img class="imgUpper" src="uploads/imageComm.jpg" alt="">
	<nav>
		<ul>
			<li><a href="profile.php">Профиль</a></li>
			<li><a href="logout.php">Выйти из аккаунта</a></li>
		</ul>
	</nav>
	<div>
		<h3 class="h3index">↓ ☺ Создайте комментарий ☺ ↓</h3>
	</div>
		<form class="boxSendComment" action="#" method="POST" enctype="multipart/form-data">
			<div>
				<label>Ваш Комментарий</label>
					<div>
						<textarea required placeholder="Написать комментарий" maxlength="1500" name="comment"></textarea>
					</div>
			</div>
			<div>
				<button type="submit">Отправить комментарий</button>
			</div>
		</form>
			<div>
				<h2 class="h2index">↓ Комментарии пользователей ↓</h2>
			</div>

			<?php foreach ($data as $showComment): ?>
			<p class="pShowComment">
				<article class="boxShowComment">
						<div>Имя отправителя:</div>
						<div>
							<?=$showComment['user_name']; ?>
						</div>
						<div>
							<img src="uploads/<?=$showComment['avatar_id']?>" alt="Картинка исчезла xD">
						</div>
						<div>
							USER ID: <?=$showComment['user_id']; ?> 
						</div>
					<div>
						<?=$showComment['created_at']; ?>
					</div>
					<div>
						<textarea disabled><?=$showComment['comment']; ?></textarea>
					</div>	
				</article>
			</p>
		<?php endforeach; 
		for ($i = 1; $i <= $pagesCount; $i++) {	
			if ($page == $i) {
				$class = ' class="aPageIndexActive"';
			} else { 
				$class = ' class="aPageIndex"';
			}
			
			echo "<a href=\"?page=$i\" $class>$i</a>";
		}
	 	?> 
</body>
</html>
