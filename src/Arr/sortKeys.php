<?php namespace lray138\GAS\Arr;

const sortKeys = __NAMESPACE__ . '\sortKeys';

function sortKeys(array $array, int $flags = SORT_REGULAR) {
    ksort($array, $flags);
    return $array;
}