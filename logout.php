<?php
include 'app/User.php';
session_unset();
session_reset();
session_destroy();
header ('Location: /index.php' ); //$_SERVER['HTTP_REFERER']