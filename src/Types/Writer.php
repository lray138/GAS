<?php

namespace lray138\GAS\Types;
// namespace PhpFp\Writer;

use FunctionalPHP\FantasyLand\{
    Monad,
    Monoid,
    Apply
};

use lray138\GAS\Traits\ExtractValueTrait;

/**
 * An OO-looking implementation of Writer in PHP.
 */
class Writer implements Monad {
    /**
     * The internal action for this monad.
     * @var callable
     */
    private $action = null;

    /**
     * Pseudo-applicative constructor for this value. Because this
     * requires two values (the monad from which we get our empty),
     * it would be wrong to call this an applicative constructor.
     * @param mixed $x The inner value of this Writer.
     * @param mixed $M Some monoid (name/instance) of your choosing.
     * @return Writer The produced writer.
     */
    public static function of($x, Monoid $m = null) : Writer
    {

    	$monoid = is_null($m) ? ArrType::of([]) : $m;

        return new Writer(
            function () use ($x, $monoid) : array
            {
                return [$x, $monoid];
            }
        );
    }

    /**
     * Write something to the Writer log using some trickery. See the
     * documentation for some more information around using this.
     * @param mixed $x The value concatenated onto the logs.
     * @return Writer To be returned to a chain function.
     */
    public static function tell(Monoid $x) : Writer
    {
        return new Writer(
            function () use ($x) : array
            {
                return [null, $x];
            }
        );
    }

    /**
     * Store the action for this Writer.
     * @param callable $f
     */
    public function __construct(callable $f)
    {
        $this->action = $f;
    }

    /**
     * Application for Writer instances, derived from chain.
     * @param Writer $that The wrapped parameter.
     * @return Writer The wrapped result.
     */
    public function ap(Apply $that) : Writer
    {
        return $this->bind(
            function (callable $f) use ($that) : Writer
            {
                return $that->map($f);
            }
        );
    }

    /**
     * PHP implementation of Haskell Writer's >>=.
     * @param callable $f a -> Writer b
     * @return Writer The result of the function.
     * renamed to bind to adhere to fantasyland
     * also, the concat was originally $log2->concat($log1) but then it reads out in verser order of the computation?
     */
    public function bind(callable $f) : Writer
    {
        return new Writer(
            function () use ($f) : array
            {

                list ($xs, $log1) = $this->run();

                // adding this to end execution of script without needing
                // the overhead of the example from ChatGPT

                if(is_null($xs)) {
                    return [null, $log1];
                }

                list ($ys, $log2) = $f($xs)->run();

                // @todo fix this later
                if(is_null($ys)) {
                    $log2 = $log2->concat(ArrType::of(["Computation ended."]));
                }

                return [$ys, $log1->concat($log2)];
            }
        );
    }

    /**
     * Functor map for Writer. Transform the inner value.
     * @param callable $f The mapping function.
     * @return Writer The outer structure is preserved.
     */
    public function map(callable $f) : Writer
    {
        return new Writer(
            function () use ($f) : array
            {
                list ($xs, $log) = $this->run();
                return [$f($xs), $log];
            }
        );
    }

    /**
     * Perform the Writer computation, return a [value, log] pair.
     * @return mixed Whatever the computation yields!
     */
    public function run()
    {
        return call_user_func(
            $this->action
        );
    }

}