<?php

namespace lray138\GAS\Types;
// not trying to hide this isn't me... there was no package
// I actually wanted to install it via composer ;)
//namespace PhpFp\Either;

// it's 11:12 on Oct 18 2024 I am adding that it implements the FantasyLand spec

use lray138\GAS\Types\Either\{Left, Right};
use \FunctionalPHP\FantasyLand\{Apply, Monad};
use lray138\GAS\Types\Comonad;
use function lray138\GAS\dump;

/**
 * An OO-looking implementation of Either in PHP.
 */
abstract class Either implements Monad, Comonad {
    /**
     * Construct a new Left instance with a value.
     * @param mixed $x The value to be wrapped.
     * @return A new Left-constructed type.
     */
    final public static function left($x) : Left
    {
        return new Left($x);
    }

    final public function dump() {
        dump($this);
        return $this;
    }

    /**
     * Construct a new Right instance with a value.
     * @param mixed $x The value to be wrapped.
     * @return A new Right-constructed type.
     */
    final public static function right($x) : Right {
        return new Right($x);
    }

    /**
     * Applicative constructor for Either.
     * @param mixed $x The value to be wrapped.
     * @return A new Right-constructed type.
     */
    public static function of($x) {
        return is_null($x) ? self::left(null) : self::right($x);
    }

    // fromNullable is OK, but ... dunno.... from/fromNullable? dunno...
    // need a way to pass the error I don't really like having to type 
    // out the conditional... 
    public static function unit($x, $fail_message = null) {
        return is_null($x) ? self::left($fail_message) : self::right($x);
    }

    public function tap(callable $callback) {
        $callback($this->value);
        return $this;
    }

    public function echo() {
        echo $this->extract();
        return $this;
    }

    /**
     * Capture an exception-throwing function in an Either.
     * @param callable $f The exception-throwing function.
     * @return Either Right (with success), or Left (with exception).
     */
    final public static function tryCatch(callable $f) : Either
    {
        try {
            return self::unit($f());
        } catch (\Exception $e) {
            return self::left($e);
        }
    }

    /**
     * Apply a wrapped parameter to this wrapped function.
     * @param Either $that The wrapped parameter.
     * @return Either The wrapped result.
     */
    abstract public function ap(Apply $that) : Apply;

    /**
     * Map over both sides of the Either.
     * @param callable $f The Left transformer.
     * @param callable $g The Right transformer.
     * @return Either Both sides transformed.
     */
    abstract public function bimap(callable $f, callable $g) : Either;

    /**
     * PHP implementation of Haskell Either's bind (>>=).
     * @param callable $f a -> Either e b
     * @return Either Either e b
     */
    abstract public function chain(callable $f) : Either;

    /**
     * Standard functor mapping, derived from chain.
     * @param callable $f The transformer for the inner value.
     * @return Either The wrapped, transformed value.
     */
    abstract public function map(callable $f) : Either;

    /**
     * Read the value within the monad, left or right.
     * @param callable $f Transformation for Left.
     * @param callable $g Transformation for Right.
     * @return mixed The same type for each branch.
     */
    abstract public function either(callable $f, callable $g);

    /**
     * The inner value of the instance.
     * @var mixed
     */
    protected $value = null;

    /**
     * Standard constructor for an Either instance.
     * @param mixed $value The value to wrap.
     */
    final private function __construct($value)
    {
        $this->value = $value;
    }

    public function getOr($value) {
        return $this->isRight() ? $this->value : $value;
    }

    // I know this is me adding onto the original class
    public function getOrElse($value) {
        return $this->isRight() ? $this->value : $value;
    }

    public function extend(callable $f): Comonad {
        return $f($this);
    }

    public function duplicate(): Comonad {
        return new static(clone $this);
    }

    public static function fromNullable($x, $left_message = "") {
        return is_null($x) ? Either::left($left_message) : Either::right($x);
    }
    
    public function __toString() {
        // YAY! PHP Fatal error:  Uncaught Error: Object of class WP_Post
        try {
            return (string) $this->extract();
        } catch(\Exception $e) {
            return $e->getMessage();
        } catch(\Error $e) {
            return $e->getMessage();
        }
    }
}