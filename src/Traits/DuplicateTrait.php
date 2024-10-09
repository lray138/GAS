<?php namespace lray138\GAS\Traits;

trait DuplicateTrait {
    public function duplicate() {
        return new static(clone $this);
    }
}