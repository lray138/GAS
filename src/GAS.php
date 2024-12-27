<?php 

// @todo rename this to "index" cause I was scanning and couln't find this

namespace lray138\GAS;

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

$diffOriginalHTML = function() {

    $files = A::of(FS\getFilesInDirRecursive(WEBPACK_DIR . "src/html"))
        ->map(function($x) {
            return A::of([
                "original" => str_replace([WEBPACK_DIR, ".ejs"], [LANDKIT_DIR, ".html"], $x),
                "modified" => $x
            ]);
        })
        ->walk(function($x) {

            $differ = new Differ(new UnifiedDiffOutputBuilder());

            // $getContents = Either::right("file_get_contents")
            //     ->ap($x->original);

            // future idea

            $content_1 = $x->original->map("file_get_contents")->get();
            $content_2 = $x->modified->map("file_get_contents")->get();

            file_put_contents(
                $x->modified->replace(".ejs", ".diff"),
                $differ->diff($content_1, $content_2));

        });
           
};

use lray138\GAS\IO;

const dump = __NAMESPACE__ . '\dump';

function dump() {
    return IO\dump(...func_get_args());
}

const diff = __NAMESPACE__ . '\diff';

function diff($a, $b) {
    $differ = new Differ(new UnifiedDiffOutputBuilder()); 
    return $differ->diff($a, $b);
}

function Str($s) {
    return $s instanceof \lray138\GAS\Types\StrType
        ? $s
        : \lray138\GAS\Types\StrType::of($s);
}

function Arr($a) {

    if(!is_array($a)) {
        $a = [$a];
    }

    return $a instanceof \lray138\GAS\Types\ArrType
        ? $a
        : \lray138\GAS\Types\ArrType::of($a);
}

function Just($x) {
    return $x instanceof \lray138\GAS\Types\Maybe\Just
        ? $x
        : \lray138\GAS\Types\Maybe::just($x);
}