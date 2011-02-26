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
    $prf=new Profile($user->idProfile);
    if ($prf->profileCode!='ADM') {
      loginErrorMaintenance();
      exit;
    }
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
   * Display an error message because of invalid login
   * @return void
   */
  function loginErrorMaintenance() {
    global $login;
    echo '<span class="messageERROR">';
    echo i18n('wrongMaintenanceUser');
    echo '</span>';
    unset($_SESSION['user']);
    traceLog("Login of non admin user during upgrade. User '" . $login . "'");
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
  	$_SESSION['appRoot']=getAppRoot();
    $crit=array();
    $crit['idUser']=$user->id;
    $crit['idProject']=null;
    $obj=new Parameter();
    $objList=$obj->getSqlElementsFromCriteria($crit,false);
//$user->_arrayFilters[$filterObjectClass . "FilterName"]=$filter->name;
    foreach($objList as $obj) {
      if ($obj->parameterCode=='lang' and $obj->parameterValue) {
        $_SESSION['currentLocale']=$obj->parameterValue;
        $i18nMessages=null; 
      } else if ($obj->parameterCode=='defaultProject') {
        $prj=new Project($obj->parameterValue);
        if ($prj->name!=null and $prj->name!='') {
            $_SESSION['project']=$obj->parameterValue;
        } else {
          $_SESSION['project']='*';
        }
      } else if (substr($obj->parameterCode,0,6)=='Filter') {
        if (! $user->_arrayFilters) {
          $user->_arrayFilters=array();
        }
        $idFilter=$obj->parameterValue;
        $filterObjectClass=substr($obj->parameterCode,6);
        $filterArray=array();
        $filter=new Filter($idFilter);
        $arrayDisp=array();
        $arraySql=array();
        if (is_array($filter->_FilterCriteriaArray)) {
          foreach ($filter->_FilterCriteriaArray as $filterCriteria) {
            $arrayDisp["attribute"]=$filterCriteria->dispAttribute;
            $arrayDisp["operator"]=$filterCriteria->dispOperator;
            $arrayDisp["value"]=$filterCriteria->dispValue;
            $arraySql["attribute"]=$filterCriteria->sqlAttribute;
            $arraySql["operator"]=$filterCriteria->sqlOperator;
            $arraySql["value"]=$filterCriteria->sqlValue;
            $filterArray[]=array("disp"=>$arrayDisp,"sql"=>$arraySql);
          }
        } 
        $user->_arrayFilters[$filterObjectClass]=$filterArray;
        $user->_arrayFilters[$filterObjectClass . "FilterName"]=$filter->name;
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