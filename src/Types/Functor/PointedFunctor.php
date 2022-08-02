<?php namespace lray138\GAS\Types\Functor;

interface PointedFunctor extends Functor 
{
    public static function of($value): Functor;
}