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
  public $comment;
  public $assignedWork;
  public $realWork;
  public $leftWork;
  public $plannedWork;
  public $rate;
  public $realStartDate;
  public $realEndDate;
  public $idle;
  
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
    $this->plannedWork = $this->realWork + $this->leftWork;
    
    /* $limitedRate=false;
    $crit=array("idProject"=>$this->idProject, "idResource"=>$this->idResource);
    $affectation=SqlElement::getSingleSqlElementFromCriteria("Affectation", $crit);
    if ($affectation) {
      if ($affectation->rate < $this->rate) {
        $this->rate=$affectation->rate;
        $limitedRate=true;
      }
    }*/
    
    $result = parent::save();
    
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
    PlanningElement::updateSynthesis($this->refType, $this->refId);
    
    // Dispatch value
    return $result;
  }
  
  public function refresh() {
    $work=new Work();
    $crit=array('idAssignment'=>$this->id);
    $workList=$work->getSqlElementsFromCriteria($crit,false);
    $realWork=0;
    $this->realStartDate=null;
    foreach ($workList as $work) {
      $realWork+=$work->work;
      if ( !$this->realStartDate or $work->workDate<$this->realStartDate ) {
        $this->realStartDate=$work->workDate;
      }
      if ( !$this->realEndDate or $work->workDate>$this->realEndDate ) {
        $this->realEndDate=$work->workDate;
      }     
    }
    $this->realWork=$realWork;
  }
  
  public function saveWithRefresh() {
    $this->refresh();
    $this->save();
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