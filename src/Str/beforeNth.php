<?php namespace lray138\GAS\Str;

/**
 * Returns the substring of a string before the nth occurrence of a delimiter.
 *
 * @param int $n The occurrence number (1-based index).
 * @param string $delimiter The delimiter to search for.
 * @param string $input The input string.
 * 
 * @todo note this should be aliased 'beforeNth' ?? delimeter?
 * @todo note this seems somewhat academic
 * 
 * @return string The substring before the nth occurrence of the delimiter.
 */
function beforeNth($n, string $delimiter, string $input) {
    if(empty($n)) {
        return $input; 
    }

    if(empty($delimiter)) {
        return ""; 
    }

    if($n > substr_count($input, $delimiter)) {
        return $input;
    }

    $out = [];
    $bits = \explode($delimiter, $input);
    
    foreach ($bits as $key => $bit) {
        if ($key > $n - 1) break; // $n is 1-based index
        $out[] = $bit;
    }
    
    return \implode($delimiter, $out);
}