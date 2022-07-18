<?php
namespace App\Snippets;
?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
<nav id="menu">
    <div class="inner">
        <h2>Блог</h2>
        <ul>
            <li><a href="/">Главная</a></li>
            <?php if (isset($name) && $name != 'Guest') : ?>
                <li><a href="/blog.php?user=<?= $name ?>">Ваш блог</a></li>
                <li><a href="/addpost.php">Добавить пост</a></li>
                <li><a href="/profile.php"><?= $_SESSION['login'] ?></a></li>
                <li><a href="/logout.php">Выйти</a></li>
            <?php else : ?>
                <li><a href="/login.php">Войти</a></li>
                <li><a href="/register.php">Регистрация</a></li>
            <?php endif; ?>
        </ul>
        </ul>
    </div><a class="close" href="#menu">Close</a></nav>

</body>

</html>
