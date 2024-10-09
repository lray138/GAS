<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry2; 

const containsAll = __NAMESPACE__ . '\containsAll';

/**
 *
 */
function containsAll() {
    $contains = function($needle, $haystack) {
        if(is_array($needle)) {
            foreach($needle as $n) {
                if(strpos($haystack, $n) === false) {
                    return false;
                }
            }
            return true;
        }
        return strpos($haystack, $needle) !== false;
    };

    return call_user_func_array(curry2($contains), func_get_args());
}