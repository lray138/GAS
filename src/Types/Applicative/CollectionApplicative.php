<?php namespace lray138\GAS\Types\Applicative;

class CollectionApplicative extends Applicative implements \IteratorAggregate
{
    private $values;

    protected function __construct($values)
    {
        $this->values = $values;
    }

    public static function pure($values): Applicative {
        if($values instanceof Traversable) {
            $values = iterator_to_array($values);
        } else if(! is_array($values)) {
            $values = [$values];
        }

        return new static($values);
    }

    public function apply(Applicative $data): Applicative {
        // $this->values is an array of callables
        return $this->pure(array_reduce($this->values,
            function($acc, callable $function) use ($data) {
                return array_merge($acc, array_map($function, $data->extract()));
            }, [])
        );
    }

    public function getIterator() {
        return new ArrayIterator($this->values);
    }

    public function extract() {
        return $this->values;
    }

}