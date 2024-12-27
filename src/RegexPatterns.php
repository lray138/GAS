<?php
namespace lray138\GAS\RegexPatterns;

// based on https://stackoverflow.com/questions/2433809/close-all-html-unclosed-img-tags
// and https://stackoverflow.com/questions/14111154/close-all-html-tags-not-only-img
// function getUnclosedVoidElementRegex() {
// NOTE: this is base Regex that needs to be mapped to a list of void elements.
// for usage see: 
function findUnclosedVoidElement() {
	return "|(<__ELEMENT__[^>]+)(?<!/)>|";
}

// getUnclosedVoidElementReplacementRegex
function replaceUnclosedVoidElement() {
	return '${1}/>';
}

function findUrl() {
	return '#(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))#i';
}

function replaceUrl() {
	return '<a href="$1">$1</a>';
}

// wonder why I was using "|" and "#" as bookends, will probably find out
// not sure I'm using it like this currently
function findAmpersand() {
	return '/&(?![a-zA-Z#]|amp|#\d+;)(?![a-zA-Z]+;)/';
}

