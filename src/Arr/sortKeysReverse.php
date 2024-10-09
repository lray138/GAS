<?php namespace lray138\GAS\Arr;

const sortKeysReverse = __NAMESPACE__ . '\sortKeysReverse';

function sortKeysReverse(array $array, int $flags = SORT_REGULAR) {
    krsort($array, $flags);
    return $array;
}