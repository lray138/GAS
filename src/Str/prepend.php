<?php namespace lray138\GAS\Str;


// This file contains the implementation of the function: prepend

const prepend = __NAMESPACE__ . '/prepend';

function prepend() {
    $prepend = function($prepend, $to) {
        return concat($prepend, $to);
    };

    return call_user_func_array(curry2($prepend), func_get_args());
}