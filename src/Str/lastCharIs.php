<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry2;

const lastCharIs = __NAMESPACE__ . '/lastCharIs';

function lastCharIs() {
    $lastCharIs = function($char, $string) {
        return lastChar($string) === $char;
    };

    return call_user_func_array(curry2($lastCharIs), func_get_args());
}