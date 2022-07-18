<?php
include 'app/User.php';

if (IsAuth()) {
    header('Location: /index.php');
    exit();
}

if (!isset($_SESSION['alerts'])) {
    $_SESSION['alerts'] = [];
}

if (isset($_POST['email']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password2'])) {
    $email = trim($_POST['email']);
    $user = trim($_POST['login']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    if ($email == '' || $user == '' || $password == '' || $password2 == '') {
        array_push($_SESSION['alerts'], 'Заполните все поля');
    } else if ($password != $password2) {
        array_push($_SESSION['alerts'], 'Пароли не совпадают');
    } else if (strlen(trim($password)) < 6) {
        array_push($_SESSION['alerts'], 'Пароль должен быть не менее 6 символов');
    } else {
        $arr = getUser($email, $user);
        if (count($arr) > 0) {
            array_push($_SESSION['alerts'], 'Email существует или имя уже занято');
        } else {
            addUser($user, $email, hash('sha256', $password));
            $_SESSION['email'] = $email;
            $_SESSION['login'] = $user;
            header('Location: /index.php');
            exit();
        }
    }
}
include('snippets/head.php');
echo '<title>Регистрация</title>';
include('snippets/header.php');
?>
    <!-- Main -->
    <div id="main">
        <div class="inner">
            <section>
                <h2>Регистрация</h2>
                <?php include "snippets/alerts.php"; ?>
                <form method="post">
                    <div class="row gtr-uniform">
                        <div class="col-12">
                            <input type="text" name="login" value="" placeholder="Логин"/>
                        </div>
                        <div class="col-12">
                            <input type="email" name="email" value="" placeholder="Email"/>
                        </div>
                        <div class="col-12">
                            <input type="password" name="password" value="" placeholder="Пароль"/>
                        </div>
                        <div class="col-12">
                            <input type="password" name="password2" value="" placeholder="Подтверждение пароля"/>
                        </div>
                        <div class="col-12">
                            <ul class="actions">
                                <li><input type="submit" value="Зарегестрироваться"/></li>
                                <li><input type="reset" value="Сбросить данные"/></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
<?php include 'snippets/footer.php'; ?>