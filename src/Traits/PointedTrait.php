<?php namespace lray138\GAS\Traits;

/*
From ChatGPT: 

A Pointed Functor is a functor with a "point" operation, sometimes called of or pure in different languages. The point operation allows you to take a raw value and "lift" it into the functor’s context.

In simpler terms, a pointed functor has an additional function that allows you to wrap a value in the functor's context, without needing an existing functor to map over.

The Pointed Functor is important in more advanced functional concepts like Monads, which require this ability to lift values and chain computations inside the context.

*/

trait PointedTrait {
    
    public static function of($value) {
        return new static($value);
    }
}