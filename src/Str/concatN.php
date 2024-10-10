<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;
use function lray138\GAS\Arr\{filter, tail};

const concatN = __NAMESPACE__ . '/concatN';

/* Oct 9 2024, well, cleary doing something extracurricular here */

function concatN() {
    $args = func_get_args();

    $filtered = filter(function($x) {
        return $x instanceof \lray138\GAS\Functional\Placeholder === false;
    }, $args);

    if(count($filtered)-1 < $args[0]) {
       return function() use ($args) {
            return concatN(...$args, ...func_get_args());
       };
    }

    $f = function() use ($args, $filtered) {
        $bits = func_get_args();
        $out = "";

        for ($i = 0; $i < count($bits); $i++) { 
            $out .= $bits[$i];
        }

        return $out;
    };

    return curryN($args[0], $f, ...tail($args));
}