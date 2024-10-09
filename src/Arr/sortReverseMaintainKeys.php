<?php namespace lray138\GAS\Arr;

const sortReverseMaintainKeys = __NAMESPACE__ . '\sortReverseMaintainKeys';

function sortReverseMaintainKeys(array $array, int $flags = SORT_REGULAR) {
    arsort($array, $flags);
    return $array;
}