<?php

namespace lray138\GAS\IO;

// https://stackoverflow.com/questions/933367/php-how-to-best-determine-if-the-current-invocation-is-from-cli-or-web-server
function isCLI()
{
    if ( defined('STDIN') )
    {
        return true;
    }

    if ( php_sapi_name() === 'cli' )
    {
        return true;
    }

    if ( array_key_exists('SHELL', $_ENV) ) {
        return true;
    }

    if ( empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) 
    {
        return true;
    } 

    if ( !array_key_exists('REQUEST_METHOD', $_SERVER) )
    {
        return true;
    }

    return false;
}

function varDump($var) {
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

const varDump = __NAMESPACE__ . '\varDump';

function dump($var) {
    if(!isCLI()) {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    } else {
        var_dump($var);
    }
}

const dump = __NAMESPACE__ . '\dump';

function dumpNdie($var) {

    varDump($var);
    die;
}

const dumpNdie = __NAMESPACE__ . '\dumpNdie';

function newLine($count = 1) {
    $line = isCLI() ? "\n" : "<br/>";
    do {
        echo $line;
        $count--;
    } while ($count > 0);
}