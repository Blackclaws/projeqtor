<?php 
/* ============================================================================
 * Assignment defines link of resources to an Activity (or else)
 */ 
class Assignment extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $idProject;
  public $refType;
  public $refId;
  public $idResource;
  public $idRole;
  public $comment;
  public $assignedWork;
  public $realWork;
  public $leftWork;
  public $plannedWork;
  public $rate;
  public $realStartDate;
  public $realEndDate;
  public $plannedStartDate;
  public $plannedEndDate;
  public $dailyCost;
  public $newDailyCost;
  public $assignedCost;
  public $realCost;
  public $leftCost;
  public $plannedCost;
  public $idle;
  public $billedWork;
  
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
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /**
   * Save object 
   * @see persistence/SqlElement#save()
   */
  public function save() {
    
  if (! $this->realWork) { $this->realWork=0; }
    // if cost has changed, update work 
    
    $this->plannedWork = $this->realWork + $this->leftWork;
    
    $this->assignedCost=$this->assignedWork*$this->dailyCost;    
    $r=new Resource($this->idResource);
    // If idRole not set, set to default for resource
    if (! $this->idRole) {
      $this->idRole=$r->idRole;
    }
    $newCost=$r->getActualResourceCost($this->idRole);
    $this->newDailyCost=$newCost;
    $this->leftCost=$this->leftWork*$newCost;
    $this->plannedCost = $this->realCost + $this->leftCost;
    if ($this->dailyCost==null) {
      $this->dailyCost=$newCost;
      if (! $this->idRole) {
        // search idRole found for newDailyCost
        $where="idResource='" . $this->idResource . "'";
        $where.= " and endDate is null";
        $where.= " and cost=" . ($newCost)?$newCost:'0';
        $rc=new ResourceCost();
        $lst = $rc->getSqlElementsFromCriteria(null, false, $where, "startDate desc");
        if (count($lst)>0) {
          $this->idRole=$lst[0]->idRole;
        }
      }      
    }
    
    // Dispatch value
    $result = parent::save();
    if (! strpos($result,'id="lastOperationStatus" value="OK"')) {
      return $result;     
    }
    
    PlanningElement::updateSynthesis($this->refType, $this->refId);
    
    /*if ($limitedRate==true) {
      $result = i18n("limitedRate", array($affectation->rate)) . $result;      
    }*/
    
    // Dispatch value
    return $result;
  }
  
  /**
   * Delete object and dispatch updates to top 
   * @see persistence/SqlElement#save()
   */
  public function delete() {    
    $result = parent::delete();
    if (! strpos($result,'id="lastOperationStatus" value="OK"')) {
      return $result;     
    }
    PlanningElement::updateSynthesis($this->refType, $this->refId);
    
    // Dispatch value
    return $result;
  }
  
  public function refresh() {
    $work=new Work();
    $crit=array('idAssignment'=>$this->id);
    $workList=$work->getSqlElementsFromCriteria($crit,false);
    $realWork=0;
    $realCost=0;
    $this->realStartDate=null;
    $this->realEndDate=null;
    foreach ($workList as $work) {
      $realWork+=$work->work;
      $realCost+=$work->cost;
      if ( !$this->realStartDate or $work->workDate<$this->realStartDate ) {
        $this->realStartDate=$work->workDate;
      }
      if ( !$this->realEndDate or $work->workDate>$this->realEndDate ) {
        $this->realEndDate=$work->workDate;
      }     
    }
    $this->realWork=$realWork;
    $this->realCost=$realCost;
  }
  
  public function saveWithRefresh() {
    $this->refresh();
    return $this->save();
  }

/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    if (! $this->idResource) {
      $result.='<br/>' . i18n('messageMandatory', array(i18n('colIdResource')));
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