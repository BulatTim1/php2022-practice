<?php
require_once 'app/Database.php';

function getAllPost($count = 20, $page = 1)
{
    $sql = "SELECT posts.*, users.login, users.avatar_path, COUNT(likes.post_id) as like_count FROM posts left join users on posts.user_id = users.id left JOIN likes ON posts.id = likes.post_id group by posts.id ORDER BY posts.created_at DESC";
    $sql .= $count != -1 ? ' LIMIT ' . $count . ' OFFSET ' . (($page - 1) * $count >= 0 ? ($page - 1) * $count : 0) : '';
    $res = DB::pq($sql, []);
    return array_map(function ($item)  {
        $item['comments'] = getPostById($item['id'])[0]['comments'] ?? 0;
        return $item;
    }, $res);
}

function getCountPost($user_id = -1): int
{
    $sql = 'SELECT COUNT(*) FROM posts';
    if ($user_id != -1) {
        $sql .= ' WHERE user_id = ?';
    }
    return DB::pq($sql, [$user_id])[0]['COUNT(*)'];
}

function getPostsBySubscription($user_id, $count = 20, $page = 1)
{
    $sql = "SELECT posts.*, users.login, users.avatar_path, COUNT(likes.post_id) as like_count FROM posts left join users on posts.user_id = users.id left JOIN likes ON posts.id = likes.post_id WHERE posts.user_id IN (SELECT subscription_id FROM subscribers WHERE subscriber_id = ?) group by posts.id ORDER BY posts.created_at DESC";
    $sql .= $count != -1 ? ' LIMIT ' . $count . ' OFFSET ' . (($page - 1) * $count >= 0 ? ($page - 1) * $count : 0) : '';
    $res = DB::pq($sql, [$user_id]);
    $sql = "SELECT comments.post_id, COUNT(*) AS 'comments' FROM comments WHERE comments.post_id in (select post_id from posts where user_id in (select  subscription_id FROM subscribers WHERE subscriber_id = ?) ORDER BY posts.created_at desc) group BY comments.post_id";
    $sql .= $count != -1 ? ' LIMIT ' . $count . ' OFFSET ' . (($page - 1) * $count >= 0 ? ($page - 1) * $count : 0) : '';
    $res2 = DB::pq($sql, [$user_id]);
    return array_map(function ($item) use ($res2) {
        $item['comments'] = $res2[$item['id']]['comments'] ?? 0;
        return $item;
    }, $res);
}

function getCountPostBySubscription($user_id)
{
    $sql = 'SELECT COUNT(*) FROM posts WHERE user_id IN (SELECT subscription_id FROM subscribers WHERE subscriber_id = ?)';
    return DB::pq($sql, [$user_id])[0]['COUNT(*)'];
}

function getPostById($id)
{
    $sql = "SELECT posts.*, users.login, users.avatar_path, COUNT(likes.post_id) as like_count 
            FROM posts left join users on posts.user_id = users.id 
                left JOIN likes ON posts.id = likes.post_id WHERE posts.id = ? group by posts.id ORDER BY posts.created_at DESC";
    $res = DB::pq($sql, [$id]);
    $sql = "SELECT COUNT(comments.post_id) as comments FROM comments WHERE comments.post_id = ? ORDER BY comments.created_at DESC";
    $res2 = DB::pq($sql, [$id]);
    return [array_merge($res[0] ?? [
        ], $res2[0] ?? [])];

}

function getPostByUser($user)
{
    $sql = "SELECT posts.*, users.login, users.avatar_path, COUNT(comments.id) as comments, COUNT(likes.post_id) as like_count FROM posts LEFT join users on posts.user_id = users.id left JOIN comments ON posts.id = comments.post_id left JOIN likes ON posts.id = likes.post_id WHERE users.login = ? group by posts.id ORDER BY posts.created_at DESC";
    return DB::pq($sql, [$user]);
}

//function getPostByUserId($id, $fullInf = true)
//{
//    if ($fullInf == false) {
//        $sql = "SELECT * FROM posts WHERE user_id = ?";
//    } else {
//        $sql = "SELECT posts.*, users.login, users.avatar, COUNT(comments.id) as comments FROM posts LEFT join users on posts.user_id = users.id left JOIN comments ON posts.id = comments.post_id WHERE posts.user_id = ? group by posts.id ";
//    }
//    return DB::pq($sql, [$id]);
//}

function addPost($title, $content, $user_id)
{
    $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
    return DB::pu($sql, [$title, $content, $user_id]);
}

function updatePost($id, $title, $content)
{
    $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    return DB::pu($sql, [$title, $content, $id]);
}

function updateViewCount($id)
{
    $sql = "UPDATE posts SET view_count = view_count + 1 WHERE id = ?";
    DB::pu($sql, [$id]);
}

function likeUnlikePost($user_id, $id)
{
    $getSql = "SELECT * FROM likes WHERE user_id = ? AND post_id = ?";
    $get = DB::pq($getSql, [$user_id, $id]);
    if (count($get) == 0) {
        try {
            $sql = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
            DB::pq($sql, [$user_id, $id]);
        } catch (Exception $e) {
            return false;
        }
    } else {
        try {
            $sql = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
            DB::pq($sql, [$user_id, $id]);
        } catch (Exception $e) {
            return false;
        }
    }
}