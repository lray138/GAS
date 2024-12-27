<?php namespace lray138\GAS\Functional;

/* originally from idles PHP, using foreach here 
   s


he has "each", I already had "walk" (I do like each)

*/

use lray138\GAS\Types\Maybe;
use function lray138\GAS\Types\wrapType;

function _path(?iterable $record, /*array|string*/ $path, $default = null): Maybe
{
    $record = collect($record);

    foreach(toPath($path) as $part) {
        if(!array_key_exists($part, $record)) {
            return Maybe::nothing();
        }

        $record = $record[$part];
    }

    return Maybe::just($record);
}

function _pathInObject(object $record, /*string|int|array*/ $path, $default = null): Maybe {

    foreach (toPath($path) as $part) {
        // if (!property_exists($record, $part)) {
        //     return Maybe::nothing();
        // }

        if (!isset($record->{$part})) {
            return Maybe::nothing();
        }

        $record = $record->{$part};
    }

    return Maybe::just($record);
}

const path = __NAMESPACE__ . '\path';

function path(...$args) {
    return curryN(2, fn($path, $record) => 
        is_object($record) ? _pathInObject($record, $path) : _path($record, $path)
    )(...$args);
}

const pathR = __NAMESPACE__ . '\pathR';

function pathR(...$args) {
    return curryN(2, fn($record, $path) => 
        is_object($record) ? _pathInObject($record, $path) : _path($record, $path)
    )(...$args);
}