<?php
include_once("../tool/projeqtor.php");

$start="2016-09-12";
$end="2016-09-13";
echo "delai jo".workDayDiffDates($start, $end).'<br/>';
echo "delai   ".dayDiffDates($start, $end).'<br/>';;

$date="2012-01-01";
while ($date<"2020-31-12") {
  $month=substr($date,5,2);
  $day=substr($date,8);
  if ( ($month==1 and $day<=15) or ($month==12 and $day>=15)) {
    $week=weekFormat($date);
    echo "$date => $week <br/>";
  }
  $date=addDaysToDate($date, 1);
}

