<?php
include 'include/Database.php';
if (isset($_POST['title']) && isset($_POST['body'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    DB::addPost($title, $body);
}

header('Location: '.$_SERVER['HTTP_REFERER']);