<?php 

namespace lray138\GAS\XML;

use lray138\GAS\Arr;

// based on https://stackoverflow.com/questions/4554233/how-check-if-a-string-is-a-valid-xml-with-out-displaying-a-warning-in-php
function isValid($xmlstr, $wrap = false) {
    if($wrap) $xmlstr = "<div class=\"wrap\">" . $xmlstr . "</div>";
    libxml_use_internal_errors(true);
    $sxe = simplexml_load_string($xmlstr);

    if($sxe === FALSE) {
        $errors = Arr\map(function($error) {
                return $error->message;
              }, libxml_get_errors());
        libxml_clear_errors();
    }
    return $sxe !== FALSE ? true : $errors;
}

function simpleXmlToArray($simple_xml) {
    return json_decode(json_encode((array) $simple_xml), 1);
}

const simpleXmlToArray = __NAMESPACE__ . '\simpleXmlToArray';

function simpleXmlToJson($simple_xml) {
    return json_encode((array) $simple_xml);
}

const simpleXmlToJson = __NAMESPACE__ . '\simpleXmlToJson';