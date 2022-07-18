<?php
include 'include/Database.php';
include 'include/scripts.php';

if (isset($_SESSION['email']) && DB::pq('select * from users where email = ?', [$_SESSION['email']])[0]['session'] == session_id() && session_id() != null)
{
    header ('Location: /index.php');
    exit();
}

if(!isset($_SESSION['alerts']))
{
    $_SESSION['alerts'] = [];
}

if (isset($_POST['email']) && isset($_POST['user']) && isset($_POST['password']) && isset($_POST['password2']))
{
    $email = trim($_POST['email']);
    $user = trim($_POST['user']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    if ($email == '' || $user == '' || $password == '' || $password2 == '')
    {
        array_push($_SESSION['alerts'] , 'Заполните все поля');
    }
    else if ($password != $password2)
    {
        array_push($_SESSION['alerts'], 'Пароли не совпадают');
    }
    else if (strlen(trim($password)) < 6)
    {
        array_push($_SESSION['alerts'], 'Пароль должен быть не менее 6 символов');
    }
    else
    {
        $arr = DB::pq('select * from users where (email = ? or user = ?)', [$email, $user]);
        if (count($arr) > 0)
        {
            array_push($_SESSION['alerts'], 'Email существует или имя уже занято');
        }
        else
        {
            DB::addUser($email, $user, $password);
            DB::setSession($email, session_id());
            $_SESSION['email'] = $email;
            $_SESSION['user'] = $user;
            header ('Location: /index.php');
            exit();
        }
    }
}
?>

<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация</title>

    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/"> -->

    

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin">
  <form method="POST">
    <h1 class="h3 mb-3 fw-normal">Регистрация</h1>

    <?=showAlerts(); ?>

    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Почта</label>
    </div>
    <div class="form-floating">
        <input type="text" name="name" class="form-control" id="floatingName" placeholder="Имя">
        <label for="floatingInput">Имя</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Пароль">
      <label for="floatingPassword">Пароль</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password2" class="form-control" id="floatingPassword2" >
      <label for="floatingPassword2">Повторите пароль</label>
    </div>

    <div class="checkbox mb-3">
      <!-- <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label> -->
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Зарегистрироваться</button>
    <p>Уже зарегистрированы? <a href="login.php">Войдите</a></p>
  </form>
</main>
  </body>
</html>