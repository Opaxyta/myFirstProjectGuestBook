<?php 

session_start();
require_once("connectdb.php");
if (!empty($_SESSION['user_id'])) {
    header("location: index.php");
}
require_once('signup.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="background">
    <img class="imgUpper" src="uploads/imageReg.jpg" alt="">
    <form class="boxReg" action="signup.php" method="post">
        <div>
            <label>Имя</label>
                <div>
                    <input type="text" name="full_name" placeholder="Введите имя пользователя" required="" value="<?=(!empty($_SESSION['regFull_name']) ? $_SESSION['regFull_name'] : ''); ?>">
                </div>
        </div>
        <div>
            <label>Логин</label>
            <div>
                    <input type="text" name="login" placeholder="Введите свой логин" required="" value="<?=(!empty($_SESSION['regLogin']) ? $_SESSION['regLogin'] : ''); ?>">
                </div>
        </div>
        <div>
            <label>Почта</label>
                <div>
                    <input type="email" name="email" placeholder="Введите адрес своей почты" required="" value="<?=(!empty($_SESSION['regEmail']) ? $_SESSION['regEmail'] : ''); ?>">
                </div>
        </div>
        <div>
            <label>Пароль</label>
                <div>
                    <input type="password" name="password" placeholder="Введите пароль" required="">
                </div>
        </div>
        <div>
            <label>Подтверждение пароля</label>
                <div>
                    <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required="">
                </div>
        </div>
        <div>
        <button type="submit">Зарегестрироваться</button>
        </div>
        <div>
        <p class="pRegAut">У вас уже есть аккаунт? - <a class="aRegAut" href="authorization.php">авторизируйтесь</a>!</p>
        </div>
        <div class="errors">
            <?php   if (isset($_SESSION['regErrors'])):
            foreach ($_SESSION['regErrors'] as $error): ?>
                 <p><?=$error; unset($_SESSION['regErrors']); ?></p>
            <?php endforeach; endif; ?>    
        </div>
        <div>
            <span class="messageDelete"> <?php if (isset($_SESSION['messageDelete'])) {
                echo $_SESSION['messageDelete']; }
                unset($_SESSION['messageDelete']); ?> 
            </span>
        </div>
    </form>
</body>
</html>