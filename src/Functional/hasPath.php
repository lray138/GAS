<?php namespace lray138\GAS\Functional;

/* Note: originally from Idles, adding support for objects */

function _hasPath(?iterable $record, /*string|int|array*/ $path): bool {
    $record = collect($record);
    foreach (toPath($path) as $part) {
        if (!\is_array($record) || !\array_key_exists($part, $record)) {
            return false;
        }
        $record = $record[$part];
    }
    return true;
}

function _hasPathInObject(object $record, /*string|int|array*/ $path): bool {
    foreach (toPath($path) as $part) {
        if (!\property_exists($record, $part)) {
            return false;
        }
        $record = $record->{$part};
    }
    return true;
}

function hasPath(...$args) {
    return curryN(2, fn($path, $record) => 
        is_object($record) ? _hasPathInObject($record, $path) : _hasPath($record, $path)
    )(...$args);
}