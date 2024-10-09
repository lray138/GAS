<?php namespace lray138\GAS\Str;

const concatNOld = __NAMESPACE__ . '/concatNOld';

// this didn't work with placeholders
function concatNOld() {
    $args = func_get_args();

    if(count($args)-1 >= $args[0]) {

        return implode(array_slice($args, 1));

        // return array_reduce(
        //     array_slice($args, 1)
        //     , function($carry, $value) {
        //         return concat($carry, $value);
        //     }, "");

    } else {
        return function() use ($args) {
            return concatN(...$args, ...func_get_args());
        };
    }

}