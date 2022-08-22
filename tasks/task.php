<?php

$arr = [
    [399, 9160, 144, 3230, 407, 8875, 1597, 9835],
    [2093, 3279, 21, 9038, 918, 9238, 2592, 7467],
    [3531, 1597, 3225, 153, 9970, 2937, 8, 807],
    [7010, 662, 6005, 4181, 3, 4606, 5, 3980],
    [6367, 2098, 89, 13, 337, 9196, 9950, 5424],
    [7204, 9393, 7149, 8, 89, 6765, 8579, 55],
    [1597, 4360, 8625, 34, 4409, 8034, 2584, 2],
    [920, 3172, 2400, 2326, 3413, 4756, 6453, 8],
    [4914, 21, 4923, 4012, 7960, 2254, 4448, 1]
];


$new_arr = [];
$fib_summ = 0;

foreach ($arr as $value) {
    foreach ($value as $num) {
        $new_arr[] = $num;
    }
}

echo '<pre>';
foreach ($new_arr as $key => $value) {
    if (
        !array_key_exists($key + 1, $new_arr) ||
        !array_key_exists($key - 1, $new_arr)
    ) {
        continue;
    }

    if ($new_arr[$key + 1] == $new_arr[$key] + $new_arr[$key - 1]) {
        $fib_summ += $new_arr[$key + 1];
    }
}


var_dump($fib_summ);
echo '</pre>';