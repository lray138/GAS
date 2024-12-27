<?php namespace lray138\GAS\Functional;

/* Note: originally from Idles */

function collect(?iterable $collection): array {
    $collection ??= [];
    return \is_array($collection) ? $collection : \iterator_to_array($collection);
}