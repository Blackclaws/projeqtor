<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class Ticket extends SqlElement {

  // List of fields that will be exposed in general user interface
  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $idProject;
  public $idTicketType;
  public $name;
  public $description;
  public $idUrgency;
  public $creationDateTime;
  public $idUser;
  public $idContact;
  public $_col_2_2_treatment;
  public $idActivity;
  public $idStatus;
  public $idResource;
  public $idCriticality;
  public $idPriority;
  public $initialDueDateTime; // is an object
  public $actualDueDateTime;
  public $result;
  public $handled;
  public $handledDateTime;
  public $done;
  public $doneDateTime;
  public $idle;
  public $idleDateTime;
  
  //public $_col_1_1_Progress;
  public $_Attachement=array();
  public $_Note=array();
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="4%" ># ${id}</th>
    <th field="nameProject" width="8%" >${idProject}</th>
    <th field="nameticketType" width="8%" >${idTicketType}</th>
    <th field="name" width="20%" >${name}</th>
    <th field="initialDueDateTime" width="8%" formatter="dateTimeFormatter">${initialDueDateTime}</th>
    <th field="nameUser" width="8%" >${issuer}</th>
    <th field="colorNameUrgency" width="8%" formatter="colorNameFormatter">${idUrgency}</th>
    <th field="colorNamePriority" width="8%" formatter="colorNameFormatter">${idPriority}</th>
    <th field="colorNameStatus" width="8%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="nameResource" width="8%" >${responsible}</th>
    <th field="handled" width="4%" formatter="booleanFormatter" >${handled}</th>
    <th field="done" width="4%" formatter="booleanFormatter" >${done}</th>
    <th field="idle" width="4%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"required", 
                                  "idProject"=>"required",
                                  "idTicketType"=>"required",
                                  "idStatus"=>"required",
                                  "creationDateTime"=>"required",
                                  "handled"=>"nobr",
                                  "done"=>"nobr",
                                  "idle"=>"nobr"
  );  
  
  private static $_colCaptionTransposition = array('idUser'=>'issuer', 
                                                   'idResource'=> 'responsible',
                                                   'idActivity' => 'planningActivity',
                                                   'idContact' => 'requestor');
  
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
    if ($colName=="idCriticality" or $colName=="idUrgency") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';  
      $colScript .= htmlGetJsTable('Urgency', 'value');
      $colScript .= htmlGetJsTable('Criticality', 'value');
      $colScript .= htmlGetJsTable('Priority', 'value');
      $colScript .= '  var urgencyValue=0; var criticalityValue=0; var priorityValue=0;';
      $colScript .= '  var filterUrgency=dojo.filter(tabUrgency, function(item){return item.id==dijit.byId("idUrgency").value;});';
      $colScript .= '  var filterCriticality=dojo.filter(tabCriticality, function(item){return item.id==dijit.byId("idCriticality").value;});';
      $colScript .= '  dojo.forEach(filterUrgency, function(item, i) {urgencyValue=item.value;});';
      $colScript .= '  dojo.forEach(filterCriticality, function(item, i) {criticalityValue=item.value;});';
      $colScript .= '  calculatedValue = Math.round(urgencyValue*criticalityValue/2);';
      $colScript .= '  var filterPriority=dojo.filter(tabPriority, function(item){return item.value==calculatedValue;});';
      $colScript .= '  if ( filterPriority.length==0) {';
      $colScript .= '    calculatedValue = Math.round(calculatedValue/2);';
      $colScript .= '    var filterPriority=dojo.filter(tabPriority, function(item){varChanged=true; return item.value==calculatedValue;});';
      $colScript .= '  }';
      $colScript .= '  var setVar="";';
      $colScript .= '  dojo.forEach(filterPriority, function(item, i) {if (setVar=="") dijit.byId("idPriority").set("value",item.id);});';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="actualDueDateTime") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  var upd=dijit.byId("initialDueDateTime");';
      $colScript .= '  if (upd && upd.value==null) { ';
      $colScript .= '    upd.set("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '</script>';     
    } else if ($colName=="actualDueDateTimeBis") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  var upd=dijit.byId("initialDueDateTimeBis");';
      $colScript .= '  if (upd && upd.value==null) { ';
      $colScript .= '    upd.set("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '</script>';     
    } else if ($colName=="initialDueDateTime") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  var upd=dijit.byId("actualDueDateTime");';
      $colScript .= '  if (upd && upd.value==null) { ';
      $colScript .= '    upd.set("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '</script>';     
    } else if ($colName=="initialDueDateTimeBis") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  var upd=dijit.byId("actualDueDateTimeBis");';
      $colScript .= '  if (upd && upd.value==null) { ';
      $colScript .= '    upd.set("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '</script>';     
    }
    return $colScript;
  }



  
}
?>