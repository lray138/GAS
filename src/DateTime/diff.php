<?php namespace lray138\GAS\DateTime;

const diff = __NAMESPACE__ . '\diff';

/**
 * Function description.
 */
function diff(\DateTime $a, \DateTime $b) {
    return $b->diff($a);
}