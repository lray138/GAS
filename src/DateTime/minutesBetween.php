<?php namespace lray138\GAS\DateTime;

const minutesBetween = __NAMESPACE__ . '\minutesBetween';

/**
 * 
 */
// for now assumes action is not longer than a day...
// hmm... also have https://stackoverflow.com/questions/365191/how-to-get-time-difference-in-minutes-in-php
// as option
function minutesBetween($date_1, $date_2) {
    $bits = explode("-", dateDifference($date_1, $date_2, "%h-%i"));
    $bits[0] = hoursToMinutes($bits[0]);
    return array_sum($bits);
}