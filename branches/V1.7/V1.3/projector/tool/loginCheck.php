<?php
/** =========================================================================== 
 * Chek login/password entered in connection screen
 */
  require_once "../tool/projector.php"; 
  
  $login="";
  $password="";
  if (array_key_exists('login',$_POST)) {
    $login=$_POST['login'];
  }
  if (array_key_exists('password',$_POST)) {
    $password=$_POST['password'];
  }    
  if ($login=="") {
    loginError();
  }
  if ($password=="") {
    loginError();
  }
  
  $obj=new User();
  $crit=array('name'=>$login, 'password'=>md5($password));
  $users=$obj->getSqlElementsFromCriteria($crit,true);
  if ( ! $users ) {
   loginError();
   exit;
  } 
  if ( count($users)!=1) {
    loginError();
    exit;
  } 
  $user=$users[0];

  if ( ! $user->id) {
    // 
    if (! Sql::getDbVersion()) {
      if ($login=="admin" and $password=="admin") {
        include "../db/maintenance.php";
        exit;
      }
    }
    loginError();
    exit;
  } 
  if ( $user->idle!=0 or  $user->locked!=0) {
    loginErrorLocked();
  } 

  if (Sql::getDbVersion()!=$version) {
    include "../db/maintenance.php";
    exit;
  }
  loginOk ($user);
  
  /** ========================================================================
   * Display an error message because of invalid login
   * @return void
   */
  function loginError() {
    global $login;
    echo '<span class="messageERROR">';
    echo i18n('invalidLogin');
    echo '</span>';
    unset($_SESSION['user']);
    traceLog("Login error for user '" . $login . "'");
    exit;
  }
  
   /** ========================================================================
   * Display an error message because of invalid login
   * @return void
   */
  function loginErrorLocked() {
    global $login;
    echo '<span class="messageERROR">';
    echo i18n('lockedUser');
    echo '</span>';
    unset($_SESSION['user']);
    traceLog("Login locked for user '" . $login . "'");
    exit;
  }
  
   /** ========================================================================
   * Valid login
   * @param $user the user object containing login information
   * @return void
   */
  function loginOk ($user) {
    global $login;
    $_SESSION['user']=$user;
	$appRoot="#N/A#";
	$page=$_SERVER['PHP_SELF'];
    if (strpos($page, '/', 1)) {
      $appRoot=substr($page, 0, strpos($page, '/', 1));
    }
	if ($appRoot=='/view' or $appRoot=='/tool' or appRoot=='/report') {
	  $appRoot='/';
	}
	$_SESSION['appRoot']=$appRoot;
    $crit=array();
    $crit['idUser']=$user->id;
    $crit['idProject']=null;
    $obj=new Parameter();
    $objList=$obj->getSqlElementsFromCriteria($crit,false);
    foreach($objList as $obj) {
      if ($obj->parameterCode=='lang') {
        $_SESSION['currentLocale']=$obj->parameterValue;
        $i18nMessages=null; 
      } else if ($obj->parameterCode=='defaultProject') {
        $prj=new Project($obj->parameterValue);
        if ($prj->name!=null and $prj->name!='') {
            $_SESSION['project']=$obj->parameterValue;
        } else {
          $_SESSION['project']='*';
        }
      } else {
        $_SESSION[$obj->parameterCode]=$obj->parameterValue;
      }
    }
    echo '<span class="messageOK">';
    echo i18n('loginOK');
    echo '<div id="validated" name="validated" type="hidden"  dojoType="dijit.form.TextBox">OK';
    echo '</div>';
    echo '</span>';
    traceLog("NEW CONNECTED USER '" . $login . "'");
  }

?>