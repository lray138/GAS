<?php namespace lray138\GAS\Arr;

const sortMaintainKeys = __NAMESPACE__ . '\sortMaintainKeys';

function sortMaintainKeys(array $array, int $flags = SORT_REGULAR) {
    asort($array, $flags);
    return $array;
}
