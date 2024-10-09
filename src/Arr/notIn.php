<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2;

const notIn = __NAMESPACE__ . '\notIn';

// wonder if this came from .. or either way the argument order should
// be reversed

// also, contains and !

/**
 * in the future, building this up with "not contains"
 * doc: https://www.php.net/manual/en/function.in-array.php
 */

function notIn($find, array $haystack) {
    $notIn = function($find, $haystack) {
        return !in_array($find, $haystack);
    };

    return curry2($notIn)(...func_get_args());
}