<?php 

namespace lray138\GAS\HTML;

use lray138\GAS\Arr;
use lray138\GAS\Str;
use lray138\GAS\Functional as FP;
use lray138\GAS\Monads\Maybe;
use lray138\GAS\IO;
use lray138\GAS\Types\Type;

use function lray138\GAS\IO\dump;

function isVoidElement($node_name) {
  return Arr\contains($node_name)(getVoidElements());
}

// run FP extract in case it's a Monad
function flatten($array) {
  $out = "";
  foreach($array as $a) {
      $out .= is_array($a) 
        ? flatten($a)
        : FP\extract($a);
  }
  return $out;
}

function element($type, $content = "", $attributes = null) {

  if($content instanceof Type) {
    $content = $content->extract();
  }

  if($attributes instanceof Type) {
    $attributes = $attributes->extract();
  }

  $out = '<' . $type;

  // for cases where flipped currying is involved
  // and you need to add extra attributes
  /// revisiting this since it hasn't really been used... 
  // wonder if just spelling "attributes" is better anyway
  if(is_array($content) && array_key_exists("attr", $content)) {
    $attributes = array_merge($attributes, $content["attr"]);
    $content = $content["content"];
  }

  if(is_array($attributes) && count($attributes) > 0) {
      $out .= _processAttributes($attributes);
  } else if(is_string($attributes) && $attributes !== "") {
      $out .= " " . $attributes;
  }

  if(in_array($type, getVoidElements())) {
    $out .= '/>';
    return $out;
  }

  // Jan 1, 2022 @ 15:19 - added extract support for types being passed
  if(is_array($content)) {
    $content = flatten($content);
    //$content = Arr\join("", Arr\map(FP\extract, $content));
  } else if($content instanceof \lray138\GAS\Types\Maybe) {
    $content = $content->extract();
  }

  $out .= '>' . $content . '</' . $type . '>';
  
  return $out;
}

function array_map_recursive($callback, $array)
{
  $func = function ($item) use (&$func, &$callback) {
    return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
  };

  return array_map($func, $array);
}

function getVoidElements() {
  return [
    "area", 
    "base", 
    "br", 
    "col", 
    "command", 
    "embed", 
    "hr", 
    "img", 
    "input", 
    "keygen", 
    "link", 
    "meta", 
    "param", 
    "source", 
    "track", 
    "wbr",
    "useElement",
    "path" // added Jan 23, 2022
  ];
}

function _processAttributes($attributes) {
    if(!is_array($attributes)) {
      return " " . $attributes;
    }

    // old way for reference
    $apply = function($value, $key) use (&$attr) {
      $attr = $attr . ' ' . $key . '="' . $value .'"';
    };

    $attr = '';
    Arr\walk($apply, $attributes);

    return $attr;
}

function a2($href, string $content = "", $attributes = []) {
  if(empty($content)) {
    $content = $href;
  }

  $attributes = is_string($attributes) 
    ? (function($x) {
          $out = [];
          Arr\walk(function($keyVal) use (&$out) {
              $bits = explode("=", str_replace('"', '', $keyVal));
              $out[$bits[0]] = $bits[1];
          })($x);
          return $out;
      })(explode(" ", $attributes))
    : $attributes;

  if(isset($attributes["base_url"])) {
    $href = $attributes["base_url"] . $href;
    unset($attributes["base_url"]);
  }

  return element("a", $content, Arr\merge(["href" => $href], $attributes));
}

const a2 = __NAMESPACE__ . '\a2';

// function a($content, $attributes = []) {
//   return element("a", $content, $attributes);
// }

// const a = __NAMESPACE__ . '\a';

function br($count = 1) {
  // return FP\compose(
  //           Arr\joinEmpty, 
  //           Arr\map(function() {
  //             return element("br");
  //           }))(range(1, $count));

  return Maybe::of(range(1, $count))
          ->bind(Arr\map(function() {
            return element("br");
          }))
          ->bind(Arr\join(""))
          ->extract();
}

const br = __NAMESPACE__ . '\br';

function comment($content, $attributes = []) {
  return element("comment", $content, $attributes);
}

const comment = __NAMESPACE__ . '\comment';

function doctype($content, $attributes = []) {
  return element("doctype", $content, $attributes);
}

const doctype = __NAMESPACE__ . '\doctype';

function a($content, $attributes = []) {
  return empty($attributes)
    ? element("a", $content, ["href" => $content])
    : element("a", $content, $attributes);
}

const a = __NAMESPACE__ . '\a';

function abbr($content, $attributes = []) {
  return element("abbr", $content, $attributes);
}

const abbr = __NAMESPACE__ . '\abbr';

function address($content, $attributes = []) {
  return element("address", $content, $attributes);
}

const address = __NAMESPACE__ . '\address';

function area($attributes = []) {
  return element("area", "", $attributes);
}

const area = __NAMESPACE__ . '\area';

function article($content, $attributes = []) {
  return element("article", $content, $attributes);
}

const article = __NAMESPACE__ . '\article';

function aside($content, $attributes = []) {
  return element("aside", $content, $attributes);
}

const aside = __NAMESPACE__ . '\aside';

function audio($content, $attributes = []) {
  return element("audio", $content, $attributes);
}

const audio = __NAMESPACE__ . '\audio';

function b($content, $attributes = []) {
  return element("b", $content, $attributes);
}

const b = __NAMESPACE__ . '\b';

function base($attributes = []) {
  return element("base", "", $attributes);
}

const base = __NAMESPACE__ . '\base';

function bdi($content, $attributes = []) {
  return element("bdi", $content, $attributes);
}

const bdi = __NAMESPACE__ . '\bdi';

function bdo($content, $attributes = []) {
  return element("bdo", $content, $attributes);
}

const bdo = __NAMESPACE__ . '\bdo';

function blockquote($content, $attributes = []) {
  return element("blockquote", $content, $attributes);
}

const blockquote = __NAMESPACE__ . '\blockquote';

function body($content, $attributes = []) {
  return element("body", $content, $attributes);
}

const body = __NAMESPACE__ . '\body';

function button($content, $attributes = []) {
  return element("button", $content, $attributes);
}

const button = __NAMESPACE__ . '\button';

function canvas($content, $attributes = []) {
  return element("canvas", $content, $attributes);
}

const canvas = __NAMESPACE__ . '\canvas';

function caption($content, $attributes = []) {
  return element("caption", $content, $attributes);
}

const caption = __NAMESPACE__ . '\caption';

function cite($content, $attributes = []) {
  return element("cite", $content, $attributes);
}

const cite = __NAMESPACE__ . '\cite';

function code($content, $attributes = []) {
  return element("code", $content, $attributes);
}

const code = __NAMESPACE__ . '\code';

function col($attributes = []) {
  return element("col", "", $attributes);
}

const col = __NAMESPACE__ . '\col';

function colgroup($content, $attributes = []) {
  return element("colgroup", $content, $attributes);
}

const colgroup = __NAMESPACE__ . '\colgroup';

function data($content, $attributes = []) {
  return element("data", $content, $attributes);
}

const data = __NAMESPACE__ . '\data';

function datalist($content, $attributes = []) {
  return element("datalist", $content, $attributes);
}

const datalist = __NAMESPACE__ . '\datalist';

function dd($content, $attributes = []) {
  return element("dd", $content, $attributes);
}

const dd = __NAMESPACE__ . '\dd';

function del($content, $attributes = []) {
  return element("del", $content, $attributes);
}

const del = __NAMESPACE__ . '\del';

function details($content, $attributes = []) {
  return element("details", $content, $attributes);
}

const details = __NAMESPACE__ . '\details';

function dfn($content, $attributes = []) {
  return element("dfn", $content, $attributes);
}

const dfn = __NAMESPACE__ . '\dfn';

function dialog($content, $attributes = []) {
  return element("dialog", $content, $attributes);
}

const dialog = __NAMESPACE__ . '\dialog';

function div($content, $attributes = []) {
  return element("div", $content, $attributes);
}

const div = __NAMESPACE__ . '\div';

function dl($content, $attributes = []) {
  return element("dl", $content, $attributes);
}

const dl = __NAMESPACE__ . '\dl';

function dt($content, $attributes = []) {
  return element("dt", $content, $attributes);
}

const dt = __NAMESPACE__ . '\dt';

function em($content, $attributes = []) {
  return element("em", $content, $attributes);
}

const em = __NAMESPACE__ . '\em';

function embed($attributes = []) {
  return element("embed", "", $attributes);
}

const embed = __NAMESPACE__ . '\embed';

function fieldset($content, $attributes = []) {
  return element("fieldset", $content, $attributes);
}

const fieldset = __NAMESPACE__ . '\fieldset';

function figcaption($content, $attributes = []) {
  return element("figcaption", $content, $attributes);
}

const figcaption = __NAMESPACE__ . '\figcaption';

function figure($content, $attributes = []) {
  return element("figure", $content, $attributes);
}

const figure = __NAMESPACE__ . '\figure';

function footer($content, $attributes = []) {
  return element("footer", $content, $attributes);
}

const footer = __NAMESPACE__ . '\footer';

function form($content, $attributes = []) {
  return element("form", $content, $attributes);
}

const form = __NAMESPACE__ . '\form';

function head($content, $attributes = []) {
  return element("head", $content, $attributes);
}

const head = __NAMESPACE__ . '\head';

function header($content, $attributes = []) {
  return element("header", $content, $attributes);
}

const header = __NAMESPACE__ . '\header';

function hr($attributes = []) {
  return element("hr", "", $attributes);
}

const hr = __NAMESPACE__ . '\hr';

function html($content, $attributes = []) {
  return element("html", $content, $attributes);
}

const html = __NAMESPACE__ . '\html';

function i($content, $attributes = []) {
  return element("i", $content, $attributes);
}

const i = __NAMESPACE__ . '\i';

function iframe($content, $attributes = []) {
  return element("iframe", $content, $attributes);
}

const iframe = __NAMESPACE__ . '\iframe';

function img($attributes = []) {
  return element("img", "", $attributes);
}

const img = __NAMESPACE__ . '\img';

function input($attributes = []) {
  return element("input", "", $attributes);
}

const input = __NAMESPACE__ . '\input';

function inputButton($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "button"]));
  }

  const inputButton = __NAMESPACE__ . '\inputButton';

  function inputCheckbox($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "checkbox"]));
  }

  const inputCheckbox = __NAMESPACE__ . '\inputCheckbox';

  function inputColor($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "color"]));
  }

  const inputColor = __NAMESPACE__ . '\inputColor';

  function inputDate($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "date"]));
  }

  const inputDate = __NAMESPACE__ . '\inputDate';

  function inputDatetimeLocal($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "datetimeLocal"]));
  }

  const inputDatetimeLocal = __NAMESPACE__ . '\inputDatetimeLocal';

  function inputDatetime($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "datetime"]));
  }

  const inputDatetime = __NAMESPACE__ . '\inputDatetime';

  function inputEmail($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "email"]));
  }

  const inputEmail = __NAMESPACE__ . '\inputEmail';

  function inputFile($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "file"]));
  }

  const inputFile = __NAMESPACE__ . '\inputFile';

  function inputHidden($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "hidden"]));
  }

  const inputHidden = __NAMESPACE__ . '\inputHidden';

  function inputImage($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "image"]));
  }

  const inputImage = __NAMESPACE__ . '\inputImage';

  function inputMonth($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "month"]));
  }

  const inputMonth = __NAMESPACE__ . '\inputMonth';

  function inputNumber($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "number"]));
  }

  const inputNumber = __NAMESPACE__ . '\inputNumber';

  function inputPassword($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "password"]));
  }

  const inputPassword = __NAMESPACE__ . '\inputPassword';

  function inputRadio($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "radio"]));
  }

  const inputRadio = __NAMESPACE__ . '\inputRadio';

  function inputRange($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "range"]));
  }

  const inputRange = __NAMESPACE__ . '\inputRange';

  function inputReset($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "reset"]));
  }

  const inputReset = __NAMESPACE__ . '\inputReset';

  function inputSearch($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "search"]));
  }

  const inputSearch = __NAMESPACE__ . '\inputSearch';

  function inputSubmit($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "submit"]));
  }

  const inputSubmit = __NAMESPACE__ . '\inputSubmit';

  function inputTel($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "tel"]));
  }

  const inputTel = __NAMESPACE__ . '\inputTel';

  function inputTelephone($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "telephone"]));
  }

  const inputTelephone = __NAMESPACE__ . '\inputTelephone';

  function inputText($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "text"]));
  }

  const inputText = __NAMESPACE__ . '\inputText';

  function inputTime($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "time"]));
  }

  const inputTime = __NAMESPACE__ . '\inputTime';

  function inputUrl($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "url"]));
  }

  const inputUrl = __NAMESPACE__ . '\inputUrl';

  function inputWeek($attributes = []) {
    return element("input", "", Arr\merge(FP\extract($attributes), ["type" => "week"]));
  }

  const inputWeek = __NAMESPACE__ . '\inputWeek';

  function ins($content, $attributes = []) {
  return element("ins", $content, $attributes);
}

const ins = __NAMESPACE__ . '\ins';

function kbd($content, $attributes = []) {
  return element("kbd", $content, $attributes);
}

const kbd = __NAMESPACE__ . '\kbd';

function label($content, $attributes = []) {
  return element("label", $content, $attributes);
}

const label = __NAMESPACE__ . '\label';

function legend($content, $attributes = []) {
  return element("legend", $content, $attributes);
}

const legend = __NAMESPACE__ . '\legend';

function li($content, $attributes = []) {
  return element("li", $content, $attributes);
}

const li = __NAMESPACE__ . '\li';

function link($attributes = []) {
  return element("link", "", $attributes);
}

const link = __NAMESPACE__ . '\link';

function main($content, $attributes = []) {
  return element("main", $content, $attributes);
}

const main = __NAMESPACE__ . '\main';

function map($content, $attributes = []) {
  return element("map", $content, $attributes);
}

const map = __NAMESPACE__ . '\map';

function mark($content, $attributes = []) {
  return element("mark", $content, $attributes);
}

const mark = __NAMESPACE__ . '\mark';

function meta($attributes = []) {
  return element("meta", "", $attributes);
}

const meta = __NAMESPACE__ . '\meta';

function meter($content, $attributes = []) {
  return element("meter", $content, $attributes);
}

const meter = __NAMESPACE__ . '\meter';

function nav($content, $attributes = []) {
  return element("nav", $content, $attributes);
}

const nav = __NAMESPACE__ . '\nav';

function noscript($content, $attributes = []) {
  return element("noscript", $content, $attributes);
}

const noscript = __NAMESPACE__ . '\noscript';

function object($content, $attributes = []) {
  return element("object", $content, $attributes);
}

const object = __NAMESPACE__ . '\object';

function ol($content, $attributes = []) {
  return element("ol", $content, $attributes);
}

const ol = __NAMESPACE__ . '\ol';

function optgroup($content, $attributes = []) {
  return element("optgroup", $content, $attributes);
}

const optgroup = __NAMESPACE__ . '\optgroup';

function option($content, $attributes = []) {
  return element("option", $content, $attributes);
}

const option = __NAMESPACE__ . '\option';

function output($content, $attributes = []) {
  return element("output", $content, $attributes);
}

const output = __NAMESPACE__ . '\output';

function p($content, $attributes = []) {
  return element("p", $content, $attributes);
}

const p = __NAMESPACE__ . '\p';

function param($attributes = []) {
  return element("param", "", $attributes);
}

const param = __NAMESPACE__ . '\param';

function picture($content, $attributes = []) {
  return element("picture", $content, $attributes);
}

const picture = __NAMESPACE__ . '\picture';

function pre($content, $attributes = []) {
  return element("pre", $content, $attributes);
}

const pre = __NAMESPACE__ . '\pre';

function progress($content, $attributes = []) {
  return element("progress", $content, $attributes);
}

const progress = __NAMESPACE__ . '\progress';

function q($content, $attributes = []) {
  return element("q", $content, $attributes);
}

const q = __NAMESPACE__ . '\q';

function rp($content, $attributes = []) {
  return element("rp", $content, $attributes);
}

const rp = __NAMESPACE__ . '\rp';

function rt($content, $attributes = []) {
  return element("rt", $content, $attributes);
}

const rt = __NAMESPACE__ . '\rt';

function ruby($content, $attributes = []) {
  return element("ruby", $content, $attributes);
}

const ruby = __NAMESPACE__ . '\ruby';

function s($content, $attributes = []) {
  return element("s", $content, $attributes);
}

const s = __NAMESPACE__ . '\s';

function samp($content, $attributes = []) {
  return element("samp", $content, $attributes);
}

const samp = __NAMESPACE__ . '\samp';

function script($content, $attributes = []) {
  return element("script", $content, $attributes);
}

const script = __NAMESPACE__ . '\script';

function section($content, $attributes = []) {
  return element("section", $content, $attributes);
}

const section = __NAMESPACE__ . '\section';

function select($content, $attributes = []) {
  return element("select", $content, $attributes);
}

const select = __NAMESPACE__ . '\select';

function small($content, $attributes = []) {
  return element("small", $content, $attributes);
}

const small = __NAMESPACE__ . '\small';

function source($attributes = []) {
  return element("source", "", $attributes);
}

const source = __NAMESPACE__ . '\source';

function span($content, $attributes = []) {
  return element("span", $content, $attributes);
}

const span = __NAMESPACE__ . '\span';

function strong($content, $attributes = []) {
  return element("strong", $content, $attributes);
}

const strong = __NAMESPACE__ . '\strong';

function style($content, $attributes = []) {
  return element("style", $content, $attributes);
}

const style = __NAMESPACE__ . '\style';

function sub($content, $attributes = []) {
  return element("sub", $content, $attributes);
}

const sub = __NAMESPACE__ . '\sub';

function summary($content, $attributes = []) {
  return element("summary", $content, $attributes);
}

const summary = __NAMESPACE__ . '\summary';

function sup($content, $attributes = []) {
  return element("sup", $content, $attributes);
}

const sup = __NAMESPACE__ . '\sup';

function svg($content, $attributes = []) {
  return element("svg", $content, $attributes);
}

const svg = __NAMESPACE__ . '\svg';

function table($content, $attributes = []) {
  return element("table", $content, $attributes);
}

const table = __NAMESPACE__ . '\table';

function tbody($content, $attributes = []) {
  return element("tbody", $content, $attributes);
}

const tbody = __NAMESPACE__ . '\tbody';

function td($content, $attributes = []) {
  return element("td", $content, $attributes);
}

const td = __NAMESPACE__ . '\td';

function template($content, $attributes = []) {
  return element("template", $content, $attributes);
}

const template = __NAMESPACE__ . '\template';

function textarea($content, $attributes = []) {
  return element("textarea", $content, $attributes);
}

const textarea = __NAMESPACE__ . '\textarea';

function tfoot($content, $attributes = []) {
  return element("tfoot", $content, $attributes);
}

const tfoot = __NAMESPACE__ . '\tfoot';

function th($content, $attributes = []) {
  return element("th", $content, $attributes);
}

const th = __NAMESPACE__ . '\th';

function thead($content, $attributes = []) {
  return element("thead", $content, $attributes);
}

const thead = __NAMESPACE__ . '\thead';

function time($content, $attributes = []) {
  return element("time", $content, $attributes);
}

const time = __NAMESPACE__ . '\time';

function title($content, $attributes = []) {
  return element("title", $content, $attributes);
}

const title = __NAMESPACE__ . '\title';

function tr($content, $attributes = []) {
  return element("tr", $content, $attributes);
}

const tr = __NAMESPACE__ . '\tr';

function track($attributes = []) {
  return element("track", "", $attributes);
}

const track = __NAMESPACE__ . '\track';

function u($content, $attributes = []) {
  return element("u", $content, $attributes);
}

const u = __NAMESPACE__ . '\u';

function ul($content, $attributes = []) {
  return element("ul", $content, $attributes);
}

const ul = __NAMESPACE__ . '\ul';

function varElement($content, $attributes = []) {
  return element("varElement", $content, $attributes);
}

const varElement = __NAMESPACE__ . '\varElement';

function video($content, $attributes = []) {
  return element("video", $content, $attributes);
}

const video = __NAMESPACE__ . '\video';

function wbr($attributes = []) {
  return element("wbr", "", $attributes);
}

const wbr = __NAMESPACE__ . '\wbr';

function h1($content, $attributes = []) {
  return element("h1", $content, $attributes);
}

const h1 = __NAMESPACE__ . '\h1';

function h2($content, $attributes = []) {
  return element("h2", $content, $attributes);
}

const h2 = __NAMESPACE__ . '\h2';

function h3($content, $attributes = []) {
  return element("h3", $content, $attributes);
}

const h3 = __NAMESPACE__ . '\h3';

function h4($content, $attributes = []) {
  return element("h4", $content, $attributes);
}

const h4 = __NAMESPACE__ . '\h4';

function h5($content, $attributes = []) {
  return element("h5", $content, $attributes);
}

const h5 = __NAMESPACE__ . '\h5';

function h6($content, $attributes = []) {
  return element("h6", $content, $attributes);
}

const h6 = __NAMESPACE__ . '\h6';

function useElement($attributes = []) {
  return element("useElement", "", $attributes);
}

const useElement = __NAMESPACE__ . '\useElement';


function indent($html) {
    return (new \Gajus\Dindent\Indenter())->indent($html);
}

const indent = __NAMESPACE__ . '\indent';

function tidy($html) {
    $tidy_options = array('indent' => 4,'output-xhtml' => true);
    $tidy = new \tidy();
    $tidy->parseString($html, $tidy_options);
    $tidy->cleanRepair();
    $body = $tidy->body();
    return $tidy;
}

const tidy = __NAMESPACE__ . '\tidy';

// https://ascii.cl/htmlcodes.htm
// html name => html number
// there's is also this: https://www.ascii-code.com/
function getHTMLNamesToNumbersArray() {
  return [
    // "<br>"   => "<br/>", // for whatever reason the regex doesn't pick these up
    // "<hr>"   => "<hr/>", // regex does not match this
    "&quot;"  => "&#34;",
    "&amp;"   => "&#38;",
    "&lt;"    => "&#60;",
    "&gt;"    => "&#62;",
    "&nbsp;"  => "&#160;",
    "&iexcl;"   => "&#161;",
    "&cent;"  => "&#162;",
    "&pound;"   => "&#163;",
    "&curren;"  => "&#164;",
    "&yen;"   => "&#165;",
    "&brvbar;"  => "&#166;",
    "&sect;"  => "&#167;",
    "&uml;"   => "&#168;",
    "&copy;"  => "&#169;",
    "&ordf;"  => "&#170;",
    "&laquo;"   => "&#171;",
    "&not;"   => "&#172;",
    "&mdash;" => "&#151;",
    "&shy;"   => "&#173;",
    "&reg;"   => "&#174;",
    "&macr;"  => "&#175;",
    "&deg;"   => "&#176;",
    "&plusmn;"  => "&#177;",
    "&sup2;"  => "&#178;",
    "&sup3;"  => "&#179;",
    "&acute;"   => "&#180;",
    "&micro;"   => "&#181;",
    "&para;"  => "&#182;",
    "&middot;"  => "&#183;",
    "&cedil;"   => "&#184;",
    "&sup1;"  => "&#185;",
    "&ordm;"  => "&#186;",
    "&raquo;"   => "&#187;",
    "&rsquo;"  => "&#8217;",
    "&frac14;"  => "&#188;",
    "&frac12;"  => "&#189;",
    "&frac34;"  => "&#190;",
    "&iquest;"  => "&#191;",
    "&Agrave;"  => "&#192;",
    "&Aacute;"  => "&#193;",
    "&Acirc;"   => "&#194;",
    "&Atilde;"  => "&#195;",
    "&Auml;"  => "&#196;",
    "&Aring;"   => "&#197;",
    "&AElig;"   => "&#198;",
    "&Ccedil;"  => "&#199;",
    "&Egrave;"  => "&#200;",
    "&Eacute;"  => "&#201;",
    "&Ecirc;"   => "&#202;",
    "&Euml;"  => "&#203;",
    "&Igrave;"  => "&#204;",
    "&Iacute;"  => "&#205;",
    "&Icirc;"   => "&#206;",
    "&Iuml;"  => "&#207;",
    "&ETH;"   => "&#208;",
    "&Ntilde;"  => "&#209;",
    "&Ograve;"  => "&#210;",
    "&Oacute;"  => "&#211;",
    "&Ocirc;"   => "&#212;",
    "&Otilde;"  => "&#213;",
    "&Ouml;"  => "&#214;",
    "&times;"   => "&#215;",
    "&Oslash;"  => "&#216;",
    "&Ugrave;"  => "&#217;",
    "&Uacute;"  => "&#218;",
    "&Ucirc;"   => "&#219;",
    "&Uuml;"  => "&#220;",
    "&Yacute;"  => "&#221;",
    "&THORN;"   => "&#222;",
    "&szlig;"   => "&#223;",
    "&agrave;"  => "&#224;",
    "&aacute;"  => "&#225;",
    "&acirc;"   => "&#226;",
    "&atilde;"  => "&#227;",
    "&auml;"  => "&#228;",
    "&aring;"   => "&#229;",
    "&aelig;"   => "&#230;",
    "&ccedil;"  => "&#231;",
    "&egrave;"  => "&#232;",
    "&eacute;"  => "&#233;",
    "&ecirc;"   => "&#234;",
    "&euml;"  => "&#235;",
    "&igrave;"  => "&#236;",
    "&iacute;"  => "&#237;",
    "&icirc;"   => "&#238;",
    "&iuml;"  => "&#239;",
    "&eth;"   => "&#240;",
    "&ntilde;"  => "&#241;",
    "&ograve;"  => "&#242;",
    "&oacute;"  => "&#243;",
    "&ocirc;"   => "&#244;",
    "&otilde;"  => "&#245;",
    "&ouml;"  => "&#246;",
    "&divide;"  => "&#247;",
    "&oslash;"  => "&#248;",
    "&ugrave;"  => "&#249;",
    "&uacute;"  => "&#250;",
    "&ucirc;"   => "&#251;",
    "&uuml;"  => "&#252;",
    "&yacute;"  => "&#253;",
    "&thorn;"   => "&#254;",
    "&yuml;"  => "&#255;",
    "&euro;"  => "&#8364;"
  ];
}

function getAltCodes() {
   return ['alt 1' => '☺',    
  'alt 2' => '☻',       
  'alt 3' => '♥',       
  'alt 4' => '♦',       
  'alt 5' => '♣',       
  'alt 6' => '♠',       
  'alt 7' => '•',       
  'alt 8' => '◘',       
  'alt 9' => '○',       
  'alt 10' => '◙',       
  'alt 11' => '♂',       
  'alt 12' => '♀',       
  'alt 13' => '♪',       
  'alt 14' => '♫',       
  'alt 15' => '☼',       
  'alt 16' => '►',       
  'alt 17' => '◄',       
  'alt 18' => '↕',       
  'alt 19' => '‼',       
  'alt 20' => '¶',       
  'alt 21' => '§',       
  'alt 22' => '▬',       
  'alt 23' => '↨',       
  'alt 24' => '↑',       
  'alt 25' => '↓',       
  'alt 26' => '→',       
  'alt 27' => '←',       
  'alt 28' => '∟',       
  'alt 29' => '↔',       
  'alt 30' => '▲',       
  'alt 31' => '▼',       
  'alt 32' => ' ',       
  'alt 33' => '!',       
  'alt 34' => '"',     
  'alt 35' => '#',       
  'alt 36' => '$',       
  'alt 37' => '%',       
  'alt 38' => '&',       
  'alt 39' => '\'',       
  'alt 40' => '(',       
  'alt 41' => ')',       
  'alt 42' => '*',       
  'alt 43' => '+',       
  'alt 44' => ',',       
  'alt 45' => '-',       
  'alt 46' => '.',       
  'alt 47' => '/',       
  'alt 48' => '0',       
  'alt 49' => '1',       
  'alt 50' => '2',       
  'alt 51' => '3',       
  'alt 52' => '4',       
  'alt 53' => '5',       
  'alt 54' => '6',       
  'alt 55' => '7',       
  'alt 56' => '8',       
  'alt 57' => '9',       
  'alt 58' => ':',       
  'alt 59' => ';',       
  'alt 60' => '<',       
  'alt 61' => '=',       
  'alt 62' => '>',      
  'alt 63' => '?',       
  'alt 64' => '@',       
  'alt 65' => 'A',       
  'alt 66' => 'B',       
  'alt 67' => 'C',       
  'alt 68' => 'D',       
  'alt 69' => 'E',       
  'alt 70' => 'F',       
  'alt 71' => 'G',       
  'alt 72' => 'H',       
  'alt 73' => 'I',       
  'alt 74' => 'J',       
  'alt 75' => 'K',       
  'alt 76' => 'L',       
  'alt 77' => 'M',       
  'alt 78' => 'N',       
  'alt 79' => 'O',       
  'alt 80' => 'P',       
  'alt 81' => 'Q',       
  'alt 82' => 'R',       
  'alt 83' => 'S',       
  'alt 84' => 'T',       
  'alt 85' => 'U',       
  'alt 86' => 'V',       
  'alt 87' => 'W',       
  'alt 88' => 'X',       
  'alt 89' => 'Y',       
  'alt 90' => 'Z',       
  'alt 91' => '[',       
  'alt 91' => '[',       
  'alt 92' => '\\',         
  'alt 93' => ']',           
  'alt 94' => '^',       
  'alt 95' => '_',       
  'alt 96' => '`',       
  'alt 97' => 'a',       
  'alt 98' => 'b',       
  'alt 99' => 'c',       
  'alt 100' => 'd',       
  'alt 101' => 'e',       
  'alt 102' => 'f',       
  'alt 103' => 'g',       
  'alt 104' => 'h',       
  'alt 105' => 'i',       
  'alt 106' => 'j',       
  'alt 107' => 'k',       
  'alt 108' => 'l',       
  'alt 109' => 'm',       
  'alt 110' => 'n',       
  'alt 111' => 'o',       
  'alt 112' => 'p',       
  'alt 113' => 'q',       
  'alt 114' => 'r',       
  'alt 115' => 's',       
  'alt 116' => 't',       
  'alt 117' => 'u',       
  'alt 118' => 'v',       
  'alt 119' => 'w',       
  'alt 120' => 'x',       
  'alt 121' => 'y',       
  'alt 122' => 'z',       
  'alt 123' => '{',       
  'alt 124' => '|',       
  'alt 125' => '}',       
  'alt 126' => '~',       
  'alt 127' => '⌂',       
  'alt 155' => '¢',       
  'alt 156' => '£',       
  'alt 157' => '¥',       
  'alt 158' => '₧',       
  'alt 159' => 'ƒ',       
  'alt 164' => 'ñ',       
  'alt 165' => 'Ñ',       
  'alt 166' => 'ª',       
  'alt 167' => 'º',       
  'alt 168' => '¿',       
  'alt 169' => '®',       
  'alt 170' => '¬',       
  'alt 171' => '½',       
  'alt 172' => '¼',       
  'alt 173' => '¡',       
  'alt 174' => '«',       
  'alt 175' => '»',       
  'alt 176' => '░',       
  'alt 177' => '▒',       
  'alt 178' => '▓',       
  'alt 179' => '│',       
  'alt 180' => '┤',       
  'alt 181' => '╡',       
  'alt 182' => '╢',       
  'alt 183' => '╖',       
  'alt 184' => '╕',       
  'alt 185' => '╣',       
  'alt 186' => '║',       
  'alt 187' => '╗',       
  'alt 188' => '╝',       
  'alt 189' => '╜',       
  'alt 190' => '╛',       
  'alt 191' => '┐',       
  'alt 192' => '└',       
  'alt 193' => '┴',       
  'alt 194' => '┬',       
  'alt 195' => '├',       
  'alt 196' => '─',       
  'alt 197' => '┼',       
  'alt 198' => '╞',       
  'alt 199' => '╟',       
  'alt 200' => '╚',       
  'alt 201' => '╔',       
  'alt 202' => '╩',       
  'alt 203' => '╦',       
  'alt 204' => '╠',       
  'alt 205' => '═',       
  'alt 206' => '╬',       
  'alt 207' => '╧',       
  'alt 208' => '╨',       
  'alt 209' => '╤',       
  'alt 210' => '╥',       
  'alt 211' => '╙',       
  'alt 212' => '╘',       
  'alt 213' => '╒',       
  'alt 214' => '╓',       
  'alt 215' => '╫',       
  'alt 216' => '╪',       
  'alt 217' => '┘',       
  'alt 218' => '┌',       
  'alt 219' => '█',       
  'alt 220' => '▄',       
  'alt 221' => '▌',       
  'alt 222' => '▐',       
  'alt 223' => '▀',       
  'alt 224' => 'α',       
  'alt 225' => 'ß',       
  'alt 226' => 'Γ',       
  'alt 227' => 'π',       
  'alt 228' => 'Σ',       
  'alt 229' => 'σ',       
  'alt 230' => 'µ',       
  'alt 231' => 'τ',       
  'alt 232' => 'Φ',       
  'alt 233' => 'Θ',       
  'alt 234' => 'Ω',       
  'alt 235' => 'δ',       
  'alt 236' => '∞',       
  'alt 237' => 'φ',       
  'alt 238' => 'ε',       
  'alt 239' => '∩',       
  'alt 240' => '≡',       
  'alt 241' => '±',       
  'alt 242' => '≥',       
  'alt 243' => '≤',       
  'alt 244' => '⌠',       
  'alt 245' => '⌡',       
  'alt 247' => '≈',       
  'alt 248' => '°',       
  'alt 249' => '·',       
  'alt 250' => '·',       
  'alt 251' => '√',       
  'alt 252' => 'ⁿ',       
  'alt 254' => '■',       
  'alt 255' => ' ',       
  'alt 0128' => '€',       
  'alt 0130' => '‘',       
  'alt 0132' => '„',       
  'alt 0133' => '…',       
  'alt 0134' => '†',       
  'alt 0135' => '‡',       
  'alt 0137' => '‰',       
  'alt 0138' => 'Š',       
  'alt 0139' => '‹',       
  'alt 0140' => 'Œ',       
  'alt 0142' => 'Ž',       
  'alt 0145' => '‘',       
  'alt 0146' => '’',       
  'alt 0147' => '“',       
  'alt 0148' => '”',       
  'alt 0151' => '—',       
  'alt 0153' => '™',       
  'alt 0154' => 'š',       
  'alt 0155' => '›',       
  'alt 0156' => 'œ',       
  'alt 0158' => 'ž',       
  'alt 0159' => 'Ÿ',       
  'alt 0164' => '¤',       
  'alt 0166' => '¦',       
  'alt 0168' => '¨',       
  'alt 0169' => '©',       
  'alt 0175' => '¯',       
  'alt 0178' => '²',       
  'alt 0179' => '³',       
  'alt 0180' => '´',       
  'alt 0183' => '·',       
  'alt 0184' => '¸',       
  'alt 0185' => '¹',       
  'alt 0188' => '¼',       
  'alt 0189' => '½',       
  'alt 0190' => '¾',       
  'alt 0192' => 'À',       
  'alt 0193' => 'Á',       
  'alt 0194' => 'Â',       
  'alt 0195' => 'Ã',       
  'alt 0196' => 'Ä',       
  'alt 0197' => 'Å',       
  'alt 0198' => 'Æ',       
  'alt 0199' => 'Ç',       
  'alt 0200' => 'È',       
  'alt 0201' => 'É',       
  'alt 0202' => 'Ê',       
  'alt 0203' => 'Ë',       
  'alt 0204' => 'Ì',       
  'alt 0205' => 'Í',       
  'alt 0206' => 'Ï',       
  'alt 0207' => 'Ï',       
  'alt 0208' => 'Ð',       
  'alt 0210' => 'Ò',       
  'alt 0211' => 'Ó',       
  'alt 0212' => 'Ô',       
  'alt 0213' => 'Õ',       
  'alt 0214' => 'Ö',       
  'alt 0215' => '×',       
  'alt 0216' => 'Ø',       
  'alt 0217' => 'Ù',       
  'alt 0218' => 'Ú',       
  'alt 0219' => 'Û',       
  'alt 0220' => 'Ü',       
  'alt 0221' => 'Ý',       
  'alt 0222' => 'Þ',       
  'alt 0223' => 'ß',       
  'alt 0224' => 'à',       
  'alt 0225' => 'á',       
  'alt 0226' => 'â',       
  'alt 0227' => 'ã',       
  'alt 0228' => 'ä',       
  'alt 0229' => 'å',       
  'alt 0230' => 'æ',       
  'alt 0231' => 'ç',       
  'alt 0232' => 'è',       
  'alt 0233' => 'é',       
  'alt 0234' => 'ê',       
  'alt 0235' => 'ë',       
  'alt 0236' => 'ì',       
  'alt 0237' => 'í',       
  'alt 0238' => 'î',       
  'alt 0239' => 'ï',       
  'alt 0240' => 'ð',       
  'alt 0242' => 'ò',       
  'alt 0243' => 'ó',       
  'alt 0244' => 'ô',       
  'alt 0245' => 'õ',       
  'alt 0246' => 'ö',       
  'alt 0247' => '÷',       
  'alt 0248' => 'ø',       
  'alt 0249' => 'ú',       
  'alt 0250' => 'û',       
  'alt 0251' => 'ü',       
  'alt 0252' => 'ù',       
  'alt 0253' => 'ý',       
  'alt 0254' => 'þ',       
  'alt 0255' => 'ÿ'];

}