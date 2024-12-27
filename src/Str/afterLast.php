<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

const afterLast = __NAMESPACE__ . '\afterLast';

function afterLast() {
    $f = function($delimeter, $string, $include_delimeter = false) {
        $out = afterNth(-1, $delimeter, $string);

        return $include_delimeter 
            ? $delimeter . $out
            : $out;
            
    };

    return curryN(2, $f)(...func_get_args());
}

function afterLast_() {
    return \lray138\GAS\Types\StrType::of(afterLast(...func_get_args()));
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