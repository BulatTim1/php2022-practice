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
    if(isset($user['firstname'])){
        $sql .= "firstname = ?, ";
    }
    if(isset($user['lastname'])){
        $sql .= "lastname = ?, ";
    }
    if(isset($user['about'])){
        $sql .= "about = ?, ";
    }
    if(isset($user['avatar'])){
        $sql .= "avatar = ?, ";
    }
    if(isset($user['birthday'])){
        $sql .= "birthday = ?, ";
    }
    if(isset($user['role'])){
        $sql .= "role = ?, ";
    }
    $sql = substr($sql, 0, -2);
    if (isset($user['id'])) {
        $sql .= " WHERE id = ?";
    } else if (isset($user['email'])) {
        $sql .= " WHERE email = ?";
    } else if (isset($user['login'])) {
        $sql .= " WHERE login = ?";
    } else {
        array_push($_SESSION['alerts'], 'Невозможно обновить пользователя');
        return false;
    }
    return DB::pu($sql, array_values($user));
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
    $sql = "SELECT roles.name FROM roles LEFT JOIN users_roles ON roles.id = users_roles.role_id WHERE users_roles.user_id = ?";
    return DB::pq($sql, [$id]);
}

function updateSessionByEmail($email, $session_id)
{
    $sql = "UPDATE users SET session = ? WHERE email = ?";
    DB::pu($sql, [$session_id, $email]);
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
        if ($user[0]['session'] != session_id())
        {
            header ('Location: /logout.php');
            exit();
        } else {
            return true;
        }
    }
    return false;
}
