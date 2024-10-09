<?php namespace lray138\GAS\DateTime;

const fromYearMonth = __NAMESPACE__ . '\fromYearMonth';

/**
 * Function description.
 */
function fromYearMonth() {
    $fromYearMonth = function($year, $month) {
        return new \DateTime("$year-$month-01");
    };

    return call_user_func_array(FP\curry2($fromYearMonth), func_get_args());
}