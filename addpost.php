<?php
include 'app/User.php';
include 'app/Post.php';
include 'app/scripts.php';

$title = 'Добавить пост';
include 'snippets/header.php';

if (!$auth) {
    header('Location: /login.php');
}

$user = getUser($_SESSION['email'])[0];

if (isset($_POST['title']) && isset($_POST['content'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!isset($_SESSION['alerts'])) {
        $_SESSION['alerts'] = [];
    }

    if (isset($user['id'])) {
        addPost($title, $content, $user['id']);
        header('Location: /blog.php?user=' . $user['login']);
        exit();
    }
}
?>

    <!-- Main -->
    <div id="main">
        <div class="inner">
            <section>
                <header>
                    <div class="title">
                        <h2 style="margin-left: 50px">Добавление поста</h2>
                    </div>
                </header>
                <?php include "snippets/alerts.php"; ?>
                <form method="POST" class="row">
                    <label class="col-12"><input class="col-6" type="text" name="title" placeholder="Заголовок"></label><br>
                    <label class="col-12"><textarea type="text" name="content" placeholder="Текст" rows="1" cols="3"></textarea></label><br>
                    <label>
                        <input type="submit" value="Добавить">
                    </label>
                </form>
            </section>
        </div>
    </div>


<?php
include 'snippets/footer.php';
?>