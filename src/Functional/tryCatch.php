<?php namespace lray138\GAS\Functional;

use lray138\GAS\Types\Either;

const tryCatch = __NAMESPACE__ . '\tryCatch';

/**
 * Function description.
 * Jan 3 13:34 - I wonder what the inspiration for this was
 */
function tryCatch(callable $f): Either {
   try {
        $val = $f();
        return is_null($val)
            ? Either::left('callable returned null')
            : Either::right($val);
    } catch (\Exception $e) {
        return Either::left($e);
    }
}