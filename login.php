<?php
include 'app/User.php';
include 'app/scripts.php';

$title = 'Вход';
include 'snippets/header.php';

if ($auth) {
    header('Location: /index.php');
    exit();
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user = getUser($email);

    if (!isset($_SESSION['alerts'])) {
        $_SESSION['alerts'] = [];
    }

    if (count($user) > 0) {
        if ($user[0]['password'] == hash('sha256', $password)) {
            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['login'] = $user[0]['login'];
            header('Location: /index.php');
        } else {
            $_SESSION['alerts'][] = 'Неверный пароль';
        }
    } else {
        $_SESSION['alerts'][] = 'Неверный email';
    }
}
?>
<!-- Main -->
<div id="main">
    <div class="inner">
        <section>
            <h2>Вход</h2>
            <?php include "snippets/alerts.php"; ?>
            <form method="post">
                <div class="row gtr-uniform">
                    <div class="col-12">
                        <input type="text" name="email" value="" placeholder="Email или логин"/>
                    </div>
                    <div class="col-12">
                        <input type="password" name="password" value="" placeholder="Пароль"/>
                    </div>
                    <div class="col-12">
                        <ul class="actions">
                            <li><input type="submit" value="Войти"/></li>
                        </ul>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php include 'snippets/footer.php'; ?>
