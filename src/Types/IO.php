<?php 

namespace lray138\GAS\Types;
// namespace PhpFp\IO;

use lray138\GAS\Types\Maybe;
use function lray138\GAS\IO\dump;

use FunctionalPHP\FantasyLand\{
    Apply, Monad
};

/**
 * An OO-looking implementation of IO in PHP.
 */
class IO implements Monad {
    /**
     * The "unsafe" IO action.
     * @var callable
     */
    private $action;

    /**
     * Applicative constructor.
     * @param mixed $x The IO's inner value.
     * @return IO The value wrapped with IO.
     */
    public static function of($x) : IO
    {
        return new IO(
            function () use ($x)
            {
                return $x;
            }
        );
    }

    /**
     * Construct a new IO with an action function.
     * @param callable $f An unsafe function.
     */
    public function __construct(callable $f)
    {
        $this->action = $f;
    }

    /**
     * Application, derived with IO::chain.
     * @param IO $that The wrapped parameter.
     * @return IO The wrapped result
     */
    public function ap(Apply $that) : IO
    {
        return $this->bind(
            function ($f) use ($that)
            {
                return $that->map($f);
            }
        );
    }

    /**
     * PHP implementation of Haskell IO's >>=.
     * @param callable $f a -> IO b
     * @return IO The result of the function.
     * renaming to bind
     */
    public function bind(callable $f) : IO {
        return new IO(
            function () use ($f) {
                return $f($this->run())->run();
            }
        );
    }

    /**
     * Functor map for IO. Transform the inner value.
     * @param callable $f The mapping function.
     * @return IO The outer structure is preserved.
     */
    public function map(callable $f) : IO
    {
        return $this->bind(
            function ($a) use ($f)
            {
                return IO::of($f($a));
            }
        );
    }

    /**
     * I wonder if I renamed this at some point from unsafePerform()
     * Run the unsafe action.
     * @return mixed Whatever the action's result! 
     */
    public function run()
    {
        return call_user_func(
            $this->action
        );
    }
}