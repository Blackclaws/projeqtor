<?php 
/* ============================================================================
 * RiskType defines the type of a risk.
 */ 
class Alert extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;
  public $idProject;
  public $refType;
  public $refId;
  public $idIndicatorValue;
  public $idUser;
  public $alertType; 
  public $title;
  public $message;
  public $read;
  public $idle;
  public $_col_2_2;
  
  // Define the layout that will be used for lists
  
  private static $_fieldsAttributes=array("idType"=>"hidden", 
                                          "idUrgency"=>"required",
                                          "value"=>"required",
                                          "idDelayUnit"=>"required",
                                          "scope"=>"hidden");
  
  
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
    
}
?>