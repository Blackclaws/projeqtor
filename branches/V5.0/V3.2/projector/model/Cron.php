<?php 
/* ============================================================================
 * ActionType defines the type of an issue.
 */ 
class Cron {

  // Define the layout that will be used for lists
    
  private static $sleepTime;
  private static $checkDates;
  private static $checkImport;
  private static $runningFile;
  private static $timesFile;
  private static $stopFile;
  private static $errorFile;
  private static $deployFile;
  private static $restartFile;
  private static $cronWorkDir;
  
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
  
  public static function init() {
  	if (self::$cronWorkDir) return;
  	self::$cronWorkDir=Parameter::getGlobalParameter('cronDirectory');
    self::$runningFile=self::$cronWorkDir.'/RUNNING';
    self::$timesFile=self::$cronWorkDir.'/DELAYS';
    self::$stopFile=self::$cronWorkDir.'/STOP';
    self::$errorFile=self::$cronWorkDir.'/ERROR';
    self::$deployFile=self::$cronWorkDir.'/DEPLOY';
    self::$restartFile=self::$cronWorkDir.'/RESTART';
  }
  
  public static function getActualTimes() {
  	self::init();
  	if (! is_file(self::$timesFile)) {
  		return array();
  	}
  	$handle=fopen(self::$timesFile, 'r');
    $line=fgets($handle);
    fclose($handle);
    $result=array();
    $arr=explode('|',$line);
    foreach ($arr as $val) {
    	$split=explode('=',$val);
    	if (count($split)==2) {
    	  $result[$split[0]]=$split[1];
    	}
    }
  	return $result;
  }

  public static function setActualTimes() {
  	self::init();
    $handle=fopen(self::$timesFile, 'w');
    fwrite($handle,'SleepTime='.self::getSleepTime().'|CheckDates='.self::getCheckDates().'|CheckImport='.self::getCheckImport() );
    fclose($handle);
  }
  
  public static function getSleepTime() {
  	self::init();
    if (self::$sleepTime) {
    	return self::$sleepTime;
    }
  	$cronSleepTime=Parameter::getGlobalParameter('cronSleepTime');
    if (! $cronSleepTime) {$cronSleepTime=10;}
    self::$sleepTime=$cronSleepTime;
    return self::$sleepTime;
  }

  public static function getCheckDates() {
  	self::init();
    if (self::$checkDates) {
      return self::$checkDates;
    }
    $checkDates=Parameter::getGlobalParameter('cronCheckDates'); 
    if (! $checkDates) {$checkDates=30;}
    self::$checkDates=$checkDates;
    return self::$checkDates;
  }

  public static function getCheckImport() {
  	self::init();
    if (self::$checkImport) {
      return self::$checkImport;
    }
    $checkImport=Parameter::getGlobalParameter('cronCheckImport'); 
    if (! $checkImport) {$checkImport=30;}
    self::$checkImport=$checkImport;
    return self::$checkImport;
  }  
  
  public static function check() {
  	self::init();
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
  	self::init();
    errorLog('cron abnormally stopped');
    if (file_exists(self::$runningFile)) {
  	  unlink(self::$runningFile);
    }
    $errorFile=fopen(self::$errorFile.'_'.date('Ymd_His'), 'w');
    fclose($errorFile);  
  } 
  
  public static function removeStopFlag() {
  	self::init();
    if (file_exists(self::$stopFile)) {
      unlink(self::$stopFile);
    }
  }
  
  public static function removeRunningFlag() {
  	self::init();
    if (file_exists(self::$runningFile)) {
      unlink(self::$runningFile);
    }
  }
  public static function removeDeployFlag() {
    if (file_exists(self::$deployFile)) {
      unlink(self::$deployFile);
    }
  }
  public static function removeRestartFlag() {
    if (file_exists(self::$restartFile)) {
      unlink(self::$restartFile);
    }
  }
  public static function setRunningFlag() {
  	self::init();
  	$handle=fopen(self::$runningFile, 'w');
    fwrite($handle,time());
    fclose($handle);
  }
  
  public static function setRestartFlag() {
    self::init();
    $handle=fopen(self::$restartFile, 'w');
    fwrite($handle,time());
    fclose($handle);
  }
  
  public static function setStopFlag() {
  	self::init();
    $handle=fopen(self::$stopFile, 'w');
    fclose($handle);
  }
  
  public static function checkStopFlag() {
  	self::init();
    if (file_exists(self::$stopFile) or file_exists(self::$deployFile)) { 
      traceLog('Cron normally stopped at '.date('d/m/Y H:i:s'));
      self::removeRunningFlag();
      self::removeStopFlag();
      if (file_exists(self::$deployFile)) {
      	traceLog('Cron stopped for deployment. Will be restarted');
      	self::setRestartFlag();
        self::removeDeployFlag();
      }
      return true; 
    } else {
    	return false;
    }
  }
  
	// If running flag exists and cron is not really running, relaunch
	public static function relaunch() {
		self::init();
		if (file_exists(self::$restartFile)) {
			self::removeRestartFlag();
			self::run();
		} else if (file_exists(self::$runningFile)) {
      $handle=fopen(self::$runningFile, 'r');
      $last=fgets($handle);
      $now=time();
      fclose($handle);
      if ( ($now-$last) > (self::getSleepTime()*5)) {
        // not running for more than 5 cycles : dead process
        self::removeRunningFlag();
        self::run();
      }
		} else {
		  
		}
	}
	
	public static function run() {
//scriptLog('Cron::run()');	
    self::init();  
		if (self::check()=='running') {
      errorLog('Try to run cron already running');
      return;
    }
    self::removeDeployFlag();
    self::removeRestartFlag();
    set_time_limit(0);
    ignore_user_abort(1);
    session_write_close();
    $cronCheckDates=self::getCheckDates();
    $cronCheckImport=self::getCheckImport();
    $cronSleepTime=self::getSleepTime();
    self::setActualTimes();
    self::removeStopFlag();
    self::setRunningFlag();
    traceLog('Cron started at '.date('d/m/Y H:i:s')); 
    while(1) {
      if (self::checkStopFlag()) {
        return; 
      }
      self::setRunningFlag();
      $cronCheckDates-=$cronSleepTime;
      if ($cronCheckDates<=0) {
      	try { 
          self::checkDates();
      	} catch (Exception $e) {
      		traceLog("Cron::run() - Error on checkDates()");
      	}
        $cronCheckDates=Cron::getCheckDates();
      }
      $cronCheckImport-=$cronSleepTime;
      if ($cronCheckImport<=0) {
      	try { 
          self::checkImport();
      	} catch (Exception $e) {
          traceLog("Cron::run() - Error on checkImport()");
        }
        $cronCheckImport=Cron::getCheckImport();
      }
      sleep($cronSleepTime);
    }
  }
  
  public static function checkDates() {
//scriptLog('Cron::checkDates()');
  	global $globalCronMode;
    self::init();
    $globalCronMode=true;  
    $indVal=new IndicatorValue();
    $where="idle='0' and (";
    $where.=" ( warningTargetDateTime<='" . date('Y-m-d H:i:s') . "' and warningSent='0')" ;
    $where.=" or ( alertTargetDateTime<='" . date('Y-m-d H:i:s') . "' and alertSent='0')" ;
    $where.=")";
    $lst=$indVal->getSqlElementsFromCriteria(null, null, $where);

    foreach ($lst as $indVal) {
      $indVal->checkDates();
    }
  }
  
  public static function checkImport() {
//scriptLog('Cron::checkImport()');
    self::init();
  	global $globalCronMode, $globalCatchErrors;
    $globalCronMode=true;   	
    $globalCatchErrors=true;
  	$importDir=Parameter::getGlobalParameter('cronImportDirectory');
  	$eol=Parameter::getGlobalParameter('mailEol');
  	$cpt=0;
  	$pathSeparator=Parameter::getGlobalParameter('paramPathSeparator');
  	$importSummary="";
  	$importFullLog="";
  	$boundary = null;
  	if (is_dir($importDir)) {
      if ($dirHandler = opendir($importDir)) {
        while (($file = readdir($dirHandler)) !== false) {
        	if ($file!="." and $file!=".." and filetype($importDir . $pathSeparator . $file)=="file") {
        		$globalCronMode=true; // Cron should not be stopped on error or exception
            $importFile=$importDir . $pathSeparator . $file;      
            $split=explode('_',$file);
            $class=$split[0];
            $result="";
            try {
              $result=Importable::import($importFile, $class);
            } catch (Exception $e) {
            	$msg="CRON : Exception on import of file '$importFile'";
            	$result="ERROR";
            }
            $globalCronMode=false; // VOLOUNTARILY STOP THE CRON. Actions are requested !
            try {
	            if ($result=="OK") {	            	
	              $msg="Import OK : file $file imported with no error [ Number of '$class' imported : " . Importable::$cptDone . " ]";
	              traceLog($msg);
	              $importSummary.="<span style='color:green;'>$msg</span><br/>";
	              if (! is_dir($importDir . $pathSeparator . "done")) {
	              	mkdir($importDir . $pathSeparator . "done",0777,true);
	              	
	              }
	              rename($importFile,$importDir . $pathSeparator . "done" . $pathSeparator . $file);
	            } else {
	            	if ($result=="INVALID") {
	               	$msg="Import INVALID : file $file imported with " . Importable::$cptInvalid . " control errors [ Number of '$class' imported : " . Importable::$cptOK . " ]";
	               	traceLog($msg);
                  $importSummary.="<span style='color:orange;'>$msg</span><br/>";
	              } else {
	            	  $msg="Import ERROR : file $file imported with " . Importable::$cptRejected . " errors [ Number of '$class' imported : " . Importable::$cptOK . " ]";
	            	  traceLog($msg);
                  $importSummary.="<span style='color:red;'>$msg</span><br/>";
	              }
	              if (! is_dir($importDir . $pathSeparator . "error")) {
	                mkdir($importDir . $pathSeparator . "error",0777,true);
	              }
	            	rename($importFile,$importDir . $pathSeparator . "error" . $pathSeparator . $file);
	            }
            } catch (Exception $e) {
            	$msg="CRON : Impossible to move file '$importFile'";
            	traceLog($msg);
              $importSummary.="<span style='color:red;'>$msg</span><br/>";
            	$msg="CRON IS STOPPED TO AVOID MULTIPLE-TREATMENT OF SAME FILES";
            	traceLog($msg);
              $importSummary.="<span style='color:red;'>$msg</span><br/>";
            	$msg="Check access rights to folder '$importDir', subfolders 'done' and 'error' and file '$importFile'";
            	traceLog($msg);
              $importSummary.="<span style='color:red;'>$msg</span><br/>";
            	exit; // VOLOUNTARILY STOP THE CRON. Actions are requested !
            }
            $globalCronMode=true; // If cannot write log file, do not exit CRON (not blocking)
            $logFile=$importDir . $pathSeparator . 'logs' . $pathSeparator . substr($file, 0, strlen($file)-4) . ".log.htm";
        	  if (! is_dir($importDir . $pathSeparator . "logs")) {
              mkdir($importDir . $pathSeparator . "logs",0777,true);
            }
            if (file_exists($logFile)) {
            	kill($logFile);
            }
            // Write log file
            $fileHandler = fopen($logFile, 'w');
            fwrite($fileHandler, Importable::getLogHeader());
            fwrite($fileHandler, Importable::$importResult);
            fwrite($fileHandler, Importable::getLogFooter());
            fclose($fileHandler);
            // Prepare joined file on email
        	  if (Parameter::getGlobalParameter('cronImportLogDestination')=='mail+log') {
        	  	if (! $boundary) {
        	  	  $boundary = md5(uniqid(microtime(), TRUE));
        	  	}
						  $file_type = 'text/html';
              $content = Importable::getLogHeader();
						  $content .= Importable::$importResult;
						  $content .= Importable::getLogFooter();
						  $content = chunk_split(base64_encode($content));       
              $importFullLog .= $eol.'--'.$boundary.$eol;
              $importFullLog .= 'Content-type:'.$file_type.';name="'.basename($logFile).'"'.$eol;
              $importFullLog .= 'Content-Length: ' . strlen($content).$eol;     
              $importFullLog .= 'Content-transfer-encoding:base64'.$eol;
              $importFullLog .= 'Content-disposition: attachment; filename="'.basename($logFile).'"'.$eol; 
              $importFullLog .= $eol.$content.$eol;
              $importFullLog .= '--'.$boundary.$eol;
            }
            $cpt+=1;
        	}
        }
        closedir($dirHandler);
      }
    } else {
    	$msg="ERROR - check Cron::Import() - ". $importDir . " is not a directory";
    	traceLog($msg);
      $importSummary.="<span style='color:red;'>$msg</span><br/>";
    }
    if ($importSummary) {
	    $logDest=Parameter::getGlobalParameter('cronImportLogDestination');
	    if (stripos($logDest,'mail')!==false) {
	    	$baseName=Parameter::getGlobalParameter('paramDbDisplayName');
	    	$to=Parameter::getGlobalParameter('cronImportMailList');
	    	if (! $to) {
	    		traceLog("Cron : email requested, but no email address defined");
	    	} else {
		      $message=$importSummary;
		      if (stripos($logDest,'log')!==false) {
		      	$message=Importable::getLogHeader()
		      	         .$message
		      	         .$eol.$importFullLog;
		      	         Importable::getLogFooter();
		      	//$message.=$eol.$importFullLog;
		      }
	        $title="[$baseName] Import summary ". date('Y-m-d H:i:s');
	        $resultMail=sendMail($to, $title, $message, null, null, null, $boundary);	        
	    	}
	    }
    }
  }
  
}
?>