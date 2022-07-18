<?php
include 'app/User.php';
include 'app/File.php';
include 'app/scripts.php';

if(IsAuth() && isset($_POST))
{
    $user = getUser($_SESSION['email']);
    if ($user[0]['role'] == 1 || $user[0]['login'] == $_POST['user'])
    {
        $user = getUser($_POST['user']);
    }
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $birthday = trim($_POST['birthday']);
    $oldpassword = trim($_POST['oldpassword']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);
    // dd([$firstname, $lastname, $birthday, $oldpassword, $password, $password2]);

    if (strlen($firstname) > 0)
    {
        $user[0]['firstname'] = $firstname;
    }

    if (strlen($lastname) > 0)
    {
        $user[0]['lastname'] = $lastname;
    }

    if (strlen($birthday) > 0)
    {
        $user[0]['birthday'] = $birthday;
    }

    if (strlen($oldpassword) > 0)
    {
        if (hash('sha256', $oldpassword) == $user[0]['password'])
        {
            if (strlen($password) > 0 && strlen($password2) > 0)
            {
                if ($password == $password2)
                {
                    $user[0]['password'] = hash('sha256', $password);
                }
                else
                {
                    array_push($_SESSION['alerts'], 'Пароли не совпадают');
                }
            }
        }
        else
        {
            array_push($_SESSION['alerts'], 'Неверный пароль');
        }
    }
    dd($_FILES);
    if (isset($_FILES['file']))
    {
        $res = saveFile($_FILES["file"], 'avatars/');
        if ($res['res'])
        {
            $user[0]['avatar'] = $res['file'];
        }
        else
        {
            array_push($_SESSION['alerts'], $res['error']);
        }
    }
    dd($user);
    updateUser($user[0]);
    // header ('Location: /profile.php?user='.$user[0]['login']);
    exit();
}