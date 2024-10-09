<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\flipN;

const pluckFromOrElse = __NAMESPACE__ . '\pluckFromOrElse';

function pluckFromOrElse($from, $or_else = null, $key = null) {
    return flipN(3)(pluckOr)(...func_get_args());
}