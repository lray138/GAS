<?php namespace lray138\GAS\Str;

const findFirst = __NAMESPACE__ . '\findFirst';

/**
 * 
 */
function findFirst($regex, $string) {
    $matches = [];
    preg_match($regex, $string, $matches);
    return $matches;
}