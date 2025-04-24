<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2;
use function lray138\GAS\dump; 

const get = __NAMESPACE__ . '\get';

/**
 * 
 */
function get() {
    $get = function($key, $array) {

        if(is_object($array) && get_class($array) == 'lray138\GAS\Types\ArrType') {
           $array = $array->extract();
        }

        if(!is_array($array)) {
            return null;
        }

        if(is_null($array) || count($array) === 0) {
            return null;
        }
        
        return isset($array[$key]) ? $array[$key] : null;
    };

    return call_user_func_array(curry2($get), func_get_args());
}