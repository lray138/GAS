<?php namespace lray138\GAS\DateTime;

const prevWeekday = __NAMESPACE__ . '\prevWeekday';

/**
 * Function description.
 */
function prevWeekday(\DateTime $date) {
    return $date->modify('-1 weekday');
}