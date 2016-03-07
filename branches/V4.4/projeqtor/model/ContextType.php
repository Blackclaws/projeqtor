<?php 
/* ============================================================================
 * Client is the owner of a project.
 */ 
require_once('_securityCheck.php');
class ContextType extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visiblez place 
  public $name;
  public $idle;
  public $description;
  public $_noDelete=true;
  public $_noCreate=true;
  //public $_isNameTranslatable = true;
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
 
}
?>