<?php namespace lray138\GAS\DateTime;

const getDayNumber2 = __NAMESPACE__ . '\getDayNumber2';

/**
 * Function description.
 */
function getDayNumber2(DateTime $dt) {
    //date('w'); // day of week
    //date('l'); // dayname
    return $dt->format("w");
}