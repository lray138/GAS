<?php namespace lray138\GAS\Traits;

use lray138\GAS\Types\Comonad;

trait ExtendTrait {
    public function extend(callable $f): Comonad {
        return new static($f($this));
    }
}