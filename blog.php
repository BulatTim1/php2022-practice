<?php
include 'app/Post.php';
include 'app/User.php';
include 'app/scripts.php';

if (isset($_GET['user']))
{
    if (count(getUser($_GET['user'])) == 0) {
        array_push($_SESSION['alerts'], 'Пользователь ' . $_GET['user'] . ' не найден');
        header('Location: /index.php');
        exit();
    }
    $posts =  getPostByUser($_GET['user']);
}
else
{
    header('Location: /');
    exit();
}


$title = 'Блог ' . $_GET['user'];
include 'snippets/header.php';
?>


<!-- Main -->
<div id="main">
    <div class="inner">
    <?php
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
        <ul class="actions pagination">
            <li><a href="" class="disabled button large previous">Previous Page</a></li>
            <li><a href="#" class="button large next">Next Page</a></li>
        </ul>
    <?php else : ?>
        <p>На данный момент постов нет.</p>
    <?php endif; ?>
    </div>
</div>
<?php include 'snippets/footer.php'; ?>