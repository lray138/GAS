<?php 
namespace lray138\GAS\Server;

use lray138\GAS\Types\{
    StrType as Str
};

use function lray138\GAS\dump;

function getProtocol(): Str {
   return Str::of((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http');
}

function getName(): Str {
    return Str::of($_SERVER["SERVER_NAME"]);
}

function getHost(): Str {
    return Str::of($_SERVER["HTTP_HOST"]);
}

function getBaseUrl(): Str {
    return getProtocol()
        ->concat(Str::of("://"))
        ->concat(getHost())
        ->concat(Str::of("/"));
}