<?php
include 'app/User.php';

$auth = IsAuth();

if(isset($_GET['user']) && $auth) {
    $sub_login = trim($_GET['user']);
    $user = getUser($_SESSION['email']);
    $sub = getUser($sub_login);

    if(isset($_SESSION['alerts'])) {
        $_SESSION['alerts'] = [];
    }

    if (count($user) == 0 || count($sub) == 0) {
        $_SESSION['alerts'][] = 'Пользователь не найден';
    } else if ($user[0]['id'] == $sub[0]['id']) {
        $_SESSION['alerts'][] = 'Нельзя подписаться на самого себя';
    } else {
        subUnsub($user[0]['id'], $sub[0]['id']);
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
} else if (!$auth){
    $_SESSION['alerts'][] = 'Для подписки нужно войти!';
    header('Location: /login.php');
    exit();
} else
{
    $_SESSION['alerts'][] = 'Ошибка подписки';
    header('Location: /index.php');
    exit();
}