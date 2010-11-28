<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
class Dependency extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $predecessorId;
  public $predecessorRefType;
  public $predecessorRefId;
  public $successorId;
  public $successorRefType;
  public $successorRefId;
  public $dependencyType;
  public $dependencyDelay;
  
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
  

 /** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    $prec=new PlanningElement($this->predecessorId);
    $succ=new PlanningElement($this->successorId);    
    $precList=$prec->getPredecessorItemsArray();
    $succList=$succ->getSuccessorItemsArray();
    if (array_key_exists('#' . $this->successorId,$precList)) {
      $result.='<br/>' . i18n('errorDependencyLoop');
    }
    if (array_key_exists('#' .$this->predecessorId,$succList)) {
      $result.='<br/>' . i18n('errorDependencyLoop');
    }
    if ($this->predecessorId==$this->successorId) {
      $result.='<br/>' . i18n('errorDependencyLoop');
    }
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }if ($result=="") {
      $result='OK';
    }
    return $result;
  }
}
?>