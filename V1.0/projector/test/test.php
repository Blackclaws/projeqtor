<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 

include_once("../tool/projector.php");

echo '<textarea rows=10 cols=100>';
htmlDrawOptionForReference('idResource', '0', null, true);
echo '</textarea>';

$start="2010-04-11";
echo "<br/>";
echo "StartDate=" . $start . "<br/>" ;
echo "<br/>";
echo "WORK DAYS DIFF<br/>";
echo "2010-04-01 => " . workDayDiffDates($start,"2010-04-01"). "<br/>";
echo "2010-04-02 => " . workDayDiffDates($start,"2010-04-02"). "<br/>";
echo "2010-04-03 => " . workDayDiffDates($start,"2010-04-03"). "<br/>";
echo "2010-04-04 => " . workDayDiffDates($start,"2010-04-04"). "<br/>";
echo "2010-04-05 => " . workDayDiffDates($start,"2010-04-05") . "<br/>";
echo "2010-04-06 => " . workDayDiffDates($start,"2010-04-06") . "<br/>";
echo "2010-04-07 => " . workDayDiffDates($start,"2010-04-07") . "<br/>";
echo "2010-04-08 => " . workDayDiffDates($start,"2010-04-08"). "<br/>";
echo "2010-04-09 => " . workDayDiffDates($start,"2010-04-09"). "<br/>";
echo "2010-04-10 => " . workDayDiffDates($start,"2010-04-10"). "<br/>";
echo "2010-04-11 => " . workDayDiffDates($start,"2010-04-11"). "<br/>";
echo "2010-04-12 => " . workDayDiffDates($start,"2010-04-12"). "<br/>";
echo "2010-04-13 => " . workDayDiffDates($start,"2010-04-13"). "<br/>";
echo "2010-04-14 => " . workDayDiffDates($start,"2010-04-14"). "<br/>";
echo "2010-04-15 => " . workDayDiffDates($start,"2010-04-15"). "<br/>";
echo "2010-04-16 => " . workDayDiffDates($start,"2010-04-16"). "<br/>";
echo "<br/>";
echo "DAYS DIFF<br/>";
echo "2010-04-01 => " . dayDiffDates($start,"2010-04-01"). "<br/>";
echo "2010-04-02 => " . dayDiffDates($start,"2010-04-02"). "<br/>";
echo "2010-04-03 => " . dayDiffDates($start,"2010-04-03"). "<br/>";
echo "2010-04-04 => " . dayDiffDates($start,"2010-04-04"). "<br/>";
echo "2010-04-05 => " . dayDiffDates($start,"2010-04-05") . "<br/>";
echo "2010-04-06 => " . dayDiffDates($start,"2010-04-06") . "<br/>";
echo "2010-04-07 => " . dayDiffDates($start,"2010-04-07") . "<br/>";
echo "2010-04-08 => " . dayDiffDates($start,"2010-04-08"). "<br/>";
echo "2010-04-09 => " . dayDiffDates($start,"2010-04-09"). "<br/>";
echo "2010-04-10 => " . dayDiffDates($start,"2010-04-10"). "<br/>";
echo "2010-04-11 => " . dayDiffDates($start,"2010-04-11"). "<br/>";
echo "2010-04-12 => " . dayDiffDates($start,"2010-04-12"). "<br/>";
echo "2010-04-13 => " . dayDiffDates($start,"2010-04-13"). "<br/>";
echo "2010-04-14 => " . dayDiffDates($start,"2010-04-14"). "<br/>";
echo "2010-04-15 => " . dayDiffDates($start,"2010-04-15"). "<br/>";
echo "2010-04-16 => " . dayDiffDates($start,"2010-04-16"). "<br/>";

echo "<br/>";
echo "ADD WORK DAYS<br/>";
echo "1  => " . addWorkDaysToDate($start,1) . "<br/>";
echo "2  => " . addWorkDaysToDate($start,2) . "<br/>";
echo "3  => " . addWorkDaysToDate($start,3) . "<br/>";
echo "4  => " . addWorkDaysToDate($start,4) . "<br/>";
echo "5  => " . addWorkDaysToDate($start,5) . "<br/>";
echo "6  => " . addWorkDaysToDate($start,6) . "<br/>";
echo "7  => " . addWorkDaysToDate($start,7) . "<br/>";
echo "8  => " . addWorkDaysToDate($start,8) . "<br/>";
echo "9  => " . addWorkDaysToDate($start,9) . "<br/>";
echo "10 => " . addWorkDaysToDate($start,10) . "<br/>";
echo "11 => " . addWorkDaysToDate($start,11) . "<br/>";
echo "12 => " . addWorkDaysToDate($start,12) . "<br/>";
echo "<br/>";
echo "ADD DAYS<br/>";
echo "1  => " . addDaysToDate($start,1) . "<br/>";
echo "2  => " . addDaysToDate($start,2) . "<br/>";
echo "3  => " . addDaysToDate($start,3) . "<br/>";
echo "4  => " . addDaysToDate($start,4) . "<br/>";
echo "5  => " . addDaysToDate($start,5) . "<br/>";
echo "6  => " . addDaysToDate($start,6) . "<br/>";
echo "7  => " . addDaysToDate($start,7) . "<br/>";
echo "8  => " . addDaysToDate($start,8) . "<br/>";
echo "9  => " . addDaysToDate($start,9) . "<br/>";
echo "10 => " . addDaysToDate($start,10) . "<br/>";
echo "11 => " . addDaysToDate($start,11) . "<br/>";
echo "12 => " . addDaysToDate($start,12) . "<br/>";


?>

</pre>

</body>
</html>