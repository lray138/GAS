<?php namespace lray138\GAS\Arr;

use lray138\GAS\HTML;

const toUl = __NAMESPACE__ . '\toUl';

function toUl(array $array, $attributes = []) {
    $mapped = implode("", map(function($x) {
        return "<li>" . $x . "</li>";
    }, $array));

    return HTML\ul($mapped, $attributes);
}