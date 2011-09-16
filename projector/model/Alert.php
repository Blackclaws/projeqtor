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
  public $alertDateTime;
  public $alertInitialDateTime;
  public $alertReadDateTime; 
  public $title;
  public $message;
  public $readFlag;
  public $idle;
  public $_col_2_2;
  
  // Define the layout that will be used for lists
  
  private static $_fieldsAttributes=array("idIndicatorValue"=>"hidden");
  
    private static $_colCaptionTransposition = array('alertType'=>'type');
    
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="10%" >${idProject}</th>
    <th field="nameUser" width="10%" >${idUser}</th>
    <th field="refType" width="10%" formatter="translatterFormatter" >${element}</th>
    <th field="refId" width="5%" >${id}</th>
    <th field="alertType" width="10%">${idType}</th>
    <th field="title" width="40%" >${title}</th>
    <th field="readFlag" width="5%" formatter="booleanFormatter" >${readFlag}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';
  
  
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
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
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
}
?>