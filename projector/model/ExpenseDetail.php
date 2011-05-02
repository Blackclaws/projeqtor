<?php 
/* ============================================================================
 * Assignment defines link of resources to an Activity (or else)
 */ 
class ExpenseDetail extends SqlElement {

  // extends SqlElement, so has $id
  public $id;
  public $idProject; 
  public $idExpense; 
  public $idExpenseDetailType; 
  public $name;
  public $description;
  public $expenseDate; 
  public $amount;
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
    $result = parent::save();
    return $result;
  }
  
  /**
   * Delete object and dispatch updates to top 
   * @see persistence/SqlElement#save()
   */
  public function delete() {
    return $result;
  }
    
/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    return $result;
  }
}
?>