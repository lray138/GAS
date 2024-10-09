<?php namespace lray138\GAS\Traits;

trait ChainTrait {
    public function chain(callable $fn) {
        return $fn($this->value);
    }
}