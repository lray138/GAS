<?php namespace lray138\GAS\Traits;

/*
From ChatGPT: 

A Pointed Functor is a functor with a "point" operation, sometimes called of or pure in different languages. The point operation allows you to take a raw value and "lift" it into the functor’s context.

In simpler terms, a pointed functor has an additional function that allows you to wrap a value in the functor's context, without needing an existing functor to map over.

The Pointed Functor is important in more advanced functional concepts like Monads, which require this ability to lift values and chain computations inside the context.

*/
use lray138\GAS\Types\Either\{Left, Right};

trait MagicGetTrait {
    
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

        return \lray138\GAS\Types\wrapType($out);

        // this is wacky down below

        if(in_array($type, ["number", "string", "array"])) {
            return \lray138\GAS\Types\wrapType($out);
        }
        
        return Either::unit($out);
    }

}