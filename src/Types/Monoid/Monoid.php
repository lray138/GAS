<?php namespace lray138\GAS\Types\Monoid;

abstract class Monoid
{
    public abstract static function id();
    public abstract static function op($a, $b);

    public static function concat(array $values)
    {
        $class = get_called_class();
        return array_reduce($values, [$class, 'op'], [$class, 'id']());
    }

    public function __invoke(...$args)
    {
        switch(count($args)) {
            case 0: throw new RuntimeException("Except at least 1 parameter");
            case 1:
                return function($b) use($args) {
                    return static::op($args[0], $b);
                };
            default:
                return static::concat($args);
        }
    }
}