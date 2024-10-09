<?php namespace lray138\GAS\DateTime;

const toEST = __NAMESPACE__ . '\toEST';

function toEST(\DateTime $dt) {
    return $dt->setTimezone(new \DateTimeZone('America/New_York'));
}