<?php
//ini_set("upload_max_filesize", "2K");
function saveFile($fileArr)
{
    if ($fileArr["error"] == 0) {
        $dir = "uploads/";
        $filename = basename($fileArr["name"]);
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $ext2 = strtolower($fileArr["type"]);
        $acceptExt = ["png", "jpg", "jpeg"];
        $acceptExt2 = ["image/png", "image/jpg", "image/jpeg"];
        if (in_array($ext, $acceptExt) && in_array($ext2, $acceptExt2)) {
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