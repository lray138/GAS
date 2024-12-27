<?php

//namespace PhpFp\Either\Constructor;
namespace lray138\GAS\Types\Either;

use lray138\GAS\Types\Either;
use FunctionalPHP\FantasyLand\{Monad, Apply};

/**
 * An OO-looking implementation of the Right constructor.
 */
final class Right extends Either
{
    /**
     * Apply a wrapped paramater to this wrapped function.
     * @param Either $that The parameter to apply.
     * @return Either The wrapped result.
     */
    public function ap(Apply $that) : Apply
    {
        return $this->chain(
            function ($f) use ($that)
            {
                return $that->map($f);
            }
        );
    }

    public static function of($x) : Either {
        return self::right($x);
    }

    /**
     * Map over both sides of the Either.
     * @param callable $f The Left transformer.
     * @param callable $g The Right transformer.
     * @return Either Both sides transformed.
     */
    public function bimap(callable $_, callable $g) : Either
    {
        return Either::right($g($this->value));
    }

    /**
     * Monadic flat map for Right instances. (>>=).
     * @param callable $f a -> Either e b
     * @return Either Either e b
     */
    public function chain(callable $f) : Either
    {
        return $f($this->value);
    }

    // if I change this to Monad from Either it works with 
    // the magic calls, which to me is OK and perhaps even what
    // the goal with this journey has been all along
    public function bind(callable $f): Monad {
        return $f($this->extract());
    }

    /**
     * Transform the inner value.
     * @param callable $f The transformer for the inner value.
     * @return Either The wrapped, transformed value.
     */
    public function map(callable $f) : Either
    {
        return Either::unit($f($this->value));
        //return Either::right($f($this->value));
    }

    /**
     * Transform the Right value with the right function.
     * @param callable $f The transformer for a Left value.
     * @param callable $g The transformer for a Right value.
     * @return mixed Whatever the returned type is.
     */
    public function either(callable $_, callable $g)
    {
        return $g($this->value);
    }

    /**
     * Transform the Right value with the right function.
     * @param callable $f The transformer for a Left value.
     * @param callable $g The transformer for a Right value.
     * @return mixed Whatever the returned type is.
     */
    public function fold(callable $_, callable $g)
    {
        return $g($this->value);
    }

    public function isRight() {
        return true;
    }

    public function isLeft() {
        return false;
    }

    public function extract() {
        return $this->value;
    }

    public function __call($method, $parameters) {

        // use bind instead of "map" which was really "then" from the Chris Pitt code
        return $this->bind(function($value) use ($method, $parameters) {

            // in this case we're trying to call something that is a property
            // this is the "back and forth" - wish I documented this better.
            if(is_array($value)) {
                return isset($value[$method]) ? Right::of($value[$method]) : Left::of("prop no exist");
            } else if($value instanceof ArrType) {
                return $value->$method;
            } else if(is_object($value)) {
                // "find" for ProcessWire exists but was not being found
                // && method_exists($value, $method)

                try {
                    
                    $val = $value->$method(...$parameters);
                    $type = \lray138\GAS\Types\getType($val);

                    if(is_null($val)) {
                        return \lray138\GAS\Types\Either::left("$method result is NULL");
                    }

                    if(in_array($type, ["number", "string", "array"])) {
                        return \lray138\GAS\Types\wrapType($val);
                    }

                    return Either::right($val);

                } catch(\Exception $e) {
                    // should really be Left
                    // omg --- Dec 10 2024, SMDH if this is (finally) the implemenetation of this then hurray and fuckin' a...
                    return Left::of("1 method no exist");
                } catch(\Error $e) {
                    
                    // perhaps a "prop"
                    // eseentially accidentally calling a method when it's a prop
                    // this may be academic ?  Dec 10, 2024
                    if(count($parameters) == 0) {

                        if(!property_exists($value, $method)) {
                            return Left::of("prop/method '$method' not found");
                        }
                        
                        $val = $value->$method;
                        $type = \lray138\GAS\Types\getType($val);

                        if(in_array($type, ["number", "string", "array"])) {
                            return \lray138\GAS\Types\wrapType($val);
                        }

                        return Right::of($val);
                    }

                    return Left::of("method '$method' not found");
                }

            } else {
                return Left::of("method '$method' not found");
            }
        
        });

    }

    public function __get($property) {

        $value = $this->extract();
        $attempt_method = true;

        // reviewing code and have no idea what this would be for
        // June 9, 2023 15:34
        if(is_array($property)) {
            $property = $property["tryProp"];
            $attempt_method = false;
        }

        $out = null;
        if(is_array($value) && isset($value[$property])) {
            $out = $value[$property];
        } else if (is_object($value) && (property_exists($value, $property) || !is_null($value->$property))) {
            $out = $value->$property;
        }       

        // if(is_null($out)) {
        //     return $attempt_method
        //         ? $this->$property()
        //         : null;
        // }

        $type = \lray138\GAS\Types\getType($out);

        if(in_array($type, ["number", "string", "array"])) {
            return \lray138\GAS\Types\wrapType($out);
        }
        
        return Either::unit($out);
    }

    public function __toString() {
        return (string) $this->extract();
    }

}