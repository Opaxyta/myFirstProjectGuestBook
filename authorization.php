<?php 

session_start();
require_once("connectdb.php");
if (!empty($_SESSION['user_id'])) {
    header("location: /index.php");
}
include_once('signin.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="background">
    <img class="imgUpper" src="uploads/imageAutho.jpg" alt="">
    <form class="boxAut" action="signin.php" method="post">
        <div>
            <label>Логин</label>
                <div>
                    <input type="text" name="login" placeholder="Введите свой логин" required="" value="<?=(!empty($_SESSION['authLogin']) ?$_SESSION['authLogin'] : '') ?>">
                </div>
        </div>
        <div>
            <label>Пароль</label>
                <div>
                    <input type="password" name="password" placeholder="Введите пароль" required="">
                </div>
        </div>
        <div>
            <button type="submit">Авторизироваться</button>
        </div>
        <div>
        <p class="pRegAut">У вас нет аккаунта? - <a class="aRegAut" href="registration.php">зарегистрируйтесь</a>!</p>
        </div>
        <div class="errors">
        <?php
            if (isset($_SESSION['errors'])) {
                echo '<p> ' . $_SESSION['errors'] . ' </p>';
            }
            unset($_SESSION['errors']); ?>
        </div>
        <div class="trueReg">
        <?php
            if (isset($_SESSION['trueReg'])) {
                echo '<p> ' . $_SESSION['trueReg'] . ' </p>';
            }
            unset($_SESSION['trueReg']); ?>
        </div>
    </form>
</body>
</html>

