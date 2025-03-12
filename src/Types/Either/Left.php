<?php

namespace lray138\GAS\Types\Either;
//namespace PhpFp\Either\Constructor;  // left to show what he did

use lray138\GAS\Types\Either;
use FunctionalPHP\FantasyLand\Apply;

/**
 * An OO-looking implementation of the Left constructor.
 */
final class Left extends Either
{
    /**
     * Do nothing; return the same value.
     * @param Either $that The parameter to apply.
     * @return Either The wrapped result.
     */
    public function ap(Apply $that) : Apply
    {
        return $that;
    }

    public function bind(callable $f): Either {
        return $this;
    }

    /**
     * Map over both sides of the Either.
     * @param callable $f The Left transformer.
     * @param callable $g The Right transformer.
     * @return Either Both sides transformed.
     */
    public function bimap(callable $f, callable $_) : Either
    {
        return Either::left($f($this->value));
    }

    /**
     * Do nothing; return the same value.
     * @param callable $f a -> Either e b
     * @return Either Either e b
     */
    public function chain(callable $f) : Either
    {
        return $this;
    }

    /**
     * Do nothing; return the same value.
     * @param callable $f The transformer for the inner value.
     * @return Either The wrapped, transformed value.
     */
    public function map(callable $f) : Either
    {
        return $this;
    }

    /**
     * Applicative constructor for Either.
     * @param mixed $x The value to be wrapped.
     * @return A new Right-constructed type.
     */
    public static function of($x) : Either
    {
        return Either::left($x);
    }

    /**
     * Transform the Left value with the left function.
     * @param callable $f The transformer for a Left value.
     * @param callable $g The transformer for a Right value.
     * @return mixed Whatever the returned type is.
     */
    public function either(callable $f, callable $_)
    {
        return $f($this->extract());
    }

    public function fold(callable $f, callable $_)
    {
        return $f($this->extract());
    }

    // return this value
    // I'm changint this to returning the value, since "dump" is applied
    // this is how I implemented it with JavaScript anyway
    // and really you should be using "fork"

    // bug here fixed on value Feb 24, 2025
    public function extract() {
        return $this->value;
    }

    public function get() {
        return $this->extract();
    }

    public function g() {
        return $this->extract();
    }

    public function isLeft() {
        return true;
    }

    public function isNothing() {
        return false;
    }

    public function isString() {
        return false;
    }

    public function getOrElse($value) {
        return $value;
    }

    public function extend(callable $f): \lray138\GAS\Types\Comonad  {
        return $this;
    }
    
    public function goe($value) {
        return $this->getOrElse($value);
    }

    public function __call($method, $value) {
        return $this;
    }

    public function isRight() {
        return false;
    }

    public function __get($_) {
        return $this;
    }

}