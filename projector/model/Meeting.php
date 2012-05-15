<?php 
/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
class Meeting extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_description;
  public $id;    // redefine $id to specify its visible place 
  public $reference;
  public $idProject;
  public $idMeetingType;
  public $meetingDate;
  public $_lib_from;
  public $meetingStartTime;
  public $_lib_to;
  public $meetingEndTime;
  public $name;
  public $location;
  public $attendees;
  public $_spe_buttonSendMail;
  public $idUser;
  public $description;
  public $_col_2_2_treatment;
  public $idStatus;
  public $idResource;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $result;
  //public $_sec_linkDecision;
  //public $_Link_Decision=array();
  //public $_sec_linkQuestion;
  //public $_Link_Question=array();
  public $_col_1_1_link;
  public $_Link=array();
  public $_Attachement=array();
  public $_Note=array();


  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameProject" width="15%" >${idProject}</th>
    <th field="nameMeetingType" width="15%" >${idMeetingType}</th>
    <th field="meetingDate" formatter="dateFormatter" width="15%" >${meetingDate}</th>
    <th field="name" width="25%" >${name}</th>
    <th field="colorNameStatus" width="10%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="handled" width="5%" formatter="booleanFormatter" >${handled}</th>
    <th field="done" width="5%" formatter="booleanFormatter" >${done}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
                                  "idProject"=>"required",
                                  "idMeetingType"=>"required",
                                  "meetingDate"=>"required, nobr",
                                  "_lib_from"=>'nobr',
                                  "_lib_to"=>'nobr',
                                  "meetingStartTime"=>'nobr',
                                  "idUser"=>"hidden",
                                  "idResource"=>"idden",
                                  "idStatus"=>"required",
                                  "handled"=>"nobr",
                                  "done"=>"nobr",
                                  "idle"=>"nobr"
  );  
  
  private static $_colCaptionTransposition = array('result'=>'minutes', 'idResource'=>'responsible');
  
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
    } else if ($colName=="initialDueDate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (dijit.byId("actualDueDate").get("value")==null) { ';
      $colScript .= '    dijit.byId("actualDueDate").set("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';     
    } else if ($colName=="actualDueDate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (dijit.byId("initialDueDate").get("value")==null) { ';
      $colScript .= '    dijit.byId("initialDueDate").set("value", this.value); ';
      $colScript .= '  } ';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';           
    } else     if ($colName=="idle") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("idleDate").get("value")==null) {';
      $colScript .= '      var curDate = new Date();';
      $colScript .= '      dijit.byId("idleDate").set("value", curDate); ';
      $colScript .= '    }';
      $colScript .= '    if (! dijit.byId("done").get("checked")) {';
      $colScript .= '      dijit.byId("done").set("checked", true);';
      $colScript .= '    }';  
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("idleDate").set("value", null); ';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="done") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("doneDate").get("value")==null) {';
      $colScript .= '      var curDate = new Date();';
      $colScript .= '      dijit.byId("doneDate").set("value", curDate); ';
      $colScript .= '    }';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("doneDate").set("value", null); ';
      $colScript .= '    if (dijit.byId("idle").get("checked")) {';
      $colScript .= '      dijit.byId("idle").set("checked", false);';
      $colScript .= '    }'; 
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }

  public function drawSpecificItem($item){
    global $print;
    $result="";
    if ($item=='buttonSendMail') {
      if ($print) {
        return "";
      }
      $result .= '<tr><td valign="top" class="label"><label></label></td><td>';
      $result .= '<button id="sendMailToAttendees" dojoType="dijit.form.Button" showlabel="true"';
      $result .= ' title="' . i18n('sendMailToAttendees') . '" >';
      $result .= '<span>' . i18n('sendMailToAttendees') . '</span>';
      $result .=  '<script type="dojo/connect" event="onClick" args="evt">';
      $result .= '   if (checkFormChangeInProgress()) {return false;}';
      $result .=  '  loadContent("../tool/sendMail.php","resultDiv","objectForm",true);';
      $result .= '</script>';
      $result .= '</button>';
      $result .= '</td></tr>';
      return $result;
    }
  }

  public function save() {
  	if (! $this->name) {
      $this->name=SqlList::getNameFromId('MeetingType',$this->idMeetingType) . " " . $this->meetingDate;
  	}
    $listTeam=SqlList::getList('Team','name');
    $listName=SqlList::getList('Affectable');
    $listUserName=SqlList::getList('Affectable','userName');
    $listInitials=SqlList::getList('Affectable','initials');
    if ($this->attendees) {
      $listAttendees=explode(',',$this->attendees);
      $this->attendees="";
      foreach ($listAttendees as $attendee) {
        $attendee=trim($attendee);
        if (in_array($attendee,$listName)) {
          $this->attendees.=($this->attendees)?', ':'';
          $this->attendees.='"' . $attendee . '"';
          $aff=SqlElement::getSingleSqlElementFromCriteria('Affectable',array('name'=>$attendee));
          if ($aff->email) {
            $this->attendees.=' <' . $aff->email . '>';
          }
        } else if (in_array($attendee,$listUserName)) {
          $this->attendees.=($this->attendees)?', ':'';
          $aff=SqlElement::getSingleSqlElementFromCriteria('Affectable',array('userName'=>$attendee));
          $this->attendees.='"' . (($aff->name)?$aff->name:$attendee) . '"';
          if ($aff->email) {
            $this->attendees.=' <' . $aff->email . '>';
          }
        } else if (in_array($attendee,$listInitials)) {
          $this->attendees.=($this->attendees)?', ':'';
          $aff=SqlElement::getSingleSqlElementFromCriteria('Affectable',array('initials'=>$attendee));
          $this->attendees.='"' . ( ($aff->name)?$aff->name:(($aff->userName)?$aff->userName:$attendee)) . '"';
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
            $this->attendees.='"' . ( ($aff->name)?$aff->name:(($aff->userName)?$aff->userName:$attendee)) . '"';
            if ($aff->email) {
              $this->attendees.=' <' . $aff->email . '>';
            }
          }
        } else {
          $this->attendees.=($this->attendees)?', ':'';
          $this->attendees.=$attendee;
        }
      }

    }
    return parent::save();

  }

  function sendMail() {
    global $paramMailSender, $paramMailReplyTo;
    $lstDest=explode(',',$this->attendees);
    $lstMail=array();
    foreach ($lstDest as $dest) {
      $to="";
      $name="";
      $start=strpos($dest,'<');
      if ($start>0) {
        $end=strpos($dest,'>');
        $to=substr( $dest, $start+1, $end-$start-1);
      } else if (strpos($dest,'@')>0){
        $to=$dest;
      }
      $nameExplode=explode('"',$dest);
      if (count($nameExplode)>=2){
        $name=$nameExplode[1];
      }
      if ($to) {
        if (!$name) {
          $name=$to;
        }
        $lstMail[$name]=$to;
      }
    }
    $sent=0;
    $vcal = "BEGIN:VCALENDAR\r\n";
    $vcal .= "VERSION:2.0\r\n";
    $vcal .= "PRODID:-//CompanyName//ProductName//EN\r\n";
    $vcal .= "METHOD:REQUEST\r\n";
    $vcal .= "BEGIN:VEVENT\r\n";
    $user=$_SESSION['user'];
    $vcal .= "ORGANIZER;CN=" . (($user->resourceName)?$user->resourceName:$user->name). ":MAILTO:$user->email\r\n";
    foreach($lstMail as $name=>$to) {
      $vcal .= "ATTENDEE;CN=\"$name\";ROLE=REQ-PARTICIPANT;RSVP=FALSE:MAILTO:$to\r\n";
    }
    $vcal .= "UID:".date('Ymd').'T'.date('His')."-".rand()."-domain.com\r\n";
    $vcal .= "DTSTAMP:".date('Ymd').'T'.date('His')."\r\n";
    $vcal .= "DTSTART:" . str_replace('-','',$this->meetingDate) . 'T' . str_replace(':','',$this->meetingStartTime) . "\r\n";
    $vcal .= "DTEND:" . str_replace('-','',$this->meetingDate) . 'T' .str_replace('','',$this->meetingEndTime) . "\r\n";
    if ($this->location != "") $vcal .= "LOCATION:$this->location\r\n";
    $vcal .= "SUMMARY:$this->name\r\n";
    $vcal .= "DESCRIPTION:$this->description\r\n";
    $vcal .= "BEGIN:VALARM\r\n";
    $vcal .= "TRIGGER:-PT15M\r\n";
    $vcal .= "ACTION:DISPLAY\r\n";
    $vcal .= "DESCRIPTION:Reminder\r\n";
    $vcal .= "END:VALARM\r\n";
    $vcal .= "END:VEVENT\r\n";
    $vcal .= "END:VCALENDAR\r\n";

    $sender=($user->email)?$user->email:$paramMailSender;
    $replyTo=($user->email)?$user->email:$paramMailReplyTo;
    $headers = "From: $sender\r\nReply-To: $replyTo";
    $headers .= "\r\nMIME-version: 1.0\r\nContent-Type: text/calendar; method=REQUEST; charset=\"utf-8\"";
    $headers .= "\r\nContent-Transfer-Encoding: 7bit\r\nX-Mailer: Microsoft Office Outlook 12.0";
    //mail($to, $this->description, $vcal, $headers);
    $destList="";
    foreach($lstMail as $name=>$to) {
      $destList.=($destList)?',':'';
      $destList.=$to;
      $sent++;
    }

    $result=sendMail($destList, $this->name, $vcal, $this, $headers,$sender);
    if (! $result) {$sent=0;}
    return $sent;

  }
}
?>