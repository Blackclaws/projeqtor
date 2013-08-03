<?php
/* ============================================================================
 * Planning element is an object included in all objects that can be planned.
 */ 
class PeriodicMeetingPlanningElement extends MeetingPlanningElement {

  public $id;
  public $idProject;
  public $refType;
  public $refId;
  public $refName;
  public $_tab_3_2=array('assigned', 'real', 'left', 'work', 'cost');
  public $assignedWork;
  public $realWork;
  public $leftWork;
  public $assignedCost;
  public $realCost;
  public $leftCost;
  public $idMeetingPlanningMode;
  
  private static $_fieldsAttributes=array(
    "initialStartDate"=>"hidden",
    "plannedStartDate"=>"hidden",
    "validatedStartDate"=>"hidden",
    "realStartDate"=>"hidden",
    "plannedEndDate"=>"hidden",
    "realEndDate"=>"hidden",
    "initialEndDate"=>"hidden",
    "validatedEndDate"=>"hidden",
    "plannedDuration"=>"hidden",
    "realDuration"=>"hidden",
    "initialDuration"=>"hidden",
    "validatedDuration"=>"hidden",
    "initialWork"=>"hidden",
    "plannedWork"=>"hidden",
    "realWork"=>"readonly",
    "leftWork"=>"readonly",
    "assignedWork"=>"readonly",
    "validatedWork"=>"hidden",
    "validatedCost"=>"hidden",
    "assignedCost"=>"readonly",
    "plannedCost"=>"hidden",
    "realCost"=>"readonly",
    "leftCost"=>"readonly",
    "progress"=>"hidden",
    "expectedProgress"=>"hidden",
    "priority"=>"hidden",
    "wbs"=>"hidden",
    "idMeetingPlanningMode"=>"hidden,required"
  );   
  
  private static $_databaseTableName = 'planningelement';
  
  private static $_databaseColumnName=array(
    "idMeetingPlanningMode"=>"idPlanningMode"
  );
    
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

    /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    $paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
    return $paramDbPrefix . self::$_databaseTableName;
  }
    
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return array_merge(parent::getStaticFieldsAttributes(),self::$_fieldsAttributes);
  }
  
  /** ========================================================================
   * Return the generic databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
  /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {
  	$meeting=new PeriodicMeeting($this->refId);
  	$old=$this->getOld();
  	if (!$this->id) {
  		$this->priority=1; // very high priority
  		$this->idMeetingPlanningMode=16; // fixed planning  		
  	}
  	if ($meeting->idPeriodicMeeting) {
  		$this->topRefType='PeriodicMeeting';
  		$this->topRefId=$meeting->idPeriodicMeeting;
  	} else if ($meeting->idActivity) {
  		$this->topRefType='Activity';
      $this->topRefId=$meeting->idActivity;
  	} else {
  		$this->topRefType='Project';
  		$this->topRefId=$meeting->idProject;
  	}
  	$this->validatedStartDate=$meeting->meetingDate;
  	$this->validatedEndDate=$meeting->meetingDate;
  	$this->validatedDuration=1; // TODO : Could be improved : duration is less than one.
  	//$this->validatedWork=0; // TODO : To be calculated from Number of assignements x meeting duration
    $this->idProject=$meeting->idProject;
    $this->refName=$meeting->name;
    if ($old->idProject!=$this->idProject or $old->topId!=$this->topId 
    or $old->topRefType!=$this->topRefType or $old->topRefId!=$this->topRefId) {
    	$this->wbs=null; // Force recalculation
    	$this->topId=null;
    }
    return parent::save();
  }
  
/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    $mode=null;
    if ($this->idMeetingPlanningMode) {
      $mode=new ActivityPlanningMode($this->idMeetingPlanningMode);
    }   
    if ($mode) {
      if ($mode->mandatoryStartDate and ! $this->validatedStartDate) {
        $result.='<br/>' . i18n('errorMandatoryValidatedStartDate');
      }
      if ($mode->mandatoryEndDate and ! $this->validatedEndDate) {
        $result.='<br/>' . i18n('errorMandatoryValidatedEndDate');
      }
      if ($mode->mandatoryDuration and ! $this->validatedDuration) {
        $result.='<br/>' . i18n('errorMandatoryValidatedDuration');
      }
   
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