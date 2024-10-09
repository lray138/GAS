<?php namespace lray138\GAS\Traits;

use FunctionalPHP\FantasyLand\Functor;

trait ExtendTrait {
    public function extend(callable $f): Functor {
        return new static($f($this));
    }
}