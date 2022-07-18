<?php
include 'app/Comment.php';
include 'app/User.php';

$auth = IsAuth();

if(isset($_POST['content']) && isset($_POST['id']) && $auth) {
    $content = trim($_POST['content']);
    $id = trim($_POST['id']);
    $user = getUser($_SESSION['email']);

    if(isset($_SESSION['alerts'])) {
        $_SESSION['alerts'] = [];
    }

    if ($content == '') {
        $_SESSION['alerts'][] = 'Введите текст комментария';
    } else {
        addComment($id, $user[0]['id'], $content);
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
} else if (!$auth){
    $_SESSION['alerts'][] = 'Для комментирования нужно войти!';
    header('Location: /login.php');
    exit();
}