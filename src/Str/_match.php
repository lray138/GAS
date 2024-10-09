<?php namespace lray138\GAS\Str;

function _match() {
    $match = function($pattern, $subject) {
        $matches = [];
        preg_match($pattern, $subject, $matches);
        return $matches;
    };

    return call_user_func_array(curry2($match), func_get_args());
}