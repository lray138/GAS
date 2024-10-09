<?php namespace lray138\GAS\Str;

const concatN = __NAMESPACE__ . '/concatN';

function concatN() {
    $args = func_get_args();

    $filtered = Arr\filter(function($x) {
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

    return FP\curryN($args[0], $f, ...Arr\tail($args));
}
