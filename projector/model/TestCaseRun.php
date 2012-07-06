<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class TestCaseRun extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $idTestCase;
  public $idTestSession;
  public $comment;
  public $idRunStatus;
  public $statusDateTime;
  public $idTicket;
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
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
 
  // ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********


/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    
   
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public function save() {

  	$new=($this->id)?false:true;
  	$old=new TestCaseRun($this->id);
  	
  	$result=parent::save();
  	
  	// Store link to ticket if idTicket is set
  	if (trim($this->idTicket)) {      
      if ($this->idTicket!=$old->idTicket) {
      	$link=new Link();
      	$link->ref1Type='TestSession';
      	$link->ref1Id=$this->idTestSession;
      	$link->ref2Type='Ticket';
      	$link->ref2Id=$this->idTicket;
      	$link->save();
      }
  	}
  	
    $session=new TestSession($this->idTestSession);
    $session->updateDependencies();
    
    $link=new Link();
    $crit=array('ref1Type'=>'Requirement', 'ref2Type'=>'TestCase', 'ref2Id'=>$this->idTestCase);
    $listLink=$link->getSqlElementsFromCriteria($crit);
    foreach ($listLink as $link) {
      $req=new Requirement($link->ref1Id);
      $req->updateDependencies();
    }
  	
  	if ($new) {
  		// on insertion, insert sub-test cases if exists
  	  $tc=new TestCase();
  	  $crit=array('idTestCase'=>$this->idTestCase);
  	  $list=$tc->getSqlElementsFromCriteria($crit);
  	  foreach ($list as $tc) {
  	  	$tcr=new TestCaseRun();
  	  	$tcr->idTestCase=$tc->id;
        $tcr->idTestSession=$this->idTestSession;
        $tcr->comment=$this->comment;
        $tcr->idRunStatus=$this->idRunStatus;
        $tcr->statusDateTime=$this->statusDateTime;
        $tcr->idTicket=$this->idTicket;
        $tcr->idle=$this->idle;
        $res=$tcr->save();
  	    if (stripos($res,'id="lastOperationStatus" value="OK"')>0 ) {
	        $deb=stripos($res,'#');
	        $fin=stripos($res,' ',$deb);
	        $resId=substr($res,$deb, $fin-$deb);
	        $deb=stripos($result,'#');
	        $fin=stripos($result,' ',$deb);
	        $result=substr($result, 0, $fin).','.$resId.substr($result,$fin);
		    }
  	  }	
  	}
  	
  	return $result;
  }
  
  public function delete() {
  	
  	$result=parent::delete();
    $link=new Link();
    $crit=array('ref1Type'=>'Requirement', 'ref2Type'=>'TestCase', 'ref2Id'=>$this->idTestCase);
    $listLink=$link->getSqlElementsFromCriteria($crit);
    foreach ($listLink as $link) {
      $req=new Requirement($link->ref1Id);
      $req->updateDependencies();
    }
    return $result;
  }
  
}
?>