<?php
include 'include/Database.php';
include 'include/scripts.php';

$user = DB::pq('select * from users where email = ?', [$_SESSION['email']]);
if(count($user) == 0)
{
  session_unset();
}
else if (isset($_SESSION['email']) && $user[0]['session'] == session_id() && session_id() != null)
{
    header ('Location: /index.php');
}

if (!isset($_SESSION['alerts']))
{
    $_SESSION['alerts'] = [];
}

if (isset($_POST['email']) && isset($_POST['password']))
{
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user = DB::pq('select * from users where email = ?', [$email]);
    if (count($user) > 0)
    {
        if ($user[0]['password'] == hash('sha256', $password))
        {
            DB::setSession($email, session_id());
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user[0]['name'];
            header ('Location: /index.php');
        }
        else
        {
            array_push($_SESSION['alerts'] , 'Неверный пароль');
        }
    }
    else
    {
        array_push($_SESSION['alerts'] , 'Неверный email');
    }
}

?>

<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    

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
    <h1 class="h3 mb-3 fw-normal">Войти</h1>

    <?=showAlerts(); ?>

    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Почта</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Пароль</label>
    </div>

    <div class="checkbox mb-3">
      <!-- <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label> -->
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
    <p>Еще не зарегистрированы? <a href="register.php">Зарегистрируйтесь</a></p>
  </form>
</main>


    
  </body>
</html>