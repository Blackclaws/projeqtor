<?php 
/* ============================================================================
 * Parameter is a global kind of object for parametring.
 * It may be on user level, on project level or on global level.
 */ 
class Parameter extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visiblez place 
  public $idUser;
  public $idProject;
  public $parameterCode;
  public $parameterValue;
  
  public $_noHistory=true; // Will never save history for this object
  
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
// GET VALIDATION SCRIPT
// ============================================================================**********

  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    //$colScript = parent::getValidationScript($colName);   
    $colScript="";
    if ($colName=="theme") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.value!="random") changeTheme(this.value);';
      $colScript .= '</script>';
    } else if ($colName=="lang") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  changeLocale(this.value);';
      $colScript .= '</script>';
    } else if ($colName=="defaultProject") {
      //$colScript .= 'dojo.xhrPost({url: "../tool/saveDataToSession.php?id=defaultProject&value=" + this.value;});';
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  newValue=this.value;';
      $colScript .= '  dojo.xhrPost({url: "../tool/saveDataToSession.php?id=' . $colName . '&value=" + newValue});';
      $colScript .= '</script>';             
    } else if ($colName=="hideMenu") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.value=="NO") {';
      $colScript .= '    if (menuActualStatus!="visible") {hideShowMenu()}';
      $colScript .= '    menuHidden=false;';
      $colScript .= '  } else {';
      $colScript .= '    menuHidden=true;';
      $colScript .= '    menuShowMode=this.value;';
      $colScript .= '  }';
      $colScript .= '  newValue=this.value;';
      $colScript .= '  dojo.xhrPost({url: "../tool/saveDataToSession.php?id=' . $colName . '&value=" + newValue});';
      $colScript .= '</script>';
    } else if ($colName=="switchedMode") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.value=="NO") {';
      $colScript .= '    switchedMode=false;';
      $colScript .= '    dijit.byId("buttonSwitchMode").set("label",i18n("buttonSwitchedMode"));';
      $colScript .= '  } else {';
      $colScript .= '    switchedMode=true;';
      $colScript .= '    switchListMode=this.value;';
      $colScript .= '    dijit.byId("buttonSwitchMode").set("label",i18n("buttonStandardMode"));';
      $colScript .= '  }';
      $colScript .= '  newValue=this.value;';
      $colScript .= '  dojo.xhrPost({url: "../tool/saveDataToSession.php?id=' . $colName . '&value=" + newValue});';
      $colScript .= '</script>';    
    } else  if ($colName=="printInNewWindow"){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  newValue=this.value;';
      $colScript .= '  if (newValue=="YES") {'; 
      $colScript .= '    printInNewWindow=true;';
      $colScript .= '  } else {';
      $colScript .= '    printInNewWindow=false;';
      $colScript .= '  }';
      $colScript .= '  dojo.xhrPost({url: "../tool/saveDataToSession.php?id=' . $colName . '&value=" + newValue});';
      $colScript .= '</script>';
    } else  if ($colName=="pdfInNewWindow"){
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  newValue=this.value;';
      $colScript .= '  if (newValue=="YES") {'; 
      $colScript .= '    pdfInNewWindow=true;';
      $colScript .= '  } else {';
      $colScript .= '    pdfInNewWindow=false;';
      $colScript .= '  }';
      $colScript .= '  dojo.xhrPost({url: "../tool/saveDataToSession.php?id=' . $colName . '&value=" + newValue});';
      $colScript .= '</script>';
    } else {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      //if (! $this->idUser and ! $this->idProject) {
      //  $colScript .= '  formChanged();';
      //}
      $colScript .= '  newValue=this.value;';
      $colScript .= '  dojo.xhrPost({url: "../tool/saveDataToSession.php?id=' . $colName . '&value=" + newValue});';
      $colScript .= '</script>';
    } 
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /** ===========================================================================
   * Give the list of allows values for a parameter (to builmd a select)
   * @param $parameter the name of the parameter
   * @return array of allowed values as code=>value
   */
  static function getList($parameter) {
    global $isAttachementEnabled;
    $list=array();
    switch ($parameter) {
      case 'theme':
        $list=array('ProjectOrRia'=>i18n('themeProjectOrRia'),
                    'ProjectOrRiaContrasted'=>i18n('themeProjectOrRiaContrasted'),
                    'ProjectOrRiaLight'=>i18n('themeProjectOrRiaLight'),
                    'blueLight'=>i18n('themeBlueLight'), 
                    'blue'=>i18n('themeBlue'), 
                    'blueContrast'=>i18n('themeBlueContrast'),
                    'redLight'=>i18n('themeRedLight'),
                    'red'=>i18n('themeRed'),
                    'redContrast'=>i18n('themeRedContrast'),
                    'greenLight'=>i18n('themeGreenLight'),
                    'green'=>i18n('themeGreen'),
                    'greenContrast'=>i18n('themeGreenContrast'),
                    'orangeLight'=>i18n('themeOrangeLight'),
                    'orange'=>i18n('themeOrange'),
                    'orangeContrast'=>i18n('themeOrangeContrast'),
                    'greyLight'=>i18n('themeGreyLight'),
                    'grey'=>i18n('themeGrey'),
                    'greyContrast'=>i18n('themeGreyContrast'),
                    'white'=>i18n('themeWhite'),
                    'random'=>i18n('themeRandom')); // keep 'random' as last value to assure it is not selected via getTheme()
        break;
      case 'lang':
        $list=array('en'=>i18n('langEn'), 
                    'fr'=>i18n('langFr'), 
                    'de'=>i18n('langDe'),
                    'es'=>i18n('langEs'),
                    'pt'=>i18n('langPt'));
        break;
      case 'defaultProject':
        if (array_key_exists('user',$_SESSION)) {
          $user=$_SESSION['user'];
          $listVisible=$user->getVisibleProjects();
        } else {
          $listVisible=SqlList::getList('Project');
        }        
        $list['*']=i18n('allProjects');
        foreach ($listVisible as $key=>$val) {
          $list[$key]=$val;
        }
        break;
      case 'displayHistory':
        $list=array('NO'=>i18n('displayNo'),
                    'YES'=>i18n('displayYes'));
        break;
      case 'displayNote':
        $list=array('YES_OPENED'=>i18n('displayYesOpened'),
                    'YES_CLOSED'=>i18n('displayYesClosed'));
        break;
      case 'displayAttachement':
        if ($isAttachementEnabled) {
          $list=array('YES_OPENED'=>i18n('displayYesOpened'),
                      'YES_CLOSED'=>i18n('displayYesClosed'));
        } else {
          $list=array('NO'=>i18n('displayNo'));          
        }
        break;
      /* case 'refreshUpdates':
        $list=array('YES'=>i18n('refreshUpdatesYes'),
                    'NO'=>i18n('refreshUpdatesNo'));
        break; */
      case 'hideMenu':
        $list=array('NO'=>i18n('displayNo'),
                    'AUTO'=>i18n('displayYesShowOnMouse'),
                    'CLICK'=>i18n('displayYesShowOnClick'));
        break;
      case 'switchedMode':
        $list=array('NO'=>i18n('displayNo'),
                    'AUTO'=>i18n('displayYesShowOnMouse'),
                    'CLICK'=>i18n('displayYesShowOnClick'));
        break;
      case 'printInNewWindow':
        $list=array('NO'=>i18n('displayNo'),
                    'YES'=>i18n('displayYes'));
        break;
      case 'pdfInNewWindow':
        $list=array('YES'=>i18n('displayYes'),
                    'NO'=>i18n('displayNo'));
        break;
      case 'imputationUnit':
      	$list=array('days'=>i18n('days'),
      	            'hours'=>i18n('hours'));
      	break;
      case 'workUnit':
        $list=array('days'=>i18n('days'),
                    'hours'=>i18n('hours'));
        break;
      case 'getVersion':
      	$list=array('YES'=>i18n('displayYes'),
                    'NO'=>i18n('displayNo'));
      	break;
      case 'ldapDefaultProfile':
      	$list=SqlList::getList('Profile');
      	break;
      case 'ldapMsgOnUserCreation';
        $list=array('NO'=>i18n('displayNo'),
                    'ALERT'=>i18n('displayAlert'),
                    'MAIL'=>i18n('displayMail'),
                    'ALERT&MAIL'=>i18n('displayAlertAndMail'));
        break;
      case 'csvSeparator';
        $list=array(';'=>';',','=>',');
        break;
      case 'changeReferenceOnTypeChange';
        $list=array('YES'=>i18n('displayYes'),
                    'NO'=>i18n('displayNo'));
        break;
      case 'displayResourcePlan';
        $list=array('name'=>i18n('colName'),
                    'initials'=>i18n('colInitials'),
                    'NO'=>i18n('displayNo'));
        break;  
    } 
    return $list;
  }
  
  static function getParamtersList($typeParameter) {
    $parameterList=array();
    switch ($typeParameter) {
      case ('userParameter'):
        $parameterList=array('sectionDisplayPerameter'=>"section",
                           "theme"=>"list", 
                           "lang"=>"list",
                           //'sectionObjectDetail'=>'section', 
                           //"displayAttachement"=>"list",
                           //"displayNote"=>"list",
                           'sectionIHM'=>'section',
                           "displayHistory"=>"list",  
                           "hideMenu"=>"list",
                           "switchedMode"=>"list",
                           'sectionPrintExport'=>'section',  
                           "printInNewWindow"=>"list",
                           "pdfInNewWindow"=>"list", 
                           'sectionMiscellaneous'=>'section',      
                           "defaultProject"=>"list",
                           'newColumn'=>'newColumn'
        
        );
        break;
      case ('globalParameter'):
      	$parameterList=array('sectionDailyHours'=>"section",
      	                     'startAM'=>'time',
      	                     'endAM'=>'time',
      	                     'startPM'=>'time',
      	                     'endPM'=>'time',
      	                     'sectionWorkUnit'=>'section',      	                     
      	                     'imputationUnit'=>'list',
      	                     'workUnit'=>'list',
      	                     'dayTime'=>'number',
      	                     'sectionAlerts'=>'section',  
      	                     'alertCheckTime'=>'number',
      	                     'sectionLdap'=>'section', 
      	                     'ldapDefaultProfile'=>'list',
      	                     'ldapMsgOnUserCreation'=>'list',
      	                     'sectionReferenceFormat'=>'section',
      	                     'referenceFormatPrefix'=>'text',
      	                     'referenceFormatNumber'=>'number',
                             'changeReferenceOnTypeChange'=>'list',
      	                     'sectionMiscellaneous'=>'section',  
      	                     'getVersion'=>'list',
      	                     'csvSeparator'=>'list',
      	                     'newColumn'=>'newColumn',
      	                     'sectionDocument'=>'section',
      	                     'documentRoot'=>'text',
      	                     'draftSeparator'=>'text',
      	                     'sectionBilling'=>'section',
      	                     'billPrefix'=>'text',
      	                     'billSuffix'=>'text',
      	                     'billNumSize'=>'number',
      	                     'billNumStart'=>'number',
      	                     'sectionPlanning'=>'section',
      	                     'displayResourcePlan'=>'list',
      	);
    }
    return $parameterList;
  }
  
  static public function getGlobalParameter($code) {
  	$paramCode='globalParameter_'.$code;
  	if (array_key_exists($paramCode,$_SESSION)) {
  		return $_SESSION[$paramCode];
  	} else {
  		$p=new Parameter();
  	  $crit=" idUser is null and idProject is null and parameterCode='" . $code . "'";
  	  $lst=$p->getSqlElementsFromCriteria(null, false, $crit);
  	  $val='';
  	  if (count($lst)==1) {
  	  	$val=$lst[0]->parameterValue;
  	  }
  	  $_SESSION[$paramCode]=$val;
  	  return $val;
    }
  }
  static public function getUserParameter($code) {
    $p=new Parameter();
    $user=$_SESSION['user'];
    $crit=" idUser ='" . $user->id . "' and idProject is null and parameterCode='" . $code . "'";
    $lst=$p->getSqlElementsFromCriteria(null, false, $crit);
    $val='';
    if (count($lst)==1) {
      $val=$lst[0]->parameterValue;
    }
    return $val;
  }
  
  static public function getPlanningColumnOrder($all=false) {
  	$res=array();
  	// Default Values
  	$user=$_SESSION['user'];
  	$crit="idUser='" . $user->id . "' and idProject is null and parameterCode like 'planningHideColumn%'";
  	$param=new Parameter();
  	$hiddenList=$param->getSqlElementsFromCriteria(null, false, $crit);
  	$hidden="|";
  	foreach($hiddenList as $param) {
  		if ($param->parameterValue=='1') {
  		  $hidden.=substr($param->parameterCode,18).'|';
  		}
  	}
  	$i=1;
  	$res[$i++]=($all or !strpos($hidden,'ValidatedWork')>0)?'ValidatedWork':'';
    $res[$i++]=($all or !strpos($hidden,'AssignedWork')>0)?'AssignedWork':'';
    $res[$i++]=($all or !strpos($hidden,'RealWork')>0)?'RealWork':'';
    $res[$i++]=($all or !strpos($hidden,'LeftWork')>0)?'LeftWork':'';
    $res[$i++]=($all or !strpos($hidden,'PlannedWork')>0)?'PlannedWork':'';
    $res[$i++]=($all or !strpos($hidden,'Duration')>0)?'Duration':'';
    $res[$i++]=($all or !strpos($hidden,'Progress')>0)?'Progress':'';
    $res[$i++]=($all or !strpos($hidden,'StartDate')>0)?'StartDate':'';
    $res[$i++]=($all or !strpos($hidden,'EndDate')>0)?'EndDate':'';
  	$res[$i++]=($all or !strpos($hidden,'Resource')>0)?'Resource':'';
  	return $res;
  }
}
?>