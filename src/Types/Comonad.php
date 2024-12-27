<?php namespace lray138\GAS\Types;

interface Comonad {
    // Extract the value from the comonad
    public function extract();

    // Apply a function to the entire comonad context
    public function extend(callable $f): Comonad;

    // Duplicate the comonad, wrapping it in itself
    public function duplicate(): Comonad;
}