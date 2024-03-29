<?php

namespace lray138\GAS\Regex;

use function lray138\GAS\IO\dump;

CONST patterns = [
	"unclosedVoidElement" => [
		"find" => "|(<__ELEMENT__[^>]+)(?<!/)>|",
		"replace" => '${1}/>'
	],
	"sublimeTextSearchResult" => [
		"find" => "|(\/[a-zA-Z.0-9\/]*):|"
	]
];


function matchAll($pattern, $subject, $matches = null, $flags = 0, $offset = 0) {
	preg_match_all($pattern, $subject, $matches);
	return $matches;
}

function replace($pattern, $replace, $string) {
	return preg_replace($pattern, $replace, $string);
}

function patterns() {
	return \lray138\GAS\Monads\Maybe::of(patterns);
}