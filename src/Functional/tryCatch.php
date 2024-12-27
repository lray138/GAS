<?php namespace lray138\GAS\Functional;

use lray138\GAS\Types\Either;

const tryCatch = __NAMESPACE__ . '\tryCatch';

/**
 * Function description.
 */
function tryCatch(callable $f): Either {
   try {
        return Either::of($f());
    } catch (\Exception $e) {
        return Either::left($e);
    }
}