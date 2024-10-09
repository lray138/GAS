<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry3;

const getOrElse = __NAMESPACE__ . '\getOrElse';

/**
 *
 */
function getOrElse() {
    $f = function($key, $else, $array) {       
        $result = get($key, $array); 
        return is_null($result) ? $else : $result;
    };

    return curry3($f)(...func_get_args());
}