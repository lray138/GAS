<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\flipN;

const pluckFromOr = __NAMESPACE__ . '\pluckFromOr';

/**
 * I believe this is me trying to decide beetween "pluckFromOrElse" vs "pluckFromOr"
 * and really no reason not to do "orElse"
 */
function pluckFromOr() {
    return flipN(3)(pluckOr)(...func_get_args());
}