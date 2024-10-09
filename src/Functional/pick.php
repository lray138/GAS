<?php namespace lray138\GAS\Functional;

const pick = __NAMESPACE__ . '\pick';

/**
 * Function description.
 */
function pick(array $properties, $source) {
    $out = [];
    foreach($properties as $prop) {
        $out[$prop] = pluck($prop, $source);
    }
    return $out;
}
