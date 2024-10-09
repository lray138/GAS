<?php namespace lray138\GAS\Str;

const contains = __NAMESPACE__ . '\contains';

/**
 * 
 */
function contains() {
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