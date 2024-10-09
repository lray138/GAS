<?php namespace lray138\GAS\DateTime;

const tomorrow = __NAMESPACE__ . '\tomorrow';

/**
 * Function description.
 */
// must have been from something else.
function tomorrow() {
    return now()->modify('+1 day');
}