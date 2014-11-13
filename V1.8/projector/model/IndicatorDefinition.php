<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
class IndicatorDefinition extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $idIndicatorable;
  public $name;
  public $nameIndicatorable;
  public $idType;
  public $idIndicator;
  public $codeIndicator;
  public $typeIndicator;
  public $warningValue;
  public $idWarningDelayUnit;
  public $codeWarningDelayUnit;
  public $alertValue; 
  public $idAlertDelayUnit;
  public $codeAlertDelayUnit;
  public $idle;
  public $_col_2_2_SendMail;
  public $mailToUser;
  public $mailToResource;
  public $mailToProject;
  public $mailToContact;
  public $mailToLeader;
  public $_sec_InternalAlert;
  public $alertToUser;
  public $alertToResource;
  public $alertToProject;
  public $alertToContact;
  public $alertToLeader;
  public $_isNameTranslatable = true;

    private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameIndicatorable" width="15%" >${element}</th>
    <th field="nameIndicator" width="20%" formatter="translateFormatter">${idIndicator}</th>
    <th field="nameType" width="10%" >${type}</th>
    <th field="warningValue" width="8%" formatter="numericFormatter">${warning}</th>
    <th field="nameWarningDelayUnit" width="12%" formatter="translateFormatter">${unit}</th>
    <th field="alertValue" width="8%" formatter="numericFormatter">${alert}</th>
    <th field="nameAlertDelayUnit" width="12%" formatter="translateFormatter">${unit}</th> 
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"hidden",
                                  "idType"=>"nocombo",
                                  "warningValue"=>"nobr",
                                  "alertValue"=>"nobr",
                                  "nameIndicatorable"=>"hidden",
                                  "codeIndicator"=>"hidden",
                                  "typeIndicator"=>"hidden",
                                  "codeWarningDelayUnit"=>"hidden",
                                  "codeAlertDelayUnit"=>"hidden"
  );  
  
    private static $_colCaptionTransposition = array('idIndicatorable'=>'element',
                                                     'idType'=>'type',
                                                     'warningValue'=>'warning',
                                                     'alertValue'=>'alert',
                                                     'alertToUser'=>'mailToUser',
                                                     'alertToResource'=>'mailToResource',
                                                     'alertToProject'=>'mailToProject',
                                                     'alertToContact'=>'mailToContact',
                                                     'alertToLeader'=>'mailToLeader');
  
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
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  public function save() {
  	$indicatorable=new Indicatorable($this->idIndicatorable);
  	$this->nameIndicatorable=$indicatorable->name;
  	$delayUnit=new DelayUnit($this->idWarningDelayUnit);
  	$this->codeWarningDelayUnit=$delayUnit->code;
  	$delayUnit=new DelayUnit($this->idAlertDelayUnit);
    $this->codeAlertDelayUnit=$delayUnit->code;
  	$indicator=new Indicator($this->idIndicator);
    $this->codeIndicator=$indicator->code;
  	$this->typeIndicator=$indicator->type;
  	$this->name=$indicator->name;
  	return parent::save();
  }
  
    /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo framework)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);
    if ($colName=='idIndicatorable') { 
      $colScript .= '<script type="dojo/connect" event="onChange" args="evt">';
      $colScript .= '  dijit.byId("idIndicator").set("value",null);';
      $colScript .= '  dijit.byId("idType").set("value",null);';
      $colScript .= '  refreshList("idIndicator","idIndicatorable", this.value, null, null, true);';
      $colScript .= '  refreshList("idType","scope", indicatorableArray[this.value]);';
      $colScript .= '</script>';
    }
    if ($colName=='idIndicator') { 
      $colScript .= '<script type="dojo/connect" event="onChange" args="evt">';
      $colScript .= '  dijit.byId("idWarningDelayUnit").set("value",null);';
      $colScript .= '  dijit.byId("idAlertDelayUnit").set("value",null);';
      $colScript .= '  dijit.byId("warningValue").set("value",null);';
      $colScript .= '  dijit.byId("alertValue").set("value",null);';
      $colScript .= '  refreshList("idWarningDelayUnit","idIndicator", this.value, null, null, false);';
      $colScript .= '  refreshList("idAlertDelayUnit","idIndicator", this.value, null, null, false);';
      $colScript .= '</script>';
    }  
    return $colScript;
  }
  
  public function control(){
    $result="";
    if (! trim($this->idIndicatorable)) {
    	$result.='<br/>' . i18n('messageMandatory',array(i18n('colElement')));
    }
    if (! trim($this->idIndicator)) {
      $result.='<br/>' . i18n('messageMandatory',array(i18n('colIdIndicator')));
    }
    if ($this->alertValue!="" and ! trim($this->idAlertDelayUnit) ) {
      $result.='<br/>' . i18n('messageMandatory',array(i18n('colUnit')));
    }
    if ($this->warningValue!="" and ! trim($this->idWarningDelayUnit) ) {
      $result.='<br/>' . i18n('messageMandatory',array(i18n('colUnit')));
    }    
    //if (! trim($this->idType)) {
    //  $result.='<br/>' . i18n('messageMandatory',array(i18n('colType')));
    //}
    $crit=array('idIndicatorable'=>trim($this->idIndicatorable),
                'idIndicator'=>trim($this->idIndicator),
                'idType'=>trim($this->idType));
    $elt=SqlElement::getSingleSqlElementFromCriteria('IndicatorDefinition', $crit);
    if ($elt and $elt->id and $elt->id!=$this->id) {
      $result.='<br/>' . i18n('errorDuplicateIndicator');
    }
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
}
?>