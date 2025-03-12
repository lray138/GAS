<?php namespace lray138\GAS\Str;

const unit = __NAMESPACE__ . '/unit';

use lray138\GAS\Types\{
    Either\Left,
    StrType 
};

function unit($value) {

    if (is_string($value)) {
        return \lray138\GAS\Types\StrType::of($value);
    }

    // safe for casting
    if (is_int($value) || is_float($value) || is_bool($value)) {
        return \lray138\GAS\Types\StrType::of((string) $value);
    }

    // object with __toString
    if (is_object($value) && method_exists($value, '__toString')) {
        return \lray138\GAS\Types\StrType::of((string) $value);
    }

    return Left::of(__FUNCTION__ . " expects a valid string or string-castable value");
}