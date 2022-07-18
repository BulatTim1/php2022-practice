<?php
require_once 'app/Database.php';

function getAllCommentsByPost($post_id, $user_name = false, $asd = true)
{
    if ($user_name == false) {
        $sql = "SELECT * FROM comments WHERE post_id = ?";
    } else {
        $sql = "SELECT comments.*, users.login, users.avatar_path FROM comments LEFT join users on comments.user_id = users.id WHERE post_id = ? order by comments.created_at " . ($asd ? 'asc' : 'desc');
    }
    return DB::pq($sql, [$post_id]);
}

function getCommentById($id)
{
    $sql = "SELECT * FROM comments WHERE id = ?";
    return DB::pq($sql, [$id]);
}

function addComment($post_id, $user_id, $body)
{
    $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)";
    DB::pu($sql, [$post_id, $user_id, $body]);
}

function getCommentByUser($user_id)
{
    $sql = "SELECT * FROM comments WHERE user_id = ?";
    return DB::pq($sql, [$user_id]);
}

function deleteComment($id)
{
    $sql = "DELETE FROM comments WHERE id = ?";
    DB::pq($sql, [$id]);
}