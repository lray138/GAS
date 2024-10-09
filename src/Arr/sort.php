<?php namespace lray138\GAS\Arr;

const sort = __NAMESPACE__ . '\sort';

/**
 * 
 * Docs: https://www.php.net/manual/en/function.sort.php
 */
function sort(array $array, int $flags = SORT_REGULAR) {
    \sort($array, $flags);
    return $array;
}