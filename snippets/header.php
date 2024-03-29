<?php
global $auth;
$auth = false;
$name = 'Guest';

include_once 'app/User.php';

if (IsAuth()) {
    $name = $_SESSION['login'];
    $email = $_SESSION['email'];
    $auth = true;
}
global $title;
if (!isset($title)) {
    $title = 'Title';
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <title><?= $title ?></title>
</head>
<body class="is-preload">

<style>
	.icon.solid:before {
		padding-right: 5px;
	}
	.logo > * {
		display: inline-block;
		vertical-align: middle;
	}
	.logo .symbol {
		margin-right: 0.65em;
	}
	.logo {
		display: block;
		border-bottom: 0;
		color: inherit;
		margin: 0 0 2.5em 0;
		text-decoration: none;
	}
	.logo .symbol img {
		display: block;
		width: 2em;
		height: 2em;
	}
    img.avatar
    {
	    height: 128px;
	    width: 128px;
	    object-fit: cover;
	    border-radius: 50%;
	    margin-bottom: 5px;
    }
</style>
<!-- Wrapper -->
<div id="wrapper">
    <header id="header">
        <div class="inner">
            <!-- Nav -->
            <nav>
                <ul>
                    <li><a href="#menu">Menu</a></li>
                </ul>
            </nav>

        </div>
    </header>