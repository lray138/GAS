<?php namespace lray138\GAS\Arr;

const sortReverse = __NAMESPACE__ . '\sortReverse';

function sortReverse(array $array, int $flags = SORT_REGULAR) {
    rsort($array, $flags);
    return $array;
}