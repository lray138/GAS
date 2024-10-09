<?php namespace lray138\GAS\Arr;

const random = __NAMESPACE__ . '\random';

/**
 * not sure why I approached the end like I did.
 */
function random(array $array) {
    return array_rand($array);
}

/**
 * @param array $array
 *
 * @return mixed
 */
// function random(array $array)
// {
//     if (length($array) === 0) {
//         return null;
//     }

//     $index = Math\random(0, length($array) - 1);

//     return $array[$index];
// }