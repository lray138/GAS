<?php namespace lray138\GAS\Functional;

const compose = __NAMESPACE__ . '\compose';

/**
 * Function description.
 */
function compose(...$functions) {
    return array_reduce(
        array_reverse($functions),
        function ($carry, $item) {
            return function ($x) use ($carry, $item) {
                return $item($carry($x));
            };
        },
        identity
    );
}