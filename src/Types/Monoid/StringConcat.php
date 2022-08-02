<?php namespace lray138\GAS\Types\Monoid;

class StringConcat extends Monoid
{
    public static function id() { return ''; }
    public static function op($a, $b) { return $a.$b; }
}