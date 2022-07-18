<?php
include 'app/Post.php';
include 'app/User.php';
include 'app/Comment.php';
include 'app/scripts.php';

$title = 'Пост '. $_GET['user'] ;
include 'snippets/header.php';

?>



<!-- Main -->
<div id="main">
    <div class="inner">
	<?php
	$post = isset($_GET['id']) ? getPostById($_GET['id'], true) : [];
	if (count($post[0]) <= 1) {
		echo '<p>Пост не найден</p>';
	} else {
		$post = $post[0];

		updateViewCount($post['id']);
		$post['view_count']++;
	?>
        <section>
            <div>
                <img class="avatar" src="<?= $post['avatar_path'] ?>" alt>
            </div>
            <header class="col-12-large">
                <div class="title">
                    <a href="/blog.php?user=<?= $post['login'] ?>"><h2 class="title">Блог <?= $post['login'] ?></h2></a>
                </div>
            </header>
        </section>
		<!-- Post -->
        <article class="row">
            <header class="col-12-large">
                <div class="title">
                    <h1><?= $post['title'] ?></h1>
                </div>
            </header>
            <p class="col-12"><?= word_teaser($post['content'], 50) ?></p>
            <footer class="row col-12">
                <ul class="col-3 row" style="list-style: none">
                    <li><a href="/addlike.php?id=<?= $post['id'] ?>" class="icon solid fa-heart"><?= $post['like_count'] ?? 0 ?></a></li>
                    <li><a href="" class="icon solid fa-eye"><?= $post['view_count'] ?></a></li>
                    <li><a href="" class="icon solid fa-comment"><?= $post['comments'] ?></a></li>
                </ul>
                <div class="col-10 row">
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
		<article class="row">
				<section>
			<?php if ($auth) {?>
					<h3>Написать комментарий</h3>
					<form method="POST" action="addcomment.php">
						<div class="row gtr-uniform">
							<div class="col-12">
								<textarea name="content" placeholder="Комментарий" rows="2"></textarea>
								<input type="text" name="id" value="<?= $_GET['id'] ?>" hidden style="display: none;">
							</div>
							<div class="col-12">
								<ul class="actions">
									<li><input type="submit" value="Прокомментировать" /></li>
								</ul>
							</div>
						</div>
					</form>
			<?php } else { ?>
					<h3>Чтобы комметировать запись вы должны войти или зарегестрироваться</h3>
			<?php } ?>
			</section>
            <hr class="col-12">
		</article>

		<?php
		$comments = getAllCommentsByPost($_GET['id'], true, false);
		if (count($comments) != 0) {
			echo '<h3>Комментарии</h3>';
		}

		foreach ($comments as $comment) :
		?>
            <article class="row">
                <header class="col-12-large">
                    <div class="title">
                        <h2><?= $comment['comment'] ?></h2>
                    </div>
                </header>
                <footer class="row col-12">
                    <div class="col-10 row">
                        <time class="published col-4"
                              datetime="<?= formatDate($comment['date']) ?>"><?= formatDate($comment['date']) ?></time>
                        <a href="/blog.php?user=<?= $comment['login'] ?>" class="logo col-8">
                                <span class="symbol"><img class="avatar" src="<?= $comment['avatar_path'] ?>"
                                                          alt="<?= $comment['login'] ?>"></span><span
                                    class="title"><?= $comment['login'] ?></span>
                        </a>
                    </div>
                </footer>
                <hr class="col-12">
            </article>
		<?php endforeach; ?>
	<?php } ?>
    </div>



</div>
<?php
include 'snippets/footer.php';
?>