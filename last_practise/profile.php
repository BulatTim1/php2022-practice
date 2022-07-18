<?php
include 'include/Database.php';
include 'include/session-check.php';
include 'templates/header.php';
$user = DB::pq("SELECT * FROM users WHERE email = ?", [$_SESSION['email']])[0];
if (isset($_GET['user']) && $user['role'] == 1)
{
    $user = DB::pq("SELECT * FROM users WHERE user = ?", [$_GET['user']])[0];
}
$username = $user['name'];
?>

<h1>Профиль <?=$_SESSION['name']?></h1>

<form method="POST" action="profile-update.php">
    <input type="text" name="user" value="<?=$username?>" hidden>
    <label>Ваше имя: <input type="text" name="firstname" value="<?=$user['firstname']?>"></label><br>
    <label>Ваша фамилия: <input type="text" name="lastname" value="<?=$user['lastname']?>"></label><br>
    <label>Ваша дата рождения: <input type="date" name="birthday" value="<?=$user['birthday']?>"></label><br>
    <h2>Смена пароля</h2><br>
    <label>Старый пароль: <input type="password" name="oldpassword"></label><br>
    <label>Новый пароль: <input type="password" name="password"></label><br>
    <label>Повтор пароля: <input type="password" name="password2"></label><br>

    <input type="submit" value="Сохранить">
</form>

<?php include 'templates/footer.php'; ?>