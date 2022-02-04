<?php

namespace lray138\GAS\HTML5DOM;

use IvoPetkov\HTML5DOMDocument;

use function lray138\GAS\IO\dump;

// via http://www.java2s.com/Code/Php/XML/TraversingaTreeofXMLNodesUsingRecursion.htm
// related https://stackoverflow.com/questions/4562769/recursively-loop-through-the-dom-tree-and-remove-unwanted-tags
/*

this traverse code doesn't belong here...

*/
function traverse($node, $level = 0 ){
    if(!handle_node( $node, $level )) {
        return false;
    }

    if ( $node->hasChildNodes() ) {
        $children = $node->childNodes;

        foreach( $children as $kid ) {
            if ( $kid->nodeType == XML_ELEMENT_NODE ) {
                if(in_array($kid->tagName, ["h1", "p", "a", "ul"])) {
                    return false;
                }
            }
        }

        foreach( $children as $kid ) {
            if ( $kid->nodeType == XML_ELEMENT_NODE ) {
                traverse( $kid, $level+1 );
            }
        }
    }
}

function handle_node($node, $level) {
    for ( $x = 0; $x < $level; $x++ ) {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    }

    if ( $node->nodeType == XML_ELEMENT_NODE ) {

        print $node->tagName."<br />\n";
    }

    return true;
}

function getNodeTypes() {
    return [
        1   => "Element",
        2   => "Attr", 
        3   => "Text",   
        4   => "CDATASection", 
        5   => "EntityReference", 
        6   => "Entity",  
        7   => "ProcessingInstruction",   
        8   => "Comment",  
        9   => "Document",  
        10  => "DocumentType",    
        11  => "DocumentFragment",     
        12  => "Notation"
    ];
}

function create($source) {
    $dom = new HTML5DOMDocument();
    $dom->loadHTML($source);
    return $dom;
}

function getNodeType($node) {
    return getNodeTypes()[$node->nodeType];
}

function getNodeValue($element) {
    return $element->nodeValue;
}

function getNodeName($element) {
    return $element->nodeName;
}

function getInnerHTML($element) {
    return $element->innerHTML;
}

function getOuterHTML($element) {
    return $element->outerHTML;
}

function getAttributes($element) {
    return is_null($element) ? [] : $element->getAttributes();
}

function getChildren($element) {
    return $element->childNodes;
}

function hasChildren($node) {
    return $node->hasChildNodes();
}