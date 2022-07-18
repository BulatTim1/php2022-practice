<?php
namespace App\View;

include 'app/Post.php';
include 'app/scripts.php';

$title = 'Главная страница';
include 'snippets/header.php';

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1) {
    $page = $_GET['page'];
}

?>


<!-- Main -->
<div id="main">
    <div class="inner">
        <?php
        $top20_posts = getAllPost(20, $page);
        if (count($top20_posts)) :
            foreach ($top20_posts as $post) :
                ?>
                <!-- Post -->
                <article class="row">
                    <header class="col-12-large">
                        <div class="title">
                            <h2><a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
                        </div>
                    </header>
                    <p class="col-12"><?= word_teaser($post['body'], 50) ?></p>
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
                                <span class="symbol"><img src="uploads/avatars/<?= $post['avatar'] ?>"
                                                          alt="<?= $post['login'] ?>"></span><span
                                        class="title"><?= $post['login'] ?></span>
                            </a>
                        </div>
                    </footer>
                    <hr class="col-12">
                </article>
            <?php endforeach; ?>
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
</div>
<?php
include 'snippets/footer.php'; ?>
