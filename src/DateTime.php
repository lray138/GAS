<?php 

namespace lray138\GAS\DateTime;

use lray138\GAS\Functional as FP;
use function lray138\GAS\dump;

function fromTimestamp($timestamp) {
	if(empty($timestamp)) {
		return null;
	}
	// noticed some old code where you could also do
	// (new DateTime("@" . $timestamp))
	return (new \DateTime())->setTimestamp($timestamp);
}

const fromTimestamp = __NAMESPACE__ . '\fromTimestamp';

function fromYearMonth() {
	$fromYearMonth = function($year, $month) {
		return new \DateTime("$year-$month-01");
	};

	return call_user_func_array(FP\curry2($fromYearMonth), func_get_args());
}

// must have been from something else.
function tomorrow() {
	return now()->modify('+1 day');
}

function prevWeekday(\DateTime $date) {
	return $date->modify('-1 weekday');
}

const prevWeekday = __NAMESPACE__ . '\prevWeekday';

const fromYearMonth = __NAMESPACE__ . '\fromYearMonth';

function fromString($string) {
	// need a check for timestamp vs.
	// ....
	return is_null($string) ? NULL : new \DateTime($string);
}

const fromString = __NAMESPACE__ . '\fromString';

// a little expirimental with currying
// the idea is you could build up the function 
// so the last day is all that is needed at that point.
function fromYearMonthDay() {
	$fromYearMonthDay = function($year, $month, $day) {
		return new \DateTime("$year-$month-$day");
	};
	return call_user_func_array(FP\curry3($fromYearMonthDay), func_get_args());
}

const fromYearMonthDay = __NAMESPACE__ . '\fromYearMonthDay';

function fromYMD() {
	return call_user_func_array(fromYearMonthDay, func_get_args());
}

function create($val = null) {
	return (new \DateTime($val));
}

const create = __NAMESPACE__ . '\create';

function current() {
	return new \DateTime();
}

const current = __NAMESPACE__ . '\current';

function now() {
	return new \DateTime();
}

const now = __NAMESPACE__ . '\now';


function format() {
	$format = function($format, \DateTime $dt) {
		return $dt->format($format);
	};

	return call_user_func_array(FP\curry2($format), func_get_args());
}

const format = __NAMESPACE__ . '\format';

function formatShell(\DateTime $dt) {
	return format("YmdHi", $dt);
}

const formatShell = __NAMESPACE__ . '\formatShell';

function formatMySQL(\DateTime $dt) {
	return format("Y-m-d H:i:s", $dt);
}

const formatMySQL = __NAMESPACE__ . '\formatMySQL';

function getYear(\DateTime $dt) {
	return format("Y", $dt);
}

function getDay(\DateTime $dt) {
	return format("d", $dt);
}

function getDayNumber(\DateTime $dt) {
	return format("d", $dt);
}

function getDayNoLeadingZero(\DateTime $dt) {
	return format("j", $dt);
}

function getDayNumberShort(\DateTime $dt) {
	return getDayNoLeadingZero($dt);
}

function getDayOfWeekNumber(\DateTime $dt) {
	return $dt->format("w");
}

const getDayNumberShort = __NAMESPACE__ . '\getDayNumberShort';

function getDayName(\DateTime $dt) {
	return format("l", $dt);
}

function getDayNameShort(\DateTime $dt) {
	return format("D", $dt);
}

function getMonthNoLeadingZero(\DateTime $dt) {
	return format("n", $dt);
}

function getMonth(\DateTime $dt) {
	return format("m", $dt);
}

function getMonthNameShort(\DateTime $dt) {
	return format("M", $dt);
}

function getMonthName(\DateTime $dt) {
	return format("F", $dt);
}

function getMonthNumberShort(\DateTime $dt) {
	return getMonthNoLeadingZero($dt);
}

function getSeconds(\DateTime $dt) {
	return format("s", $dt);
}

function getMinutes(\DateTime $dt) {
	return format("i", $dt);
}

function getFormatsObj(\DateTime $dt) {
	$out = new \StdClass;
	$out->day = $dt->format("d");
	$out->year = $dt->format("Y");
	$out->month = $dt->format("m");
	$out->string = $dt->format("M d, Y");
	$out->shell = $dt->format("YmdHi");
	$out->mysql = $dt->format("Y-m-d H:i:s");
	$out->timestamp = $dt->getTimestamp();
	return $out;
}

const getFormatObj = __NAMESPACE__ . '\getFormatsObj';




// function getMonthName($number) {
// 	$index = (int) $number;
// 	return getMonthNames()[$index-1];
// }

/**
 * Round minutes to the nearest interval of a DateTime object.
 * 
 * @param \DateTime $dateTime
 * @param int $minuteInterval
 * @return \DateTime
 */
// https://ourcodeworld.com/articles/read/756/how-to-round-up-down-to-nearest-10-or-5-minutes-of-datetime-in-php
function roundToNearestMinuteInterval() {
	$round = function($minuteInterval, \DateTime $dateTime) {
		return $dateTime->setTime($dateTime->format('H')
								, round(($dateTime->format("i") + ($dateTime->format("s") / 60)) / $minuteInterval) * $minuteInterval
								, 0);
	};

	return call_user_func_array(FP\curry2($round), func_get_args());
}

/**
 * Round up minutes to the nearest upper interval of a DateTime object.
 * 
 * @param \DateTime $dateTime
 * @param int $minuteInterval
 * @return \DateTime
 */
function roundUpToMinuteInterval(\DateTime $dateTime, $minuteInterval = 10) {
    return $dateTime->setTime(
        $dateTime->format('H'),
        ceil($dateTime->format('i') / $minuteInterval) * $minuteInterval,
        0
    );
}

/**
 * Round down minutes to the nearest lower interval of a DateTime object.
 * 
 * @param \DateTime $dateTime
 * @param int $minuteInterval
 * @return \DateTime
 */
function roundDownToMinuteInterval(\DateTime $dateTime, $minuteInterval = 10)
{
    return $dateTime->setTime(
        $dateTime->format('H'),
        floor($dateTime->format('i') / $minuteInterval) * $minuteInterval,
        0
    );
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDifference(\DateTime $date_1, \DateTime $date_2 , $differenceFormat = '%i' )
{   
    $interval = date_diff($date_1, $date_2);
 
    if(!$interval) {
    	return "false";
    } 

    return $interval->format($differenceFormat);
}

function diff(\DateTime $a, \DateTime $b, $differenceFormat = '%i') {
	return dateDifference($a, $b, $differenceFormat);
}

function toDateTime($var) {
	if($var instanceof \DateTime) return $var;
	// assume timestamp
	if(is_int($var)) return (new \DateTime())->setTimestamp($var);
}

function niceDiffFormat($a, $b, $options = []) {
	$a = toDateTime($a);
	$b = toDateTime($b);

	$delimeter = isset($options["delimeter"]) ? $options["delimeter"] : " ";

	if(is_null($a) || is_null($b)) {
		return "Problem with provided dates";
	}

	$interval = date_diff($a, $b);
 
    if(!$interval) {
    	return "false";
    }

    $map = [
    	"y" => "years"
    	, "m" => "months"
    	, "d" => "days"
    	, "h" => "hours"
    	, "i" => "minutes"
    	, "s" => "seconds"
    ];

    $filtered = array_reduce(array_keys($map), function($carry, $x) use ($delimeter, $map, $interval) {
    	$formatted = $interval->format("%" . $x);
    	// we know it's a string so "=="
    	if($formatted == 0) return $carry;

    	$field = $formatted < 2
    		? substr($map[$x], 0, strlen($map[$x])-1)
    		: $map[$x];

    	$carry[] = $formatted . " " . $field;
    	return $carry;
    }, []);

    return implode($delimeter, $filtered);

    // $out = [];
    // array_walk(array_keys($map), function($x) use ($interval, &$out) {
    // 	$format = $interval->format("%" . $x);
    // 	if($format != 0) {
    // 		$out[$x] = $format;
    // 	}
    // });

    // $out2 = [];
    // array_walk($out, function($x, $y) use (&$out2, $map) {
    // 	$field = $x < 2
    // 		? substr($map[$y], 0, strlen($map[$y])-1)
    // 		: $map[$y];
    	
    // 	$out2[] = $x . " " . $field;
    // });

    // return implode($delimeter, $out2);
}

function hoursToMinutes($hour) {
	return $hour * 60;
}

function minutesToHours($mins) {
	$hours = floor($mins/60);
	$remainder = $mins%60;
	return "$hours hours and $remainder mins";
}

// for now assumes action is not longer than a day...
// hmm... also have https://stackoverflow.com/questions/365191/how-to-get-time-difference-in-minutes-in-php
// as option
function minutesBetween($date_1, $date_2) {
	$bits = explode("-", dateDifference($date_1, $date_2, "%h-%i"));
	$bits[0] = hoursToMinutes($bits[0]);
	return array_sum($bits);
}


/**
* calculate number of days in a particular month
*
* @author              The-Di-Lab <thedilab@gmail.com>
* @param               number
* @param               number
* @return              number
*/
function daysInMonth(){	
	$daysInMonth = function($year, $month) {
		return date('t',strtotime($year.'-'.$month.'-01'));
	};

	return call_user_func_array(FP\curry2($daysInMonth), func_get_args());
}

// from calendar php
function weeksInMonth(){					
	$weeksInMonth = function($year, $month) {
		// find number of weeks in this month
		$daysInMonths = daysInMonth($year, $month);
	
		$numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
		$monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
		$monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
		$monthEndingDay==7?$monthEndingDay=0:'';
		$monthStartDay==7?$monthStartDay=0:'';
	
		if($monthEndingDay < $monthStartDay){
			$numOfweeks++;
		}
		return $numOfweeks;
	};

	return call_user_func_array(FP\curry2($weeksInMonth), func_get_args());
}

function firstDayOfWeek() {
	$firstDayOfTheWeek = function($year, $month) {
		return date('N', strtotime($year . '-' . $month . '-01'));
	};

	return call_user_func_array(FP\curry2($firstDayOfTheWeek), func_get_args());
}

function niceTime($taskTotal) {
	$out = "";
	if($taskTotal >= 60) {
		$hours = floor($taskTotal/60);
		$out .= $hours ." hour";
		if($hours > 1) { $out .= "s";}
	
		$mins = ($taskTotal-(60*$hours));
		if($mins > 0) {
			if($hours > 0) {
				$out .= " and ";
			}
			$out .= $mins ." mins";
		}
	} else {
		$out .= $taskTotal . " mins";
	}
	return $out;
}

function formatMySQLDate(\DateTime $dt) {
	return $dt->format("Y-m-d");
}

function getDayNumber2(DateTime $dt) {
	//date('w'); // day of week
	//date('l'); // dayname
	return $dt->format("w");
}

/*
function getDurationMins(\DateTime $start, \DateTime $end) {
	return round(abs($start->getTimestamp() - $end->getTimestamp()) / 3600,2);
}
*/

function getDurationMins(\DateTime $start, \DateTime $end) {
	$since = $start->diff($end);
	$minutes = $since->days * 24 * 60;
	$minutes += $since->h * 60;
	$minutes += $since->i;
	$minutes += $since->s/60;
	return $minutes;
}

function getDurationString($start, $end) {
	$since = $start->diff($end);
	
	$out = [];

	if($since->h > 0) {
		$out[] = $since->h . " hour";
	}

	if($since->i > 0) {
		$out[] = $since->i . " min";
	}

	if($since->s > 0) {
		$out[] = $since->s . " sec";
	}
	
	return implode(", ", $out);
}