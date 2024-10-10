<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry2;

const prepend = __NAMESPACE__ . '/prepend';

function prepend() {
    $prepend = function($prepend, $to) {
        return concat($prepend, $to);
    };

    return call_user_func_array(curry2($prepend), func_get_args());
}