<?php namespace lray138\GAS\Str;

const afterLast = __NAMESPACE__ . '\afterLast';

use function lray138\GAS\Functional\curry2 as curry;

function afterLast() {
    $f = function($delimeter, $string, $include_delimeter = false) {
        $out = afterNth(-1, $delimeter, $string);

        return $include_delimeter 
            ? $out . $delimeter
            : $out;
            
    };

    return curry($f)(...func_get_args());
}


/**
 * 
 */
// for example, after last '.' for extension, but 
// we want to include the delimiter for better matching
function afterLast_Woah() {
    $afterLast = function($substring, $string, $include_delimeter = false) {
        $index = strrpos($string, $substring);
        // if we wanted to include the character we would not add 1... 
        $start = ($index !== 0) ? $index + 1 : strlen($substring);
        $length = ($index !== 0) ? strlen($string)-$index : (strlen($string) - strlen($substring));
        $out = $index === false ? $string : substr($string, $start, $length);
        return $include_delimeter ? $substring . $out : $out;
    };
    return curry2($afterLast)(...func_get_args());
}