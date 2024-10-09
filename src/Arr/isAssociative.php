<?php namespace lray138\GAS\Arr;

const isAssociative = __NAMESPACE__ . '\isAssociative';

function isAssociative(array $array) {
    $keys = array_keys($array);
    return array_keys($keys) !== $keys;
}