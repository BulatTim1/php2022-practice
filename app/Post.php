<?php
require_once 'app/Database.php';

function getAllPost($count = 20, $page = 1)
{
    $sql = 'SELECT posts.*, users.login, users.avatar, COUNT(comments.id) as comments FROM posts left join users on posts.user_id = users.id left JOIN comments ON posts.id = comments.post_id group by posts.id ORDER BY date DESC';
    $sql .= $count != -1 ? ' LIMIT ' . $count . ' OFFSET ' . (($page - 1) * $count >= 0 ? ($page - 1) * $count : 0) : '';
    return DB::q($sql);
}

function getCountPost($user_id = -1): int
{
    $sql = 'SELECT COUNT(*) FROM posts';
    if ($user_id != -1) {
        $sql .= ' WHERE user_id = ?';
    }
    return DB::pq($sql, [$user_id])[0]['COUNT(*)'];
}

function getCountPostBySubscription($user_id)
{
    $sql = 'SELECT COUNT(*) FROM posts WHERE user_id IN (SELECT subscription_id FROM subscriptions WHERE subscriber_id = ?)';
    return DB::pq($sql, [$user_id])[0]['COUNT(*)'];
}

function getPostById($id)
{
    $sql = "SELECT posts.*, users.login, users.avatar, COUNT(comments.id) as comments FROM posts LEFT join users on posts.user_id = users.id left JOIN comments ON posts.id = comments.post_id WHERE posts.id = ? group by posts.id ";
    return DB::pq($sql, [$id]);
}

function getPostByUser($user)
{
    $sql = "SELECT posts.*, users.login, users.avatar, COUNT(comments.id) as comments FROM posts LEFT join users on posts.user_id = users.id left JOIN comments ON posts.id = comments.post_id WHERE users.login = ? group by posts.id ";
    return DB::pq($sql, [$user]);
}

function getPostByUserId($id, $fullInf = true)
{
    if ($fullInf == false) {
        $sql = "SELECT * FROM posts WHERE user_id = ?";
    } else {
        $sql = "SELECT posts.*, users.login, users.avatar, COUNT(comments.id) as comments FROM posts LEFT join users on posts.user_id = users.id left JOIN comments ON posts.id = comments.post_id WHERE posts.user_id = ? group by posts.id ";
    }
    return DB::pq($sql, [$id]);
}

function addPost($title, $body, $user_id, $banner = null)
{
    $sql = "INSERT INTO posts (title, body, user_id, image_path) VALUES (?, ?, ?, ?)";
    DB::pq($sql, [$title, $body, $user_id, $banner]);
}

function updatePost($id, $title, $body, $banner = null)
{
    $sql = "UPDATE posts SET title = ?, body = ?, image_path = ? WHERE id = ?";
    DB::pq($sql, [$title, $body, $banner, $id]);
}

function updateViewCount($id)
{
    $sql = "UPDATE posts SET view_count = view_count + 1 WHERE id = ?";
    DB::pu($sql, [$id]);
}
