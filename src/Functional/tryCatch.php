<?php namespace lray138\GAS\Functional;

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
