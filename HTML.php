<?php 

namespace lray138\GAS\HTML;

use lray138\GAS\Arr;
use lray138\GAS\Str;
use lray138\GAS\Functional as FP;
use lray138\GAS\Monads\Maybe;
use lray138\GAS\IO;

use function lray138\GAS\IO\dump;

function isVoidElement($node_name) {
  return Arr\in($node_name)(getVoidElements());
}

function element($type, $content = "", $attributes = null) {
  $out = '<' . $type;

  // for cases where flipped currying is involved
  // and you need to add extra attributes
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

  if(is_array($content)) {
    $content = Arr\join("", $content);
  }
  $out .= '>' . $content . '</' . $type . '>';
  
  return $out;
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
    "wbr"
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

    // return FP\compose(
    //           function($x) {
    //             if(strlen($x) > 0 && substr($x, 0, 1) !== " ") {
    //               return " " . $x;
    //             }
    //             return $x;
    //           },
    //           Arr\join(" "), 
    //           Arr\map(function($value, $key) {
    //             return "$key='$value'";
    //           }))($attributes);
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

function a($content, $attributes = []) {
  return element("a", $content, $attributes);
}

const a = __NAMESPACE__ . '\a';

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

/* everything below can be auto generated */

function abbr($content, $attributes = []) {
  return element("abbr", $content, $attributes);
}

const abbr = __NAMESPACE__ . '\abbr';

function acronym($content, $attributes = []) {
  return element("acronym", $content, $attributes);
}

const acronym = __NAMESPACE__ . '\acronym';

function address($content, $attributes = []) {
  return element("address", $content, $attributes);
}

const address = __NAMESPACE__ . '\address';

function applet($content, $attributes = []) {
  return element("applet", $content, $attributes);
}

const applet = __NAMESPACE__ . '\applet';

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

function basefont($content, $attributes = []) {
  return element("basefont", $content, $attributes);
}

const basefont = __NAMESPACE__ . '\basefont';

function bdi($content, $attributes = []) {
  return element("bdi", $content, $attributes);
}

const bdi = __NAMESPACE__ . '\bdi';

function bdo($content, $attributes = []) {
  return element("bdo", $content, $attributes);
}

const bdo = __NAMESPACE__ . '\bdo';

function big($content, $attributes = []) {
  return element("big", $content, $attributes);
}

const big = __NAMESPACE__ . '\big';

function blockquote($content, $attributes = []) {
  return element("blockquote", $content, $attributes);
}

const blockquote = __NAMESPACE__ . '\blockquote';

function body($content, $attributes = []) {
  return element("body", $content, $attributes);
}

const body = __NAMESPACE__ . '\body';

// function br($attributes = []) {
//   return element("br", "", $attributes);
// }

// const br = __NAMESPACE__ . '\br';

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

function center($content, $attributes = []) {
  return element("center", $content, $attributes);
}

const center = __NAMESPACE__ . '\center';

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

function dir($content, $attributes = []) {
  return element("dir", $content, $attributes);
}

const dir = __NAMESPACE__ . '\dir';

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

function font($content, $attributes = []) {
  return element("font", $content, $attributes);
}

const font = __NAMESPACE__ . '\font';

function footer($content, $attributes = []) {
  return element("footer", $content, $attributes);
}

const footer = __NAMESPACE__ . '\footer';

function form($content, $attributes = []) {
  return element("form", $content, $attributes);
}

const form = __NAMESPACE__ . '\form';

function frame($content, $attributes = []) {
  return element("frame", $content, $attributes);
}

const frame = __NAMESPACE__ . '\frame';

function frameset($content, $attributes = []) {
  return element("frameset", $content, $attributes);
}

const frameset = __NAMESPACE__ . '\frameset';

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

function noframes($content, $attributes = []) {
  return element("noframes", $content, $attributes);
}

const noframes = __NAMESPACE__ . '\noframes';

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

function strike($content, $attributes = []) {
  return element("strike", $content, $attributes);
}

const strike = __NAMESPACE__ . '\strike';

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

function tt($content, $attributes = []) {
  return element("tt", $content, $attributes);
}

const tt = __NAMESPACE__ . '\tt';

function u($content, $attributes = []) {
  return element("u", $content, $attributes);
}

const u = __NAMESPACE__ . '\u';

function ul($content, $attributes = []) {
  return element("ul", $content, $attributes);
}

const ul = __NAMESPACE__ . '\ul';

// function var($content, $attributes = []) {
//   return element("var", $content, $attributes);
// }

// const var = __NAMESPACE__ . '\var';

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

function indent($html) {
  return (new \Gajus\Dindent\Indenter())->indent($html);
}