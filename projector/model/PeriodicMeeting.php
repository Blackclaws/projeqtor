<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class PeriodicMeeting extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $idProject;
  public $idMeetingType;
  public $name;
  public $location;
  public $_sec_Assignment;
  public $_Assignment=array();
  public $attendees;
  public $idUser;
  public $description;
  public $_col_2_2_treatment;
  public $idActivity;
  public $idResource;
  public $idle;
  public $_sec_periodicity;
  public $periodicityStartDate;
  public $_lib_until;
  public $periodicityEndDate;
  public $_lib_for;
  public $periodicityTimes;
  public $_lib_times;
  public $meetingStartTime;
  public $_lib_to;
  public $meetingEndTime;
  public $MeetingPlanningElement;
  public $_Note=array();


  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="14%" >${idProject}</th>
    <th field="nameMeetingType" width="14%" >${idMeetingType}</th>
    <th field="name" width="22%" >${name}</th>
    <th field="periodicityStartDate" formatter="dateFormatter" width="10%" >${startDate}</th>
    <th field="periodicityEndDate" formatter="dateFormatter" width="10%" >${endDate}</th>
    <th field="periodicityTimes" width="6%" >${periodicityTimes}</th>
    <th field="meetingStartTime" width="8%" >${startTime}</th>
    <th field="meetingEndTime" width="8%" >${endTime}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("idProject"=>"required",
                                  "idMeetingType"=>"required",
                                  "periodicityStartDate"=>"required, nobr",
                                  "_lib_until"=>'nobr',
                                  "periodicityEndDate"=>"nobr",
                                  "_lib_for"=>'nobr',      
                                  "periodicityTimes"=>'nobr,smallWidth',                            
                                  "meetingStartTime"=>'nobr',
                                  "_lib_to"=>'nobr',
                                  "meetingEndTime"=>'nobr',
                                  "idUser"=>"hidden",
                                  "idResource"=>"idden",
                                  "idStatus"=>"required",
                                  "handled"=>"nobr",
                                  "done"=>"nobr",
                                  "idle"=>"nobr"
  );  
  
  private static $_colCaptionTransposition = array(
    'idResource'=>'responsible',
    'idActivity'=>'parentActivity',
    'periodicityStartDate'=>'period',
    'meetingStartTime'=>'time',
    'attendees'=>'otherAttendees' );
  
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

    if ($colName=="periodicityEndDate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= 'if (this.value) {';
      $colScript .= '  dijit.byId("periodicityTimes").set("value", null); ';
      $colScript .= '  formChanged();';
      $colScript .= '}';
      $colScript .= '</script>';     
    } else if ($colName=="periodicityTimes") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= 'if (this.value) {';
      $colScript .= '  dijit.byId("periodicityEndDate").set("value", null); ';
      $colScript .= '  formChanged();';
      $colScript .= '}';
      $colScript .= '</script>';           
    }
    return $colScript;
  }

  public function drawSpecificItem($item){
    global $print;
    $result="";
    return $result;
  }

  public function save() {
  	if (! $this->name) {
      $this->name=SqlList::getNameFromId('MeetingType',$this->idMeetingType);
  	}
    $listTeam=array_map('strtolower',SqlList::getList('Team','name'));
    $listName=array_map('strtolower',SqlList::getList('Affectable'));
    $listUserName=array_map('strtolower',SqlList::getList('Affectable','userName'));
    $listInitials=array_map('strtolower',SqlList::getList('Affectable','initials'));
    if ($this->attendees) {
      $listAttendees=explode(',',str_replace(';',',',$this->attendees));
      $this->attendees="";
      foreach ($listAttendees as $attendee) {
      	$stockAttendee=$attendee;
        $attendee=strtolower(trim($attendee));
        if (in_array($attendee,$listName)) {
          $this->attendees.=($this->attendees)?', ':'';
          $aff=new Affectable(array_search($attendee,$listName));
          $this->attendees.='"' . $aff->name . '"';
          if ($aff->email) {
            $this->attendees.=' <' . $aff->email . '>';
          }
        } else if (in_array($attendee,$listUserName)) {
          $this->attendees.=($this->attendees)?', ':'';
          $aff=new Affectable(array_search($attendee,$listUserName));
          $this->attendees.='"' . (($aff->name)?$aff->name:$stockAttendee) . '"';
          if ($aff->email) {
            $this->attendees.=' <' . $aff->email . '>';
          }
        } else if (in_array($attendee,$listInitials)) {
          $this->attendees.=($this->attendees)?', ':'';
          $aff=new Affectable(array_search($attendee,$listInitials));         
          $this->attendees.='"' . ( ($aff->name)?$aff->name:(($aff->userName)?$aff->userName:$stockAttendee)) . '"';
          if ($aff->email) {
            $this->attendees.=' <' . $aff->email . '>';
          }
        } else if (in_array($attendee,$listTeam)) {
          $this->attendees.=($this->attendees)?', ':'';
          $id=array_search($attendee,$listTeam);
          $aff=new Affectable();
          $lst=$aff->getSqlElementsFromCriteria(array('idTeam'=>$id));
          foreach ($lst as $aff) {
            $this->attendees.=($this->attendees)?', ':'';
            $this->attendees.='"' . ( ($aff->name)?$aff->name:(($aff->userName)?$aff->userName:$stockAttendee)) . '"';
            if ($aff->email) {
              $this->attendees.=' <' . $aff->email . '>';
            }
          }
        } else {
          $this->attendees.=($this->attendees)?', ':'';
          $this->attendees.=$stockAttendee;
        }
      }
      $this->attendees=str_ireplace(',  ', ', ', $this->attendees);
      $this->attendees=str_ireplace(',  ', ', ', $this->attendees);
    }
    return parent::save();
  }

  
}
?>