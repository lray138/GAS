<?php 

namespace lray138\GAS\Types;

use lray138\GAS\Types\Either;
use lray138\GAS\Types\ArrType as Arr;

use function lray138\GAS\dump;

use lray138\GAS\Types\{
    Either\Left,
    Either\right,
    Boolean as Boo,
    StrType as Str
};
use \FunctionalPHP\FantasyLand\{Apply, Monad, Semigroup};
use lray138\GAS\Types\Comonad;
use lray138\GAS\Traits\ExtractValueTrait;
use function lray138\GAS\Arr\get;
use function lray138\GAS\Functional\wrap;

/**
 * An OO-looking implementation of Either in PHP.
 * Comonad, Semigroup 
 */ 
class File implements Monad, Comonad {

    private $value;

    public const of  = __CLASS__ . '::of';

    private static function handleExists(string $path, array $data = null) {
        return file_exists($path) 
            ? new File(Arr::of(
                is_null($data) 
                    ? [
                        "path" => $path,
                        "pathname" => $path
                    ]
                    : $data
                ))
            : Either::left("File not found: " . $path);
    }

    public static function of($data) {
        return wrap($data)
            ->extend(fn($x) => match(get_class($x)) {
                'lray138\\GAS\\Types\\StrType' => $x,
                'lray138\\GAS\\Types\\ArrType' => $x,
                default => Either::left('unsupported initialization type')
            })
            ->extend(fn($x) 
                => $x->prop('path')->either(
                    fn() => static::handleExists($x->get()),
                    fn() => static::handleExists($x->prop('path')->get())
            ));
    }

    private function __construct(Arr $data) {
        $this->value = $data;
    }

    public function path(): string {
        return $this->extract();
    }

    public function ap(Apply $b): Apply {
        return $this;
    }

    public function exists(): Boo {
        return $this->extract()
            ->prop('path')
            ->bind(fn($path) => Boo::of(file_exists($path)));
    }

    public function bind(callable $fn) {
        return $fn($this->extract());
    }

    public function map(callable $fn): File {
        return new static($fn($this->extract()));
    }

    public function __toString() {
        return $this->extract()->prop('path')->get();
    }

    public function getExtension(): Str {
        return $this->extract()
            ->prop('pathname')
            ->map(fn($pn) 
                => pathinfo($pn, PATHINFO_EXTENSION)
            );
    }

    // TRAITS
    use \lray138\GAS\Traits\ExtendTrait;
    use \lray138\GAS\Traits\PropTrait;
    use \lray138\GAS\Traits\DuplicateTrait;
    use \lray138\GAS\Traits\MagicCallTrait;
    use \lray138\GAS\Traits\MagicGetTrait;
    use ExtractValueTrait;

}