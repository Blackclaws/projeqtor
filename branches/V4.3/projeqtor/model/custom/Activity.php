<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */  
require_once('_securityCheck.php');
class Activity extends ActivityMain {

	// List of fields that will be exposed in general user interface
	// List of fields that will be exposed in general user interface
	public $_col_1_2_description;
	public $id;    // redefine $id to specify its visible place
	public $reference;
	public $idProject;
	public $idActivityType;
	public $name;
	public $externalReference;
	public $creationDate;
	public $idUser;
	public $idContact;
	public $Origin;
	public $description;
	public $_sec_address;
	public $test;
	public $_col_2_2_treatment;
	public $idActivity;
	public $idStatus;
	public $idResource;
	public $handled;
	public $handledDate;
	public $done;
	public $doneDate;
	public $idle;
	public $idleDate;
	public $cancelled;
	public $_lib_cancelled;
	public $idTargetVersion;
	public $result;
	//public $_sec_Assignment;
	public $_Assignment=array();
	public $_col_1_1_Progress;
	public $ActivityPlanningElement; // is an object
	public $_col_1_2_predecessor;
	public $_Dependency_Predecessor=array();
	public $_col_2_2_successor;
	public $_Dependency_Successor=array();
	public $_col_1_1_Link;
	public $_Link=array();
	public $_Attachement=array();
	public $_Note=array();
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


}
?>