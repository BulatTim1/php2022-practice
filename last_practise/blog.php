<?php
include 'include/Database.php';
$user;
if (isset($_GET['user']))
{
    $user = $_GET['user'];
}
else
{
    $user = 'admin';
}
?>
<?php include 'templates/header.php'?>
<link href="blog.css" rel="stylesheet">
<article class="blog-post">
<?php
foreach(DB::pq("SELECT * FROM posts WHERE user_id IN (SELECT id FROM users WHERE name = ?);", [$user]) as $post)
{
    echo '<div class="post">';
    echo '<h2 class="blog-post-title">'.$post['title'].'</h2>';
    echo '<p class="blog-post-meta">'.$post['date'].'</p>';
    echo '<div class="blog-post-body">'.$post['body'].'</p>';
    echo '</div>';
}
?>
</article>
<?php include 'templates/footer.php'?>
