<?php
require_once 'app/Database.php';

// class User
// {
//     public $id;
//     public $username;
//     public $password;
//     public $email;
//     public $created_at;
//     public $birthday;
//     public $role;
//     public $avatar;
//     public $about;
//     public $firstname;
//     public $lastname;
// }


function getUserById($id)
{
    $sql = "SELECT * FROM users WHERE id = ?";
    return DB::pq($sql, [$id]);
}

function searchUsers($login)
{
    $sql = "SELECT * FROM users WHERE login LIKE ?";
    return DB::pq($sql, ["%$login%"]);
}

// function getUserByLogin($login)
// {
//     $sql = "SELECT * FROM users WHERE login = ?";
//     return DB::pq($sql, [$login]);
// }

// function getUserByEmail($email)
// {
//     $sql = "SELECT * FROM users WHERE email = ?";
//     return DB::pq($sql, [$email]);
// }

function getUser($emailOrLogin, $login = null)
{
    $sql = "SELECT * FROM users WHERE email = ? OR login = ?";
    return DB::pq($sql, [$emailOrLogin, isset($login) ? $login : $emailOrLogin]);
}

function addUser($login, $email, $password)
{
    $sql = "INSERT INTO users (login, email, password) VALUES (?, ?, ?)";
    DB::pu($sql, [$login, $email, $password]);
}

// function updateUser($id, $login, $email, $password, $image_path)
// {
//     $sql = "UPDATE users SET login = ?, email = ?, password = ?, image_path = ? WHERE id = ?";
//     return DB::pu($sql, [$login, $email, $password, $image_path, $id]);
// }

function updateUser($user)
{
    $sql = "UPDATE users SET ";
    $params = [];
    if(isset($user['firstname'])){
        $sql .= "firstname = :firstname, ";
        $params['firstname'] = $user['firstname'];
    }
    if(isset($user['lastname'])){
        $sql .= "lastname = :lastname, ";
        $params['lastname'] = $user['lastname'];
    }
    if(isset($user['description'])){
        $sql .= "description = :description, ";
        $params['description'] = $user['description'];
    }
    if(isset($user['avatar_path'])){
        $sql .= "avatar_path = :avatar_path, ";
        $params['avatar_path'] = $user['avatar_path'];
    }
    if(isset($user['role'])){
        $sql .= "role = :role, ";
        $params['role'] = $user['role'];
    }
    if(isset($user['password'])){
        $sql .= "password = :password, ";
        $params['password'] = $user['password'];
    }
    $sql = substr($sql, 0, -2);
    if (isset($user['id'])) {
        $sql .= " WHERE id = :id";
        $params['id'] = $user['id'];
    } else if (isset($user['email'])) {
        $sql .= " WHERE email = :email";
        $params['email'] = $user['email'];
    } else if (isset($user['login'])) {
        $sql .= " WHERE login = :login";
        $params['login'] = $user['login'];
    } else {
        array_push($_SESSION['alerts'], 'Невозможно обновить пользователя');
        return false;
    }
    return DB::pu($sql, $params);
}

function deleteUser($id)
{
    $sql = "DELETE FROM users WHERE id = ?";
    return DB::pu($sql, [$id]);
}

function getAllUsers($count = -1)
{
    if ($count == -1) {
        $sql = "SELECT * FROM users";
    } else {
        $sql = "SELECT * FROM users LIMIT $count";
    }
    return DB::q($sql);
}

function getRoleByUserId($id)
{
    $sql = "SELECT role FROM users WHERE id = ?";
    return DB::pq($sql, [$id]);
}

function isSubscribed($user_id, $sub_id)
{
    if ($user_id == $sub_id) {
        return [];
    }
    $sql = "SELECT * FROM subscribers WHERE subscriber_id = ? AND subscription_id = ?";
    return DB::pq($sql, [$user_id, $sub_id]);
}

function subUnsub($user_id, $sub_id)
{
    if ($user_id == $sub_id) {
        return false;
    }
    $getSql = "SELECT * FROM subscribers WHERE subscriber_id = ? AND subscription_id = ?";
    $get = DB::pq($getSql, [$user_id, $sub_id]);
    if (count($get) == 0) {
        try {
            $sql = "INSERT INTO subscribers (subscriber_id, subscription_id) VALUES (?, ?)";
            DB::pu($sql, [$user_id, $sub_id]);
        } catch (Exception $e) {
            return false;
        }
    } else {
        try {
            $sql = "DELETE FROM subscribers WHERE subscriber_id = ? AND subscription_id = ?";
            DB::pu($sql, [$user_id, $sub_id]);
        } catch (Exception $e) {
            return false;
        }
    }
    return true;
}

function IsAuth()
{
    if (isset($_SESSION['email'])){
        $user = getUser($_SESSION['email']);
    } else {
        return false;
    }
    if(count($user) == 0)
    {
        header ('Location: /logout.php');
        exit();
    }
    else if ($_SESSION['login'] == $user[0]['login'])
    {
        return true;
    }
    return false;
}
