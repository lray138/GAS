<?php namespace lray138\GAS\Str;

use lray138\GAS\{
    Arr,
    Functional as FP,
    Types
};

use function lray138\GAS\Functional\{curryN};
use function lray138\GAS\IO\dump;

use function lray138\GAS\Functional\unwrap;

if (!defined('DOUBLE_QUOTE')) {
    define('DOUBLE_QUOTE', '"');
}

if (!defined('SINGLE_QUOTE')) {
    define('SINGLE_QUOTE', "'");
}

require __DIR__ . '/Str/_match.php';
require __DIR__ . '/Str/addLeadingZero.php';
require __DIR__ . '/Str/afterFirst.php';
require __DIR__ . '/Str/afterLast.php';
require __DIR__ . '/Str/afterNth.php';
require __DIR__ . '/Str/append.php';
require __DIR__ . '/Str/beforeFirst.php';
require __DIR__ . '/Str/beforeLast.php';
require __DIR__ . '/Str/beforeNth.php';
require __DIR__ . '/Str/concat.php';
require __DIR__ . '/Str/concatN.php';
require __DIR__ . '/Str/concatNOld.php';
require __DIR__ . '/Str/contains.php';
require __DIR__ . '/Str/containsAll.php';
require __DIR__ . '/Str/containsAny.php';
require __DIR__ . '/Str/containsNone.php';
require __DIR__ . '/Str/DOMToArray.php';
require __DIR__ . '/Str/endsWith.php';
require __DIR__ . '/Str/endsWithExpression.php';
require __DIR__ . '/Str/endsWithString.php';
require __DIR__ . '/Str/equals.php';
require __DIR__ . '/Str/explode.php';
require __DIR__ . '/Str/extract.php';
require __DIR__ . '/Str/findFirst.php';
require __DIR__ . '/Str/isUrl.php';
require __DIR__ . '/Str/findLast.php';
require __DIR__ . '/Str/firstChar.php';
require __DIR__ . '/Str/indexOf.php';
require __DIR__ . '/Str/indexOfExpression.php';
require __DIR__ . '/Str/indexOfString.php';
require __DIR__ . '/Str/isExpression.php';
require __DIR__ . '/Str/isRegex.php';
require __DIR__ . '/Str/join.php';
require __DIR__ . '/Str/unit.php';
require __DIR__ . '/Str/kebalbCaseToCamel.php';
require __DIR__ . '/Str/kebalbCaseToPascal.php';
require __DIR__ . '/Str/lastChar.php';
require __DIR__ . '/Str/lastCharIs.php';
require __DIR__ . '/Str/length.php';
require __DIR__ . '/Str/ltrim.php';
require __DIR__ . '/Str/matchAll.php';
require __DIR__ . '/Str/matchOne.php';
require __DIR__ . '/Str/matches.php';
require __DIR__ . '/Str/matchesExpression.php';
require __DIR__ . '/Str/matchesString.php';
require __DIR__ . '/Str/numberFormat.php';
require __DIR__ . '/Str/padLeft.php';
require __DIR__ . '/Str/padLeftN.php';
require __DIR__ . '/Str/padZero.php';
require __DIR__ . '/Str/prepend.php';
require __DIR__ . '/Str/removeQuotes.php';
require __DIR__ . '/Str/replace.php';
require __DIR__ . '/Str/replaceWithArray.php';
require __DIR__ . '/Str/replaceWithExpression.php';
require __DIR__ . '/Str/replaceWithString.php';
require __DIR__ . '/Str/rtrim.php';
require __DIR__ . '/Str/slugToCamelCase.php';
require __DIR__ . '/Str/slugify.php';
require __DIR__ . '/Str/slice.php';
require __DIR__ . '/Str/split.php';
require __DIR__ . '/Str/splitWithExpression.php';
require __DIR__ . '/Str/splitWithNull.php';
require __DIR__ . '/Str/splitWithString.php';
require __DIR__ . '/Str/startsWith.php';
require __DIR__ . '/Str/startsWithExpression.php';
require __DIR__ . '/Str/startsWithString.php';
require __DIR__ . '/Str/toCamelCase.php';
require __DIR__ . '/Str/toHTML5DOM.php';
require __DIR__ . '/Str/toInt.php';
require __DIR__ . '/Str/toUpper.php';
require __DIR__ . '/Str/trim.php';
require __DIR__ . '/Str/trimLeft.php';
require __DIR__ . '/Str/trimLeftWithExpression.php';
require __DIR__ . '/Str/trimLeftWithString.php';
require __DIR__ . '/Str/trimRight.php';
require __DIR__ . '/Str/trimRightWithExpression.php';
require __DIR__ . '/Str/trimRightWithString.php';
require __DIR__ . '/Str/trimWithExpression.php';
require __DIR__ . '/Str/trimWithString.php';
require __DIR__ . '/Str/wrap.php';
require __DIR__ . '/Str/XMLToArray.php';

// wtf, it's 03:38 and I'm adding a isURL function...? DRY DRY DRY DRY DRY
//https://stackoverflow.com/questions/161738/what-is-the-best-regular-expression-to-check-if-a-string-is-a-valid-url

function urlConcat(...$args) {
    $f = function($str, $to) {
        return \lray138\GAS\Types\StrType::of(\trim(unwrap($to), "/") . "/" . \trim(unwrap($str), "/") . "/");
    };

    return curryN(2, $f)(...$args);
}