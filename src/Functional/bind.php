<?php namespace lray138\GAS\Functional;

const bind = __NAMESPACE__ . '\bind';

/**
 * Function description.
 */
function bind() {
    $f = function($function, $monad) {
        return $monad->bind($function);
    };

    return curry2($f)(...func_get_args());
}