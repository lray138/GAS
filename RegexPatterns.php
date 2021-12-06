<?php
namespace lray138\GAS\RegexPatterns;

function YYYasdfas() {
	
}

// based on https://stackoverflow.com/questions/2433809/close-all-html-unclosed-img-tags
// and https://stackoverflow.com/questions/14111154/close-all-html-tags-not-only-img
// function getUnclosedVoidElementRegex() {
function findUnclosedVoidElement() {
	return "|(<__ELEMENT__[^>]+)(?<!/)>|";
}

// getUnclosedVoidElementReplacementRegex
function replaceUnclosedVoidElement() {
	return '${1}/>';
}