<?php namespace lray138\GAS\Str;

const XMLToArray = __NAMESPACE__ . '/XMLToArray';

function XMLToArray(string $xml): array {
    $previous_value = libxml_use_internal_errors(true);
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false; 
    $dom->loadXml($xml);
    
    libxml_use_internal_errors($previous_value);
    
    if (libxml_get_errors()) {
        return [];
    }

    return DOMToArray($dom);
}