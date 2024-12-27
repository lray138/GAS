<?php namespace lray138\GAS\Functional\Just;

use lray138\GAS\Types\Maybe\Just;

const unit = __NAMESPACE__ . '\unit';

function unit($value) {
    return Just::of($value);
}

const pure = __NAMESPACE__ . '\pure';

// this threw me off at certain points so "why not"
// I would also stick with unit
function pure($value) {
    return unit($value);
}