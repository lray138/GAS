<?php namespace lray138\GAS\Str;

const wrap = __NAMESPACE__ . '/wrap';

function wrap() {
    $wrap = function($a, $b, $c) {
        return $a . $c . $b;
    };

    return call_user_func_array(curry3($wrap), func_get_args());
}