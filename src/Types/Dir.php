<?php 

namespace lray138\GAS\Types;

use lray138\GAS\Types\Either;
use lray138\GAS\Types\ArrType as Arr;
use function lray138\GAS\Arr\{map, filter};
use function lray138\GAS\Str\{
    append, prepend, lastCharIs,
};
use const lray138\GAS\Arr\notIn;
use lray138\GAS\Functional as FP;

use function lray138\GAS\dump;

use lray138\GAS\Types\{
    Either\Left,
    Either\right,
    Boolean as Boo,
    File
};
use \FunctionalPHP\FantasyLand\{Apply, Monad, Semigroup};
use lray138\GAS\Types\Comonad;

use function lray138\GAS\Functional\wrap;

/**
 * An OO-looking implementation of Either in PHP.
 * Comonad, Semigroup 
 */ 
class Dir implements Monad, Comonad {

    private $value;

    // well, well, well, this actually already existsed Apr 22, 15:39
    use \lray138\GAS\Traits\ExtendTrait;
    use \lray138\GAS\Traits\DuplicateTrait; // and this ha

    public const of  = __CLASS__ . '::of';

    public static function of($path) {
        return is_dir($path) 
            ? new Dir($path)
            : Either::left("Dir not found: " . $path)
            ;
    }

    // traits

    use \lray138\GAS\Traits\ExtractValueTrait;
    use \lray138\GAS\Traits\MagicCallTrait;
    use \lray138\GAS\Traits\MagicGetTrait;

    private function __construct($path) {
        $this->value = Arr::of([
            "path" => $path
        ]);
    }

    public function dump() {
        dump($this);
        return $this;
    }

    public function path(): string {
        return $this->extract();
    }

    public function ap(Apply $b): Apply {
        return $this;
    }

    public function exists(): Boo {
        return Boo::true();
    }

    // public function exists() {
    //     return $this->extract()
    //         ->extend(fn(Arr $dir) 
    //             => Boo::of(is_dir($dir->p('path')->get())));
    // }

    public function bind(callable $fn) {
        return $fn($this->extract());
    }

    public function map(callable $fn): Dir {
        return new static($fn($this->extract()));
    }

    // mode not implemented but would be the difference between
// file object and a the full path that this currently provides.
function getFiles($options = []): Arr {

    $directory = $this->extract()->prop('path')->get();

	if(is_object($directory) && method_exists($directory, "extract")) {
		$directory = $directory->extract();
	}

	if(isset($options["mode"])
		&& in_array(strtolower($options["mode"]), ["object", "obj", "splfile"])) {
		$files = [];
		foreach (new \DirectoryIterator($directory) as $fileInfo) {
			if($fileInfo->isDot() || $fileInfo->isDir()) continue;
            die('lol, do this at some point maybe');
			$files[] = File::of([
				"path" => $fileInfo->getPath() 
				, "pathname" => $fileInfo->getPathname()
				, "filename" => $fileInfo->getFilename()
				, "extension" => $fileInfo->getExtension()
			]);
		}

		return Arr::of($files);
	}

	$prependDirectoryToFile = map(
		function($x) use ($directory) {
			if(!lastCharIs("/", $directory)) {
				return prepend(append("/", $directory), $x);
			} 
			return prepend($directory, $x);
		});

	// leave a comment, like and subscribe
	// Oct 9, 2024 - 18:37 . not sure what changed but I have to add flip to 
	$process = FP\pipe(
		filter(FP\flip(notIn)([".", "..", ".DS_Store"])),
		(isset($options["filter"]) ? filter($options["filter"]) : fn($x) => $x),
		$prependDirectoryToFile
    );

        // carbon relies on zero indexing somewhere and 
        // was tripping up because of this that 2025-01-16 12:27
        return Arr::of(array_values(filter(
            "is_file",
            $process(scandir($directory))))
        )
        ->map(fn($x) => File::of($x));
}

    // https://stackoverflow.com/questions/24783862/list-all-the-files-and-folders-in-a-directory-with-php-recursive-function
    // and
    // https://stackoverflow.com/questions/19724579/php-recursivedirectoryiterator-how-to-exclude-directory-paths-with-a-dot-and-do
    public function getFilesRecursive($options = []): Arr {

        $dir = $this
            ->extract()
            ->prop('path')
            ->get();

        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        
        $value = isset($options["return_type"]) && strtolower($options["return_type"]) === "fileinfo"
            ? iterator_to_array(new \RecursiveIteratorIterator($it))
            : array_keys(iterator_to_array(new \RecursiveIteratorIterator($it)));

        return Arr::of($value);
    }

    public function __toString() {
        return $this->extract()->prop('path')->get();
    }

}