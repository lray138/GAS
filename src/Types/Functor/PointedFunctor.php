<?php namespace lray138\GAS\Types\Functor;

/* 
 * not sure if this is my code based on learning or from the book...
 * Probably cause I didn't have FantasyLand in?
 */

interface PointedFunctor extends Functor 
{
    public static function of($value): Functor;
}