<?php namespace lray138\GAS\Types\Applicative;

use lray138\GAS\Types\Functor\{
	PointedFunctor
	, Functor 
};

abstract class Applicative implements Functor
{
	// left for example: Packt Functional PHP denotes "pure"
	// whereas other's use "unit", which can be the same as 
	// the pointed "of"
    public abstract static function pure($value): Applicative;

    public abstract function apply(Applicative $f): Applicative;

    public function map(callable $f): Functor {
        return $this->pure($f)->apply($this);
    }
}