<?php
require_once "../tool/projector.php";
if (file_exists('../files/cron/RUNNING')) {
	errorLog('try to run cron already running');
  return;
}
set_time_limit(0);
ignore_user_abort(1);
session_write_close();

$cronSleepTime=10; // in seconds. Attention, if changed, also change cronSleepTime in projectorDialog.php
$cronCheckDates=0.2*60; // every minute

function endCron()
{
  unlink('../files/cron/RUNNING');
	fopen('../files/cron/ERROR_ON_'.date('Ymd_His'), 'w');  
  errorLog('cron abnormally stopped');
}

register_shutdown_function('endCron');

$tmpCronCheckDates=$cronCheckDates;
if (file_exists('../files/cron/STOP')) {
  unlink('../files/cron/STOP');
}
fopen('../files/cron/RUNNING', 'w');
while(1)
{
	debugLog(date('d/m/Y H:i:s'));
  if (file_exists('../files/cron/STOP')) { 
  	debugLog('cron normally stopped at '.date('d/m/Y H:i:s'));
  	unlink('../files/cron/RUNNING');
  	unlink('../files/cron/STOP');
  	return; 
  }
  $tmpCronCheckDates-=$cronSleepTime;
  if ($tmpCronCheckDates<=0) {
  	checkDates();
  	$tmpCronCheckDates=$cronCheckDates;
  }
  sleep($cronSleepTime);
  //fopen($scripts[$indexScript]['URLScript'], 'r') /* on lance le script. */
}

function checkDates() {
	debugLog("cron : checkDates at " .date('d/m/Y H:i:s'));
	$indVal=new IndicatorValue();
	$where="idle='0' and (";
	$where.=" ( warningTargetDateTime>'" . date('d/m/Y H:i:s') . "' and warningSent='0')" ;
	$where.=" or ( alertTargetDateTime>'" . date('d/m/Y H:i:s') . "' and alertSent='0')" ;
	$where.=")";
	$lst=$indVal->getSqlElementsFromCriteria(null, null, $where);
	foreach ($lst as $indVal) {
		$indVal->checkDates();
	}
}