<?php
include 'app/User.php';

$title = 'Профиль';
include 'snippets/header.php';

if (!$auth)
{
    header('Location: /login.php')
}

$user = getUser($_SESSION['email'])[0];
if (isset($_GET['user']) && $user['role'] == 1)
{
    $user = getUser($_GET['user']);
}
?>
<article class="post">
    <header>
        <div class="title">
            <h2>Профиль <?=$user['login']?></h2>
        </div>
    </header>
    <form method="POST" action="updateuser.php" enctype="multipart/form-data">
        <label>Ваша аватарка: <input type="file" name="file"></label><br>
        <label>Ваше имя: <input type="text" name="firstname" value="<?=$user['firstname']?>"></label><br>
        <label>Ваша фамилия: <input type="text" name="lastname" value="<?=$user['lastname']?>"></label><br>
        <label>Ваша дата рождения: <input type="date" name="birthday" value="<?=$user['birthday']?>"></label><br>
        <h2>Смена пароля</h2><br>
        <label>Старый пароль: <input type="password" name="oldpassword"></label><br>
        <label>Новый пароль: <input type="password" name="password"></label><br>
        <label>Повтор пароля: <input type="password" name="password2"></label><br>

        <input type="hidden" name="user" value="<?=$user['email']?>">

        <input type="submit" value="Сохранить">
    </form>
</article>



<?php 
include 'snippets/footer.php';
?>