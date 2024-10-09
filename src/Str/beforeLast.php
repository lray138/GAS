<?php namespace lray138\GAS\Str;

const beforeLast = __NAMESPACE__ . '\beforeLast';

// added trim right so that I can .. hmmm...
function beforeLast() {
    $beforeLast = function($substring, $string, $trim_right = false) {
        $index = strrpos($string, $substring, 0);
        if($trim_right) {
            $index++;
        }
        return $index === false ? $string : substr($string, 0, $index);
    };
    return call_user_func_array(curry2($beforeLast), func_get_args());
}