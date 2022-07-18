<?php
include 'app/Post.php';
include 'app/User.php';
include 'app/scripts.php';

if (isset($_GET['user'])) {
    $author = getUser($_GET['user']);
    if (count($author) == 0) {
        array_push($_SESSION['alerts'], 'Пользователь ' . $_GET['user'] . ' не найден');
        header('Location: /index.php');
        exit();
    }
    $author = $author[0];
    $posts = getPostByUser($_GET['user']);
} else {
    header('Location: /');
    exit();
}

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1) {
    $page = $_GET['page'];
}

$title = 'Блог ' . $_GET['user'];
include 'snippets/header.php';

$user = getUser($_SESSION['login']);
$user = count($user) == 0 ? null : $user[0];
$isSub = count(isSubscribed($user['id'], $author['id'])) == 0;

?>


    <!-- Main -->
    <div id="main">
        <div class="inner">
            <section style="margin-bottom: 50px;">
                <div>
                    <img class="avatar" src="<?= $author['avatar_path'] ?>" alt>
                </div>
                <header class="col-12-large">
                    <div class="title">
                        <h2 class="title">Блог <?= $_GET['user'] ?></h2>
                    </div>
                    <div class="description">
                        <p>Описание: <?= $author['description'] ?></p>
                        <?php if ($auth && $user['id'] != $author['id']) :?>
                        <a href="/subscribe.php?user=<?= $_GET['user'] ?>" class="button <?= $isSub ? '': 'primary'?>"><?= $isSub ? 'Подписаться' : 'Отписаться'?></a>
                        <?php endif; ?>
                    </div>
                </header>
            </section>
            <?php
            if (count($posts)) :
                foreach (array_slice($posts, 20 * ($page - 1), 20) as $post) :
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
                                <li><a href="/addlike.php?id=<?= $post['id'] ?>"
                                       class="icon solid fa-heart"><?= $post['like_count'] ?? 0 ?></a></li>
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
                <!-- Pagination -->
                <ul class="actions pagination">
                    <?php
                    $params = $_GET;
                    if ($page != 1) { ?>
                        <li><a href="/blog.php?<?php
                            $params['page'] = $page - 1;
                            echo http_build_query($params); ?>" class="button large previous">Предыдущая страница</a></li>
                    <?php } else { ?>
                        <li><a href="/blog.php?<?php
                            $params['page'] = $page;
                            echo http_build_query($params); ?>" class="disabled button large previous">Предыдущая страница</a></li>
                    <?php } ?>
                    <?php
                    if (count($posts) - $page * 20 > 0) { ?>
                        <li><a href="/blog.php?<?php
                            $params['page'] = $page + 1;
                            echo http_build_query($params); ?>" class="button large next">Следующая страница</a></li>
                    <?php } else { ?>
                        <li><a href="/blog.php?<?php
                            $params['page'] = $page;
                            echo http_build_query($params); ?>" class="disabled button large next">Следующая страница</a></li>
                    <?php } ?>
                </ul>
            <?php else :
                ?>
                <p>На данный момент постов нет.</p>
            <?php endif; ?>
        </div>
    </div>
<?php include 'snippets/footer.php'; ?>