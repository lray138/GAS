<?php namespace lray138\GAS\Types\Functor;

interface Functor
{
    public function map(callable $f): Functor;
}