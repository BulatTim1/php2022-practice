<?php
include "include/Database.php";
$info = DB::pq('select role, session from users where email = ?', [$_SESSION['email']])[0];
if($info['session'] == session_id() && $info['role'] == 1)
{
    phpinfo(-1);
}
else {
    header('Location: /index.php');
}