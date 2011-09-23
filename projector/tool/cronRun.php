<?php
require_once "../tool/projector.php";
if (Cron::check()=='running') {
	errorLog('try to run cron already running');
  return;
}
set_time_limit(0);
ignore_user_abort(1);
session_write_close();

function cronAbort() {Cron::abort();}
register_shutdown_function('cronAbort');

$cronCheckDates=Cron::getCheckDates();
$cronSleepTime=Cron::getSleepTime();
Cron::removeStopFlag();
Cron::setRunningFlag();
while(1)
{
  if (Cron::checkStopFlag()) { 
   	return; 
  }
  Cron::setRunningFlag();
  $cronCheckDates-=$cronSleepTime;
  if ($cronCheckDates<=0) {
  	Cron::checkDates();
  	$cronCheckDates=Cron::getCheckDates();
  }
  sleep($cronSleepTime);
}
