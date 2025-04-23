<?php namespace lray138\GAS\Traits;

/*
From ChatGPT: 

A Pointed Functor is a functor with a "point" operation, sometimes called of or pure in different languages. The point operation allows you to take a raw value and "lift" it into the functor’s context.

In simpler terms, a pointed functor has an additional function that allows you to wrap a value in the functor's context, without needing an existing functor to map over.

The Pointed Functor is important in more advanced functional concepts like Monads, which require this ability to lift values and chain computations inside the context.

*/

use lray138\GAS\Types\Either\{Left, Right};

trait MagicCallTrait {
    
    public function __call($method, $parameters) {

        // use bind instead of "map" which was really "then" from the Chris Pitt code
        return $this->bind(function($value) use ($method, $parameters) {

            // in this case we're trying to call something that is a property
            // this is the "back and forth" - wish I documented this better.
            if(is_array($value)) {
                return isset($value[$method]) ? Right::of($value[$method]) : Left::of("method '$method' does not exist");
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

}