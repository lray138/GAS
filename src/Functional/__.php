<?php namespace lray138\GAS\Functional;

const __ = __NAMESPACE__ . '\__';

/**
 * Function description.
 */
class Placeholder {
    public function __toString() {
        return "";
    }
}

// placeholder for currying
function __() {
    static $placeholder;

    if ($placeholder === null) {
        $placeholder = new Placeholder();
    }

    return $placeholder;
}