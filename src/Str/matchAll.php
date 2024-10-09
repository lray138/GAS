<?php namespace lray138\GAS\Str;

const matchAll = __NAMESPACE__ . '/matchAll';

function matchAll() {
    $matchAll = function($pattern, $subject) {
        $matches = [];
        $count = preg_match_all($pattern, $subject, $matches);

        if($count === 0) {
            return false;
        }

        $head = array_shift($matches);
        $tail = $matches;

        $out = [];
        for ($i = 0; $i < $count; $i++) {
            $match = ["full" => $head[$i]];
            foreach($tail as $key => $t) {
               $match["group_" . ($key+1)] = $t[$i];
            }
            $out[] = $match;
        }

        return $out;
    };

    return call_user_func_array(curry2($matchAll), func_get_args());
}