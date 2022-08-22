<?php
echo '<pre>';
$arr = range(1, 10000);

foreach ($arr as $key => $value) {
    $num_arr = str_split($value);

    if (count($num_arr) < 3) {
        continue;
    }

    foreach ($num_arr as $num_arr_key => $num_arr_value) {
        if (
            !array_key_exists($num_arr_key + 1, $num_arr) ||
            !array_key_exists($num_arr_key + 2, $num_arr)
        ) {
            continue;
        }

        if (
            (($num_arr_value + 1) == $num_arr[$num_arr_key + 1]) &&
            (($num_arr_value + 2) == $num_arr[$num_arr_key + 2])
        ) {
            unset($arr[$key]);
            break;
        }
    }
}

$summ = array_sum($arr);
var_dump($summ);
echo '</pre>';
