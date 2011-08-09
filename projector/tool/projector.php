<?php
session_start();              // Setup session. Must be first command.
/** ============================================================================
 * Global tool script for the application.
 * Must be included (include once) on each script remotely called.
 * $Revision$
 * $Date$
 */
set_exception_handler('exceptionHandler');
set_error_handler('errorHandler');
$browserLocale="";
$reportCount=0;
include_once("../tool/file.php");
include_once "../tool/html.php"; // include html functions

/* ============================================================================
 * global variables
 * ============================================================================ */
if (is_file("../tool/parametersLocation.php")) {
  // Location of the parameters file should be changed. 
  // For security reasons, you should move it to a non web accessed directory.
  // Just create parametersLocation.php file including just one line :
  // <?php $parametersLocation='location of your parameters file'; 
  include_once "../tool/parametersLocation.php";
  if ( ! is_file($parametersLocation) ) {
    echo "*** ERROR ****<br/>";
    echo " parameter file not found at '" . $parametersLocation . "'<br/>";
    echo " Check file '/tool/parametersLocation.php' or remove it to use '/tool/parameters.php'.<br/>";
    echo " <br/>";
    echo " If problem persists, you may get some help at the forum at <a href='http://projector.toolware.fr/'>projectOr web site </a>.";
    exit;
  }
  include_once $parametersLocation;
} else {
  if (is_file("../tool/config.php")) {
    include_once "../tool/config.php";
    exit;
  } 
  include_once "../tool/parameters.php"; // New in 0.6.0 : No more need to change this line if you move this file. See above.
}
date_default_timezone_set($paramDefaultTimezone);
scriptLog($_SERVER["SCRIPT_NAME"]);

$testMode=false;              // Setup a variable for testing purpose test.php changes this value to true
$i18nMessages=null;           // Array containing messages depending on local (initialized at first need)
   
setupLocale();                // Set up the locale : must be called before any call to i18n()

setupIconSize();              // 
$cr="\n";                     // Line feed (just for html dynamic building, to ease debugging
// === Application data : version, dependencies, about message, ...
$applicationName="Project'Or RIA"; // Name of the application
$copyright=$applicationName;  // Copyright to be displayed
$version="V1.6.2";            // Version of application : Major / Minor / Release
$build="0034";                // Build number. To be increased on each release
$website="http://projectorria.toolware.fr"; // ProjectOr site url
$aboutMessage='';             // About message to be displayed when clicking on application logo
$aboutMessage.='<div>' . $applicationName . ' ' . $version . '</div><br/>';
$aboutMessage.='<div>' . i18n("aboutMessageWebsite") . ' : <a href=\'' . $website . '\'>' . $website . '</a></div><br/>';

$isAttachementEnabled=true;   // allow attachement
if (! $paramAttachementDirectory or ! $paramAttachementMaxSize) {
  $isAttachementEnabled=false;
} 

/* ============================================================================
 * main controls
 * ============================================================================ */

// Check 'magic_quotes' : must be disabled ====================================
if (get_magic_quotes_gpc ()) {
  debugLog (i18n("errorMagicQuotesGpc"));  
}
if (get_magic_quotes_runtime ()) {
  @set_magic_quotes_runtime(0);
}
// Check Register Globals 
if (ini_get('register_globals')) {
  debugLog (i18n("errorRegisterGlobals"));  
}

$page=$_SERVER['PHP_SELF'];
if ( ! (isset($maintenance) and $maintenance) ) {
  // Get the user from session. If not exists, request connection ===============
  if (isset($_SESSION['user'])) {
    $user=$_SESSION['user'];
    // user must be a User object. Otherwise, it may be hacking attempt.
    if (get_class($user) != "User") {
      // Hacking detected
      traceLog("'user' is not an instance of User class. May be a hacking attempt from IP " . $_SERVER['REMOTE_ADDR']) ;
      envLog();
      $user=null;
      throw new Exception(i18n("invalidAccessAttempt"));
    }
    $oldRoot="";
    if (array_key_exists('appRoot',$_SESSION)) {
      $oldRoot=$_SESSION['appRoot'];
    }
    if ($oldRoot!="" and $oldRoot!=getAppRoot()) {
      $appRoot=getAppRoot();
      traceLog("Application root changed (from $oldRoot to $appRoot). New Login requested for user '" . $user->name . "' from IP " . $_SERVER['REMOTE_ADDR']);
      session_destroy();
      $user = null;
    }
  } else {
    $user = null;
  }  
  $pos=strrpos($page,"/");
  if ($pos) {
    $page=substr($page,$pos+1);
  }
  //scriptLog("Page=" . $page);
  if ( ! $user and $page != 'loginCheck.php') {
    if (is_file("login.php")) {
      include "login.php";
    } else {
      echo '<input type="hidden" id="lastOperation" name="lastOperation" value="testConnection">';
      echo '<input type="hidden" id="lastOperationStatus" name="lastOperationStatus" value="ERROR">';    
      echo '<span class="messageERROR" >' . i18n('errorConnection') . '</span>';
    }
    exit;
  }
  
  if ($user and $page != 'loginCheck.php' and $page != "changePassword.php") {
    $changePassword=false;
    if (array_key_exists('changePassword',$_REQUEST)) {
      $changePassword=true;
    }
    if ( $user->password==md5($paramDefaultPassword)) {
      $changePassword=true;
    }
    if ( $changePassword ) {
      if (is_file("passwordChange.php")) {
        include "passwordChange.php";
      } else {
        echo '<input type="hidden" id="lastOperation" name="lastOperation" value="testPassword">';
        echo '<input type="hidden" id="lastOperationStatus" name="lastOperationStatus" value="ERROR">';    
        echo '<span class="messageERROR" >' . i18n('invalidPasswordChange') . '</span>';
      }
      exit;  
    }
  }
}

/* ============================================================================
 * functions
 * ============================================================================ */

/** ============================================================================
 * Set up the locale 
 * May be found in request : transmitted from dojo (javascript)
 * @return void 
 */
function setupLocale () {
  global $currentLocale, $paramDefaultLocale, $browserLocale;
  if (isset($_SESSION['currentLocale'])) {
    // First fetch in Session (filled in at login depending on user parameter)
    $currentLocale=$_SESSION['currentLocale'];
  } else if (isset($_REQUEST['currentLocale'])) {
    // Second fetch from request (for screens before user id identified)
    $currentLocale=$_REQUEST['currentLocale'];
    $_SESSION['currentLocale']=$currentLocale;
    $i18nMessages=null; // Should be null at this moment, just to be sure
  } else {
    // none of the above methods worked : get the default one form parameter file
    $currentLocale=$paramDefaultLocale;
  }
  if (isset($_SESSION['browserLocale'])) {
    $browserLocale=$_SESSION['browserLocale'];
  } else {
    $browserLocale=$currentLocale;
  }
  $_SESSION['lang']=$currentLocale; // Must be kept for user parameter screen initialization
}

/** ============================================================================
 * Set up the icon size, converting session text value (small, medium, big)
 * to int corresponding value (16, 22, 32)
 * @return void 
 */
function setupIconSize() {
  global $iconSizeMode;
  // Search in Session, if found, convert from text to int corresponding value
  if (isset($_SESSION['iconSize'])) {
    $iconSizeMode = $_SESSION['iconSize'];
    switch ($iconSizeMode) {
      case 'small' :
        $paramIconSize='16';
        break;
      case 'medium' :
        $paramIconSize='22';
        break;
      case 'big' :
         $paramIconSize='32';
        break;
    }
  }
}
//echo "SESSION=<br/>";var_dump ($_SESSION);echo "<br/><br/>";

/** ============================================================================
 * Internationalization / same function exists in js exploiting same resources
 * @param $str the code of the message to search and translate
 * @return the translated message (or the �nput message if not found)
 */
function i18n($str, $vars=null) {
  global $i18nMessages, $currentLocale;
  // on first use, initialize $i18nMessages
  if ( ! $i18nMessages) {
    $filename="../tool/i18n/nls/lang.js";
    if (isset($currentLocale)) {
      $testFile="../tool/i18n/nls/" . $currentLocale . "/lang.js";
      if (file_exists($testFile)) {
        $filename=$testFile;
      }
    }
    $i18nMessages=array();
    $file=fopen($filename,"r");
    while ($line=fgets($file)) {
      $split=explode(":",$line);
      if (isset($split[1])) {
        $var=trim($split[0],' ');
        $valTab=explode(",",$split[1]);
        $val=trim($valTab[0],' ');
        $val=trim($val,'"');
        $i18nMessages[$var]=$val;
      }
    }
    fclose($file);
  }
  // fetch the message in the array
  if (array_key_exists($str,$i18nMessages)) {
    $ret=$i18nMessages[$str];
    if ($vars) {
      foreach ($vars as $ind => $var) {
        $rep='${' . ($ind+1) . '}';
        $ret=str_replace($rep, $var, $ret);
      }
    }
    return $ret;
  } else {
    return "[" . $str . "]"; // return a defaut value if message code not found
  }
}

/** ============================================================================
 * Return the layout for a grid with the columns header translated (i18n)
 * @param $layout the layout string
 * @return the translated layout
 */
function layoutTranslation($layout) {
  $deb=strpos($layout,'${');
  while ($deb) {
    $fin=strpos($layout,'}',$deb);
    if (! $fin) {exit;}
    $rep=substr($layout,$deb,$fin-$deb+1);
    $col=substr($rep,2, strlen($rep) - 3);
    $col=i18n('col' . ucfirst($col));
    $layout=str_replace( $rep, $col, $layout);
    $deb=strpos($layout,'${');
  }
  return $layout;
}

/** ============================================================================
 * Exception management
 * @param $exeption the exception
 * @return void
 */
function exceptionHandler($exception) {
  global $logLevel;
  errorLog("EXCEPTION *****");
  errorLog("on file '" . $exception->getFile() . "' at line (" . $exception->getLine() . ")");
  errorLog("cause = " . $exception->getMessage());
  $trace=$exception->getTrace();
  foreach($trace as $indTrc => $trc) {
    errorLog("   => #" . $indTrc . " " . $trc['file'] 
     . " (" . $trc['line'] . ")"
     . " -> " . $trc['function'] . "()");
  }
  //echo "<span class='messageERROR'>" . i18n("messageError") . " : " . $exception->getMessage() . "</span>  ";
  //echo "(" . i18n("contactAdministrator") . ")";
  if ($logLevel>=3) {
    throwError($exception->getMessage());  
  } else {
    throwError(i18n('exceptionMessage', array( date('Y-m-d'),date('H:i:s')) ));
  } 
}

/** ============================================================================
 * Error management
 * @param $exeption the exception
 * @return void
 */
function errorHandler($errorType, $errorMessage, $errorFile, $errorLine) {
  global $logLevel;
  errorLog("ERROR *****");
  errorLog("on file '" . $errorFile . "' at line (" . $errorLine . ")");
  errorLog("cause = " . $errorMessage);
  //echo "<span class='messageERROR'>" . i18n("messageError") . " : " . $exception->getMessage() . "</span>  ";
  //echo "(" . i18n("contactAdministrator") . ")";
  if ($logLevel>=3) {
    throwError($errorMessage . "<br/>&nbsp;&nbsp;&nbsp;in " . basename($errorFile) . "<br/>&nbsp;&nbsp;&nbsp;at line " . $errorLine);
  } else {
    throwError(i18n('errorMessage', array( date('Y-m-d'),date('H:i:s')) ));
  } 
}

/** ============================================================================
 * Format error message, display it and exit script
 * NB : error messages are not using i18n (because it may be the origin of the error)
 *      Error messages are always displayed in english (hard coded)
 * @param $message the message of the error to be returned
 * @param $code not used
 * @return void
 */
function throwError($message, $code=null) {
  echo '<span class="messageERROR" >ERROR : ' . $message . '</span>';
  echo '<input type="hidden" id="lastSaveId" value="" />';
  echo '<input type="hidden" id="lastOperation" value="ERROR" />';
  echo '<input type="hidden" id="lastOperationStatus" value="ERROR" />';
  exit();  
}


/** ============================================================================
 * Autoload fonction, to automatically load classes
 * Class file is searched in :
 *   1 => current directory (same as current script) [DISABLED]
 *   2 => model directory => all object model classes should be here
 *   3 => model/persistence => all Sql classes, to interact with database
 *   4 => tool directory [DISABLED]
 * @param $className the name of the class
 * @return void
 */
function __autoload($className) {
  $localfile=ucfirst($className) . '.php';               // locally
  $modelfile='../model/' . $localfile;                   // in the model directory
  $persistfile='../model/persistence/' . $localfile;     // in the model/persistence directory
  if (is_file($modelfile)) {
    require_once $modelfile;
  } elseif (is_file($persistfile)) {
    require_once $persistfile;  
  } else if (0 and is_file($localfile)) { // [DISABLED]
    require_once $localfile;
  } else {
    throwError ("Impossible to load class $className<br/>"
      . "  => Not found in $modelfile <br/>"
      . "  => Not found in $persistfile <br/>")
      . "  => Not found in $localfile <br/>";
  } 
}

/** ============================================================================
 * Return the id of the current connected user (user stored in session)
 * If an weird data is detected (user not existing, user not of User class) an error is raised
 * @return the current user id or raises an error
 */
function getCurrentUserId() {
  if ( ! array_key_exists('user',$_SESSION)) {
    throw "ERROR user does not exist";
    exit;
  }
  $user=$_SESSION['user'];
  if (get_class($user) != 'User') {
    throw "ERROR user is not a User object";
    exit;
  }
  return $user->id;
}

/** ===========================================================================
 * New function that merges array, but preseves numeric keys (unlike array_merge)
 * @param any number of arrays
 * @retrun the arrays merged into one, preserving keys (even numeric ones) 
 */
function array_merge_preserve_keys() {
  $params= func_get_args();
  $result=array();
  foreach($params as &$array) {
    foreach ($array as $key=>&$value) {
      $result[$key]=$value;
    }
  }  
  return $result;
}

/** ===========================================================================
 * Check if menu can be displayed, depending of user profile
 * @param $menu the name of the menu to check
 * @return boolean, true if displayable, false either
 */
function securityCheckDisplayMenu($idMenu, $class=null) {
  $user=null;
  $menu=$idMenu;
  if (! $idMenu and $class) {
  	$menu=SqlList::getIdFromName('MenuList','menu'.$class);
  }
  if (array_key_exists('user',$_SESSION)) {
    $user=$_SESSION['user'];
  }
  if ( ! $user) { 
    return false;
  }
  $profile=$user->idProfile;
  $crit=array();
  $crit['idProfile']=$profile;
  $crit['idMenu']=$menu;
  $obj=SqlElement::getSingleSqlElementFromCriteria('Habilitation', $crit);
  if ($obj->id==null) {
    return false;
  } 
  if ($obj->allowAccess==1) { 
    return true;
  }
  return false;
}

/** =========================================================================== 
 * Get the list of Project Id that are visible : the selected project and its
 * sub-projects
 * At the difference of User->getVisibleProjects(), 
 * selected Project is taken into account
 * @return the list of projects as a string of id
 */
function getVisibleProjectsList($limitToActiveProjects=true, $idProject=null) { 
  if ( ! array_key_exists('project', $_SESSION)) {
    return '( 0 )';
  }
  if ($idProject) {
    $project=$idProject;
  } else {
    $project=$_SESSION['project'];
  }
  $prj=new Project($project);
  $subProjectsList=$prj->getRecursiveSubProjectsFlatList($limitToActiveProjects);
  $result='(0';
  if ($project!='*') {
    $result.=', ' . $project ;
  }
  foreach ($subProjectsList as $id=>$name) {
    $result .= ', ' . $id;
  }
  $result .= ')';
  return $result;
}

function getAccesResctictionClause($objectClass,$alias=null) {
  $obj=new $objectClass();
  if ($alias) {
    $table=$alias;
  } else {
    $table=$obj->getDatabaseTableName();
  }
  $accessRightRead=securityGetAccessRight($obj->getMenuClass(), 'read');
  $queryWhere="";
  if ($accessRightRead=='NO') {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    $queryWhere.=  "(1 = 2)";      
  } else if ($accessRightRead=='OWN') {
    if (propertyExists($obj,"idUser")) {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      if ($alias===false) {
        $queryWhere.=  "idUser = '" . $_SESSION['user']->id . "'";   
      } else {
        $queryWhere.=  $table . ".idUser = '" . $_SESSION['user']->id . "'";   
      }
    } else {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  "(1 = 2)";  
    }         
  } else if ($accessRightRead=='PRO') {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    if ($alias===false) {
      $queryWhere.= "idProject in " . transformListIntoInClause($_SESSION['user']->getVisibleProjects()) ;   
    } else {
      $queryWhere.=  $table . ".idProject in " . transformListIntoInClause($_SESSION['user']->getVisibleProjects()) ;
    }      
  } else if ($accessRightRead=='ALL') {
    $queryWhere.= ' (1=1) ';
  }
  return " " . $queryWhere . " ";
}
/** ============================================================================
 * Return the name of the theme : defaut of selected by user
 */
function getTheme() {
  global $defaultTheme;
  $theme='blue'; // default if never  set
  if (isset($defaultTheme)) {
    $theme=$defaultTheme;   
  }
  if (array_key_exists('theme',$_SESSION) ) {
    $theme= $_SESSION['theme'] ; 
  }
  if ($theme=="random") {
    $themes=array_keys(Parameter::getList('theme'));
    $rnd=rand(0, count($themes)-2);
    $theme=$themes[$rnd];
    $_SESSION['theme']=$theme; // keep value in session to have same theme during all session...
  }
  return $theme;
}
/** ===========================================================================
 * Send a mail
 * @param $to the receiver of message
 * @param $title title of the message
 * @param $message the main body of the message
 * @return unknown_type
 */ 
function sendMail($to, $title, $message, $object=null)  {
  global $paramMailSender, $paramMailReplyTo, $paramMailSmtpServer, $paramMailSmtpPort, $paramMailSendmailPath;
  // Save data of the mail
  $mail=new Mail();
  $mail->idUser=$_SESSION['user']->id;
  if ($object) {
    $mail->idProject=$object->idProject;
    $mail->idMailable=SqlList::getIdFromName('Mailable',get_class($object));
    $mail->refId=$object->id;
    $mail->idStatus=$object->idStatus;
  }
  $mail->mailDateTime=date('Y-m-d G:i');
  $mail->mailTo=$to;
  $mail->mailTitle=$title;
  $mail->mailBody=$message;
  $mail->mailStatus='WAIT';
  $mail->idle='0';
  $mail->save();  
  // Send then mail
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $headers .= 'From: ' . $paramMailSender . "\r\n";
  $headers .= 'Reply-To: ' . $paramMailReplyTo . "\r\n";
  $headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n"; 
  $headers .= 'X-Mailer: PHP/' . phpversion();
  if (isset($paramMailSmtpServer) and $paramMailSmtpServer) {
    ini_set('SMTP',$paramMailSmtpServer);
  }
  if (isset($paramMailSmtpPort) and $paramMailSmtpPort) {
    ini_set('smtp_port',$paramMailSmtpPort);
  }
  if (isset($paramMailSendmailPath) and $paramMailSendmailPath) {
    ini_set('sendmail_path',$paramMailSendmailPath);
  }
  
  error_reporting(E_ERROR);  
  restore_error_handler();
  $resultMail=mail($to,$title,$message,$headers);
  error_reporting(E_ALL);
  set_error_handler('errorHandler');
  if (! $resultMail) {
    errorLog("Error sending mail");
    $smtp=ini_get('SMTP');
    errorLog("   SMTP Server : " . $smtp);
    $port=ini_get('smtp_port');
    errorLog("   SMTP Port : " . $port);
    $path=ini_get('sendmail_path');
    errorLog("   Sendmail path : " . $path);
    errorLog("   Mail stored in Database : #" . $mail->id);
  }
  // save the status of the sending
  $mail->mailStatus=($resultMail)?'OK':'ERROR';
  $mail->save(); 
  return $resultMail;
}

/** ===========================================================================
 * Log tracing. Not to be called directly. Use following functions instead.
 * @param $message message to store on log
 * @param $level level of trace : 1=error, 2=trace, 3=debug, 4=script
 * @return void
 */
function logTracing($message, $level=9) {
  global $logLevel, $logFile;
  if ( ! $logFile or $logFile=='' or $level==9) {
    exit;
  }
  if ($level<=$logLevel) {
    $file=str_replace('${date}',date('Ymd'),$logFile);
    if (is_array($message)or is_object($message)) {
      $txt=is_array($message)?'Array':'Object';
      $txt.='[' . count($message) . ')';
      logTracing($txt,$level);
      foreach ($message as $ind => $val) {
        if (is_array($val)or is_object($val)) {
          $txt = $ind . ' => ';
          $txt .= is_array($val)?'Array ':'Object ';
          logTracing($txt, $level); 
          logTracing($val, $level); 
        } else {
          $txt=$ind . ' => ' . $val;
          logTracing($txt, $level); 
        }
      }
      $level=999;
      $msg='';
    } else {
      $msg=$message . "\n";
    }
    switch ($level) {
      case 1:
        $msg = date('Y-m-d H:i:s') . " ***** ERROR ***** " . $msg; 
        break;
      case 2:
        $msg = date('Y-m-d H:i:s') . " ===== TRACE ===== " . $msg; 
        break;
      case 3:
        $msg = date('Y-m-d H:i:s') . " ----- DEBUG ----- " . $msg;
        break;
      case 4:
        $msg = date('Y-m-d H:i:s') . " ..... SCRIPT .... " . $msg;
        break;
      default:
        break;
    }
    $dir=dirname($file);
    if ( ! file_exists($dir) ) {
      echo '<br/><span class="messageERROR">' . i18n("invalidLogDir",array($dir)) . '</span>';   
    } else if ( ! is_writable($dir)) {
      echo '<br/><span class="messageERROR">' . i18n("lockedLogDir",array($dir)) . '</span>';   
    } else {
      writeFile( $msg,$file);
    }     
  }
}

/** ===========================================================================
 * Log tracing for debug
 * @param $message message to store on log
 * @return void
 */
function debugLog($message) {
  logTracing($message,3);
}

/** ===========================================================================
 * Log tracing for general trace
 * @param $message message to store on log
 * @return void
 */
function traceLog($message) {
  logTracing($message,2);
}

/** ===========================================================================
 * Log tracing for error
 * @param $message message to store on log
 * @return void
 */
function errorLog($message) {
  logTracing($message,1);
}

/** ===========================================================================
 * Log tracing for entry into script
 * @param $message message to store on log
 * @return void
 */
function scriptLog($script) {
  logTracing(getIP() . $script,4);
}

/** ===========================================================================
 * Log a maximum of environment data (to trace hacking)
 * @return void
 */
function envLog() {
  traceLog('IP CLient=' . getIP());
  if (isset($_REQUEST)) {
    foreach ($_REQUEST as $ind => $val) {
      traceLog('$_REQUEST[' . $ind . ']=' . $val);
    }
  }
}


/** ===========================================================================
 * Get the IP of the Client
 * @return the IP as a string
 */
function getIP(){  
  if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {  
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } else { 
    $ip = $_SERVER['REMOTE_ADDR'];
  }  
  return $ip;
} 

/** ===========================================================================
 * Get the access right for a menu and an access type
 * @param $menuName The name of the menu; should be 'menuXXX'
 * @param $accessType requested access type : 'read', 'create', 'update', 'delete'
 * @return the access right 
 *    'NO'  => non access
 *    'PRO' => all elements of affected projects
 *    'OWN' => only own elements
 *    'ALL' => any element
 */
function securityGetAccessRight($menuName, $accessType, $obj=null) {
  $user=$_SESSION['user'];
  $accessRightList=$user->getAccessControlRights();
  //$accessRight='NO';
  // TODO : set default to NO, when non-project-dependant lists are implemented
  $accessRight='ALL';
  if ($accessType=='update' and $obj and $obj->id==null) {
    return securityGetAccessRight($menuName, 'create');
  }
  if (array_key_exists($menuName, $accessRightList)) {
    $accessRightObj=$accessRightList[$menuName];
    if (array_key_exists($accessType, $accessRightObj)) {
      $accessRight=$accessRightObj[$accessType];
    }
  }
  return $accessRight;
}

/** ===========================================================================
 * Get the access right for a menu and an access type, just returning Yes or No
 * @param $menuName The name of the menu; should be 'menuXXX'
 * @param $accessType requested access type : 'read', 'create', 'update', 'delete'
 * @return the right as Yes or No (depending on object properties) 
 */
function securityGetAccessRightYesNo($menuName, $accessType, $obj=null) {
  // ATTENTION, NOT FOR READ ACCESS
  $user=$_SESSION['user'];
  $accessRight=securityGetAccessRight($menuName, $accessType, $obj);
  if ($accessType=='create') {
    $accessRight=($accessRight=='NO' or $accessRight=='OWN')?'NO':'YES';
  } else if ($accessType=='update' or $accessType=='delete' or $accessType='read') {
    if ($accessRight=='NO') {
      // will return no
    } else if ($accessRight=='ALL') {
      $accessRight='YES';
    } else if ($accessRight=='PRO') {
      $accessRight='NO';
      if ($obj != null) {
        if (property_exists($obj, 'idProject')) {
          if (array_key_exists($obj->idProject, $user->getVisibleProjects()) or $obj->id==null) {
            $accessRight='YES';
          }
        }
      }
    } else if ($accessRight=='OWN') {
      $accessRight='NO';
      if ($obj != null) {
        if (property_exists($obj, 'idUser')) {
          if ($user->id==$obj->idUser) {
            $accessRight='YES';
          }
        }
      }
    }
  }
  return $accessRight;
}

/** ============================================================================
 * Transfor a list, as an array, into an 'IN' clause
 * @param $list an array, with the id to select as index
 * @return the IN clause, as ('xx', 'yy', ... )
 */
function transformListIntoInClause($list) {
  if (count($list)==0) return '(0)';
  $result='(' ;
  foreach ($list as $id=>$name) {
    $result .= ($result=='(')?'':', ';
    $result .= $id;
  }
  $result .= ')'; 
  return $result;
}

function transformValueListIntoInClause($list) {
  if (count($list)==0) return '(0)';
  $result='(' ;
  foreach ($list as $id=>$name) {
    $result .= ($result=='(')?'':', ';
    $result .= "'" . $name . "'";
  }
  $result .= ')'; 
  return $result;
}

/** ============================================================================
 * Calculate difference between 2 dates
 * @param $start start date - format yyyy-mm-dd
 * @param $end end date - format yyyy-mm-dd
 * @return int number of work days (remove week-ends)
 */
function workDayDiffDates($start, $end) {
  if (! $start or ! $end) {
    return "";
  }
  $tStart = explode("-", $start);
  $tEnd = explode("-", $end);
  $dStart=mktime(0, 0, 0, $tStart[1], $tStart[2], $tStart[0]);
  $dEnd=mktime(0, 0, 0, $tEnd[1], $tEnd[2], $tEnd[0]);
  if (date("N",$dEnd)>=6) {
    $dEnd=mktime(0, 0, 0, $tEnd[1], $tEnd[2]+5-date("N",$dEnd), $tEnd[0]);
  }
  if (date("N",$dStart)>=6) {
    $dStart=mktime(0, 0, 0, $tStart[1], $tStart[2]+8-date("N",$dStart), $tStart[0]);
  }
  if ($dStart>$dEnd) {
    return 0;
  }
  $diff = $dEnd - $dStart;
  $diffDay=($diff / 86400);
  $diffDay=round($diffDay,0);
  //remove week-ends 
  if ($diffDay>=7) {
    $diffDay-=(floor($diffDay/7)*2);
  }
  // Remove 1 more week-end if not complete week including a week-end
  if (date("N",$dEnd) < date("N",$dStart)) {
    $diffDay-=2;
  }
  //add 1 day to include first day, workDayDiffDates(X,X)=1, workDayDiffDates(X,X+1)=2
  $diffDay+=1;
  return($diffDay);
}

/** ============================================================================
 * Calculate difference between 2 dates
 * @param $start start date - format yyyy-mm-dd
 * @param $end end date - format yyyy-mm-dd
 * @return int number of days
 */
function dayDiffDates($start, $end) {
  $tStart = explode("-", $start);
  $tEnd = explode("-", $end);
  $dStart=mktime(0, 0, 0, $tStart[1], $tStart[2], $tStart[0]);
  $dEnd=mktime(0, 0, 0, $tEnd[1], $tEnd[2], $tEnd[0]);
  $diff = $dEnd - $dStart;
  $diffDay=($diff / 86400);
  return round($diffDay,0);
}  
  
/** ============================================================================
 * Calculate new date after adding some days
 * @param $date start date - format yyyy-mm-dd
 * @param $days numbers of days to add (can be < 0 to subtract days)
 * @return new calculated date - format yyyy-mm-dd
 */
function addWorkDaysToDate($date, $days) {
  if ($days<=0) {
    return $date;
  }
  if (! $date) {
  	return;
  }
  $days-=1;
  $tDate = explode("-", $date);
  $dStart=mktime(0, 0, 0, $tDate[1], $tDate[2], $tDate[0]);
  if (date("N",$dStart) >=6) {
    $tDate[2]=$tDate[2]+8-date("N",$dStart);
    $dStart=mktime(0, 0, 0, $tDate[1], $tDate[2], $tDate[0]);
  }
  $weekEnds=floor($days/5);
  $additionalDays=$days-(5*$weekEnds);
  if (date("N",$dStart) + $additionalDays >=6) {
    $weekEnds+=1;
  }
  $days+=2*$weekEnds;
  $dEnd=mktime(0, 0, 0, $tDate[1], $tDate[2]+$days, $tDate[0]);
  return date("Y-m-d", $dEnd);
}

/** ============================================================================
 * Calculate new date after adding some months
 * @param $date start date - format yyyy-mm-dd
 * @param $months numbers of months to add (can be < 0 to subtract months)
 * @return new calculated date - format yyyy-mm-dd
 */
function addDaysToDate($date, $days) {
  $tDate = explode("-", $date);
  return date("Y-m-d", mktime(0, 0, 0, $tDate[1], $tDate[2]+$days, $tDate[0]));
}
/** ============================================================================
 * Calculate new date after adding some months
 * @param $date start date - format yyyy-mm-dd
 * @param $months numbers of months to add (can be < 0 to subtract months)
 * @return new calculated date - format yyyy-mm-dd
 */
function addMonthsToDate($date, $months) {
  $tDate = explode("-", $date);
  return date("Y-m-d", mktime(0, 0, 0, $tDate[1]+$months, $tDate[2], $tDate[0]));
}

/** ============================================================================
 * Calculate new date after adding some weeks
 * @param $date start date - format yyyy-mm-dd
 * @param $weeks numbers of weeks to add (can be < 0 to subtract weeks)
 * @return new calculated date - format yyyy-mm-dd
 */
function addWeeksToDate($date, $weeks) {
  $tDate = explode("-", $date);
  return date("Y-m-d", mktime(0, 0, 0, $tDate[1], $tDate[2]+(7*$weeks), $tDate[0]));
}

/**
 * Return wbs code as a sortable value string (pad number with zeros)
 * @param $wbs wbs code 
 * @return string the formated sortable wbs
 */
function formatSortableWbs($wbs) {
  $exp=explode('.',$wbs);
  $result="";
  foreach ($exp as $node) {
    $result.=($result!='')?'.':'';
    $result.=substr('000',0,3-strlen($node)) . $node;
  }
  return $result;
}

/**
 * Calculate forecolor for a given background color
 * Return black for light backgroud color
 * Return white for dark backgroud color
 * @param $color
 * @return string The fore color to fit the back ground color
 */
function getForeColor($color) {
  $foreColor='#000000';
  if (strlen($color)==7) {
    $red=substr($color,1,2);
    $green=substr($color,3,2);
    $blue=substr($color,5,2);
    $light=(0.3) * hexdec($red) + (0.6) * hexdec($green) + (0.1) * hexdec($blue);
    if ($light<128) { $foreColor='#FFFFFF'; }
  }
  return $foreColor;
}

/* calculate the first day of a given week
 * 
 */
function firstDayofWeek($week,$year) 
{
    $Jan1 = mktime(1,1,1,1,1,$year); 
    $MondayOffset = (11-date('w',$Jan1))%7-3; 
    $desiredMonday = strtotime(($week-1) . ' weeks '.$MondayOffset.' days', $Jan1); 
    return $desiredMonday; 
}

/* Calculate number of days between 2 dates
 */
/*  Not user anymore.  See dayDiffDates()
 function numberOfDays($startDate, $endDate) {
  $tabStart = explode("-", $startDate);
  $tabEnd = explode("-", $endDate);
  $diff = mktime(0, 0, 0, $tabEnd[1], $tabEnd[2], $tabEnd[0]) - 
          mktime(0, 0, 0, $tabStart[1], $tabStart[2], $tabStart[0]);
  return(($diff / 86400)+1);
}
*/

/* calculate the week number for a given date
 * 
 */
function weekNumber($dateValue) { 
    return date('W', strtotime ($dateValue) );       
} 

function weekFormat($dateValue) { 
    return date('Y-W', strtotime ($dateValue) );       
} 

/*
 * Checks if a date is a "off day" (weekend or else)
 */
function isOffDay ($dateValue) {
  //TODO : add off days management and calendar management : here are french holidays
  if (isOpenDay ($dateValue)) {
    return false;
  } else {
    return true;
  } 
}
/*
 * Checks if a date is a "off day" (weekend or else)
 */
function isOpenDay ($dateValue) {
  global $paramDefaultLocale;
  $iDate=strtotime($dateValue);
  if ($paramDefaultLocale=='xxxfr') {  // Temporary desactivate France Holidays
    $aBankHolidays = array (
          '1_1',
          '1_5',
          '8_5',
          '14_7',
          '15_8',
          '1_11',
          '11_11',
          '25_12'
          );
    $iEaster = getEaster ((int)date('Y'), $iDate);
    $aBankHolidays[] = date ('j_n', $iEaster);
    $aBankHolidays[] = date ('j_n', $iEaster + (86400*39));
    $aBankHolidays[] = date ('j_n', $iEaster + (86400*49));
  } else {
    $aBankHolidays = array ();
  }  
  //TODO : add off days management and calendar management : here are french holidays
  if (in_array (date ('w', $iDate),array (0,6) ) || in_array (date ('j_n', $iDate), $aBankHolidays)) {
    return false;
  } else {
    return true;
  }
}

function getEaster ($iYear = null) {
    if (is_null ($iYear)) {
        $iYear = (int)date ('Y');
    }
    $iN = $iYear - 1900;
    $iA = $iN%19;
    $iB = floor (((7*$iA)+1)/19);
    $iC = ((11*$iA)-$iB+4)%29;
    $iD = floor ($iN/4);
    $iE = ($iN-$iC+$iD+31)%7;
    $iResult = 25-$iC-$iE;
    if ($iResult > 0) {
        $iEaster = strtotime ($iYear.'/04/'.$iResult);
    } else {
        $iEaster = strtotime ($iYear.'/03/'.(31+$iResult));
    }
    return $iEaster;
}

function numberOfDaysOfMonth($dateValue) {
  return date('t', strtotime ($dateValue) );    
}

function getBooleanValue($val) {
  if ($val===true) {return true;}
  if ($val===false) {return false;}
  if ($val=='true') {return true;}
  if ($val=='false') {return false;}
  return false;
}

function getBooleanValueAsString($val) {
  if (getBooleanValue($val)) {
    return 'true';
  } else {
    return 'false';
  }
}

function getArrayMonth($max,$addPoint=true) {
  $monthArr=array(i18n("January"),i18n("February"),i18n("March"),
      i18n("April"), i18n("May"),i18n("June"),
      i18n("July"), i18n("August"), i18n("September"),
      i18n("October"),i18n("November"),i18n("December"));
  if ($max) {
    foreach ($monthArr as $num=>$month) {
      if (mb_strlen($month,'UTF-8')>$max) {
        if ($addPoint) {
          $monthArr[$num]=mb_substr($month,0,$max-1,'UTF-8'). '.';
        } else {
          $monthArr[$num]=mb_substr($month,0,$max,'UTF-8');
        }
      }
    }
  }
  return $monthArr;  
}

function getAppRoot() {
  $appRoot="";
  $page=$_SERVER['PHP_SELF'];
  if (strpos($page, '/', 1)) {
    $appRoot=substr($page, 0, strpos($page, '/', 1));
  }
  if ($appRoot=='/view' or $appRoot=='/tool' or $appRoot=='/report') {
    $appRoot='/';
  }
  return $appRoot;
}
?>