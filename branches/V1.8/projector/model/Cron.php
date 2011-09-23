<?php 
/* ============================================================================
 * ActionType defines the type of an issue.
 */ 
class Cron {

  // Define the layout that will be used for lists
    
  private static $sleepTime;
  private static $checkDates;
  private static $runningFile='../files/cron/RUNNING';
  private static $stopFile='../files/cron/STOP';
  private static $errorFile='../files/cron/ERROR';
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    
  }

  
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    
  }

// ============================================================================**********
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
  

  public static function getSleepTime() {
    if (self::$sleepTime) {
    	return self::$sleepTime;
    }
  	$cronSleepTime=Parameter::getGlobalParameter('cronSleepTime');
    if (! $cronSleepTime) {$cronSleepTime=10;}
    self::$sleepTime=$cronSleepTime;
    return self::$sleepTime;
  }

  public static function getCheckDates() {
    if (self::$checkDates) {
      return self::$checkDates;
    }
    $checkDates=Parameter::getGlobalParameter('cronCheckDates'); 
    if (! $checkDates) {$checkDates=30;}
    self::$checkDates=$checkDates;
    return self::$checkDates;
  }
  
  public static function check() {
    if (file_exists(self::$runningFile)) {
      $handle=fopen(self::$runningFile, 'r');
      $last=fgets($handle);
      $now=time();
      fclose($handle);
      if ( ($now-$last) > (self::getSleepTime()*5)) {
        // not running for more than 5 cycles : dead process
        self::removeRunningFlag();
        return "stopped";
      } else {
        return "running";
      }
    } else {
      return "stopped";
    }
  }
  
  public static function abort() {
    errorLog('cron abnormally stopped');
  	unlink(self::$runningFile);
    $errorFile=fopen(self::$errorFile.'_'.date('Ymd_His'), 'w');
    fclose($errorFile);  
  } 
  
  public static function removeStopFlag() {
    if (file_exists(self::$stopFile)) {
      unlink(self::$stopFile);
    }
  }
  
  public static function removeRunningFlag() {
    if (file_exists(self::$runningFile)) {
      unlink(self::$runningFile);
    }
  }
  
  public static function setRunningFlag() {
  	$handle=fopen(self::$runningFile, 'w');
    fwrite($handle,time());
    fclose($handle);
  }
  
  public static function setStopFlag() {
    $handle=fopen(self::$stopFile, 'w');
    fclose($handle);
  }
  
  public static function checkStopFlag() {
    if (file_exists(self::$stopFile)) { 
      debugLog('cron normally stopped at '.date('d/m/Y H:i:s'));
      unlink(self::$runningFile);
      unlink(self::$stopFile);
      return true; 
    } else {
    	return false;
    }
  }
  
	public static function checkDates() {
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
}
?>