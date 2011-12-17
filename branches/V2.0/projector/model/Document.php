<?php 
/* ============================================================================
 * Stauts defines list stauts an activity or action can get in (lifecylce).
 */ 
class Document extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $reference;
  public $idDocumentType;
  public $name;
  public $extension;
  public $idProject;
  public $idProduct;
  public $idVersioningType;
  public $idStatus;
  public $currentVersion;
  public $currentRefVersion;
  public $idDocumentDirectory;
  public $locked;
  public $idAuthor;
  public $idLocker;
  public $lockedDate;
  public $idle;
  public $_col_2_2; 
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%"># ${id}</th>
    <th field="name" width="40%">${name}</th>
    <th field="nameProject" width="20%">${project}</th>
    <th field="nameDocumentDirectory" width="20%">${parent}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';

   private static $_fieldsAttributes=array(
    "id"=>"nobr");
   
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
    
  protected function getStaticFieldsAttributes() {
    return array_merge(parent::getStaticFieldsAttributes(),self::$_fieldsAttributes);
  }
 
}
?>