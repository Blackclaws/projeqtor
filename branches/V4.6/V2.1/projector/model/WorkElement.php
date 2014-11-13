<?php 
/* ============================================================================
 * Client is the owner of a project.
 */ 
class WorkElement extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visiblez place 
  public $refType;
  public $refId;
  public $refName;
  public $plannedWork;
  public $realWork;
  public $leftWork;
  public $done;
  public $idle;
   
   private static $_fieldsAttributes=array("refType"=>"hidden", "refId"=>"hidden", "refName"=>"hidden",
                                           "leftWork"=>"readonly", "done"=>"hidden", "idle"=>"hidden");

   private static $_colCaptionTransposition = array('plannedWork'=>'estimatedWork');
   
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
    
  public function save() {
  	$this->leftWork=$this->plannedWork-$this->realWork;  
  	if ($this->leftWork<0 or $this->done) {
  		$this->leftWork=0;
  	}
  	return parent::save();
  }
}
?>