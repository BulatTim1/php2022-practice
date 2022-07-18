<?php

include 'app/Post.php';
include 'app/scripts.php';

$title = 'Ваша лента';
include 'snippets/header.php';

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1) {
    $page = $_GET['page'];
}

if (!$auth)
{
    $_SESSION['alerts'][] = 'Для просмотра ленты нужно войти!';
    header('Location: /login.php');
    exit();
}

$user = getUser($_SESSION['email']);
$user = count($user) == 0 ? null : $user[0];

?>


<!-- Main -->
<div id="main">
    <div class="inner">
        <section>
            <header class="col-12-large">
                <div class="title">
                    <h2 class="title">Лента новостей</h2>
                </div>
            </header>
        </section>
        <?php
        $posts = getPostsBySubscription($user['id'], 20, $page);
        $count = getCountPostBySubscription($user['id']);
        if (count($posts)) :
            foreach ($posts as $post) :
                ?>
                <!-- Post -->
                <article class="row">
                    <header class="col-12-large">
                        <div class="title">
                            <h2><a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
                        </div>
                    </header>
                    <p class="col-12"><?= word_teaser($post['content'], 50) ?></p>
                    <footer class="row col-12">
                        <ul class="col-3 row" style="list-style: none">
                            <li><a href="/addlike.php?id=<?= $post['id'] ?>" class="icon solid fa-heart"><?= $post['like_count'] ?? 0 ?></a></li>
                            <li><a href="#" class="icon solid fa-eye"><?= $post['view_count'] ?></a></li>
                            <li><a href="#" class="icon solid fa-comment"><?= $post['comments'] ?></a></li>
                        </ul>
                        <div class="col-9 row">
                            <time class="published col-4"
                                  datetime="<?= formatDate($post['date']) ?>"><?= formatDate($post['date']) ?></time>
                            <a href="/blog.php?user=<?= $post['login'] ?>" class="logo col-8">
                                <span class="symbol"><img class="avatar" src="<?= $post['avatar_path'] ?>"
                                                          alt="<?= $post['login'] ?>"></span><span
                                        class="title"><?= $post['login'] ?></span>
                            </a>
                        </div>
                    </footer>
                    <hr class="col-12">
                </article>
            <?php endforeach; ?>
        <?php elseif ($count > 0): ?>
            <p>Вернитесь на главную страницу.</p>
        <?php else : ?>
            <p>На данный момент постов нет.</p>
        <?php endif; ?>

        <!-- Pagination -->
        <ul class="actions pagination">
            <?php if ($page != 1) { ?>
                <li><a href="/?page=<?= $page - 1 ?>" class="button large previous">Предыдущая страница</a></li>
            <?php } else { ?>
                <li><a href="/?page=<?= $page ?>" class="disabled button large previous">Предыдущая страница</a></li>
            <?php } ?>
            <?php
            if (getCountPost() - $page * 20 > 0) { ?>
                <li><a href="/?page=<?= $page + 1 ?>" class="button large next">Следующая страница</a></li>
            <?php } else { ?>
                <li><a href="/?page=<?= $page ?>" class="disabled button large next">Следующая страница</a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php
include 'snippets/footer.php'; ?>
