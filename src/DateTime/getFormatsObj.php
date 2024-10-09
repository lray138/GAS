<?php namespace lray138\GAS\DateTime;

const getFormatsObj = __NAMESPACE__ . '\getFormatsObj';

/**
 * Function description.
 */
function getFormatsObj(\DateTime $dt) {
    $out = new \StdClass;
    $out->day = $dt->format("d");
    $out->year = $dt->format("Y");
    $out->month = $dt->format("m");
    $out->string = $dt->format("M d, Y");
    $out->shell = $dt->format("YmdHi");
    $out->mysql = $dt->format("Y-m-d H:i:s");
    $out->timestamp = $dt->getTimestamp();
    return $out;
}

const getFormatObj = __NAMESPACE__ . '\getFormatsObj';