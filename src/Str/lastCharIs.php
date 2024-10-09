<?php namespace lray138\GAS\Str;

const lastCharIs = __NAMESPACE__ . '/lastCharIs';

function lastCharIs() {
    $lastCharIs = function($char, $string) {
        return substr($string, strlen($string)-1, 1) === $char;
    };

    return call_user_func_array(curry2($lastCharIs), func_get_args());
}