<?php namespace lray138\GAS\DateTime;

const getFirstDayOfMonth = __NAMESPACE__ . '\getFirstDayOfMonth';

/**
 * Function description.
 */
function getFirstDayOfMonth(\DateTime $dt) {
    return $dt->modify('first day of')->setTime(0, 0, 0, 0);
}