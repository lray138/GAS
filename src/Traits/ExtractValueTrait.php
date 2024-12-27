<?php namespace lray138\GAS\Traits;

use FunctionalPHP\FantasyLand\Functor;

trait ExtractValueTrait {
    public function extract() {
        return $this->value;
    }

    public function get() {
        return $this->extract();
    }
}