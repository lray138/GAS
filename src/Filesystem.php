<?php
declare(strict_types=1);

// https://www.php.net/manual/en/ref.filesystem.php

namespace lray138\GAS\Filesystem;

use lray138\GAS\{
	Functional as FP, 
	Arr,
	Str
};

use lray138\GAS\Types\Either;
use function lray138\GAS\IO\dump;
use function lray138\GAS\Functional\curryN;

const sortBySize = __NAMESPACE__ . '\sortBySize';

function sortBySize($x, $y) {
	return filesize($x) > filesize($y) ? -1 : 1;
}

function getContents($filename) {
	return file_get_contents($filename);
}

// this shows we were kind of on the way... Jan 14 2024 - 11:22
function getContents_($filename) {
	return Str\of(file_get_contents($filename));
}

const getContentsEither = __NAMESPACE__ . '\getContentsEither';

function getContentsEither($pathname) {
		return file_exists($pathname) 
			? Either::right(file_get_contents($pathname))
			: Either::left("File not found: $pathname");
}

const read = __NAMESPACE__ . '\read';

function read($filename) {
	return file_get_contents(FP\extract($filename));
}

function readFile($filename) {
	return file_get_contents($filename);
}

// function copy(string $to, string $from = null, $context = null) {
// 	 $f = function(string $to, string $from, $context = null) {
// 	  	copy($from, $to, $resource);
// 	 };

// 	 curryN(2, $f)(...func_get_args());
// }

function write($pathname, $contents = "", $create_dir_if_not_exists = false) {
	$f = function($pathname, $contents, $create_dir_if_not_exists = false) {
		if($create_dir_if_not_exists) {
			$dir = Str\beforeLast("/", $pathname);
			if(!dirExists($dir)) {
				createDir($dir);
			}
		}
	
		file_put_contents($pathname, $contents);
	};

	return FP\curry2($f)(...func_get_args());
}


function createFile($pathname) {
	file_put_contents($pathname, "");
}

const createFile = __NAMESPACE__ . '\createFile';

// here is an example not not necessarilly getting much milage out of
// default currying and if currying is needed then do it inline

// well... Nov 23 @ 13:12 -- found a case ;)
function putContents($filename, $contents = null) {
	$f = function($filename, $contents) {
		return file_put_contents($filename, $contents);
	};

	return curryN(2, $f)(...func_get_args());
}

function getChangedTimestamp($filename) {
	return filectime($filename);
}

const getChangedTimestamp = __NAMESPACE__ . '\getChangedTimestamp';

function getModifiedTimestamp($filename) {
	return filemtime($filename);
}

// I tried to call this when it was "timestamp"
function getModifiedTime($filename) {
	return filemtime($filename);
}

const getModifiedTimestamp = __NAMESPACE__ . '\getModifiedTimestamp';

function getFiles($directory) {
	return getFilesInDir($directory);
}

const getFiles = __NAMESPACE__ . '\getFiles';

// mode not implemented but would be the difference between
// file object and a the full path that this currently provides.
function getFilesInDir($directory, $options = []): array {

	if(is_object($directory) && method_exists($directory, "extract")) {
		$directory = $directory->extract();
	}

	if(isset($options["mode"]) 
		&& in_array(strtolower($options["mode"]), ["object", "obj", "splfile"])) {
		$files = [];
		foreach (new \DirectoryIterator($directory) as $fileInfo) {
			if($fileInfo->isDot() || $fileInfo->isDir()) continue;
			$files[] = [
				"path" => $fileInfo->getPath() 
				, "pathname" => $fileInfo->getPathname()
				, "filename" => $fileInfo->getFilename()
				, "extension" => $fileInfo->getExtension()
			];
		}
		return $files;
	}

	$prependDirectoryToFile = Arr\map(
		function($x) use ($directory) {
			if(!Str\lastCharIs("/", $directory)) {
				return Str\prepend(Str\append("/", $directory), $x);
			} 
			return Str\prepend($directory, $x);
		});

	// leave a comment, like and subscribe
	// Oct 9, 2024 - 18:37 . not sure what changed but I have to add flip to 
	$process = FP\pipe(
		Arr\filter(FP\flip(Arr\notIn)([".", "..", ".DS_Store"])),
		(isset($options["filter"]) ? Arr\filter($options["filter"]) : fn($x) => $x),
		$prependDirectoryToFile);


	// carbon relies on zero indexing somewhere and 
	// was tripping up because of this that 2025-01-16 12:27
	return array_values(Arr\filter(
		"is_file",
		$process(scandir($directory))));
}

function getFilesInDir_($directory, $options = []) {
		return Arr\of(getFilesInDir($directory, $options));
}

const getFilesInDir = __NAMESPACE__ . '\getFilesInDir';

function getDirsInFolder($directory, $filter = null) {
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

	$filter = !is_null($filter) 
		? FP\compose($filter, "is_dir")
		: "is_dir";

	return Arr\filter(
				"is_dir", 
		 		$process(scandir($directory)));

}


// ////////////////////////////////////////////////////////													//

const getPathinfo = __NAMESPACE__ . '\getPathinfo';

function getPathinfo($pathname) {
	return json_decode(json_encode(pathinfo($pathname)));
}

// https://stackoverflow.com/questions/24783862/list-all-the-files-and-folders-in-a-directory-with-php-recursive-function
// and
// https://stackoverflow.com/questions/19724579/php-recursivedirectoryiterator-how-to-exclude-directory-paths-with-a-dot-and-do
function getFilesInDirRecursive($dir, $options = []) {

	if(!is_dir($dir)) {
		return Either::left("dir '$dir' not found");
	}

	$it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
	
	return isset($options["return_type"]) && strtolower($options["return_type"]) === "fileinfo"
		? iterator_to_array(new \RecursiveIteratorIterator($it))
		: array_keys(iterator_to_array(new \RecursiveIteratorIterator($it)));
}

function scan($directory) {
	$prepend = !Str\lastCharIs("/", $directory) 
					? Str\prepend(Str\concat($directory, "/"))
					: Str\prepend($directory);
	
	return FP\compose(
		Arr\map($prepend),
		Arr\filter(Arr\notIn([".", ".."]))
	)(\scandir($directory));
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

const dirExists = __NAMESPACE__ . '\dirExists';

function isDir($filename) {
	return is_dir($filename);
}

const isDir = __NAMESPACE__ . '\isDir';

// function runCallback($callable, $args) {
// 	$args = Arr\map(FP\extract)($args);

// 	return $callable(...$args);
// }

function fileExists($filename) {
		//return runCallback("file_exists", func_get_args());
		return file_exists(FP\extract($filename));
}

const fileExists = __NAMESPACE__ . '\fileExists';

function isFile($filename) {
	return file_exists($filename);
}

// 
function createDir($filename) {
	if(!is_dir($filename)) {
		return mkdir($filename);
	}
}

function createDirRecursive($dir, int $permissions = 0777) {
	if(!is_dir($dir)) {
		return mkdir($dir, $permissions, true);
	}
}

function makeDir($filename) {
	return createDir($filename);
}

function move($from, $to) {
	// // move by renaming
	return rename($from, $to);
}

function rename() {
		$f = function($from, $to) {
			return \rename($from, $to);
		};

		return FP\curry2($f)(...func_get_args());
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
function getUrlContent($url, $cookies_file = null) {
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

function getSize($pathname) {
	return filesize($pathname);
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

const getCreatedTime = __NAMESPACE__ . '\getCreatedTime';

function getCreatedTime($pathname) {
	return filectime($pathname);
}


const getCreatedDateTime = __NAMESPACE__ . '\getCreatedDateTime';

function getCreatedDateTime($pathname) {
	return (new \DateTime())->setTimestamp(getCreatedTime($pathname));
}

const getModifiedTime = __NAMESPACE__ . '\getModifiedTime';

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

/**
 * Reads a file line by line, applies a callback to each line, and writes the result to a new file.
 *
 * @param string $inputFilePath Path to the input file.
 * @param string $outputFilePath Path to the output file.
 * @param callable $callback A function to apply to each line, which can modify the line.
 */
function mapLinesAndWrite() {
	$f = function(callable $callback, $inputFilePath, $outputFilePath = null) {

		if(!is_file($inputFilePath)) {
				die($inputFilePath . " is not file");
		}

		if(is_null($outputFilePath)) {
			$outputFilePath = $inputFilePath;
		}


	    // Open the input file for reading
	    $inputFile = fopen($inputFilePath, 'r');

	    if ($inputFile) {
	        $updatedLines = [];

	        // Read each line, apply the callback, and store the result in an array
	        while (($line = fgets($inputFile)) !== false) {
	            // Apply the callback function to potentially modify the line
	            $updatedLines[] = $callback($line);
	        }

	        // Close the input file after reading all lines
	        fclose($inputFile);

	        // Open the output file for writing and write all lines at once
	        file_put_contents($outputFilePath, implode('', $updatedLines));
	    } else {
	        echo "Error: Unable to open the input file.";
	    }
	};

	return curryN(2, $f)(...func_get_args());
}


// OK so I had started this.... Jan 14 - 9:56 PM
function getExtension($pathname) {
	return pathinfo($pathname, PATHINFO_EXTENSION);
}

function getBasename($pathname) {
	return pathinfo($pathname, PATHINFO_BASENAME);
}

function getFilename($pathname) {
	return pathinfo($pathname, PATHINFO_FILENAME);
}

function getDirname($pathname) {
	return pathinfo($pathname, PATHINFO_DIRNAME);
}