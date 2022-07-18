<?php
namespace App\Snippets;

if (!isset($_SESSION['email']) || !isset($_SESSION['login']))
{
    session_destroy();
    header ('Location: /login.php');
    $_SESSION['alerts'] = ['Вы не авторизованы'];
    exit();
}
$user = DB::pq("SELECT * FROM users WHERE email = ?", [$_SESSION['email']]);
if (count($user) == 0)
{
    session_destroy();
    header ('Location: /login.php');
    $_SESSION['alerts'] = ['Аяй-яй-яй. Шалишь, да?'];
    exit();
}
if (session_id() != $user[0]['session'])
{
    session_destroy();
    header ('Location: /login.php');
    $_SESSION['alerts'] = ['Срок действия сессии истек. Войдите еще раз.'];
    exit();
}
?>