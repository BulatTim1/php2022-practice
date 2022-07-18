<?php
include 'include/Database.php';
$isAdmin = false;
if (isset($_SESSION['login']))
{
    $isAdmin = true;
} else {
    if(!isset($_SESSION['alert'])) {
        $_SESSION['alert'] = [];
    }
    $_SESSION['alert'][] = 'Для доступа к этой странице необходимо авторизоваться'; 
}
if(isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['birthday'])
{
    if ($)
    DB::pq("UPDATE users SET firstname = ?, lastname = ?, birthday = ? WHERE login = ?", [$_POST['firstname'], $_POST['lastname'], $_POST['birthday'], $_POST['user']]);
}

if(isset($_POST['oldpassword']) && isset($_POST['password']) && isset($_POST['password2']))
{
    $oldpass = trim($_POST['oldpassword']);
    $pass = trim($_POST['password']);
    $pass2 = trim($_POST['password2']);
    $user = DB::pq("SELECT * FROM users WHERE login = ?", [$_POST['user']])[0];
    if ($user['password'] ==  hash('sha256', $oldpass))
    {
        if ($pass == $pass2)
        {
            DB::pq("UPDATE users SET password = ? WHERE login = ?", [hash('sha256', $pass), $_POST['user']]);
        }
        else
        {
            $_SESSION['alerts'][] = 'Пароли не совпадают';
        }
    }
    else
    {
        $_SESSION['alerts'][] = 'Неверный пароль';
    }
}