<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
class Trigger extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $RefType;
  public $RefId;
  public $delay;
  
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
    $result="OK";
    
    return $result;
  }
}
?>