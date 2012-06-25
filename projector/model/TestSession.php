<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class TestSession extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $reference;
  public $idProject;
  public $idProduct;
  public $idVersion;
  public $idTestSessionType;
  public $name;
  public $externalReference;
  public $creationDateTime;
  public $idUser;
  public $description;
  public $_col_2_2_treatment;
  public $idStatus;
  public $idResource;
  public $startDate;
  public $endDate;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $result;
  public $_col_1_1_Link;
  public $_Link=array();
  public $_Attachement=array();
  public $_Note=array();
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="10%" >${idProject}</th>
    <th field="nameProduct" width="10%" >${idProduct}</th>
    <th field="nameVersion" width="10%" >${idVersion}</th>
    <th field="nameTestCaseType" width="10%" >${type}</th>
    <th field="name" width="20%" >${name}</th>
    <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="nameResource" width="10%" >${responsible}</th>
    <th field="handled" width="5%" formatter="booleanFormatter" >${handled}</th>
    <th field="done" width="5%" formatter="booleanFormatter" >${done}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
                                  "name"=>"required", 
                                  "idTestCaseType"=>"required",
                                  "idStatus"=>"required",
                                  "creationDateTime"=>"required",
                                  "handled"=>"nobr",
                                  "done"=>"nobr",
                                  "idle"=>"nobr",
                                  "idUser"=>"hidden"
  );  
  
  private static $_colCaptionTransposition = array('idResource'=> 'responsible',
                                                   'idTestSessionType'=>'type',
                                                   'result'=>'expectedResult'
                                                   );
  
  private static $_databaseColumnName = array();
    
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

  /** ========================================================================
   * Return the specific databaseColumnName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
  // ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo framework)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);
    return $colScript;
  }

/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    
    if (!trim($this->idProject) and !trim($this->idProduct)) {
      $result.="<br/>" . i18n('messageMandatory',array(i18n('colIdProject') . " " . i18n('colOrProduct')));
    }
    
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public function save() {

  	$result=parent::save();
    return $result;
  }
  
}
?>