<?php namespace lray138\GAS\Arr;

// note: this is an alias of sortUser

const sortCallback = __NAMESPACE__ . '\sortCallback';

function sortCallback(callable $c) {
    return sortUser(...func_get_args());
}