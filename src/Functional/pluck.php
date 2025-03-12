<?php namespace lray138\GAS\Functional;

const pluck = __NAMESPACE__ . '\pluck';

/**
 * Function description.
 */
function pluck() {
    $f = function($key, $source) {
        if($source instanceof \lray138\GAS\Types\ArrType) {
            return $source->prop($key);
        }

        if(is_array($source)) {
            return isset($source[$key]) ? $source[$key] : null;
        }

        if(is_object($source)) {
            return isset($source->$key) ? $source->$key : null;
        }
    };

    return curry2($f)(...func_get_args()); 
}

function prop(...$args) {
    return pluck(...$args);
}