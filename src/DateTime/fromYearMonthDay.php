<?php namespace lray138\GAS\DateTime;

const fromYearMonthDay = __NAMESPACE__ . '\fromYearMonthDay';

// a little expirimental with currying
// the idea is you could build up the function _
// so the last day is all that is needed at that point.
function fromYearMonthDay() {
    $fromYearMonthDay = function($year, $month, $day) {
        return new \DateTime("$year-$month-$day");
    };

    return call_user_func_array(FP\curry3($fromYearMonthDay), func_get_args());
}