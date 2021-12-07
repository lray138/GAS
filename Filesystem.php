<?php
declare(strict_types=1);

namespace lray138\GAS\Filesystem;

use lray138\GAS\Functional as FP;
use lray138\GAS\Arr;
use lray138\GAS\Str;

function getContents($filename) {
	return file_get_contents($filename);
}

function read($filename) {
	return file_get_contents($filename);
}

const read = __NAMESPACE__ . '\read';

function readFile($filename) {
	return file_get_contents($filename);
}

function write() {
	return call_user_func_array(putContents(), func_get_args());
}

function putContents() {
	$putContents = function($filename, $contents) {
		return file_put_contents($filename, $contents);
	};

	return call_user_func_array(FP\curry2($putContents), func_get_args());
}

function getChangedTimestamp($filename) {
	return filectime($filename);
}

const getChangedTimestamp = __NAMESPACE__ . '\getChangedTimestamp';

function getModifiedTimestamp($filename) {
	return filemtime($filename);
}

const getModifiedTimestamp = __NAMESPACE__ . '\getModifiedTimestamp';

function getFiles($directory) {
	return getFilesInDir($directory);
}

const getFiles = __NAMESPACE__ . '\getFiles';


function getFilesInDir($directory) {
	$prependDirectoryToFile = Arr\map(
					function($x) use ($directory) {
						if(!Str\lastCharIs("/", $directory)) {
							return Str\prepend(Str\append("/", $directory), $x);
						} 
						return Str\prepend($directory, $x);
					});

	$process = FP\pipe(
					Arr\filter(Arr\notIn([".", "..", ".DS_Store"])),
		 			$prependDirectoryToFile);

	return Arr\filter(
				"is_file", 
		 		$process(scandir($directory)));
}

function scan($directory) {
	$prepend = !Str\lastCharIs("/", $directory) 
					? Str\prepend(Str\concat($directory, "/"))
					: Str\prepend($directory);
	
	return FP\compose(
		Arr\map($prepend),
		Arr\filter(Arr\notIn([".", "..", ".DS_Store"]))
	)(scandir($directory));
}


function getDirs($directory) {
	return Arr\filter(function($filename) {
		return isDir($filename);
	})(scan($directory));
}


function includeFileReturnObject(string $filename, string $class_name, array $args = []) {
	if(file_exists($filename)) {
		include $filename;
		return new $class_name(...$args);
	}
}

function jsonDecodeAssoc($json) {
	return json_decode($json, true);
}

const jsonDecodeAssoc = __NAMESPACE__ . '\jsonDecodeAssoc';

function jsonDecodeArray($json) {
	return json_decode($json, true);
}

const jsonDecodeArray = __NAMESPACE__ . '\jsonDecodeArray';

function jsonToArray($json) {
	return json_decode($json, true);
}

const jsonToArray = __NAMESPACE__ . '\jsonToArray';

function jsonDecode($json) {
	return json_decode($json);
}

const jsonDecode = __NAMESPACE__ . '\jsonDecode';

function dirExists($filename) {
	return is_dir($filename);
}

function isDir($filename) {
	return is_dir($filename);
}

function fileExists($filename) {
	return file_exists($filename);
}

function isFile($filename) {
	return file_exists($filename);
}

// 
function createDir($filename) {
	if(!is_dir($filename)) {
		return mkdir($filename);
	}
}

function makeDir($filename) {
	return createDir($filename);
}

function move($from, $to) {
	// // move by renaming
	return rename($from, $to);
}

// came from PHP 
function csvToAssoc($file) {
	$array = array_map('str_getcsv', file($file));

	$header = array_shift($array);

	$combineArray = function(&$row, $key, $header) {
  		$row = array_combine($header, $row);
	};

	array_walk($array, $combineArray, $header);
	return $array;
}

function getCsvColumns($file) {
	
}

function includeFileFromDir() {
	$includeFileFromDir = function($dir, $file) {
		if(!Str\endsWith("/", $dir)) {
			$dir = $dir . "/";
		}
		return (include $dir . $file);
	};

	return call_user_func_array(FP\curry2($includeFileFromDir), func_get_args());
}

// via https://stackoverflow.com/questions/17363545/file-get-contents-is-not-working-for-some-url
function getUrlContent($url, $cookies_file) {
		//$cookies_file = dirname(dirname(__DIR__)) . "/output/cookies.txt";
    
    fopen($cookies_file, "w");
    $parts = parse_url($url);
    $host = $parts['host'];
    $ch = curl_init();
    $header = array('GET /1575051 HTTP/1.1',
        "Host: {$host}",
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language:en-US,en;q=0.8',
        'Cache-Control:max-age=0',
        'Connection:keep-alive',
        'Host:adfoc.us',
        'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
    );

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);

    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies_file);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies_file);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// for file comparison (one at the bottom is what I'm using even though that wasn't the issuee)
// https://stackoverflow.com/questions/18849927/verifying-that-two-files-are-identical-using-pure-php
function filesAreEqual($a, $b) {
  // Check if filesize is different
  if(filesize($a) !== filesize($b))
      return false;

  // Check if content is different
  $ah = fopen($a, 'rb');
  $bh = fopen($b, 'rb');

  $result = true;
  while(!feof($ah))
  {
    if(fread($ah, 8192) != fread($bh, 8192))
    {
      $result = false;
      break;
    }
  }

  fclose($ah);
  fclose($bh);

  return $result;
}

// called via shell
function setModifiedTime($shelltime, $filename) {
	$exec = "touch -mt $shelltime $filename";
	$exec = escapeshellcmd($exec);
	shell_exec($exec);
}

// this will change modified and created
// generally this is what I want, or probably always
// called via shell
function setCreatedTime($shelltime, $filename) {
	$exec = "SetFile -d $shelltime $filename";
	$exec = escapeshellcmd($exec);
	shell_exec($exec);
}