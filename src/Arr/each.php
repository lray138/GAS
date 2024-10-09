<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2;

const each = __NAMESPACE__ . '\each';

/**
 * @param array|ArrType $array
 * @param callable      $callback
 * @todo remove this in favor of walk, otherwise call it forEach
 * @return array
 */
function each()
{
    return walk(...func_get_args());
}