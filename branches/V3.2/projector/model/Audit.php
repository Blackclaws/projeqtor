<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class Audit extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $sessionId;
  public $auditDay;
  public $connexion;
  public $disconnexion;
  public $lastAccess;
  public $duration;
  public $idUser;
  public $userName;
  public $userAgent;
  public $platform;
  public $browser;
  public $browserVersion;
  public $requestRefreshParam;
  public $requestDisconnection;
  public $idle;

  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="sessionId" width="15%" ># ${session}</th>
    <th field="userName" width="15%" >${idUser}</th>
    <th field="connexion" formatter="dateFormatter" width="12%" >${connexion}</th>
    <th field="lastAccess" formatter="dateFormatter" width="12%"  >${lastAccess}</th>
    <th field="duration" formatter="timeFormatter" width="8%"  >${duration}</th>
    <th field="platform" width="8%" >${platform}</th>
    <th field="browser" formatter="timeFormatter" width="10%" >${browser}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
  }

   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }


// ============================================================================**********
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
  
  static function updateAudit() {
  	$audit=SqlElement::getSingleSqlElementFromCriteria('Audit', array('sessionId'=>session_id()));
    if (! $audit->id) {
      $audit->sessionId=session_id();
      $audit->auditDay=date('Ymd');
      $audit->connexion=date('Y-m-d H:i:s');
      $user=$_SESSION['user'];
      $audit->idUser=$user->id;
      $audit->userName=$user->name;
      $audit->userAgent=$_SERVER['HTTP_USER_AGENT'];
      $browser = self::getBrowser(null, true);
      $audit->platform=$browser['platform'];
      $audit->browser=$browser['browser'];
      $audit->browserVersion=$browser['version'];
      $audit->disconnexion=null;
    }
    $audit->lastAccess=date('Y-m-d H:i:s');
    $audit->duration=strtotime($audit->lastAccess)-strtotime($audit->connexion);
  	$result=$audit->save();
  }
  
   static function finishSession() {
     $audit=SqlElement::getSingleSqlElementFromCriteria('Audit', array('sessionId'=>session_id()));
     if ($audit->id) {
     	 $audit->lastAccess=date('Y-m-d H:i:s');
     	 $audit->disconnexion=$audit->lastAccess;
       $audit->duration=strtotime($audit->lastAccess)-strtotime($audit->connexion);
       $audit->idle=1;
    	 $audit->save();
     }
     $user=$_SESSION['user'];
     $user->disconnect();
     // terminate the session
     if (ini_get("session.use_cookies")) {
	     $params = session_get_cookie_params();
	     setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]);
     }
     session_destroy();
   }  
   
  static function getBrowser() { 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
  
    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}    
    return array(
        'userAgent' => $u_agent,
        'browser'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
  } 
   
}
?>