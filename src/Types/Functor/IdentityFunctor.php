<?php namespace lray138\GAS\Types\Functor;

use FunctionalPHP\FantasyLand\{Functor, Pointed};
use lray138\GAS\Types\Comonad;
use lray138\GAS\Traits\{
    PointedTrait, 
    ExtractValueTrait, 
    MapTrait,
    ExtendTrait,
    DuplicateTrait
};

class IdentityFunctor implements Functor, Pointed, Comonad {
	private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    use PointedTrait;
    use MapTrait;
    use ExtractValueTrait;
    use ExtendTrait;
    use DuplicateTrait;

}