<?php
include "include/scripts.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pow example</title>
</head>
<body>
    <form action="" method="get">
        <label>Массив: <input type="text" name="arr" placeholder="Массив из чисел через пробел"></label>
        <label>Степень: <input type="number" name="num"></label>
        <input type="submit" value="Вычислить">
    </form>

    <?php
    if (isset($_GET['arr']) && isset($_GET['num'])) {
        $arr = explode(' ', $_GET['arr']);
        $num = $_GET['num'];
        $result = pow_arr($arr, $num);
        echo '<pre>';
        foreach ($result as $i) {
            echo $i. '<br>';
        }
        echo '</pre>';
    }
    ?>
</body>
</html>