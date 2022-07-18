<?php

function pow_arr($arr, $num)
{
    $result = [];
    foreach ($arr as $key => $value) {
        $result[$key] = pow($value, $num);
    }
    return $result;
}

function word_teaser($string, $count)
{
    $original_string = $string;
    $words = explode(' ', $original_string);

    if (count($words) > $count) {
        $words = array_slice($words, 0, $count);
        $string = implode(' ', $words);
    }

    return $string;
}

function formatDate($str, $date_format='d.m.Y H:i:s')
{
    $date = new DateTime($str);
    return $date->format($date_format);
}

function dd($var)
{
    echo '<h2>'.$var.'</h2>';
    echo '<code>';
    var_dump($var);
    echo '</code>';
    exit;
}