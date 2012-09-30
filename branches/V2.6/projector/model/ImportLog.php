<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
class ImportLog extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $mode;
  public $importDateTime;
  public $importFile;
  public $importClass;
  public $importStatus;
  public $importedTodo;
  public $importedDone;
  public $importedDoneCreated;
  public $importedDoneModified;
  public $importedDoneUnchanged;
  public $importedRejected;
  public $importedRejectedInvalid;
  public $importedRejectedError;
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
  
}
?>