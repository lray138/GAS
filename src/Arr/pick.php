<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const pick = __NAMESPACE__ . '\pick';

// if multiple keys are provided it acts like
// pick ? or some other whatever function
function pick() {
    $f = function($keys, $array) {
        if(!is_array($keys)) $keys = [$keys];

        $out = [];
        foreach($keys as $key) {
            if(isset($array[$key])) {
                $out[$key] = $array[$key];
            }
        }

        return $out;
    };
 
    return curry($f)(...func_get_args());
}