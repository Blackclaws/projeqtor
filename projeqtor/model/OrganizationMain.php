<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ============================================================================
 * Project is the main object of the project managmement.
 * Almost all other objects are linked to a given project.
 */ 
require_once('_securityCheck.php');
class OrganizationMain extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_sec_Description;
  public $id;    // redefine $id to specify its visible place
  public $name;
  public $idOrganizationType;
  public $idResource;
  public $idUser;
  public $creationDate;
  public $lastUpdateDateTime;
  public $idle;
  public $description;
  public $_sec_Progress;
  public $OrganizationPlanningElement; // is an object

  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();

  // hidden
  public $sortOrder;
  public $_nbColMax=3;
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="wbsSortable" from="OrganizationPlanningElement" formatter="sortableFormatter" width="10%" >${wbs}</th>
    <th field="name" width="65%" >${projectName}</th>
    <th field="nameOrganizationType" width="20%" >${type}</th>
    ';
// Removed in 1.2.0 
//     <th field="wbs" from="ProjectPlanningElement" width="5%" >${wbs}</th>
// Removed in 2.0.1
//  <th field="nameRecipient" width="10%" >${idRecipient}</th>
  

  private static $_fieldsAttributes=array("name"=>"required",                                   
                                  "sortOrder"=>"hidden",
                                  "idOrganizationType"=>"required",
                                  "longitude"=>"hidden", "latitude"=>"hidden",
                                  "idStatus"=>"required",
                                  "idleDate"=>"nobr",
                                  "cancelled"=>"nobr"
  );   
 
  private static $_colCaptionTransposition = array('idResource'=>'manager',
   'idProject'=> 'isSubProject',
   'idProjectType'=>'type',
   'idContact'=>'billContact',
   'idUser'=>'issuer');

  private static $_subProjectList=array();
  private static $_subProjectFlatList=array();
  private static $_drawSubProjectsDone=array();
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
  	parent::__construct($id,$withoutDependentObjects);
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
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
  }  

    /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);

 
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Recusively retrieves all the hierarchic sub-projects of the current project
   * @return an array containing id, name, subprojects (recursive array)
   */

  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   *    - subprojects => presents sub-projects as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    $result="";
     return $result;
  }
  


   /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {	
    $old=$this->getOld();
    $this->recalculateCheckboxes();
    if (!$this->id) {
      //$this->isUnderConstruction=1; // Will post this later...
    }
    if(SqlList::getFieldFromId("Status", $this->idStatus, "setHandledStatus")!=0) {
      $this->isUnderConstruction=0;
    }
    //$old=$this->getOld();
    //$oldtype=new ProjectType($old->idProjectType);
    $type=new ProjectType($this->idProjectType);
    
    $noMoreAdministrative=false;
    if ($this->codeType=='ADM' and $type->code!='ADM') {
    	$noMoreAdministrative=true;
    }
    $this->codeType=$type->code;
    
    $this->ProjectPlanningElement->refName=$this->name;
    $this->ProjectPlanningElement->idProject=$this->id;
    $this->ProjectPlanningElement->idle=$this->idle;
    $this->ProjectPlanningElement->done=$this->done;
    $this->ProjectPlanningElement->cancelled=$this->cancelled;
    if ($this->idProject and trim($this->idProject)!='') {
      $this->ProjectPlanningElement->topRefType='Project';
      $this->ProjectPlanningElement->topRefId=$this->idProject;
      $this->ProjectPlanningElement->topId=null;
    } else {
      $this->ProjectPlanningElement->topId=null;
      $this->ProjectPlanningElement->topRefType=null;
      $this->ProjectPlanningElement->topRefId=null;
    }
    if (trim($this->idProject)!=trim($old->idProject)) {    	
      $this->ProjectPlanningElement->wbs=null;
      $this->ProjectPlanningElement->wbsSortable=null;
      $this->sortOrder=null;
    }
    // Initialize user->_visibleProjects, to force recalculate
    $result = parent::save();
    if (! strpos($result,'id="lastOperationStatus" value="OK"')) {
      return $result;     
    } 
    if (! $old->id or $this->idle!=$old->idle or $this->idProject!=$old->idProject) {
    	if ($old->idProject) {
        User::resetAllVisibleProjects($this->id, null);
    	} else {
    		User::resetAllVisibleProjects(null, null);
    	}
    	
    }
    if ($this->idle) {
      $crit=array('idProject'=>$this->id, 'idle'=>'0');
      $vp=new VersionProject();
      $vpLst=$vp->getSqlElementsFromCriteria($crit, false);
      foreach ($vpLst as $vp) {
        $vp->idle=$this->idle;
        $vp->save();
      }
    }
    // Create affectation for Manager.
    if ($this->idUser) {
      if (securityGetAccessRight('menuProject', 'update', null)!="ALL"){
        $id=($this->id)?$this->id:Sql::$lastQueryNewid;
        $crit=array('idProject'=>$id, 'idResource'=>$this->idUser);
        $aff=SqlElement::getSingleSqlElementFromCriteria('Affectation', $crit);
        if ( ! $aff or ! $aff->id) {
        	$aff=new Affectation();
        	$aff->_automaticCreation=true;
        	$aff->idResource=$this->idUser;
        	$aff->idProject=$id;
        	$aff->idProfile=getSessionUser()->idProfile;
        	if (securityGetAccessRightYesNo('menuProject', 'update', null, getSessionUser()) != "YES") {
        	  $crit=array('idProject'=>$this->idProject, 'idResource'=>$this->idUser);
        	  $affTop=SqlElement::getSingleSqlElementFromCriteria('Affectation', $crit);
        	  $aff->idProfile=$affTop->idProfile;
        	}
        	$resAff=$aff->save();
        } else if (! $this->idle and $aff->idle) {
          $aff->_automaticCreation=true;
        	$aff->idle=0;
        	$resAff=$aff->save();
        }
      }
    }

    if ($this->idle) {
      Affectation::updateIdle($this->id, null);
    }
    if ($noMoreAdministrative) {
    	 $ass=new Assignment();
    	 $lstAss=$ass->getSqlElementsFromCriteria(array('idProject'=>$this->id));
    	 foreach ($lstAss as $ass) {
    	 	 if ($ass->realWork==0 and $ass->leftWork==0) {
    	 	 	 $ass->delete();
    	 	 }
    	 }
    }
    //parent::save(); // DANGER : must not save again, would erase updates from PlanningElement (sortOrder)
    return $result; 

  }
  public function delete() {
    User::resetAllVisibleProjects($this->id,null);
  	$result = parent::delete();
    return $result;
  }
  
  // Ticket #1175
  public function updateValidatedWork() {
  	if (! $this->id) return;
	  $lst=null;
  	$sumValidatedWork=0;
  	$sumValidatedCost=0;
  	$order=new Command();
  	$lst=$order->getSqlElementsFromCriteria(array('idProject'=>$this->id, 'cancelled'=>'0'));
  	foreach ($lst as $item) { 		
  		$sumValidatedWork+=$item->validatedWork;
  		$sumValidatedCost+=$item->totalUntaxedAmount;
  	}
  	
  	$lst=null;
  	$prj=new Project();
  	$queryWhere='refType=\'Project\' and refId in (SELECT id FROM ' . $prj->getDatabaseTableName() . ' WHERE idProject=' . $this->id . ' and cancelled=0)';
  	
  	$prj=new ProjectPlanningElement();
  	$lst=$prj->getSqlElementsFromCriteria(array(), false, $queryWhere);
  	foreach ($lst as $item) {
  		$sumValidatedWork+=$item->validatedWork;
  		$sumValidatedCost+=$item->validatedCost;
  	}

  	$this->ProjectPlanningElement->validatedWork=$sumValidatedWork;
  	$this->ProjectPlanningElement->validatedCost=$sumValidatedCost;
  	$this->save();
  	
  	if (trim($this->idProject)!='') {
  		$prj=new Project($this->idProject);
  		$prj->updateValidatedWork();
  	}
  }
  // Ticket END
  
/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    if ($this->id and $this->id==$this->idProject) {
      $result.='<br/>' . i18n('errorHierarchicLoop');
    } else if ($this->ProjectPlanningElement and $this->ProjectPlanningElement->id){
      $parent=SqlElement::getSingleSqlElementFromCriteria('PlanningElement',array('refType'=>'Project','refId'=>$this->idProject));
      $parentList=$parent->getParentItemsArray();
      if (array_key_exists('#' . $this->ProjectPlanningElement->id,$parentList)) {
        $result.='<br/>' . i18n('errorHierarchicLoop');
      }
    }
    
    if ($this->longitude!=null and $this->latitude!=null) {
      if ($this->longitude > 180 || $this->longitude < -180 || $this->latitude < -90 || $this->latitude > 90) {
        $result = i18n('invalidGpsData');
      }
    }
    
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public static function getAdminitrativeProjectList($returnResultAsArray=false) {
  	$arrayProj=array();
  	$arrayProj[]=0;
  	$type=new ProjectType();
  	$critType=array('code'=>'ADM');
  	$listType=$type->getSqlElementsFromCriteria($critType, false);
  	foreach ($listType as $type) {
  	  $proj=new Project(); 
  		$critProj=array('idProjectType'=>$type->id);
      $listProj=$proj->getSqlElementsFromCriteria($critProj, false);
      foreach ($listProj as $proj) {
      	$arrayProj[$proj->id]=$proj->id;
      }
  	}
  	if ($returnResultAsArray) return $arrayProj;
  	return '(' . implode(', ',$arrayProj) . ')';
  }

  public static function getFixedProjectList($returnResultAsArray=false) {
    $arrayProj=array();
    $arrayProj[]=0;
    $proj=new Project(); 
    $critProj=array('fixPlanning'=>'1', 'idle'=>'0');
    $listProj=$proj->getSqlElementsFromCriteria($critProj, false);
    foreach ($listProj as $proj) {
      $arrayProj[]=$proj->id;
      $sublist=$proj->getRecursiveSubProjectsFlatList(true);
      if ($sublist and count($sublist)>0) {
        foreach($sublist as $subId=>$subName) {
          $arrayProj[]=$subId;
        }
      }
    }
    if ($returnResultAsArray) return $arrayProj;
    return '(' . implode(', ',$arrayProj) . ')';
  }
  
  public function getColor() {
    $color=null;
    if ($this->color) {
      $color=$this->color;
    } else if ($this->idProject) {
      $top=new Project($this->idProject);
      $color=$top->getColor();
    }
    return $color;
  }
  
  public static function getTemplateList() {
    $result=array();
    $types=SqlList::getListWithCrit('ProjectType',array('code'=>'TMP'));
    foreach($types as $typId=>$typName) {
      $projects=SqlList::getListWithCrit('Project', array('idProjectType'=>$typId));
      $result=array_merge_preserve_keys($result,$projects);
    }
    return $result;
  }
  public static function getTemplateInClauseList() {
    $list=self::getTemplateList();
    $in='(0';
    foreach ($list as $id=>$name) {
      $in.=','.$id;
    }
    $in.=')';
    return $in;
  }

  
}
?>