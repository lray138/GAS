<?php namespace lray138\GAS\Arr;

const shuffle = __NAMESPACE__ . '\shuffle';

function shuffle(array $array, int $flags = SORT_REGULAR) {
    \shuffle($array);
    return $array;
}