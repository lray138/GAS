<?php namespace lray138\GAS\DateTime;

const getDurationMins = __NAMESPACE__ . '\getDurationMins';

/**
 * Function description.
 */
function getDurationMins(\DateTime $start, \DateTime $end) {
    $since = $start->diff($end);
    $minutes = $since->days * 24 * 60;
    $minutes += $since->h * 60;
    $minutes += $since->i;
    $minutes += $since->s/60;
    return $minutes;
}