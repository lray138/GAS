<?php namespace lray138\GAS\DateTime;

const minutesToHours = __NAMESPACE__ . '\minutesToHours';

/**
 * Function description.
 */
function minutesToHours($mins) {
    $hours = floor($mins/60);
    $remainder = $mins%60;
    return "$hours hours and $remainder mins";
}