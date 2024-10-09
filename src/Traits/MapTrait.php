<?php namespace lray138\GAS\Traits;

use FunctionalPHP\FantasyLand\Functor;

trait MapTrait {
    public function map(callable $f): Functor {
        return new static($f($this->extract()));
    }
}