<?php
require "db.php";

DB::connect();
$title = $_POST["title"];
$text = $_POST["text"];
ini_set("upload_max_filesize", "2K");

if ($_FILES["file"]["error"] == 0) {
    $dir = "uploads/";
//    $filename = basename($_FILES["file"]["name"]);
    $filename = DB::getLastId("posts");
    $ext = strtolower(explode(".", $filename)[1]);
    $acceptExt = ["png", "jpg", "jpeg"];
    if (in_array($ext, $acceptExt)) {
        $tmp = $_FILES["file"]["tmp_name"];
        $uploadFileName = $dir . strtolower($filename);
        $res = move_uploaded_file($tmp, $uploadFileName);
        echo "<a href=$uploadFileName>$uploadFileName</a>";
//        if ($res) {
//            header("Location: " . $_SERVER["HTTP_REFERER"]);
//        }
    } else {
        echo "Неверный формат файла";
    }
}
