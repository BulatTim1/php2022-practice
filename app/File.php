<?php
namespace App\Controllers;
//ini_set("upload_max_filesize", "2K");
function saveFile($fileArr, $pathInUploads)
{
    if ($fileArr["error"] == 0) {
        $dir = "uploads/";
        $filename = basename($fileArr["name"]);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $acceptExt = ["png", "jpg", "jpeg"];
        if (in_array($ext, $acceptExt)) {
            $tmp = $fileArr["tmp_name"];
            $uploadFileName = uniqid() . "_" . strtolower($filename);
            $res = move_uploaded_file($tmp, $dir.$uploadFileName);
            return [
                'res' => $res,
                'filename' => $uploadFileName,
                'path' => $dir.$uploadFileName
            ];
        } else {
            return [
                'res' => false,
                'filename' => '',
                'path' => '',
                'error' => 'Неверный формат файла'
            ];
        }
    } else {
        return [
            'res' => false,
            'filename' => '',
            'path' => '',
            'error' => 'Ошибка загрузки'
        ];
    }
}