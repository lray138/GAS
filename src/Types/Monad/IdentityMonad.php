<?php namespace lray138\GAS\Types\Monad;

use lray138\GAS\Types\Applicative\Applicative;

class IdentityMonad extends Monad
{
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function pure($value): Applicative
    {
        return new static($value);
    }

    public function get()
    {
        return $this->value;
    }

    public function bind(callable $f)
    {
        return $f($this->get());
    }

    public function apply(Applicative $a): Applicative
    {
        return static::pure($this->get()($a->get()));
    }
}