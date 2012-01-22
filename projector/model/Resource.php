<?php 
/* ============================================================================
 * User is a resource that can connect to the application.
 */ 
class Resource extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $initials;
  public $capacity;
  public $idTeam;
  public $isUser;
  public $idProfile;
  public $userName;
  public $isContact;
  public $email;
  public $phone;
  public $mobile;
  public $fax;
  public $idle;
  public $description;
  public $_col_2_2_FunctionCost;
  public $idRole;
  public $_ResourceCost=array();
  public $_sec_Affectations;
  public $_spe_affectations;
  
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%"># ${id}</th>
    <th field="name" width="25%">${name}</th>
    <th field="initials" width="10%">${initials}</th>  
    <th field="nameTeam" width="15%">${team}</th>
    <th field="capacity" width="10%" >${capacity}</th>
    <th field="userName" width="20%">${userName}</th> 
    <th field="isUser" width="5%" formatter="booleanFormatter">${isUser}</th>
    <th field="isContact" width="5%" formatter="booleanFormatter">${isContact}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"required", 
                                          "idProfile"=>"readonly",
                                          "isUser"=>"readonly",
                                          "isContact"=>"readonly"
  );    
  
  private static $_databaseTableName = 'user';

  private static $_databaseColumnName = array('name'=>'fullName',
                                              'userName'=>'name');

  private static $_databaseCriteria = array('isResource'=>'1');
  
  private static $_colCaptionTransposition = array('idRole'=>'mainRole'
  );
  
  /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
    
    $crit=array("name"=>"menuUser");
    $menu=SqlElement::getSingleSqlElementFromCriteria('Menu', $crit);
    if (! $menu) {
      return;
    }     
    if (securityCheckDisplayMenu($menu->id)) {
    	self::$_fieldsAttributes["isUser"]="";
    	self::$_fieldsAttributes["idProfile"]="";
    }
    
    $crit=array("name"=>"menuContact");
    $menu=SqlElement::getSingleSqlElementFromCriteria('Menu', $crit);
    if (! $menu) {
      return;
    }     
    if (securityCheckDisplayMenu($menu->id)) {
      self::$_fieldsAttributes["isContact"]="";
    }
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
 
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    global $paramDbPrefix;
    return $paramDbPrefix . self::$_databaseTableName;
  }

  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
  /** ========================================================================
   * Return the specific database criteria
   * @return the databaseTableName
   */
  protected function getStaticDatabaseCriteria() {
    return self::$_databaseCriteria;
  }

     /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
    /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld) {
    return self::$_colCaptionTransposition;
  }
  
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo framework)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);

    if ($colName=="isUser") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    dijit.byId("userName").set("required", "true");';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("userName").set("required", null);';
      $colScript .= '    dijit.byId("userName").set("value", "");';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;

  } 

  public function getWork($startDate, $withProjectRepartition=false) {
    $result=array();
    $startDay=str_replace('-','',$startDate);
    $where="day >= '" . $startDay . "'";
    $where.=" and idResource='" . $this->id . "'"; 
    $pw=new PlannedWork();
    $pwList=$pw->getSqlElementsFromCriteria(null,false,$where);
    $listTopProjectsArray=array();
    foreach ($pwList as $work) {
      $date=$work->workDate;
      if (array_key_exists($date,$result)) {
        $val=$result[$date];
      } else {
        $val=0;
      }
      $val+=$work->work;
      $result[$date]=$val;
      if ($withProjectRepartition) {
        $projectKey='Project#'. $work->idProject;
        if (array_key_exists($projectKey,$listTopProjectsArray)) {
          $listTopProjects=$listTopProjectsArray[$projectKey];
        } else {
          $proj = new Project($work->idProject);
          $listTopProjects=$proj->getTopProjectList(true);
          $listTopProjectsArray[$projectKey]=$listTopProjects;
        }
      // store Data on a project level view
        foreach ($listTopProjects as $idProject) {
          $projectKey='Project#'. $idProject;
          $week=weekFormat($date);
          if (array_key_exists($projectKey,$result)) {
            if (array_key_exists($week,$result[$projectKey])) {
              $valProj=$result[$projectKey][$week];
            } else {
              $valProj=0;
            }
          } else {
            $result[$projectKey]=array();
            $result[$projectKey]['rate']=$this->getAffectationRate($idProject);
            $valProj=0;
          }
          $valProj+=$work->work; 
          $result[$projectKey][$week]=$valProj;
        }
      }
    }
    $w=new Work();
    $wList=$w->getSqlElementsFromCriteria(null,false,$where);
    foreach ($wList as $work) {
      $date=$work->workDate;
      if (array_key_exists($date,$result)) {
        $val=$result[$date];
      } else {
        $val=0;
      }
      $val+=$work->work;
      $result[$date]=$val;
// ProjectRepartition - start
      if ($withProjectRepartition) {
        $projectKey='Project#'. $work->idProject;
        if (array_key_exists($projectKey,$listTopProjectsArray)) {
          $listTopProjects=$listTopProjectsArray[$projectKey];
        } else {
          $proj = new Project($work->idProject);
          $listTopProjects=$proj->getTopProjectList(true);
          $listTopProjectsArray[$projectKey]=$listTopProjects;
        }
        // store Data on a project level view
        foreach ($listTopProjects as $idProject) {
          $projectKey='Project#' . $idProject;
          $week=weekFormat($date);
          if (array_key_exists($projectKey,$result)) {
            if (array_key_exists($week,$result[$projectKey])) {
              $valProj=$result[$projectKey][$week];
            } else {
              $valProj=0;
            }
          } else {
            $result[$projectKey]=array();
            $result[$projectKey]['rate']=$this->getAffectationRate($idProject);
            $valProj=0;
          }
          $valProj+=$work->work; 
          $result[$projectKey][$week]=$valProj;
        }
      }
// ProjectRepartition - end
    }
    return $result;
  }
  
  public function getAffectationRate($idProject) {
    $result="";
    $crit=array('idResource'=>$this->id, 'idProject'=>$idProject);
    $aff=SqlElement::getSingleSqlElementFromCriteria('Affectation',$crit);
    if ($aff->rate) {
      $result=$aff->rate;
    } else {
      $prj=new Project($idProject);
      if ($prj->idProject) {
        $result=$this->getAffectationRate($prj->idProject);
      } else {
        $result='100';
      }
    }
    return $result;
  }
/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    if ($this->isUser and (! $this->userName or $this->userName=="")) {
      $result.='<br/>' . i18n('messageMandatory',array(i18n('colUserName')));
    } 
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public function save() {
  	$result=parent::save();
    if (! strpos($result,'id="lastOperationStatus" value="OK"')) {
      return $result;     
    }
  	Affectation::updateAffectations($this->id);
  	return $result;
  }
  
  public function getResourceCost() {
    $result=array();
    $rc=new ResourceCost();
    $crit=array('idResource'=>$this->id);
    $rcList=$rc->getSqlElementsFromCriteria($crit, false, null, 'idRole, startDate');
    return $rcList;
  }
  public function getActualResourceCost($idRole=null) {
    if (! $this->id) return null;
    if (! $idRole) $idRole=$this->idRole;
    $where="idResource='" . $this->id . "'";
    if ($idRole) {
      $where.= " and idRole='" . $idRole . "'";
    }
    $where.= " and endDate is null";
    $rc=new ResourceCost();
    $rcL = $rc->getSqlElementsFromCriteria(null, false, $where, "startDate desc");
    if (count($rcL)>=1) {
      return $rcL[0]->cost;
    }
    return null;
  }  

  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   *    - subprojects => presents sub-projects as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    $result="";
    if ($item=='affectations') {
      $aff=new Affectation();
      $critArray=array('idResource'=>(($this->id)?$this->id:'0'),'idle'=>'0');
      $affList=$aff->getSqlElementsFromCriteria($critArray, false);
      drawAffectationsFromObject($affList, $this, 'Project', false);   
      return $result;
    }
  }
  
  public function deleteControl() {
    
  	$result="";
    if ($this->isUser) {   	
	    $crit=array("name"=>"menuUser");
	    $menu=SqlElement::getSingleSqlElementFromCriteria('Menu', $crit);
	    if (! $menu) {
	      return;
	    }     
	    if (! securityCheckDisplayMenu($menu->id)) {
	      $result="<br/>" . i18n("msgCannotDeleteResource");
	    }     	    	
    }
    if (! $result) {	
      $result=parent::deleteControl();
    }
    return $result;
  }
  
  public function drawMemberList($team) {
    $result="<table>";
    $crit=array('idTeam'=>$team);
    $resList=$this->getSqlElementsFromCriteria($crit, false);
    foreach ($resList as $res) {
      $result.= '<tr><td valign="top" width="20px"><img src="css/images/iconList16.png" height="16px" /></td><td>';
      $result.=htmlDrawLink($res);
      $result.='</td></tr>';
    }
    $result .="</table>";
    return $result; 
  }
  
}
?>