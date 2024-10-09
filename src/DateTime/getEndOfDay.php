<?php namespace lray138\GAS\DateTime;

const getEndOfDay = __NAMESPACE__ . '\getEndOfDay';

/**
 * Function description.
 */
function getEndOfDay(\DateTime $dt) {
    $c = clone $dt;
    return $c->setTime(23, 59, 59, 59);
}