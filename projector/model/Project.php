<?php 
/** ============================================================================
 * Project is the main object of the project managmement.
 * Almost all other objects are linked to a given project.
 */ 
class Project extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $description;
  public $idClient;
  public $projectCode;
  public $contractCode;
  public $idProject;
  public $idUser;
  public $color;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $_col_2_2_Subprojects;
  public $_spe_subprojects;
  public $_col_1_1_Progress;
  public $ProjectPlanningElement; // is an object
  public $_col_1_2_predecessor;
  public $_Dependency_Predecessor=array();
  public $_col_2_2_successor;
  public $_Dependency_Successor=array();
  


  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
     <th field="wbsSortable" from="ProjectPlanningElement" width="5%" >${wbs}</th>
    <th field="name" width="25%" >${projectName}</th>
    <th field="color" width="5%" formatter="colorFormatter">${color}</th>
    <th field="projectCode" width="15%" >${projectCode}</th>
    <th field="nameClient" width="15%" >${clientName}</th>
    <th field="validatedEndDate" from="ProjectPlanningElement" width="10%" formatter="dateFormatter">${validatedEnd}</th>
    <th field="plannedEndDate" from="ProjectPlanningElement" width="10%" formatter="dateFormatter">${plannedEnd}</th>  
    <th field="done" width="5%" formatter="booleanFormatter" >${done}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';
// Removed in 1.2.0 
//     <th field="wbs" from="ProjectPlanningElement" width="5%" >${wbs}</th>

  private static $_fieldsAttributes=array("name"=>"required", 
                                  "description"=>"required",
                                  "done"=>"nobr",
                                  "idle"=>"nobr"
  );   
 
  private static $_colCaptionTransposition = array('idUser'=>'manager',
   'idProject'=> 'isSubProject');
  
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
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld) {
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

    if ($colName=="idle") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("idleDate").value==null) {';
      $colScript .= '      var curDate = new Date();';
      $colScript .= '      dijit.byId("idleDate").set("value", curDate); ';
      $colScript .= '    }';
      $colScript .= '    if (! dijit.byId("done").get("checked")) {';
      $colScript .= '      dijit.byId("done").set("checked", true);';
      $colScript .= '    }';  
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("idleDate").set("value", null); ';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="done") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("doneDate").value==null) {';
      $colScript .= '      var curDate = new Date();';
      $colScript .= '      dijit.byId("doneDate").set("value", curDate); ';
      $colScript .= '    }';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("doneDate").set("value", null); ';
      $colScript .= '    if (dijit.byId("idle").get("checked")) {';
      $colScript .= '      dijit.byId("idle").set("checked", false);';
      $colScript .= '    }'; 
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="idProject") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  dijit.byId("ProjectPlanningElement_wbs").set("value", null); ';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="idStatus") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= htmlGetJsTable('Status', 'setIdleStatus', 'tabStatusIdle');
      $colScript .= htmlGetJsTable('Status', 'setDoneStatus', 'tabStatusDone');
      $colScript .= '  var setIdle=0;';
      $colScript .= '  var filterStatusIdle=dojo.filter(tabStatusIdle, function(item){return item.id==dijit.byId("idStatus").value;});';
      $colScript .= '  dojo.forEach(filterStatusIdle, function(item, i) {setIdle=item.setIdleStatus;});';
      $colScript .= '  if (setIdle==1) {';
      $colScript .= '    dijit.byId("idle").set("checked", true);';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("idle").set("checked", false);';
      $colScript .= '  }';
      $colScript .= '  var setDone=0;';
      $colScript .= '  var filterStatusDone=dojo.filter(tabStatusDone, function(item){return item.id==dijit.byId("idStatus").value;});';
      $colScript .= '  dojo.forEach(filterStatusDone, function(item, i) {setDone=item.setDoneStatus;});';
      $colScript .= '  if (setDone==1) {';
      $colScript .= '    dijit.byId("done").set("checked", true);';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("done").set("checked", false);';
      $colScript .= '  }';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';     
    }
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Retrieves the hierarchic sub-projects of the current project
   * @return an array of Projects as sub-projects
   */
  public function getSubProjects($limitToActiveProjects=false) {
    if ($this->id==null or $this->id=='') {
      return array();
    }
    if ($this->id=='*') {
      $this->id=null;
    }
    $crit=array('idProject'=>$this->id);
    if ($limitToActiveProjects) {
      $crit['idle']='0';
    }
    $subProjects=$this->getSqlElementsFromCriteria($crit, false) ;
    return $subProjects;
  }

  /** ==========================================================================
   * Recusively retrieves all the hierarchic sub-projects of the current project
   * @return an array containing id, name, subprojects (recursive array)
   */
  public function getRecursiveSubProjects($limitToActiveProjects=false) {
    $crit=array('idProject'=>$this->id);
    if ($limitToActiveProjects) {
      $crit['idle']='0';
    }
    $obj=new Project();
    $subProjects=$obj->getSqlElementsFromCriteria($crit, false) ;
    $subProjectList=null;
    foreach ($subProjects as $subProj) {
      $recursiveList=null;
      $recursiveList=$subProj->getRecursiveSubProjects($limitToActiveProjects);
      $arrayProj=array('id'=>$subProj->id, 'name'=>$subProj->name, 'subItems'=>$recursiveList);
      $subProjectList[]=$arrayProj;
    }
    return $subProjectList;
  }
  
  /** ==========================================================================
   * Recusively retrieves all the sub-projects of the current project
   * and presents it as a flat array list of id=>name
   * @return an array containing the list of subprojects as id=>name
   * 
   */
  public function getRecursiveSubProjectsFlatList($limitToActiveProjects=false, $includeSelf=false) {
    $tab=$this->getRecursiveSubProjects($limitToActiveProjects);
    $list=array();
    if ($includeSelf) {
      $list[$this->id]=$this->name;
    }
    if ($tab) {
      foreach($tab as $subTab) {
        $id=$subTab['id'];
        $name=$subTab['name'];
        $list[$id]=$name;
        $subobj=new Project();
        $subobj->id=$id;
        $sublist=$subobj->getRecursiveSubProjectsFlatList($limitToActiveProjects);
        if ($sublist) {
          $list=array_merge_preserve_keys($list,$sublist);
        }
      }
    }
    return $list;
  }

  
  public function getTopProjectList($includeSelf=false) {
    if ($includeSelf) {
      return array_merge(array($this->id),$this->getTopProjectList(false));
    }
    if (! $this->idProject) {
      return array();
    } else {
      $topProj=new Project($this->idProject);
      $topList=$topProj->getTopProjectList();
      $result=array_merge(array($this->idProject),$topList);
      return $result;
    }
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
    if ($item=='subprojects') {
      $result .="<table><tr><td class='label' valign='top'><label>" . i18n('subProjects') . "&nbsp;:&nbsp;</label>";
      $result .="</td><td>";
      $result .= $this->drawSubProjects();
      $result .="</td></tr></table>";
      return $result;
    } 
  }

  /** =========================================================================
   * Specific function to draw a recursive tree for subprojects
   * @return the html table for the given level of subprojects
   *  must be redefined in the inherited class
   */  
  public function drawSubProjects($selectField=null, $recursiveCall=false, $limitToUserProjects=false, $limitToActiveProjects=false) {
    if ($limitToUserProjects) {
      $user=$_SESSION['user'];
      if (! $user->_accessControlVisibility) {
        $user->getAccessControlRights(); // Force setup of accessControlVisibility
      }      
      $visibleProjectsList=$user->getHierarchicalViewOfVisibleProjects();
      $reachableProjectsList=$user->getVisibleProjects();
    } else {  
      $visibleProjectsList=array();
      $reachableProjectsList=array();
    }
    $result="";
    $subList=$this->getSubProjects($limitToActiveProjects);
    if ($selectField!=null and ! $recursiveCall) {
      $result .= '<table><tr><td colspan="20"><div dojoType="dijit.form.TextBox" class="menuTree" readonly value="' . i18n('allProjects') . '" >';
      $result .= ' <script type="dojo/connect" event="onClick" args="evt">';
      $result .= '  dijit.byId("' . $selectField . '").set("label","<i>' . i18n('allProjects') . '</i>");';
      $result .= '  setSelectedProject("*", "' . i18n('allProjects') . '", "' . $selectField . '");'; 
      $result .= '  dijit.byId("' . $selectField . '").closeDropDown();';
      $result .= ' </script>';
      $result .= '</div></td></tr></table>';
    }
    $result .='<table >';
    if (count($subList)>0) {
      foreach ($subList as $prj) {
        $showLine=true;
        $reachLine=true;
        if ($limitToUserProjects) {
          if ($user->_accessControlVisibility != 'ALL') {
            if (! array_key_exists('#' . $prj->id,$visibleProjectsList)) {
              $showLine=false;
            }
            if (! array_key_exists($prj->id,$reachableProjectsList)) {
              $reachLine=false;
            }
          }
        }
        if ($showLine) {
          $result .='<tr><td valign="top" width="20px"><img src="css/images/iconList16.png" height="16px" /></td>';
          if ($selectField==null) {
            $result .= '<td class="display" style="width: 100%;" NOWRAP>' . $prj->name;
          } else if (! $reachLine) {
            $result .= '<td class="display" style="width: 100%; color: #AAAAAA;" NOWRAP>' . $prj->name;
          } else {
            $result .= '<td><div dojoType="dijit.form.TextBox" class="menuTree" readonly value="' . htmlEncode($prj->name) . '" >';
            $result .= ' <script type="dojo/connect" event="onClick" args="evt">';
            $result .= '  dijit.byId("' . $selectField . '").set("label","' . htmlEncode($prj->name) . '");';
            $result .= '  setSelectedProject("' . $prj->id . '", "' . htmlEncode($prj->name) . '", "' . $selectField . '");'; 
            $result .= '  dijit.byId("' . $selectField . '").closeDropDown();';
            $result .= ' </script>';
            $result .= '</div>';
          }
          $result .= $prj->drawSubProjects($selectField,true,$limitToUserProjects,$limitToActiveProjects);
          $result .= '</td></tr>';
        }
      }
    }
    $result .='</table>';
    return $result;
  }

  /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {
    $this->ProjectPlanningElement->refName=$this->name;
    $this->ProjectPlanningElement->idProject=$this->id;
    $this->ProjectPlanningElement->idle=$this->idle;
    $this->ProjectPlanningElement->done=$this->done;
    if ($this->idProject and trim($this->idProject)!='') {
      $this->ProjectPlanningElement->topRefType='Project';
      $this->ProjectPlanningElement->topRefId=$this->idProject;
      $this->ProjectPlanningElement->topId='';
    } else {
      $this->ProjectPlanningElement->topId=null;
      $this->ProjectPlanningElement->topRefType=null;
      $this->ProjectPlanningElement->topRefId=null;
    }
    // Initialize user->_visibleProjects, to force recalculate
    if (array_key_exists('user',$_SESSION)) {
      $user=$_SESSION['user'];
      $user->resetVisibleProjects();
      $_SESSION['user']=$user;
    }
    return parent::save();
  }
  
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
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
}
?>