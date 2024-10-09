<?php namespace lray138\GAS\Functional;

const chain = __NAMESPACE__ . '\chain';

/**
 * Function description.
 */
function chain() {
    $f = function($function, $monad) {
        return $monad->bind($function)->extract();
    };

    return curry2($f)(...func_get_args());
}