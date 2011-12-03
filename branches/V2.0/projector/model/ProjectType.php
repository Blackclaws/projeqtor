<?php 
/* ============================================================================
 * DecisionType defines the type of a decision.
 */ 
class ProjectType extends SqlElement {

  // Define the layout that will be used for lists
    // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  //public $idWorkflow;
  public $code;
  public $mandatoryDescription;
  public $_lib_mandatoryField;
  public $sortOrder=0;
  public $idle;
  public $_col_2_2;
	
   private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%"># ${id}</th>
    <th field="name" width="60%">${name}</th>
    <th field="sortOrder" width="5%">${sortOrderShort}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';
   
  private static $_databaseCriteria = array('scope'=>'Project');
  
   private static $_fieldsAttributes=array("name"=>"required", 
                                          "idWorkflow"=>"hidden",
                                          "mandatoryDescription"=>"nobr",
                                          "code"=> "hidden");
   private static $_databaseTableName = 'type';
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

  /** ========================================================================
   * Return the specific database criteria
   * @return the databaseTableName
   */
  protected function getStaticDatabaseCriteria() {
    return self::$_databaseCriteria;
  }
  
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
    /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    global $paramDbPrefix;
    return $paramDbPrefix . self::$_databaseTableName;
  }
  
  public function deleteControl() {
  	$result="";
    if ($this->code=='ADM' or $this->code=='TMP') {    
      $result="<br/>" . i18n("msgCannotDeleteProjectType");
    }
    if (! $result) {  
      $result=parent::deleteControl();
    }
    return $result;
  }
  
  
}
?>