<?php 

namespace lray138\GAS\PHTML;

use lray138\GAS\{
	Filesystem as FS,
	Str,
	Functional as FP,
	Arr,
	HTML,
	HTML5DOM as DOM
};

use function lray138\GAS\IO\dump;

function process($src, $dist) {
	$src = FS\isDir($src) ? FS\getFilesInDirRecursive($src) : [$src];

	$src = Arr\filter(function($x) {
		return !Str\contains(".DS_Store", $x);
	}, $src);

	$createGHTML = function($pathname) use ($src, $dist) {
		$source_contents = DOM\create(FS\read($pathname));
		$trim_right = Str\lastCharIs("/", $dist);
		$source_dir = Str\beforeLast("/", $pathname, $trim_right);
		
		$write_to = Str\replace(["src", ".html"], ["dist", ".php"], $pathname);

		$element_to_process = $source_contents->documentElement->firstElementChild;

		if($element_to_process->tagName === "head" ) {
			$tag_name = "head";
		} else {
			$element_to_process = $element_to_process->firstElementChild;
			if(is_null($element_to_process)) {
				dump("issue with " . $pathname);
			}
			$tag_name = $element_to_process->tagName;
		}

		$out = getPHPStart();
		$out .= 'use lray138\GAS\{
	HTML,
	Types\ArrType
};

use function lray138\GAS\Functional\flip as _;
		';
		$out .= '
';

		$out .= 'return function(ArrType $data = null) {
    return ';

		$out .= traverse2(traverseForBlockContent($element_to_process)); 

		$out .= ';
};';

		FS\write($write_to, $out, true);
	};

	Arr\walk($createGHTML, $src);
}

function getPHPStart($namespace = null) {
	$out = '<?php
';

	if(!is_null($namespace)) {
		$out .= 'namespace ' . $namespace;
	}

	return $out;
}

// great example of the programmers are lazy
// and case where this is a super generic function name
// and really no help once you come back after a few days
// off
function traverse2($node, $level = 0 ){
    $stuff = handle_node2($node, $level);

    $children = [];

    $out = "";

    if ( isset($node["children"]) ) {

        foreach( $node["children"] as $kid ) {
            $children[] = traverse2($kid, $level+1);
        }

        //$out = '([';
       	$out .= implode(",
", $children);
       	//$out .= '])';

    } else if(!HTML\isVoidElement($node["node_name"])) {
    	if(isset($node["content"])) {
//     		$out .= getPad($level) . '"' . $node["content"] . '"
// ';
			$out .= '"' . $node["content"] . '"';
    	}
    	
    }

    if(HTML\isVoidElement($node["node_name"])) {
    	return $stuff . $out . getPad($level-1);
    } else if(!isset($node["children"])) {
    	$out = empty($out) ? "''" : $out;
    	return $stuff . "(" . $out . ")";
    } else {
    	return $stuff . "([
"
. $out . getPad($level-1) . "
" . getPad($level) . "])";
}

	

    }


function handle_node2($node, $level) {
	$out = getPad($level);

	if(!HTML\isVoidElement($node["node_name"])) {
		$out .= '_(';
	}

    $out .= 'HTML\\' . $node["node_name"];

    if(!HTML\isVoidElement($node["node_name"])) {
		$out .= ')';
	}

    $out .= '(\'' . getAttributesString($node["attributes"]) . '\')';

    return $out;
}


function getAttributesString($attributes) {
	$out = [];

	foreach($attributes as $key => $val) {
		$out[] = $key . '="' . addslashes($val) . '"';
	}

	return Arr\implode(" ", $out);
}


function traverseForBlockContent($node, $carry = []){
    if(is_null($node)) {
    	return [];
    }

    $out = [
    	"node_name" => DOM\getNodeName($node) === "use" ? "useElement" : DOM\getNodeName($node),
    	"attributes" => DOM\getAttributes($node)
    ];

    if ( $node->hasChildNodes() ) {
        foreach($node->childNodes as $kid ) {
            if ( DOM\getNodeType($kid) === "Element" ) {
                $out["children"][] = traverseForBlockContent($kid);
            } elseif($kid->nodeType === XML_TEXT_NODE) {
                if(empty(trim($kid->textContent))) continue;
                $out["content"] = $kid->textContent;
          	} elseif($kid->nodeType === XML_CDATA_SECTION_NODE) {
                if(empty(trim($kid->textContent))) continue;
                $out["content"] = Str\replace("-html5-dom-document-internal-cdata", "", $kid->textContent);
            } 
        }
    } 

	return $out;
}

function getPad($level) {
	$pad = "";
    for ( $x = 0; $x < $level; $x++ ) {
        $pad .= "    ";
    }
    return $pad;
}

