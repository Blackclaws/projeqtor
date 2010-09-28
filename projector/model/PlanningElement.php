<?php
/* ============================================================================
 * Planning element is an object included in all objects that can be planned.
 */ 
class PlanningElement extends SqlElement {

  public $id;
  public $idProject;
  public $refType;
  public $refId;
  public $refName;
  public $initialStartDate;
  public $validatedStartDate;
  public $plannedStartDate;
  public $realStartDate;
  public $initialEndDate;
  public $validatedEndDate;
  public $plannedEndDate;
  public $realEndDate;
  public $initialDuration;
  public $validatedDuration;
  public $plannedDuration;
  public $realDuration;
  public $initialWork;
  public $validatedWork;
  public $assignedWork;
  public $plannedWork;
  public $leftWork;
  public $realWork;
  public $wbs;
  public $wbsSortable;
  public $topId;
  public $topRefType;
  public $topRefId;
  public $priority;
  public $elementary;
  public $idle;
  public $done;
  public $idPlanningMode;

  private static $_fieldsAttributes=array(
                                  "id"=>"hidden",
                                  "refType"=>"hidden",
                                  "refId"=>"hidden",
                                  "refName"=>"hidden",
                                  "wbs"=>"hidden", 
                                  "wbsSortable"=>"hidden",
                                  "topType"=>"hidden",
                                  "topId"=>"hidden",
                                  "topRefType"=>"hidden",
                                  "topRefId"=>"hidden",
                                  "idProject"=>"hidden",
                                  "idle"=>"hidden",
                                  "done"=>"hidden",
                                  "plannedStartDate"=>"readonly",
                                  "plannedEndDate"=>"readonly",
                                  "plannedDuration"=>"readonly",
                                  "plannedWork"=>"readonly",
                                  "realStartDate"=>"readonly",
                                  "realEndDate"=>"readonly",
                                  "realDuration"=>"readonly",
                                  "realWork"=>"readonly",
                                  "elementary"=>"hidden",
                                  "idPlanningMode"=>"hidden"
  );   
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
    $colScript = parent::getValidationScript($colName);
    $rubr=""; $name="";
    $test = 'initial';
    $pos = stripos( $colName, $test);
    if ($pos!==false) { 
      $rubr=$test; $name=substr($colName,$pos+strlen($test));
    } else {
      $test = 'validated';
      $pos = stripos( $colName, $test);
      if ($pos!==false) { 
        $rubr=$test; $name=substr($colName,$pos+strlen($test));
      } else {
        $test = 'planned';
        $pos = stripos( $colName, $test);
        if ($pos!==false) { 
          $rubr=$test; $name=substr($colName,$pos+strlen($test));      
        } else {
          $test = 'real';
          $pos = stripos( $colName, $test);
          if ($pos!==false) { 
            $rubr=$test; $name=substr($colName,$pos+strlen($test));
          }
        }
      }
    }
   
    if ($name=="StartDate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (testAllowedChange(this.value)) {';
      $colScript .= '    var startDate=this.value;';
      $colScript .= '    var endDate=dijit.byId("' . get_class($this) . '_' . $rubr . 'EndDate").value;';
      $colScript .= '    var duration=workDayDiffDates(startDate, endDate);';
      $colScript .= '    dijit.byId("' . get_class($this) . '_' . $rubr . 'Duration").attr("value",duration);';
      $colScript .= '    terminateChange();';
      $colScript .= '    formChanged();';
      $colScript .= '  }';
      $colScript .= '</script>';
    } else if ($name=="EndDate") { // Not to do any more for end date (not managed this way) ???? Reactivted !
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (testAllowedChange(this.value)) {';    
      $colScript .= '    var endDate=this.value;';
      $colScript .= '    var startDate=dijit.byId("' . get_class($this) . '_' . $rubr . 'StartDate").value;';
      $colScript .= '    var duration=workDayDiffDates(startDate, endDate);';
      $colScript .= '    dijit.byId("' . get_class($this) . '_' . $rubr . 'Duration").attr("value",duration);';
      if ($rubr=="real") {
        $colScript .= '   if (dijit.byId("idle")) { ';
        $colScript .= '     if ( endDate!=null && endDate!="") {';
        $colScript .= '       dijit.byId("idle").attr("checked", true);';
        $colScript .= '     } else {';
        $colScript .= '       dijit.byId("idle").attr("checked", false);';
        $colScript .= '     }';
        $colScript .= '   }';
      }
      $colScript .= '    terminateChange();';
      $colScript .= '    formChanged();';
            $colScript .= '  }';   
      $colScript .= '</script>';
    } else if ($name=="Duration") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  var value=dijit.byId("' . get_class($this) . '_' . $rubr . 'Duration");';
      $colScript .= '  if (testAllowedChange(value)) {';
      $colScript .= '    var duration=(value==null || value=="")?"":parseInt(value.attr("value"));';
      $colScript .= '    var startDate=dijit.byId("' . get_class($this) . '_' . $rubr . 'StartDate").attr("value");';
      //$colScript .= 'alert("test Duration:" + startDate);';
      $colScript .= '    var endDate=dijit.byId("' . get_class($this) . '_' . $rubr . 'EndDate").attr("value");';
      $colScript .= '    if (duration!=null && duration!="") {';
      $colScript .= '      if (startDate!=null && startDate!="") {';
      $colScript .= '        endDate = addWorkDaysToDate(startDate,duration);';
      $colScript .= '        dijit.byId("' . get_class($this) . '_' . $rubr . 'EndDate").attr("value",endDate);';
      //$colScript .= '      } else if (endDate!=null){';
      //$colScript .= '        startDate= addworkDaysToDate(endDate,"day", duration * (-1));';
      //$colScript .= '        dijit.byId("' . get_class($this) . '_' . $rubr . 'StartDate").attr("value",startDate);';
      $colScript .= '      }';
      $colScript .= '    }';
      $colScript .= '    terminateChange();';
      $colScript .= '    formChanged();';
      $colScript .= '  }';
      $colScript .= '</script>';
    }    
    return $colScript;
  }
    
  /** ==========================================================================
   * Extends save functionality to implement wbs calculation
   * Triggers parent::save() to run defaut functionality in the end.
   * @return the result of parent::save() function
   */
  public function save() {
    // Get old element (stored in database) : must be fetched before saving
    $old=new PlanningElement($this->id);

    // If done and no work, set up end date
    if ( $this->done and $this->leftWork==0 and $this->realWork==0 ) {
      $refObj=new $this->refType($this->refId);
      if (property_exists($refObj, 'doneDate')) {
        $this->realEndDate=$refObj->doneDate;
      }
    }
    
    // update topId if needed
    $topElt=null;
    if ( (! $this->topId or trim($this->topId)=='') and ( $this->topRefId and trim($this->topRefId)!='') ) {
      $crit=array("refType"=>$this->topRefType, "refId"=>$this->topRefId);
      $topElt=SqlElement::getSingleSqlElementFromCriteria('PlanningElement',$crit);
      if ($topElt) {
        $this->topId=$topElt->id;
        $topElt->elementary=0;        
      }
    }
    
    // calculate wbs
    $dispatchNeeded=false;
    $wbs="";
    $crit='';
    if (! $this->wbs or trim($this->wbs)=='') {
      //if ( $this->topId and trim($this->topId)!='') {
      if ($topElt) {
        //$elt=new PlanningElement($this->topId);
        $wbs=$topElt->wbs . ".";
        $crit=" topId='" . $this->topId . "' ";
      } else {
        $crit=" (topId is null or topId='') ";
      }
      $crit.=" and id!='" . $this->id . "' ";
      $lst=$this->getSqlElementsFromCriteria(null, null, $crit, 'wbsSortable desc');
      if (count($lst)==0) {
        $localSort=1;
      } else {
        if ( !$lst[0]->wbsSortable or $lst[0]->wbsSortable=='') {
          $localSort=1;
        } else {
          $localSort=substr($lst[0]->wbsSortable,-3,3)+1;
        }
      }
      $wbs.=$localSort;
      $this->wbs=$wbs;
      $dispatchNeeded=true;
    }
    $wbsSortable=formatSortableWbs($this->wbs);
    if ($wbsSortable != $this->wbsSortable) {
      $dispatchNeeded=true;
    }
    $this->wbsSortable=$wbsSortable;
    // search for dependant elements
    $crit=" topId='" . $this->id . "'";
    $lstElt=$this->getSqlElementsFromCriteria(null, null, $crit ,'wbsSortable asc');
    if ($lstElt and count($lstElt)>0) {
      $this->elementary=0;
    } else {
      $this->elementary=1;
    }
    if (! $this->priority or $this->priority==0) {
      $this->priority=500; // default value for priority
    }
    
    $this->realDuration=workDayDiffDates($this->realStartDate, $this->realEndDate);
    $this->plannedDuration=workDayDiffDates($this->plannedStartDate, $this->plannedEndDate);
    $this->validatedDuration=workDayDiffDates($this->validatedStartDate, $this->validatedEndDate);
    $this->initialDuration=workDayDiffDates($this->initialStartDate, $this->initialEndDate);
    
    $result=parent::save();

    // Update dependant objects
    if ($dispatchNeeded) {
      $cpt=0;
      foreach ($lstElt as $elt) {
        $cpt++;
        $elt->wbs=$this->wbs . '.' . $cpt;
        $elt->save();
        // TODO : check result to return error message in case of error
      }
    }
    
    // update topObject
    if ($topElt) {
        $topElt->save();    
    }
    
    // save old parent (for synthesis update) if parent has changed
    if ($old->topId!='' and $old->topId!=$this->topId) {
      $this->updateSynthesis($old->topRefType, $old->topRefId);
    }
    // save new parent (for synthesis update) if parent has changed
    if ($this->topId!='' and $old->topId!=$this->topId) {
      $this->updateSynthesis($this->topRefType, $this->topRefId);
    }       
    
    return $result;
  }

    /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
   /** =========================================================================
   * Update the synthesis Data (work).
   * Called by sub-element (assignment, ...) 
   * @param $col the nale of the property
   * @return a boolean 
   */
  private function updateSynthesisObj () {
    $assignedWork=0;
    $leftWork=0;
    $plannedWork=0;
    $realWork=0;
    $this->_noHistory=true;
    // Add data from assignments directly linked to this item
    $critAss=array("refType"=>$this->refType, "refId"=>$this->refId);
    $assignment=new Assignment();
    $assList=$assignment->getSqlElementsFromCriteria($critAss, false);
    $realStartDate=null;
    $realEndDate=null;
    $plannedStartDate=null;
    $plannedEndDate=null;
    foreach ($assList as $ass) {
      $assignedWork+=$ass->assignedWork;
      $leftWork+=$ass->leftWork;
      $plannedWork+=$ass->plannedWork;
      $realWork+=$ass->realWork;
      if ( $ass->realStartDate and (! $realStartDate or $ass->realStartDate<$realStartDate )) {
        $realStartDate=$ass->realStartDate;
      }
      if ( $ass->realEndDate and (! $realEndDate or $ass->realEndDate>$realEndDate )) {
        $realEndDate=$ass->realEndDate;
      }
      if ( $ass->plannedStartDate and (! $plannedStartDate or $ass->plannedStartDate<$plannedStartDate )) {
        $plannedStartDate=$ass->plannedStartDate;
      }
      if ( $ass->plannedEndDate and (! $plannedEndDate or $ass->plannedEndDate>$plannedEndDate )) {
        $plannedEndDate=$ass->plannedEndDate;
      }      
    }
    // Add data from other planningElements dependant from this one
    if (! $this->elementary) {
      $critPla=array("topId"=>$this->id);
      $planningElement=new PlanningElement();
      $plaList=$planningElement->getSqlElementsFromCriteria($critPla, false);
      // Add data from other planningElements dependant from this one    
      foreach ($plaList as $pla) {
        $assignedWork+=$pla->assignedWork;
        $leftWork+=$pla->leftWork;
        $plannedWork+=$pla->plannedWork;
        $realWork+=$pla->realWork;
        if ( $pla->realStartDate and (!$this->realStartDate or $pla->realStartDate<!$this->realStartDate )) {
          $realStartDate=$pla->realStartDate;
        }
        if ( $pla->realEndDate and (!$this->realEndDate or $pla->realEndDate>!$this->realEndDate )) {
          $realEndDate=$pla->realEndDate;
        }  
        if ( $pla->plannedStartDate and (!$this->plannedStartDate or $pla->plannedStartDate<$this->plannedStartDate )) {
          $plannedStartDate=$pla->plannedStartDate;
        }
        if ( $pla->plannedEndDate and (!$this->plannedEndDate or $pla->plannedEndDate>$this->plannedEndDate )) {
          $plannedEndDate=$pla->plannedEndDate;
        }                
      }
    }
    $this->realStartDate=$realStartDate;
    if ($realWork>0 or $leftWork>0) {
      if ($leftWork==0) {
        $this->realEndDate=$realEndDate;
      } else {
        $this->realEndDate=null;
      }
    }
    $this->plannedStartDate=$plannedStartDate;
    if ($plannedStartDate and $realStartDate and $realStartDate<$plannedStartDate) {
      $this->plannedStartDate=$realStartDate;
    }
    $this->plannedEndDate=$plannedEndDate;
    // save cumulated data
    $this->assignedWork=$assignedWork;
    $this->leftWork=$leftWork;
    $this->plannedWork=$plannedWork;
    $this->realWork=$realWork;
    $this->save();
    // Dispath to top element
    if ($this->topId) {
        self::updateSynthesis($this->topRefType, $this->topRefId);
    }
    
  }
  
   /** =========================================================================
   * Update the synthesis Data (work).
   * Called by sub-element (assignment, ...) 
   * @param $col the nale of the property
   * @return a boolean 
   */
  public static function updateSynthesis ($refType, $refId) {
    $crit=array("refType"=>$refType, "refId"=>$refId);
    $obj=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', $crit);
    if ($obj) {
      return $obj->updateSynthesisObj();
    }
  } 
  
    /**
   * Delete object 
   * @see persistence/SqlElement#save()
   */
  public function delete() { 
    // Delete existing Assignment
    $critAss=array("refType"=>$this->refType, "refId"=>$this->refId);
    $assignment=new Assignment();
    $assList=$assignment->getSqlElementsFromCriteria($critAss, false);
    foreach ($assList as $ass) {
      $ass->delete();
    }
    $refType=$this->topRefType;
    $refId=$this->topRefId;
    $result = parent::delete();
    if ($refId) {
        //self::updateSynthesis($this->topRefType, $this->topRefId);
        self::updateSynthesis($refType, $refId);
    }
    
    // Dispatch value
    return $result;
   
  }
  
 /** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    //echo "xxx";
    $result="";
    if ($this->idle and $this->leftWork>0) {
      //echo "yyy";
      $result.='<br/>' . i18n('errorIdleWithLeftWork');
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
  
  public function getParentItemsArray() {
    $elt=new $this->refType($this->refId);
    $result=array();
    if (property_exists($elt,'idActivity') and $elt->idActivity) {
      $crit=array('refType'=>'Activity', 'refId'=>$elt->idActivity);
      $parent=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', $crit);
      if ($parent->id and ! array_key_exists('#' . $parent->id, $result)) {
        $result=$parent->getParentItemsArray();
        $result['#' . $parent->id]=$parent;
      }
    } else {
      if (property_exists($elt,'idProject') and $elt->idProject) {
        $crit=array('refType'=>'Project', 'refId'=>$elt->idProject);
        $parent=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', $crit);
        if ($parent->id and ! array_key_exists('#' . $parent->id, $result)) {
          $result=$parent->getParentItemsArray();
          $result['#' . $parent->id]=$parent;
        }        
      }
    }
    return $result;
  }
  
  public function getPredecessorItemsArray() {
    $result=array();
    $crit=array("successorId"=>$this->id);
    $dep=new Dependency();
    $depList=$dep->getSqlElementsFromCriteria($crit, false);
    foreach ($depList as $dep) {
      $elt=new PlanningElement($dep->predecessorId);
      if ($elt->id and ! array_key_exists('#' . $elt->id, $result)) {
        $result['#' . $elt->id]=$elt;
        $resultPredecessor=$elt->getPredecessorItemsArray();
        $result=array_merge($result,$resultPredecessor);
      }
    }
    return $result;
  }
  
  public function getSuccessorItemsArray() {
    $result=array();
    $crit=array("predecessorId"=>$this->id);
    $dep=new Dependency();
    $depList=$dep->getSqlElementsFromCriteria($crit, false);
    foreach ($depList as $dep) {
      $elt=new PlanningElement($dep->successorId);
      if ($elt->id and ! array_key_exists('#' . $elt->id, $result)) {
        $result['#' . $elt->id]=$elt;
        $resultSuccessor=$elt->getSuccessorItemsArray();
        $result=array_merge($result,$resultSuccessor);
      }
    }
    return $result;
  }
}
?>