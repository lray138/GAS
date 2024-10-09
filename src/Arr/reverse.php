<?php namespace lray138\GAS\Arr;

const reverse = __NAMESPACE__ . '\reverse';

/**
 * just an alias, included for coverage
 */ 
function reverse(array $array): array {
    return array_reverse($array);
}