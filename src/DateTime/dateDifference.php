<?php namespace lray138\GAS\DateTime;

const dateDifference = __NAMESPACE__ . '\dateDifference';

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
// I can see now I had %i because I would have been more concerened with minutes
function dateDifference(\DateTime $date_1, \DateTime $date_2 , $differenceFormat = '%i' )
{   
    $interval = date_diff($date_1, $date_2);
 
    if(!$interval) {
        return "false";
    } 

    return $interval->format($differenceFormat);
}