<?php
include 'app/User.php';

$title = 'Профиль';
include 'snippets/header.php';

if (!$auth) {
    header('Location: /login.php');
}

$user = getUser($_SESSION['email'])[0];
if (isset($_GET['user']) && $user['role'] == 1) {
    $user = getUser($_GET['user']);
}
?>
    <!-- Main -->
    <div id="main">
        <div class="inner">
            <section>
                <header>
                    <div class="title">
                        <h2 style="margin-left: 50px">Профиль <?= $user['login'] ?></h2>
                    </div>
                </header>
                <?php include "snippets/alerts.php"; ?>
                <form method="POST" action="updateuser.php" enctype="multipart/form-data" class="row">
                    <div>
                        <img class="avatar" src="<?=$user['avatar_path']?>" alt>
                    </div>
                    <label class="col-12">Ваша аватарка: <input type="file" name="file" class="col-6"></label><br>
                    <label class="col-12"><input class="col-6" type="text" name="firstname" value="<?= $user['firstname'] ?>" placeholder="Ваше имя"></label><br>
                    <label class="col-12"><input class="col-6" type="text" name="lastname" value="<?= $user['lastname'] ?>" placeholder="Ваша фамилия"></label><br>
                    <div class="col-12">
                        <label for="demo-message"></label><textarea name="description" id="demo-message" placeholder="Напишите о себе" rows="1" style="overflow: hidden; resize: none; height: 69px;"><?= $user['description'] ?></textarea>
                    </div>

                    <h3 style="margin-top:30px; margin-left: 50px">Смена пароля</h3><br>
                    <label class="col-12"><input class="col-6" type="password" name="oldpassword" placeholder="Старый пароль"></label><br>
                    <label class="col-12"><input class="col-6" type="password" name="password" placeholder="Новый пароль"></label><br>
                    <label class="col-12"><input class="col-6" type="password" name="password2" placeholder="Повторите пароль"></label><br>

                    <input type="hidden" name="user" value="<?= $user['email'] ?>">

                    <label>
                    <input type="submit" value="Сохранить">
                    </label>
                </form>
            </section>
        </div>
    </div>


<?php
include 'snippets/footer.php';
?>