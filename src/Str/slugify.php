<?php namespace lray138\GAS\Str;

const slugify = __NAMESPACE__ . '/slugify';

function slugify($str) {
    return strtolower(str_replace(" ", "-", $str));
}