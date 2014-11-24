<?php
if (ob_get_level() == 0) ob_start();
$timestart=microtime(true);
echo "SET REPORTING LEVEL TO GET ALL ERRORS<br/>";
error_reporting(E_ALL);
echo "SET TIME LIMIT TO UNLIMITED EXECUTION<br/>";
$res=set_time_limit(0);
if ($res) {
	echo "OK, NEW TIME LIMIT ACCEPTED BY PHP<br/>";
} ELSE {
	echo"*** ERROR, NEW TIME LIMIT NOT ACCEPTED BY PHP ***<br/>";
}
while (1) {
	$timeend=microtime(true);
	$time=$timeend-$timestart;
	$page_load_time = number_format($time,0);
	echo "SCRIPT RUNNING FOR " . $page_load_time . " S";
	echo str_pad(' ',4096)."\n";
	echo "<br/>";
	ob_flush();
	flush();
	sleep(10);
}
