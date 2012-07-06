<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class TestCase extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $reference;
  public $idProject;
  public $idProduct;
  public $idVersion;
  public $idTestCaseType;
  public $name;
  public $externalReference;
  public $creationDateTime;
  public $idContext1;
  public $idContext2;
  public $idContext3;
  public $idUser;
  public $description;
  public $_col_2_2_treatment;
  public $idTestCase;
  public $idStatus;
  public $idResource;
  public $idPriority;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $prerequisite;
  public $result;
  public $_col_1_1_TestCaseRun;
  public $_TestCaseRun=array();
  public $_col_1_2_predecessor;
  public $_Dependency_Predecessor=array();
  public $_col_2_2_successor;
  public $_Dependency_Successor=array();
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
                                  "handled"=>"hidden","handledDate"=>"hidden",
                                  "done"=>"nobr",
                                  "idle"=>"nobr",
                                  "idUser"=>"hidden",
                                  "idContext1"=>"nobr,size1/3,title",
                                  "idContext2"=>"nobr,title", 
                                  "idContext3"=>"title"
  );  
  
  private static $_colCaptionTransposition = array('idResource'=> 'responsible',
                                                   'idTestCaseType'=>'type',
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
    
    if ($this->id and $this->id==$this->idTestCase) {
      $result.='<br/>' . i18n('errorHierarchicLoop');
    } else if (trim($this->idTestCase)){
      $parentList=array();
      $parent=new TestCase($this->idTestCase);
      while ($parent->idTestCase) {
        $parentList[$parent->idTestCase]=$parent->idTestCase;
        $parent=new TestCase($parent->idTestCase);
      }
      if (array_key_exists($this->id,$parentList)) {
        $result.='<br/>' . i18n('errorHierarchicLoop');
      }
    }
    if (trim($this->idTestCase)) {
      $parent=new TestCase($this->idTestCase);
      if ( trim($this->idProduct)) {
        if (trim($parent->idProduct)!=trim($this->idProduct)) {
      	  $result.='<br/>' . i18n('msgParentTestCaseInSameProjectProduct');
        }
      } else {
      	if (trim($parent->idProject)!=trim($this->idProject)) {
          $result.='<br/>' . i18n('msgParentTestCaseInSameProjectProduct');
        }
      }
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

  	if (! $this->prerequisite and $this->idTestCase) {
  		$parent=new TestCase($this->idTestCase);
  		$this->prerequisite=$parent->prerequisite;
  	}
  	$result=parent::save();
    return $result;
  }
  
}
?>