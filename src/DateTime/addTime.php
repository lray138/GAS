<?php namespace lray138\GAS\DateTime;

use function lray138\GAS\Functional\curry2 as curry;

const addTime = __NAMESPACE__ . '\addTime';

/**
 * Function description.
 */
function addTime() {
    $f = function($string, \DateTime $dt) {
        return modify("+" . $string, $dt);
    };

    return curry($f)(...func_get_args());
}