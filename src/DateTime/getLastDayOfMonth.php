<?php namespace lray138\GAS\DateTime;

const getLastDayOfMonth = __NAMESPACE__ . '\getLastDayOfMonth';

/**
 * Function description.
 */
function getLastDayOfMonth(\DateTime $dt) {
    $c = clone $dt;
    return $c->modify('last day of')->setTime(23, 59, 59, 59);
}