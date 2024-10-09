<?php namespace lray138\GAS\Math;

const divideBy = __NAMESPACE__ . '\divideBy';

function divideBy() {
    return call_user_func_array(FP\flip(divide), func_get_args());
}