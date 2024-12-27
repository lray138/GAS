<?php namespace lray138\GAS\Traits;

trait ChainTrait {

    public function flatMap(callable $fn) {
        return $this->chain($fn);
    }

    public function bind(callable $fn) {
        return $this->chain($fn);
    }

    public function chain(callable $fn) {
        return $fn($this->value);
    }
}