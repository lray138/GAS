<?php namespace lray138\GAS\Functional;

const flipUnary = __NAMESPACE__ . '\flipUnary';

/**
 * Function description.
 */
function flipUnary($callable) {
    return unary(flip($callable));
}