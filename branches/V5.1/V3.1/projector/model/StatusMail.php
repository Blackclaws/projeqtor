<?php 
/* ============================================================================
 * Menu defines list of items to present to users.
 */ 
class StatusMail extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $idMailable;
  public $idStatus;
  public $idEvent;
  public $idle;
  public $_col_2_2_SendMail;
  public $mailToContact;
  public $mailToUser;
  public $mailToResource;
  public $mailToProject;
  public $mailToLeader;
  public $mailToManager;
  public $mailToOther;
  public $otherMail;
  
  public $_noCopy;
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameMailable" formatter="translateFormatter" width="15%" >${idMailable}</th>
    <th field="colorNameStatus" width="13%" formatter="colorNameFormatter">${newStatus}</th>
    <th field="nameEvent" formatter="translateFormatter" width="13%" >${idMailable}</th>
    <th field="mailToContact" width="7%" formatter="booleanFormatter" >${mailToContact}</th>    
    <th field="mailToUser" width="7%" formatter="booleanFormatter" >${mailToUser}</th>
    <th field="mailToResource" width="7%" formatter="booleanFormatter" >${mailToResource}</th>
    <th field="mailToProject" width="7%" formatter="booleanFormatter" >${mailToProject}</th>
    <th field="mailToLeader" width="7%" formatter="booleanFormatter" >${mailToLeader}</th>
    <th field="mailToManager" width="7%" formatter="booleanFormatter" >${mailToManager}</th>
    <th field="mailToOther" width="7%" formatter="booleanFormatter" >${mailToOther}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("idMailable"=>"required", 
                                  "mailToOther"=>"nobr",
                                  "otherMail"=>""
  );  
  
  private static $_colCaptionTransposition = array('idStatus'=>'newStatus','otherMail'=>'email','idEvent'=>'orOtherEvent');
  
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

  public function control() {
    $result="";
    $crit="idMailable='" . Sql::fmtId($this->idMailable) . "'";
    if (trim($this->idStatus)) {
    	$crit.=" and idStatus='" . Sql::fmtId($this->idStatus) . "'";
    }
    if (trim($this->idEvent)) {
      $crit.=" and idEvent='" . Sql::fmtId($this->idEvent) . "'";
    }
    $crit.=" and id<>'" . Sql::fmtId($this->id) . "'";
    $list=$this->getSqlElementsFromCriteria(null, false, $crit);
    if (count($list)>0) {
      $result.="<br/>" . i18n('errorDuplicateStatusMail',null);
    }
    if (!trim($this->idStatus) and !trim($this->idEvent)) {
    	$result.="<br/>" . i18n('messageMandatory',array(i18n('colNewStatus')." ".i18n('colOrOtherEvent')));
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
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    if ($this->mailToOther=='1') {
      self::$_fieldsAttributes['otherMail']='';
    } else {
      self::$_fieldsAttributes['otherMail']='invisible';
    } 
    
    $colScript = parent::getValidationScript($colName);

    if ($colName=="mailToOther") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= ' var fld = dijit.byId("otherMail").domNode;';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    dojo.style(fld, {visibility:"visible"});';
      $colScript .= '  } else {';
      $colScript .= '    dojo.style(fld, {visibility:"hidden"});';
      $colScript .= '    fld.set("value","");';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="idStatus") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.value!=" ") { ';
      $colScript .= '    dijit.byId("idEvent").set("value"," ");';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="idEvent") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.value!=" ") { ';
      $colScript .= '    dijit.byId("idStatus").set("value"," ");';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
}
?>