<?php
include 'app/User.php';
if (isset($_SESSION['email'])) {
    updateSessionByEmail($_SESSION['email'], 'NULL');
}
session_unset();
session_reset();
session_destroy();
header ('Location: /index.php' ); //$_SERVER['HTTP_REFERER']