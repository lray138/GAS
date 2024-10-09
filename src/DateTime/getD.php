<?php namespace lray138\GAS\DateTime;

const getD = __NAMESPACE__ . '\getD';

/**
 * Function description.
 */
function getD(\DateTime $dt) {
    return $dt->format("j");
}