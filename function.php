<?php 

session_start();
require_once("connectdb.php");
if (empty($_SESSION['user_id'])) {
	header('Location: authorization.php');
}

$id = $_SESSION['user_id']['id'];
$query = "SELECT * FROM users WHERE id='$id'";

$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

function avatarSecurity($avatar) {
	$name = $avatar['name'];
	$type = $avatar['type'];
	$size = $avatar['size'];
	$blacklist = ['.php', '.js', '.html'];

	foreach ($blacklist as $row) {
		if(preg_match("/$row\$/i", $name)) return false;
	}

	if (($type != "image/png") && ($type != "image/jpg") && ($type != "image/jpeg")) return false;
	if ($size > 20 * 1024 * 1024) return false;

	return true;
}

function loadAvatar($avatar) {
	$type = $avatar['type'];
	$name = md5(microtime()) . '.' . substr($type, strlen("image/"));
	$dir = 'uploads/';
	$uploadfile = $dir . $name;
	$id = $_SESSION['user_id']['id'];
	$link = mysqli_connect('localhost', 'root', '', 'poma');

	if (move_uploaded_file($avatar['tmp_name'], $uploadfile)) {

		$queryUpdateAvatar = "UPDATE users SET avatar='$name' WHERE id='$id'";
		mysqli_query($link, $queryUpdateAvatar); 
	} else { 
		return false;
	}
	return true;
}
