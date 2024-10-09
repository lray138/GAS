<?php namespace lray138\GAS\DateTime;

const getDurationString = __NAMESPACE__ . '\getDurationString';

/**
 * Function description.
 */
function getDurationString(\DateTime $start, \DateTime $end) {
    $since = $start->diff($end);
    
    $get = fn($str, $val) => $val . " " . ($val > 1 ? $str . "s" : $str);

    $out = [];

    if ($since->y > 0) {
        $out[] = $get("year", $since->y);
    }

    if ($since->m > 0) {
        $out[] = $get("month", $since->m);
    }

    if ($since->d > 0) {
        $out[] = $get("day", $since->d);
    }

    if ($since->h > 0) {
        $out[] = $get("hour", $since->h);
    }

    if ($since->i > 0) {
        $out[] = $get("minute", $since->i);
    }

    if ($since->s > 0) {
        $out[] = $get("second", $since->s);
    }
   
    return implode(", ", $out);
}
