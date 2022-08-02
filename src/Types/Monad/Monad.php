<?php namespace lray138\GAS\Types\Monad; 

use lray138\GAS\Types\Applicative\Applicative;

abstract class Monad extends Applicative
{
    public static function return($value): Monad
    {
        return static::pure($value);
    }

    public abstract function bind(callable $f);
}