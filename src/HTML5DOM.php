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

const sortAttributesAlphabetically = __NAMESPACE__ . '\sortAttributesAlphabetically';

function sortAttributesAlphabetically(\IvoPetkov\HTML5DOMDocument $input) {
    $doc = clone $input;
    // Traverse the DOM tree
    $elements = $doc->getElementsByTagName('*');
    foreach ($elements as $element) {
        // Check if the element has attributes
        if ($element->hasAttributes()) {

            $sorted_attributes = $element->getAttributes();
            ksort($sorted_attributes);

            foreach($element->getAttributes() as $key => $value) {
                $element->removeAttribute($key);
            }

            foreach($sorted_attributes as $key => $value) {
                $element->setAttribute($key, $value);
            }

        }
    }
    return $doc;
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

// an alias for textContent, thinking about using the HH getTextValues, getTextValue
// as the "interface" call
function getTextValue(IvoPetkov\HTML5DOMElement $node) {
    return $node->textContent;
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

function how() {
    echo "fromContents or fromPathname";
}

function create($source, $options = null) {
    $dom = new HTML5DOMDocument();
    $dom->loadHTML($source, $options);
    return $dom;
}

// @todo Figure out how to properly deprectate something.
function _create($file_contents, $options = null) {
    return create($file_contents, $options);
}

function fromContents($contents, $options = null) {
    return create($contents, $options);
}

// wow, amazing what you think the right name is sometimes...
function fromString($file_contents, $options = null) {
    return _create($file_contents, $options);
}

function fromPathname($pathname, $options = null) {
    return create(file_get_contents($pathname), $options);
}

function fromFile($pathname, $options = null) {
    return fromPathname(($pathname), $options);
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