<?php
include 'app/Comment.php';
include 'app/Post.php';
include 'app/User.php';

$auth = IsAuth();

if(isset($_GET['id']) && $auth) {
    $id = trim($_GET['id']);
    $user = getUser($_SESSION['email']);
    $post = getPostById($id);

    if(isset($_SESSION['alerts'])) {
        $_SESSION['alerts'] = [];
    }

    if ($post == null || count($user) == 0) {
        $_SESSION['alerts'][] = 'Пост или пользователь не найден';
    } else {
        likeUnlikePost($user[0]['id'], $id);
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
} else if (!$auth){
    $_SESSION['alerts'][] = 'Для лайка нужно войти!';
    header('Location: /login.php');
    exit();
} else
{
    $_SESSION['alerts'][] = 'Не выбран пост для лайка';
    header('Location: /index.php');
    exit();
}