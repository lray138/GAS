<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2;

const implode = __NAMESPACE__ . '\implode';

function implode() {
    return call_user_func_array(curry2('\implode'), func_get_args());
}