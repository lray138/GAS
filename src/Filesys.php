<?php
declare(strict_types=1);

// https://www.php.net/manual/en/ref.filesystem.php

namespace lray138\GAS\Filesys;

use function lray138\GAS\{
    dump, 
    Functional\curryN,
    Functional\wrap
};

use lray138\GAS\Types\{
    Either, 
    Boolean as Boo,
    ArrType as Arr
};

use const lray138\GAS\dump;

// 
function putContents(...$args) {
    $f = function ($filename, $data, $flags = 0): Either {
        return wrap($filename)
            ->bind(fn($x) => Boo::of(file_put_contents($x, $data, $flags)))
            ->bind(fn($x) => $x 
                ? Either::right("successful write to '$filename'") 
                : Either::left("problem writing to '$filename'")
            );
    };

    return curryN(2, $f)(...$args);
}

// https://www.php.net/manual/en/function.copy.php
function copy(...$args) {
    $f = function($from, $to): Either {
        return wrap($from)
            ->bind(fn($x) => Boo::of(\copy($from, $to)))
            ->fold(
                fn() => Either::left("error copying '" . basename($to) . "'"),
                fn() => Either::right("copied '" . basename($to) . "' successfully")
            );
    };

    return curryN(2, $f)(...$args);
}

function getContents(...$args) {
    $f = function($filename) {
        
        return wrap($filename)
            ->bind(function($x) {
                $contents = file_get_contents($x);
                return $contents === false ? Either::left("error reading file") : Either::right($contents);
            });
    };

    return $f(...$args);
}

function getJson(...$args) {
    $f = function($filename) {
        return getContents($filename)
            ->bind(fn($x) => Arr::of(json_decode($x, true)));
    };

    return $f(...$args);
}