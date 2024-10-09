<?php namespace lray138\GAS\Str;

const padLeftN = __NAMESPACE__ . '\padLeftN';

/* 
str_pad(
    string $string,
    int $length,
    string $pad_string = " ",
    int $pad_type = STR_PAD_RIGHT
): string
*/
function padLeftN() {
    $padLeftN = function($n, $delimeter, $string) {
        $out = \str_pad($string, $n, $delimeter, STR_PAD_LEFT);
        return $out;
    };

    return call_user_func_array(FP\curry3($padLeftN), func_get_args());
}