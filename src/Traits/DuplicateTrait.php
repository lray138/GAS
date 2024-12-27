<?php namespace lray138\GAS\Traits;

use lray138\GAS\Types\Comonad;

trait DuplicateTrait {
    public function duplicate(): Comonad {
        return new static(clone $this);
    }
}