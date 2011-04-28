<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class IndividualExpense extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $idProject;
  public $idResource;
  public $idUser;
  public $idIndividualExpenseType;
  public $name;
  public $description;
  public $_col_2_2_treatment;
  public $idStatus;  
  public $expensePlannedDate;
  public $plannedAmount;
  public $expenseRealDate;
  public $realAmount;
  public $idle;
  
  public $_col_1_1_Detail;
  public $_Attachement=array();
  public $_Note=array();


  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="15%" >${idProject}</th>
    <th field="nameResource" width="15%" >${idResource}</th>
    <th field="nameIndividualExpenseType" width="15%" >${type}</th>
    <th field="name" formatter="dateFormatter" width="20%" >${name}</th>
    <th field="colorNameStatus" width="15%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("idProject"=>"required",
                                  "idIndividualExpenseType"=>"required",
                                  "expensePlannedDate"=>"",
                                  "plannedAmount"=>"",
                                  "idResource"=>"required",
                                  "idStatus"=>"required",
  								                "idUser"=>"hidden"
  );  
  
  private static $_colCaptionTransposition = array('idIndividualExpenseType'=>'type',
  'expensePlannedDate'=>'plannedDate',
  'expenseRealDate'=>'realDate'
  );
  
  //private static $_databaseColumnName = array('idResource'=>'idUser');
  private static $_databaseColumnName = array("idIndividualExpenseType"=>"idExpenseType",
  );

  private static $_databaseCriteria = array('scope'=>'IndividualExpense');

  private static $_databaseTableName = 'expense';
  
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
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    global $paramDbPrefix;
    return $paramDbPrefix . self::$_databaseTableName;
  }
  
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }

  /** ========================================================================
   * Return the specific database criteria
   * @return the databaseTableName
   */
  protected function getStaticDatabaseCriteria() {
    return self::$_databaseCriteria; 
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

    if ($colName=="idStatus") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= htmlGetJsTable('Status', 'setIdleStatus', 'tabStatusIdle');
      $colScript .= htmlGetJsTable('Status', 'setDoneStatus', 'tabStatusDone');
      $colScript .= '  var setIdle=0;';
      $colScript .= '  var filterStatusIdle=dojo.filter(tabStatusIdle, function(item){return item.id==dijit.byId("idStatus").value;});';
      $colScript .= '  dojo.forEach(filterStatusIdle, function(item, i) {setIdle=item.setIdleStatus;});';
      $colScript .= '  if (setIdle==1) {';
      $colScript .= '    dijit.byId("idle").set("checked", true);';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("idle").set("checked", false);';
      $colScript .= '  }';
      $colScript .= '  var setDone=0;';
      $colScript .= '  var filterStatusDone=dojo.filter(tabStatusDone, function(item){return item.id==dijit.byId("idStatus").value;});';
      $colScript .= '  dojo.forEach(filterStatusDone, function(item, i) {setDone=item.setDoneStatus;});';
      $colScript .= '  if (setDone==1) {';
      $colScript .= '    dijit.byId("done").set("checked", true);';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("done").set("checked", false);';
      $colScript .= '  }';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';     
    }
    return $colScript;
  }

  public function control() {
  	$result="";
  	if (! $this->plannedAmount and ! $this->realAmount) {
  		$result.= '<br/>' . i18n('msgEnterRPAmount');
  	}
    if (! $this->expensePlannedDate and ! $this->expenseRealDate) {
      $result.= '<br/>' . i18n('msgEnterRPDate');
    }
    if ( ($this->plannedAmount and ! $this->expensePlannedDate ) 
      or (! $this->plannedAmount and $this->expensePlannedDate ) ){
      $result.= '<br/>' . i18n('msgEnterPlannedDA');	
    }
    if ( ($this->realAmount and ! $this->expenseRealDate ) 
      or (! $this->realAmount and $this->expenseRealDate ) ){
      $result.= '<br/>' . i18n('msgEnterRealDA');  
    }
    if ($result=="") {
    	return 'OK';
    } else {
    	return $result;
    }
  }
  
  public function save() {
    $this->idUser=$this->idResource;
    return parent::save();
  }
}
?>