<?php namespace lray138\GAS\DateTime;

use function lray138\GAS\Functional\curry2;

const modify = __NAMESPACE__ . '\modify';

/**
 * Function description.
 */
function modify() {
    $f = function($string, \DateTime $dt) {
        $c = clone $dt;
        return $c->modify($string);
    };

    return call_user_func(curry2($f), ...func_get_args());
}