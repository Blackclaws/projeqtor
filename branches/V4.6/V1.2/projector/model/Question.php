<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class Question extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $idProject;
  public $idQuestionType;
  public $name;
  public $description;
  public $creationDate;
  public $idUser;
  public $_col_2_2_answer;
  public $idStatus;
  public $idResource;
  public $initialDueDate;
  public $actualDueDate;
  public $result;    
  public $replier;    
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $_sec_linkMeeting;
  public $_Link_Meeting=array();
  public $_Attachement=array();
  public $_Note=array();


  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="10%" >${idProject}</th>
    <th field="nameQuestionType" width="10%" >${idQuestionType}</th>
    <th field="name" width="40%" >${name}</th>
    <th field="actualDueDate" width="10%" >${dueDate}</th>
    <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="nameResource" width="15%" >${idResource}</th>
    <th field="done" width="5%" formatter="booleanFormatter" >${done}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"required", 
                                  "idProject"=>"required",
                                  "idStatus"=>"required",
                                  "idQuestionType"=>"required",
                                  "description"=>"required",
                                  "creationDate"=>"required",
                                  "done"=>"nobr",
                                  "idle"=>"nobr"
  );  
  
  private static $_colCaptionTransposition = array('idUser'=>'issuer', 
                                                   'idResource'=> 'responsible',
                                                   'result'=>'response');
  
  //private static $_databaseColumnName = array('idResource'=>'idUser');
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
   * Return the specific databaseTableName
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

    if ($colName=="idStatus") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= htmlGetJsTable('Status', 'setIdleStatus', 'tabStatusIdle');
      $colScript .= htmlGetJsTable('Status', 'setDoneStatus', 'tabStatusDone');
      $colScript .= '  var setIdle=0;';
      $colScript .= '  var filterStatusIdle=dojo.filter(tabStatusIdle, function(item){return item.id==dijit.byId("idStatus").value;});';
      $colScript .= '  dojo.forEach(filterStatusIdle, function(item, i) {setIdle=item.setIdleStatus;});';
      $colScript .= '  if (setIdle==1) {';
      $colScript .= '    dijit.byId("idle").attr("checked", true);';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("idle").attr("checked", false);';
      $colScript .= '  }';
      $colScript .= '  var setDone=0;';
      $colScript .= '  var filterStatusDone=dojo.filter(tabStatusDone, function(item){return item.id==dijit.byId("idStatus").value;});';
      $colScript .= '  dojo.forEach(filterStatusDone, function(item, i) {setDone=item.setDoneStatus;});';
      $colScript .= '  if (setDone==1) {';
      $colScript .= '    dijit.byId("done").attr("checked", true);';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("done").attr("checked", false);';
      $colScript .= '  }';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';     
    } else if ($colName=="initialDueDate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (dijit.byId("actualDueDate").value==null) { ';
      $colScript .= '    dijit.byId("actualDueDate").attr("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';     
    } else if ($colName=="actualDueDate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (dijit.byId("initialDueDate").value==null) { ';
      $colScript .= '    dijit.byId("initialDueDate").attr("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';           
    } else     if ($colName=="idle") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("idleDate").value==null) {';
      $colScript .= '      var curDate = new Date();';
      $colScript .= '      dijit.byId("idleDate").attr("value", curDate); ';
      $colScript .= '    }';
      $colScript .= '    if (! dijit.byId("done").attr("checked")) {';
      $colScript .= '      dijit.byId("done").attr("checked", true);';
      $colScript .= '    }';  
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("idleDate").attr("value", null); ';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="done") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("doneDate").value==null) {';
      $colScript .= '      var curDate = new Date();';
      $colScript .= '      dijit.byId("doneDate").attr("value", curDate); ';
      $colScript .= '    }';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("doneDate").attr("value", null); ';
      $colScript .= '    if (dijit.byId("idle").attr("checked")) {';
      $colScript .= '      dijit.byId("idle").attr("checked", false);';
      $colScript .= '    }'; 
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
    
}
?>