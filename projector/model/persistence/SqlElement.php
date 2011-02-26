<?php
/** ===========================================================================**********
 * Abstract class defining all methods to interact with database, 
 * using Sql class.
 * Give public visibility to elementary methods (save, delete, copy, ...) 
 * and constructor.
 */
abstract class SqlElement {
   // List of fields that will be exposed in general user interface
  public $id; // every SqlElement have an id !!!
  
  // Store the layout of the different object classes
  private static $_tablesFormatList=array();

  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%"># ${id}</th>
    <th field="name" width="85%">${name}</th> 
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';

  // Define the specific field attributes
  private static $_fieldsAttributes=array("name"=>"required");

  // All dependencies between objects :
  //    control => sub-object must not exist to allow deletion
  //    cascade => sub-objects are automaticaly deleted
  private static $_relationShip=array(
    "AccessProfile" =>      array("AccessRight"=>"cascade"),
    "AccessScopeRead" =>    array("AccessProfile"=>"control"),
    "AccessScopeCreate" =>  array("AccessProfile"=>"control"),
    "AccessScopeUpdate" =>  array("AccessProfile"=>"control"),
    "AccessScopeDelete" =>  array("AccessProfile"=>"control"),
    "Assignment" =>         array("Work"=>"control",
                                  "PlannedWork"=>"cascade"),
    "Action" =>             array("Note"=>"cascade",
                                  "Link"=>"cascade"),
    "ActionType" =>         array("Action"=>"control"),
    "Activity" =>           array("Milestone"=>"control", 
                                  "Activity"=>"control", 
                                  "Ticket"=>"control",
                                  "Assignment"=>"control",
                                  "Note"=>"cascade",
                                  "Attachement"=>"cascade",
                                  "Dependency"=>"cascade"),
    "ActivityType" =>       array("Activity"=>"control"),
    "Client" =>             array("Project"=>"control"),
    "Criticality" =>        array("Risk"=>"control", 
                                  "Ticket"=>"control"),
    "DecisionType" =>       array("Decision"=>"control"),
    "Filter" =>             array("FilterCriteria"=>"cascade"),
    "Function" =>           array("Affectation"=>"control", 
                                  "Assignment"=>"control",
                                  "Resource"=>"control",
                                  "ResourceCost"=>"control"),
    "Issue" =>              array("Attachement"=>"cascade",
                                  "Note"=>"cascade",
                                  "Link"=>"cascade"),
    "IssueType" =>          array("Issue"=>"control"),
    "Likelihood" =>         array("Risk"=>"control"),
    "MeetingType" =>        array("Meeting"=>"control"),
    "Menu" =>               array("AccessRight"=>"cascade"),
    "MessageType" =>        array("Message"=>"control"),
    "Milestone" =>          array("Attachement"=>"cascade",
                                  "Note"=>"cascade",
                                  "Dependency"=>"cascade"),
    "MilestoneType" =>      array("Milestone"=>"control"),
    "Priority" =>           array("Issue"=>"control", 
                                  "Ticket"=>"control"),
    "Profile" =>            array("AccessRight"=>"cascade",
                                  "Habilitation"=>"cascade",
                                  "Message"=>"cascade",
                                  "Resource"=>"control",
                                  "User"=>"control"),
    "Project" =>            array("Action"=>"control", 
                                  "Activity"=>"control",
                                  "Affectation"=>"control",
                                  "Issue"=>"control",
                                  "Message"=>"cascade",
                                  "Milestone"=>"control",
                                  "Parameter"=>"cascade", 
                                  "Project"=>"control", 
                                  "Risk"=>"control", 
                                  "Ticket"=>"control",
                                  "Work"=>"control",
                                  "Dependency"=>"cascade",
                                  "Decision"=>"control",
                                  "Meeting"=>"control",
                                  "Question"=>"control"),
    "QuestionType" =>       array("Question"=>"control"),
    "Resource" =>           array("Action"=>"control", 
                                  "Activity"=>"control",
                                  "Affectation"=>"control",
                                  "Assignment"=>"control",
                                  "Issue"=>"control",
                                  "Milestone"=>"control", 
                                  "Risk"=>"control", 
                                  "Ticket"=>"control",
                                  "Work"=>"control",
                                  "Decision"=>"control",
                                  "Meeting"=>"control",
                                  "Question"=>"control",
                                  "ResourceCost"=>"delete"),
    "Risk" =>               array("Attachement"=>"cascade",
                                  "Note"=>"cascade",
                                  "Link"=>"cascade"),
    "RiskType" =>           array("Risk"=>"control"),
    "Severity" =>           array("Risk"=>"control"),
    "Status" =>             array("Action"=>"control", 
                                  "Activity"=>"control",
                                  "Issue"=>"control",
                                  "Milestone"=>"control", 
                                  "Risk"=>"control", 
                                  "Ticket"=>"control",
                                  "Decision"=>"control",
                                  "Meeting"=>"control",
                                  "Question"=>"control",
                                  "StatusMail"=>"cascade"),
    "Team" =>               array("Resource"=>"control"),
    "Ticket" =>             array("Attachement"=>"cascade",
                                  "Note"=>"cascade"),
    "TicketType" =>         array("Ticket"=>"control"),
    "Urgency" =>            array("Ticket"=>"control"),
    "User" =>               array("Action"=>"control", 
                                  "Activity"=>"control",
                                  "Attachement"=>"control",
                                  "Issue"=>"control",
                                  "Message"=>"cascade",
                                  "Milestone"=>"control",
                                  "Note"=>"control",
                                  "Parameter"=>"cascade", 
                                  "Project"=>"control", 
                                  "Risk"=>"control", 
                                  "Ticket"=>"control",
                                  "Decision"=>"control",
                                  "Meeting"=>"control",
                                  "Question"=>"control"),
    "Workflow" =>            array("WorkflowStatus"=>"cascade", 
                                  "TicketType"=>"control", 
                                  "ActivityType"=>"control", 
                                  "MilestoneType"=>"control", 
                                  "RiskType"=>"control", 
                                  "ActionType"=>"control", 
                                  "IssueType"=>"control",)
  );
// Not taken into account :
// XxxPlanningelement => Project, XxxPlanningMode  

  /** =========================================================================
   * Constructor. Protected because this class must be extended.
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */
  protected function __construct($id = NULL) {
    $this->id=$id;
    if ($this->id=='') {
      $this->id=null;
    }
    $this->getSqlElement();
  }

  /** =========================================================================
   * Destructor
   * @return void
   */ 
  protected function __destruct() {
  }
  
// ============================================================================**********
// UPDATE FUNCTIONS
// ============================================================================**********
  
  /** =========================================================================
   * Give public visibility to the saveSqlElement action
   * @return message including definition of html hiddenfields to be used 
   */
  public function save() {
    return $this->saveSqlElement();
  }

  /** =========================================================================
   * Give public visibility to the purgeSqlElement action
   * @return message including definition of html hiddenfields to be used 
   */
  public function purge($clause) {
    return $this->purgeSqlElement($clause);
  }
  
  /** =========================================================================
   * Give public visibility to the deleteSqlElement action
   * @return message including definition of html hiddenfields to be used 
   */
  public function delete() {
    return $this->deleteSqlElement();
  }
  
  /** =========================================================================
   * Give public visibility to the copySqlElement action
   * @return the new object
   */
  public function copy() {
    return $this->copySqlElement();
  }

  /** =========================================================================
   * Save an object to the database
   * @return void
   */
  private function saveSqlElement() {
    // #305
    $this->recalculateCheckboxes();    
    // select operation to be executed
    $control=$this->control();
    if ($control=="OK") {
      $statusChanged=false;
      if ($this->id != null) {
        if (property_exists($this, 'idStatus')) {
          if ($this->idStatus) {
            $class=get_class($this);
            $old=new $class($this->id);
            if ($old->idStatus!=$this->idStatus) {
              $statusChanged=true;
            }            
          }
        }
        $returnValue=$this->updateSqlElement();
      } else {
        if (property_exists($this, 'idStatus')) {
          $statusChanged=true;
        }
        $returnValue=$this->insertSqlElement();
      }
      if ($statusChanged and stripos($returnValue,'id="lastOperationStatus" value="OK"')>0 ) {
        $mailResult=$this->sendMailIfMailable();
        if ($mailResult) {
          $returnValue=str_replace('${mailMsg}',' - ' . i18n('mailSent'),$returnValue);
        } else {
          $returnValue=str_replace('${mailMsg}','',$returnValue);
        }
      } else {
        $returnValue=str_replace('${mailMsg}','',$returnValue);
      }
      return $returnValue;
    } else {
      // errors on control => don't save, display error message
      $returnValue='<b>' . i18n('messageInvalidControls') . '</b><br/>' . $control;
      $returnValue .= '<input type="hidden" id="lastSaveId" value="' . $this->id . '" />';
      $returnValue .= '<input type="hidden" id="lastOperation" value="control" />';
      $returnValue .= '<input type="hidden" id="lastOperationStatus" value="INVALID" />';
      return $returnValue;
    }
  }

  /** =========================================================================
   * Save an object to the database : new object
   * @return void
   */
  private function insertSqlElement() {
    $depedantObjects=array();
    $returnStatus="OK";
    $objectClass = get_class($this);
    $query="insert into " . $this->getDatabaseTableName();
    $queryColumns="";
    $queryValues="";
    // initialize object definition criteria
    $crit=$this->getDatabaseCriteria();
    foreach ($crit as $col_name => $col_value) {
      $dataType = $this->getDataType($col_name);
      $dataLength = $this->getDataLength($col_name);
      if ($dataType=='int' and $dataLength==1) {
        if ($col_value==NULL or $col_value=="") {
          $col_value='0';
        }
      }
      if ($col_value != NULL and $col_value != '' and $col_value != ' ' and $col_name != 'id') {
        if ($queryColumns != "") {
          $queryColumns.=", ";
          $queryValues.=", ";
        }
        $queryColumns .= $this->getDatabaseColumnName($col_name);
        $queryValues .= "'" . Sql::str($col_value, $objectClass) . "'";
      }    
    }
    // get all data
    foreach($this as $col_name => $col_value) {
      if (substr($col_name,0,1)=="_") {
        // not a fiels, just for presentation purpose
      } else if (ucfirst($col_name) == $col_name) {
        // if property is an object, store it to save it at the end of script
        $depedantObjects[$col_name]=($this->$col_name);
      } else {
        $dataType = $this->getDataType($col_name);
        $dataLength = $this->getDataLength($col_name);
        if ($dataType=='int' and $dataLength==1) {
          if ($col_value==NULL or $col_value=="") {
            $col_value='0';
          }
        }
        if ($col_value != NULL and $col_value != '' and $col_value != ' ' 
            and $col_name != 'id' 
            and strpos($queryColumns, ' '. $this->getDatabaseColumnName($col_name) . ' ')===false ) {
          if ($queryColumns != "") {
            $queryColumns.=",";
            $queryValues.=", ";
          }
          $queryColumns .= ' ' . $this->getDatabaseColumnName($col_name) . ' ';
          $queryValues .= "'" . Sql::str($col_value, $objectClass) . "'";
        }
      }
    }
    $query.=" ($queryColumns) values ($queryValues)";
    // execute request
    $result = Sql::query($query);
    if (!$result) {
      $returnStatus="ERROR";
    }
    // save history
    $newId= Sql::$lastQueryNewid;
    $this->id=$newId;
    if ($returnStatus!="ERROR" and ! property_exists($this,'_noHistory') ) {      
      $result = History::store($objectClass,$newId,'insert');
      if (!$result) {$returnStatus="ERROR";}
    }
    // save depedant elements (properties that are objects)
    if ($returnStatus!="ERROR") {
      $returnStatus=$this->saveDependantObjects($depedantObjects,$returnStatus);
    }
    // Prepare return data
    if ($returnStatus!="ERROR") {
      $returnValue=i18n(get_class($this)) . ' #' . $this->id . ' ' . i18n('resultInserted');
    } else {
      $returnValue=Sql::$lastQueryErrorMessage;
    }
    if ($returnStatus=="OK") {
      $returnValue .= '${mailMsg}';
    }
    $returnValue .= '<input type="hidden" id="lastSaveId" value="' . $this->id . '" />';
    $returnValue .= '<input type="hidden" id="lastOperation" value="insert" />';
    $returnValue .= '<input type="hidden" id="lastOperationStatus" value="' . $returnStatus . '" />';
    return $returnValue;
  }
 
  /** =========================================================================
   * save an object to the database : existing object
   * @return void
   */
  private function updateSqlElement() {
//traceLog('updateSqlElement (for ' . get_class($this) . ' #' . $this->id . ')');
    $returnValue = i18n('messageNoChange') . ' ' . i18n(get_class($this)) . ' #' . $this->id;
    $returnStatus = 'NO_CHANGE';
    $depedantObjects=array();
    $objectClass = get_class($this);
    $idleChange=false;
    // Get old values (stored) to : 1) build the smallest query 2) save change history
    $oldObject = null;
    if (array_key_exists('currentObject',$_SESSION)) {
      $testObject = $_SESSION['currentObject'];
      if ($testObject) {
        if (get_class($testObject)==$objectClass) {
          $oldObject=$testObject;
        }
      }
    }
    if (! $oldObject) {
      $oldObject = new $objectClass($this->id);
    }
    $nbChanged=0;
    $query="update " . $this->getDatabaseTableName();
    // get all data, and identify if changes
    foreach($this as $col_name => $col_new_value) {     
      if (substr($col_name,0,1)=="_") {
        // not a fiels, just for presentation purpose
      } else if (ucfirst($col_name) == $col_name) {
        $depedantObjects[$col_name]=($this->$col_name);
      } else {
        $dataType = $this->getDataType($col_name);
        $dataLength = $this->getDataLength($col_name);
        if ($dataType=='int' and $dataLength==1) {
          if ($col_new_value==NULL or $col_new_value=="") {
            $col_new_value='0';
          }
        }
        $col_old_value=$oldObject->$col_name;
        // special null treatment (new value)
        $col_new_value=SQL::str(trim($col_new_value));
        if ($col_new_value=='') {$col_new_value=NULL;};
        // special null treatment (old value)
        $col_old_value=SQL::str(trim($col_old_value));
        if ($col_old_value=='') {$col_old_value=NULL;};
        // if changed
        if ($col_new_value != $col_old_value) {
          if ($col_name=='idle') {$idleChange=true;}
          $query .= ($nbChanged==0)?" set ":", ";
          if ($col_new_value==NULL or $col_new_value=='') {
            $query .= $this->getDatabaseColumnName($col_name) . " = NULL";
          } else {
            $query .= $this->getDatabaseColumnName($col_name) . " = '" . $col_new_value ."' ";
          }
          $nbChanged+=1;
          // Save change history
          if ($objectClass!='History' and ! property_exists($this,'_noHistory') ) {      
            $result = History::store($objectClass,$this->id,'update', $col_name, $col_old_value, $col_new_value);
            if (!$result) {
              $returnStatus="ERROR";
              $returnValue=Sql::$lastQueryErrorMessage;
            }
          }
        }
      }
    }
    $query .= " where id='" . Sql::str($this->id) . "'";
    // If changed, execute the query
    if ($nbChanged > 0 and $returnStatus!="ERROR") {
      // Catch errors, and return error message
      $result = Sql::query($query);
      if ($result) {
        if (Sql::$lastQueryNbRows==0) {
          $test=new $objectClass($this->id);
          if ($this->id!=$test->id) {
            $returnValue = i18n('messageItemDelete', array(i18n(get_class($this)), $this->id));  
            $returnStatus='ERROR';
          } else {   
            $returnValue = i18n('messageNoChange') . ' ' . i18n(get_class($this)) . ' #' . $this->id;
            $returnStatus = 'NO_CHANGE';
          }     
        } else {
            $returnValue=i18n(get_class($this)) . ' #' . $this->id . ' ' . i18n('resultUpdated');
            $returnStatus='OK';
        }
      } else {
        $returnValue=Sql::$lastQueryErrorMessage;
        $returnStatus="ERROR";
      }      
    }
    
    // if object is Asignable, update assignments on idle change
    // TODO : add constrain 'is assignable'
    if ($idleChange and $returnStatus!="ERROR") {
      $ass=new Assignment();
      $query="update " . $ass->getDatabaseTableName();
      $query.=" set idle='" . $this->idle . "'";
      $query.=" where refType='" . get_class($this) . "' ";
      $query.=" and refId='" . $this->id . "'";
      $result = Sql::query($query);
      if ($returnStatus=="ERROR") {
        $returnValue=Sql::$lastQueryErrorMessage;
        $returnStatus='ERROR';         
      } 
    }
    
    // save depedant elements (properties that are objects)
    if ($returnStatus!="ERROR") { 
      $returnStatus=$this->saveDependantObjects($depedantObjects,$returnStatus);
      if ($returnStatus=="ERROR") {
        $returnValue=Sql::$lastQueryErrorMessage;
      }
      if ($returnStatus=="OK") {
        $returnValue=i18n(get_class($this)) . ' #' . $this->id . ' ' . i18n('resultUpdated');
      }
    }
    if ($returnStatus=="OK") {
      $returnValue .= '${mailMsg}';
    }
    // Prepare return data
    $returnValue .= '<input type="hidden" id="lastSaveId" value="' . $this->id . '" />';
    $returnValue .= '<input type="hidden" id="lastOperation" value="update" />';
    $returnValue .= '<input type="hidden" id="lastOperationStatus" value="' . $returnStatus . '" />';
    return $returnValue;
  }

  /** =========================================================================
   * Save the dependant objects stored in a list (may be single objects or list
   * @param $depedantObjects list (array) of objects to store
   * @return void
   */
  private function saveDependantObjects($depedantObjects,$returnStatus) { 
    $returnStatusDep=$returnStatus;
    foreach ($depedantObjects as $class => $depObj) {
      if (is_array($depObj) and $returnStatusDep!="ERROR" ) {
        foreach ($depObj as $depClass => $depObjOccurence) {
          if ($depObjOccurence instanceof SqlElement and $returnStatusDep!="ERROR") {
            $depObjOccurence->refId=$this->id;
            $depObjOccurence->refType=get_class($this);
            $ret=$depObjOccurence->saveSqlElement();
            if (stripos($ret,'id="lastOperationStatus" value="ERROR"')) {
              $returnStatusDep="ERROR";
            } else if (stripos($ret,'id="lastOperationStatus" value="OK"')) {
              $returnStatusDep='OK';
            }
          }
        }
      } else if ($depObj instanceof SqlElement and $returnStatusDep!="ERROR") {
        $depObj->refId=$this->id;
        $depObj->refType=get_class($this);
        $ret=$depObj->save();
        if (stripos($ret,'id="lastOperationStatus" value="ERROR"')) {
          $returnStatusDep="ERROR";
        } else if (stripos($ret,'id="lastOperationStatus" value="OK"')) {
          $returnStatusDep='OK';
        }
      }
    }
    return $returnStatusDep;
  }
  /** =========================================================================
   * Delete an object from the database
   * @return void
   */
  private function deleteSqlElement() {
    $objectClass = get_class($this);
    $control=$this->deleteControl();
    if ($control!="OK") {
      // errors on control => don't save, display error message
      $returnValue='<b>' . i18n('messageInvalidControls') . '</b><br/>' . $control;
      $returnValue .= '<input type="hidden" id="lastSaveId" value="' . $this->id . '" />';
      $returnValue .= '<input type="hidden" id="lastOperation" value="control" />';
      $returnValue .= '<input type="hidden" id="lastOperationStatus" value="INVALID" />';
      return $returnValue;
    }
    foreach($this as $col_name => $col_value) {
      // if property is an array containing objects, delete each
      if (is_array($this->$col_name)) {
        foreach ($this->$col_name as $obj) {
          if ($obj instanceof SqlElement) {
            if ($obj->id and $obj->id!='') { // object may be a "new" element, so try to delete only if id exists
              $obj->delete();
            }
          }
        }
      } else if (ucfirst($col_name) == $col_name) {
        // if property is an object, delete it
        if ($this->$col_name instanceof SqlElement) {
          if ($this->$col_name->id and $this->$col_name->id!='') { // object may be a "new" element, so try to delete only if id exists
            $this->$col_name->delete();
          }
        }
      } 
    }
    // check relartionship : if "cascade", then auto delete
    $relationShip=self::$_relationShip;
    if (array_key_exists(get_class($this),$relationShip)) {
      $relations=$relationShip[get_class($this)];
      foreach ($relations as $object=>$mode) {
        if ($mode=="cascade") {      
                  $where=null;
          $crit=array('id' . get_class($this) => $this->id);
          if ($object=="Assignment" or $object=="Note" or $object=="Attachement") {
            $crit=array("refType"=>get_class($this), "refId"=>$this->id);
          }
          if ($object=="Dependency") {
            $crit=null;
            $where="(predecessorRefType='" . get_class($this) . "' and predecessorRefId='" . $this->id ."')"
             . " or (successorRefType='" . get_class($this) . "' and successorRefId='" . $this->id ."')"; 
          }
          if ($object=="Link") {
            $crit=null;
            $where="(ref1Type='" . get_class($this) . "' and ref1Id='" . $this->id ."')"
             . " or (ref2Type='" . get_class($this) . "' and ref2Id='" . $this->id ."')"; 
          }
          $obj=new $object();
          $list=$obj->getSqlElementsFromCriteria($crit,false,$where);
          foreach ($list as $subObj) {
            $subObj->delete();
          }
        }
      }
    }
    $query="delete from " .  $this->getDatabaseTableName() . " where id='" . $this->id . "'";
    // execute request
    $returnStatus="OK";
    $result = Sql::query($query);
    if (!$result) {
      $returnStatus="ERROR";
    }    
    // save history
    if ($returnStatus!="ERROR" and ! property_exists($this,'_noHistory') ) {      
      $result = History::store($objectClass,$this->id,'delete');
      if (!$result) {$returnStatus="ERROR";}
    }
    if ($returnStatus!="ERROR") {
      $returnValue=i18n(get_class($this)) . ' #' . $this->id . ' ' . i18n('resultDeleted');   
    } else {
      $returnValue=Sql::$lastQueryErrorMessage;
    } 
    $returnValue .= '<input type="hidden" id="lastSaveId" value="' . $this->id . '" />';
    $returnValue .= '<input type="hidden" id="lastOperation" value="delete" />';
    $returnValue .= '<input type="hidden" id="lastOperationStatus" value="' . $returnStatus .'" />';
    $returnValue .= '<input type="hidden" id="noDataMessage" value="' . htmlGetNoDataMessage(get_class($this)) . '" />';
    return $returnValue;
  }


  /** =========================================================================
   * Purge objects from the database : delete all objects corresponding 
   * to clause $ clause
   * Important : 
   *   => does not automatically purges included elements ...
   *   => does not include history insertion
   * @return void
   */
  private function purgeSqlElement($clause) {
    $objectClass = get_class($this);
    // get all data, and identify if changes
    $query="delete from " .  $this->getDatabaseTableName() . " where " . $clause;
    // execute request
    $returnStatus="OK";
    $result = Sql::query($query);
    if (!$result) {
      $returnStatus="ERROR";
    }    
    if ($returnStatus!="ERROR") {
      $returnValue=Sql::$lastQueryNbRows . " " . i18n(get_class($this)) . '(s) ' . i18n('resultDeleted');   
    } else {
      $returnValue=Sql::$lastQueryErrorMessage;
    } 
    $returnValue .= '<input type="hidden" id="lastSaveId" value="' . $this->id . '" />';
    $returnValue .= '<input type="hidden" id="lastOperation" value="delete" />';
    $returnValue .= '<input type="hidden" id="lastOperationStatus" value="' . $returnStatus .'" />';
    $returnValue .= '<input type="hidden" id="noDataMessage" value="' . htmlGetNoDataMessage(get_class($this)) . '" />';
    return $returnValue;
  }
  
  /** =========================================================================
   * Copy the curent object as a new one of the same class
   * @return the new object
   */
  private function copySqlElement() {
    $newObj=clone $this;
    $newObj->id=null;
    if (property_exists($newObj,"wbs")) {
      $newObj->wbs=null;
    }
    if (property_exists($newObj,"topId")) {
      $newObj->topId=null;
    }
    if (property_exists($newObj,"idStatus")) {
      $list=SqlList::getList('Status');
      $revert=array_keys($list);
      $newObj->idStatus=$revert[0];
    }
    if (property_exists($newObj,"idUser")) {
      $newObj->idUser=$_SESSION['user']->id;
    }
    if (property_exists($newObj,"creationDate")) {
      $newObj->creationDate=date('Y-m-d');
    }
    if (property_exists($newObj,"creationDateTime")) {
      $newObj->creationDateTime=date('Y-m-d G:i');
    }
    if (property_exists($newObj,"done")) {
      $newObj->done=0;
    }
    if (property_exists($newObj,"idle")) {
      $newObj->idle=0;
    }
    if (property_exists($newObj,"idleDate")) {
      $newObj->idleDate=0;
    }
      if (property_exists($newObj,"doneDate")) {
      $newObj->doneDate=0;
    }
      if (property_exists($newObj,"idleDateTime")) {
      $newObj->idleDateTime=0;
    }
      if (property_exists($newObj,"doneDateTime")) {
      $newObj->doneDateTime=0;
    }
    foreach($newObj as $col_name => $col_value) {
      if (ucfirst($col_name) == $col_name) {
        // if property is an object, delete it
        if ($newObj->$col_name instanceof SqlElement) {
          $newObj->$col_name->id=null;
          if (property_exists($newObj->$col_name,"wbs")) {
            $newObj->$col_name->wbs=null;
          }
          if (property_exists($newObj->$col_name,"topId")) {
            $newObj->$col_name->topId=null;
          }
          if ($newObj->$col_name instanceof PlanningElement) {
            $newObj->$col_name->plannedStartDate="";
            $newObj->$col_name->realStartDate="";
            $newObj->$col_name->plannedEndDate="";
            $newObj->$col_name->realEndDate="";
            $newObj->$col_name->plannedDuration="";
            $newObj->$col_name->realDuration="";
            $newObj->$col_name->assignedWork="";
            $newObj->$col_name->plannedWork="";
            $newObj->$col_name->leftWork="";
            $newObj->$col_name->realWork="";
            $newObj->$col_name->idle=0;
            $newObj->$col_name->done=0;
          }
        }       
      } 
    }
    $result=$newObj->saveSqlElement();
    if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) { 
      $returnValue=i18n(get_class($this)) . ' #' . $this->id . ' ' . i18n('resultCopied') . ' #' . $newObj->id;    
      $returnValue .= '<input type="hidden" id="lastSaveId" value="' . $newObj->id . '" />';
      $returnValue .= '<input type="hidden" id="lastOperation" value="copy" />';
      $returnValue .= '<input type="hidden" id="lastOperationStatus" value="OK" />';
    } else {
      $returnValue=$result;
    }
    $newObj->_copyResult=$returnValue; 
    return $newObj;
  }
    

// ============================================================================**********
// GET AND FETCH OBJECTS FUNCTIONS
// ============================================================================**********
  
  /** =========================================================================
   * Retrieve an object from the Request (modified Form) - Public method
   * @return void (operate directly on the object)
   */
  public function fillFromRequest() {
    $this->fillSqlElementFromRequest();
  }
  
  /**  ========================================================================
   * Retrieve a list of objects from the Database
   * Called from an empty object of the expected class
   * @param $critArray the critera asd an array
   * @param $initializeIfEmpty boolean indicating if no result returns an 
   * initialised element or not
   * @param $clauseWhere Sql Where clause (alternative way to define criteria)
   *        => $critArray must not be set 
   * @param $clauseOrderBy Sql Order By clause 
   * @return an array of objects
   */
  public function getSqlElementsFromCriteria($critArray, $initializeIfEmpty=false, 
  $clauseWhere=null, $clauseOrderBy=null, $getIdInKey=false ) {
    // Build where clause from criteria
    $whereClause='';
    $objects=array();
    $className=get_class($this);
    $defaultObj = new $className();
    if ($critArray) {
      foreach ($critArray as $colCrit => $valCrit) {
        $whereClause.=($whereClause=='')?' where ':' and ';
        if ($valCrit==null) {
          $whereClause.=$this->getDatabaseTableName() . '.' . $this->getDatabaseColumnName($colCrit) . ' is null';
        } else { 
          $whereClause.=$this->getDatabaseTableName() . '.' . $this->getDatabaseColumnName($colCrit) . " = '" . Sql::str($valCrit) . "' ";
        }
        $defaultObj->$colCrit=$valCrit;
      }
    } else if ($clauseWhere) { 
      $whereClause = ' where ' . $clauseWhere;
    }
    // If $whereClause is set, get the element from Database
    $query = "select * from " . $this->getDatabaseTableName() . $whereClause;
    if ($clauseOrderBy) {
      $query .= ' order by ' . $clauseOrderBy;
    } else if (isset($this->sortOrder)) {
      $query .= ' order by ' . $this->getDatabaseTableName() . '.sortOrder';
    }
    $result = Sql::query($query); 
    if (Sql::$lastQueryNbRows > 0) {
      $line = Sql::fetchLine($result);
      while ($line) {
        $obj=clone($this);
        // get all data fetched
        $keyId=null;
        foreach ($obj as $col_name => $col_value) {
          if (substr($col_name,0,1)=="_") {
            // not a fiels, just for presentation purpose
          } else if (ucfirst($col_name) == $col_name) {
            $obj->getDependantSqlElement($col_name);
          } else {
            $dbColName=$obj->getDatabaseColumnName($col_name);
            if (array_key_exists($dbColName,$line)) {
              $obj->{$col_name}=$line[$obj->getDatabaseColumnName($col_name)];
            } else {
              errorLog("Error on SqlElement to get '" . $col_name . "' for Class '".get_class($obj) . "' "
                . " : field '" . $dbColName . "' not found in Database.");
            }
            if ($col_name=='id' and $getIdInKey) {$keyId='#' . $obj->{$col_name};}
          }
        }
        if ($getIdInKey) {
          $objects[$keyId]=$obj;
        } else {
          $objects[]=$obj;
        }
        
        $line = Sql::fetchLine($result);
      }
    } else {
      if ($initializeIfEmpty) {
        $objects[]=$defaultObj; // return at least 1 element, initialized with criteria
      }
    }
    return $objects;
  }

  /**  ========================================================================
   * Retrieve the count of a list of objects from the Database
   * Called from an empty object of the expected class
   * @param $critArray the critera asd an array
   * @param $clauseWhere Sql Where clause (alternative way to define criteria)
   *        => $critArray must not be set 
   * @param $clauseOrderBy Sql Order By clause 
   * @return an array of objects
   */
  public function countSqlElementsFromCriteria($critArray, $clauseWhere=null) {
    // Build where clause from criteria
    $whereClause='';
    $objects=array();
    $className=get_class($this);
    $defaultObj = new $className();
    if ($critArray) {
      foreach ($critArray as $colCrit => $valCrit) {
        $whereClause.=($whereClause=='')?' where ':' and ';
        if ($valCrit==null) {
          $whereClause.=$this->getDatabaseTableName() . '.' . $this->getDatabaseColumnName($colCrit) . ' is null';
        } else { 
          $whereClause.=$this->getDatabaseTableName() . '.' . $this->getDatabaseColumnName($colCrit) . " = '" . Sql::str($valCrit) . "' ";
        }
        $defaultObj->$colCrit=$valCrit;
      }
    } else if ($clauseWhere) { 
      $whereClause = ' where ' . $clauseWhere;
    }
    // If $whereClause is set, get the element from Database
    $query = "select count(*) as cpt from " . $this->getDatabaseTableName() . $whereClause;
    
    $result = Sql::query($query); 
    if (Sql::$lastQueryNbRows > 0) {
      $line = Sql::fetchLine($result);
      return $line['cpt'];
    }
    return 0;  
  }
  
  
    /**  ==========================================================================
   * Retrieve a single object from the Database
   * Called from an empty object of the expected class
   * @param $critArray the critera asd an array
   * @param $initializeIfEmpty boolean indicating if no result returns en initialised element or not
   * @return an array of objects
   */
  public static function getSingleSqlElementFromCriteria($class, $critArray) {
    $obj=new $class();
    $objList=$obj->getSqlElementsFromCriteria($critArray, true);
    if (count($objList)==1) {
      return $objList[0];
    } else {
      $obj->singleElementNotFound=true;
      if (count($objList)>1) {
traceLog("getSingleSqlElementFromCriteria for object '" . $class . "' returned more than 1 element");
        $obj->tooManyRows=true;
      }
      return $obj;
    }
  }  

  /**  ==========================================================================
   * Retrieve an object from the Request (modified Form)
   * @return void (operate directly on the object)
   */
  private function fillSqlElementFromRequest($included=false) {
    foreach($this as $key => $value) {
      // If property is an object, recusively fill it
      if (ucfirst($key) == $key and substr($key,0,1)<> "_") {
        if (is_object($key)) {
          $subObjectClass = get_class($key);
          $subObject = $key;
        } else {
          $subObjectClass = $key;
          $subObject= new $subObjectClass;
        }
        $subObject->fillSqlElementFromRequest(true);
        $this->$key = $subObject;
      } else {
        if (substr($key,0,1)== "_") {
          // not a real field
        } else { 
          $dataType = $this->getDataType($key);
          $dataLength = $this->getDataLength($key);
          $formField = $key;
          if ($included) { // if included, then object is called recursively, name is prefixed by className
            $formField = get_class($this) . '_' . $key;
          }
          //echo get_class($this) . '->' . $key . ' ==> ' . $formField . '=' . $_REQUEST[$formField] . '<br/>'; 
          if ($dataType=='int' and $dataLength==1) {
            //echo "Boolean / key '" . $key . "' ";
            if (array_key_exists($formField,$_REQUEST)) {
              //echo "val=True<br/>";
              $this->$key = 1;
            } else {
              //echo "val=False<br/>";
              $this->$key = 0;
            }
          } else if ($dataType=='datetime') {
            $keyBis = $key . "Bis";
            $this->$key = $_REQUEST[$key] . " " . substr($_REQUEST[$keyBis],1);
        } else {
            if (array_key_exists($formField,$_REQUEST)) {
              $this->$key = $_REQUEST[$formField];
            }
          }
        }
      }
    }
  }

  /**  ==========================================================================
   * Retrieve an object from the Database
   * @return void
   */
  private function getSqlElement() {
    $curId=$this->id;
    $empty=true;
    // If id is set, get the element from Database
    if ($curId != NULL) {
      $query = "select * from " . $this->getDatabaseTableName() . " where id ='" . Sql::str($curId) ."'" ;
      $result = Sql::query($query); 
      if (Sql::$lastQueryNbRows > 0) {
        $empty=false;
        $line = Sql::fetchLine($result);
        // get all data fetched
        foreach ($this as $col_name => $col_value) {
          if (substr($col_name,0,1)=="_") {
            $colName=substr($col_name,1);
            if (is_array($this->{$col_name}) and ucfirst($colName) == $colName ) {
              if (substr($colName,0,4)=="Link") {
                $linkClass=null;
                if (strlen($colName)>4) {
                  $linkClass=substr($colName,5);
                }
                $this->{$col_name}=Link::getLinksForObject($this,$linkClass);
              } else if ($colName=="ResourceCost") {
                $this->{$col_name}=$this->getResourceCost();
              } else if (substr($colName,0,10)=="Dependency") {
                $depType=null;
                $crit=Array();
                if (strlen($colName)>10) {
                  $depType=substr($colName,11);
                  if ($depType=="Successor") {
                    $crit=Array("PredecessorRefType"=>get_class($this),
                                "PredecessorRefId"=>$this->id );
                  } else {
                    $crit=Array("SuccessorRefType"=>get_class($this),
                                "SuccessorRefId"=>$this->id );
                  }
                }
                $dep=new Dependency();
                $this->{$col_name}=$dep->getSqlElementsFromCriteria($crit, false);
              } else {
                $this->{$col_name}=$this->getDependantSqlElements($colName);
              }
            }
          } else if (ucfirst($col_name) == $col_name) {
            $this->{$col_name}=$this->getDependantSqlElement($col_name);
          } else {
            //$test=$line[$this->getDatabaseColumnName($col_name)];
            $this->{$col_name}=$line[$this->getDatabaseColumnName($col_name)];
          }
        }
      } else {
        $this->id=null;
      }
    } 
    if ($empty) {
      // Get all the elements that are objects (first letter is uppercase in object properties)
      foreach($this as $key => $value) {
        //echo substr($key,0,1) . "<br/>";
        if (ucfirst($key) == $key and substr($key,0,1)<> "_") {
          $this->{$key}=$this->getDependantSqlElement($key);
        }
      }
      // set default idUser if exists
      if (property_exists($this, 'idUser')) {
        if (array_key_exists('user', $_SESSION)) {
          $this->idUser=$_SESSION['user']->id;
        }
      }
    }
  }

  /** ==========================================================================
   * retrieve single object included in an object from the Database
   * @param $objClass the name of the class of the included object
   * @return an object
   */
  private function getDependantSqlElement($objClass) {
    $curId=$this->id;
    $obj = new $objClass;
    $obj->refId=$this->id;
    $obj->refType=get_class($this);
    // If id is set, get the elements from Database
    if ( ($curId != NULL) and ($obj instanceof SqlElement) ) {
      // set the reference data
      // build query
      $query = "select id from " . $obj->getDatabaseTableName()
      . " where refId ='" . Sql::str($curId) . "'"
      . " and refType ='" . get_class($this) . "'" ;      
      $result = Sql::query($query);
      // if no element in database, will return empty object
      if (Sql::$lastQueryNbRows > 0) {
        $line = Sql::fetchLine($result);
        // get all data fetched for the dependant element
        $obj->id=$line['id'];
        $obj->getSqlElement();
      }
    }
    // set the dependant element
    return $obj;
  }

  /** ==========================================================================
   * retrieve objects included in an object from the Database
   * @param $objClass the name of the class of the included object
   * @return an array ob objects
   */
  private function getDependantSqlElements($objClass) {
    $curId=$this->id;
    $obj = new $objClass;
    $list=array();
    //$obj->refId=$this->id;
    //$obj->refType=get_class($this);
    // If id is set, get the elements from Database
    if ( ($curId != NULL) and ($obj instanceof SqlElement) ) {
      // set the reference data
      // build query
      $query = "select id from " . $obj->getDatabaseTableName()
      . " where refId ='" . Sql::str($curId) . "'"
      . " and refType ='" . get_class($this) . "'" 
      . " order by id desc ";
      $result = Sql::query($query);
      // if no element in database, will return empty array
      if (Sql::$lastQueryNbRows > 0) {
        while ($line = Sql::fetchLine($result)) {
          $newObj = new $objClass;
          $newObj->id=$line['id'];
          $newObj->getSqlElement();
          $list[]=$newObj;
        }
      }
    }
    // set the dependant element
    return $list;
  }
    
// ============================================================================**********
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
 
  /** ========================================================================
   * return the type of a column depending on its name
   * @param $colName the name of the column
   * @return the type of the data
   */  
  public function getDataType($colName) {
    $formatList=self::getFormatList(get_class($this));
    if ( ! array_key_exists($colName, $formatList) ) {
      return 'undefined';
    }
    $fmt=$formatList[$colName];
    $split=preg_split('/[()\s]+/',$fmt,2);
    return $split[0];
  }

  /** ========================================================================
   * return the length (max) of a column depending on its name
   * @param $colName the name of the column
   * @return the type of the data
   */  
  public function getDataLength($colName) {
    $formatList=self::getFormatList(get_class($this));
    if ( ! array_key_exists($colName, $formatList) ) {
      return '';
    }
    $fmt=$formatList[$colName];
    $split=preg_split('/[()\s]+/',$fmt,3);
    $type = $split[0];
    if ($type=='date') { 
      return '10'; 
    } else if ($type=='time') { 
      return '5'; 
    } else if ($type=='timestamp' or $type=='datetime') {
      return 19;
    } else if ($type=='double') {
      return 2;
    } else {
      return $split[1];
    }
  }

  /** ========================================================================
   * return the generic layout for grit list
   * @return the layout from static data
   */  
  public function getLayout() {    
    return layoutTranslation($this->getStaticLayout());
  }
      
  /** ========================================================================
   * return the generic attributes (required, disabled, ...) for a given field
   * @return an array of fields  with specific attributes
   */  
  public function getFieldAttributes($fieldName) {
    $fieldsAttributes=$this->getStaticFieldsAttributes();
    if (array_key_exists($fieldName,$fieldsAttributes)) {
      return $fieldsAttributes[$fieldName];
    } else {
      return '';
    }
  }  
  
  /** ========================================================================
   * Return the name of the table in the database
   * Default is the name of the class (lowercase)
   * May be overloaded for some classes, who reference a table different 
   * from class name
   * @return string the name of the data table 
   */
  public function getDatabaseTableName() {
    return $this->getStaticDatabaseTableName();
  }

  /** ========================================================================
   * Return the name of the column name in the table in the database
   * Default is the name of the field
   * May be overloaded for some fields of some classes 
   * @return string the name of the data column
   */
  public function getDatabaseColumnName($field) {
    $databaseColumnName=$this->getStaticDatabaseColumnName();
    if (array_key_exists($field,$databaseColumnName)) {
      return Sql::str($databaseColumnName[$field]);
    } else {
      return Sql::str($field);
    }
  }

  /** ========================================================================
   * Return the name of the field in the object from the column name in the 
   * table in the database 
   * (it is the reversed method from getDatabaseColumnName()
   * Default is the name of the field
   * May be overloaded for some fields of some classes 
   * @return string the name of the data column
   */
  public function getDatabaseColumnNameReversed($field) {
    $databaseColumnName=$this->getStaticDatabaseColumnName();
    $databaseColumnNameReversed=array_flip($databaseColumnName);
    if (array_key_exists($field,$databaseColumnNameReversed)) {
      return Sql::str($databaseColumnNameReversed[$field]);
    } else {
      return Sql::str($field);
    }
  }
    
  /** ========================================================================
   * Return the additional criteria to select class elements in the database
   * Default is empty string
   * May be overloaded for some classes, which reference a table different 
   * from class name
   * @return array listing criteria
   */
  public function getDatabaseCriteria() {
    return $this->getStaticDatabaseCriteria();
  }

  /** ============================================================================
   * Return the caption of a field using i18n translation
   * @param $fld the name of the field
   * @return the translated colXxxxxx value
   */
  function getColCaption($fld) {
    if (! $fld or $fld=='') {
      return '';
    }
    $colCaptionTransposition=$this->getStaticColCaptionTransposition($fld);
    if (array_key_exists($fld,$colCaptionTransposition)) {
      $fldName=$colCaptionTransposition[$fld];
    } else {
      $fldName=$fld;
    }
    return i18n('col' . ucfirst($fldName));
  }

  /** =========================================================================
   * Return the list of fields format and store it in static array of formats
   * to be able to fetch it again without requesting it from database
   * @param $class the class of the object
   * @return the format list
   */
  private static function getFormatList($class) {
    if (array_key_exists($class, self::$_tablesFormatList)) {
      return self::$_tablesFormatList[$class];
    }
    $obj=new $class();
    $formatList= array();
    $result=Sql::query("desc " . $obj->getDatabaseTableName());
    while ( $line = Sql::fetchLine($result) ) {
      $fieldName=$line['Field'];
      $fieldName=$obj->getDatabaseColumnNameReversed($fieldName);
      $formatList[$fieldName] = $line['Type'];
    }
    self::$_tablesFormatList[$class]=$formatList;
    return $formatList;
  }
  
  /** ========================================================================
   * return the generic layout
   * @return the layout from static data
   */  
  protected function getStaticLayout() {
    return self::$_layout;
  }
  
  /** ==========================================================================
   * Return the generic fieldsAttributes
   * @return the layout
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }

  /** ==========================================================================
   * Return the generic databaseTableName
   * @return the layout
   */  
  protected function getStaticDatabaseTableName() {
    global $paramDbPrefix;
    return Sql::str(strtolower($paramDbPrefix . get_class($this)));
  }

  /** ========================================================================
   * Return the generic databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return array();
  }
  
  /** ========================================================================
   * Return the generic database criteria
   * @return the databaseTableName
   */
  protected function getStaticDatabaseCriteria() {
    return array();
  }

  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld) {
    return array();
  }
  
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
    
  /** ========================================================================
   * return generic javascript to be executed on validation of field
   * @param $colName the name of the column
   * @return the javascript code
   */  
  public function getValidationScript($colName) {
    $colScript = '';
    $posDate=strlen($colName)-4;
    if (substr($colName,0,2)=='id' and strlen($colName)>2 ) {  // SELECT => onChange
      $colScript .= '<script type="dojo/connect" event="onChange" args="evt">';
      $colScript .= '  if (this.value!=null && this.value!="") { ';
      $colScript .= '    formChanged();';
      $colScript .= '  }';
      if ( get_class($this)=='Activity' or get_class($this)=='Ticket' or get_class($this)=='Milestone' ) {
        if ($colName=='idProject' and property_exists($this,'idActivity')) {
          $colScript .= '   refreshList("idActivity","idProject", this.value);';
        }
        if ($colName=='idProject' and property_exists($this,'idResource')) {
          $colScript .= '   refreshList("idResource","idProject", this.value);';
        }
      }
      $colScript .= '</script>';
    } 
    if (substr($colName,$posDate,4)=='Date') {  // Date => onChange
      $colScript .= '<script type="dojo/connect" event="onChange">';
      $colScript .= '  if (this.value!=null && this.value!="") { ';
      $colScript .= '    formChanged();';
      $colScript .= '  }';
      $colScript .= '</script>';
    }     
    if ( ! (substr($colName,0,2)=='id' and strlen($colName)>2 ) ) { // OTHER => onKeyPress
      $colScript .= '<script type="dojo/method" event="onKeyPress" args="event">'; 
      $colScript .= '  if (isUpdatableKey(event.keyCode)) {';
      $colScript .= '    formChanged();';
      $colScript .= '  }';
      $colScript .= '</script>';
    }
    if ($colName=="idStatus") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      if (property_exists($this, 'idle')) {
        $colScript .= htmlGetJsTable('Status', 'setIdleStatus', 'tabStatusIdle');
        $colScript .= '  var setIdle=0;';
        $colScript .= '  var filterStatusIdle=dojo.filter(tabStatusIdle, function(item){return item.id==dijit.byId("idStatus").value;});';
        $colScript .= '  dojo.forEach(filterStatusIdle, function(item, i) {setIdle=item.setIdleStatus;});';
        $colScript .= '  if (setIdle==1) {';
        $colScript .= '    dijit.byId("idle").set("checked", true);';
        $colScript .= '  } else {';
        $colScript .= '    dijit.byId("idle").set("checked", false);';
        $colScript .= '  }';
      }
      if (property_exists($this, 'done')) {
        $colScript .= htmlGetJsTable('Status', 'setDoneStatus', 'tabStatusDone');
        $colScript .= '  var setDone=0;';
        $colScript .= '  var filterStatusDone=dojo.filter(tabStatusDone, function(item){return item.id==dijit.byId("idStatus").value;});';
        $colScript .= '  dojo.forEach(filterStatusDone, function(item, i) {setDone=item.setDoneStatus;});';
        $colScript .= '  if (setDone==1) {';
        $colScript .= '    dijit.byId("done").set("checked", true);';
        $colScript .= '  } else {';
        $colScript .= '    dijit.byId("done").set("checked", false);';
        $colScript .= '  }';
      }
      if (property_exists($this, 'handled')) {
        $colScript .= htmlGetJsTable('Status', 'setHandledStatus', 'tabStatusHandled');
        $colScript .= '  var setHandled=0;';
        $colScript .= '  var filterStatusHandled=dojo.filter(tabStatusHandled, function(item){return item.id==dijit.byId("idStatus").value;});';
        $colScript .= '  dojo.forEach(filterStatusHandled, function(item, i) {setHandled=item.setHandledStatus;});';
        $colScript .= '  if (setHandled==1) {';
        $colScript .= '    dijit.byId("handled").set("checked", true);';
        $colScript .= '  } else {';
        $colScript .= '    dijit.byId("handled").set("checked", false);';
        $colScript .= '  }';
      }
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="idle") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      if (property_exists($this, 'idleDateTime')) {
        $colScript .= '    if (dijit.byId("idleDateTime").value==null) {';
        $colScript .= '      var curDate = new Date();';
        $colScript .= '      dijit.byId("idleDateTime").set("value", curDate); ';
        $colScript .= '      dijit.byId("idleDateTimeBis").set("value", curDate); ';
        $colScript .= '    }';
      }
      if (property_exists($this, 'idleDate')) {
        $colScript .= '    if (dijit.byId("idleDate").value==null) {';
        $colScript .= '      var curDate = new Date();';
        $colScript .= '      dijit.byId("idleDate").set("value", curDate); ';
        $colScript .= '    }';
      }
      if (property_exists($this, 'done')) {
        $colScript .= '    if (! dijit.byId("done").get("checked")) {';
        $colScript .= '      dijit.byId("done").set("checked", true);';
        $colScript .= '    }';   
      }
      if (property_exists($this, 'handled')) {   
        $colScript .= '    if (! dijit.byId("handled").get("checked")) {';
        $colScript .= '      dijit.byId("handled").set("checked", true);';
        $colScript .= '    }';    
      }  
      $colScript .= '  } else {';
      if (property_exists($this, 'idleDateTime')) {
        $colScript .= '    dijit.byId("idleDateTime").set("value", null); ';
        $colScript .= '    dijit.byId("idleDateTimeBis").set("value", null); ';
      }
      if (property_exists($this, 'idleDate')) {
        $colScript .= '    dijit.byId("idleDate").set("value", null); ';
      }
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="done") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      if (property_exists($this, 'doneDateTime')) {
        $colScript .= '    if (dijit.byId("doneDateTime").value==null) {';
        $colScript .= '      var curDate = new Date();';
        $colScript .= '      dijit.byId("doneDateTime").set("value", curDate); ';
        $colScript .= '      dijit.byId("doneDateTimeBis").set("value", curDate); ';
        $colScript .= '    }';
      }
      if (property_exists($this, 'doneDate')) {
        $colScript .= '    if (dijit.byId("doneDate").value==null) {';
        $colScript .= '      var curDate = new Date();';
        $colScript .= '      dijit.byId("doneDate").set("value", curDate); ';
        $colScript .= '    }';
      }
      if (property_exists($this, 'handled')) { 
        $colScript .= '    if (! dijit.byId("handled").get("checked")) {';
        $colScript .= '      dijit.byId("handled").set("checked", true);';
        $colScript .= '    }';
      }      
      $colScript .= '  } else {';
      if (property_exists($this, 'doneDateTime')) {           
        $colScript .= '    dijit.byId("doneDateTime").set("value", null); ';
        $colScript .= '    dijit.byId("doneDateTimeBis").set("value", null); ';
      }
      if (property_exists($this, 'doneDate')) {           
        $colScript .= '    dijit.byId("doneDate").set("value", null); ';
      }
      if (property_exists($this, 'idle')) {     
        $colScript .= '    if (dijit.byId("idle").get("checked")) {';
        $colScript .= '      dijit.byId("idle").set("checked", false);';
        $colScript .= '    }'; 
      }
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    } else if ($colName=="handled") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      if (property_exists($this, 'handledDateTime')) {
        $colScript .= '    if (dijit.byId("handledDateTime").value==null) {';
        $colScript .= '      var curDate = new Date();';
        $colScript .= '      dijit.byId("handledDateTime").set("value", curDate); ';
        $colScript .= '      dijit.byId("handledDateTimeBis").set("value", curDate); ';
        $colScript .= '    }';
      }
      if (property_exists($this, 'handledDate')) {
        $colScript .= '    if (dijit.byId("handledDate").value==null) {';
        $colScript .= '      var curDate = new Date();';
        $colScript .= '      dijit.byId("handledDate").set("value", curDate); ';
        $colScript .= '    }';
      }
      $colScript .= '  } else {';          
      if (property_exists($this, 'handledDateTime')) { 
        $colScript .= '    dijit.byId("handledDateTime").set("value", null); ';
        $colScript .= '    dijit.byId("handledDateTimeBis").set("value", null); ';
      }
      if (property_exists($this, 'handledDate')) { 
        $colScript .= '    dijit.byId("handledDate").set("value", null); ';
      }
      if (property_exists($this, 'done')) { 
        $colScript .= '    if (dijit.byId("done").get("checked")) {';
        $colScript .= '      dijit.byId("done").set("checked", false);';
        $colScript .= '    }'; 
      }
      if (property_exists($this, 'idle')) { 
        $colScript .= '    if (dijit.byId("idle").get("checked")) {';
        $colScript .= '      dijit.byId("idle").set("checked", false);';
        $colScript .= '    }'; 
      }
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }       
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********

  /** =========================================================================
   * Draw a specific item for a given class.
   * Should always be implemented in the corresponding class.
   * Here is alway an error.
   * @param $item the item
   * @return a message to draw (to echo) : always an error in this class, 
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    return "No specific item " . $item . " for object " . get_class($this);  
  }
  
  /** =========================================================================
   * Indicate if a property of is translatable 
   * @param $col the nale of the property
   * @return a boolean 
   */
  public function isFieldTranslatable($col) {
    $testField='_is' . ucfirst($col) . 'Translatable';
    if (isset($this->{$testField})) {
      if ($this->{$testField}) {
        return true;
      } else {
        return false;
      }
    }
  }

  /** =========================================================================
   * control data corresponding to Model constraints, before saving an object
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
//traceLog('control (for ' . get_class($this) . ' #' . $this->id . ')');
    $result="";
    foreach ($this as $col => $val) {
      if (substr($col,0,1)!='_') {
        if (ucfirst($col) == $col and is_object($val)) {
          $subResult=$val->control();
          if ($subResult!='OK') {
            $result.= $subResult;
          }
        } else {
          // check if required
          if (strpos($this->getFieldAttributes($col), 'required')!==false) {
            if (!$val) {
              $result.='<br/>' . i18n('messageMandatory',array(i18n('col' . ucfirst($col))));
            } else if (trim($val)==''){
              $result.='<br/>' . i18n('messageMandatory',array(i18n('col' . ucfirst($col))));
            }
          }
          $dataType=$this->getDataType($col);
          if ($dataType=='datetime') {
            if (strlen($val)==9) {              
              $result.='<br/>' . i18n('messageDateMandatoryWithTime',array(i18n('col' . ucfirst($col))));
            }
          }
          if ($dataType=='date' and $val!='') {
            if (strlen($val)!=10 or substr($val,4,1)!='-' or substr($val,7,1)!='-') {
              $result.='<br/>' . i18n('messageInvalidDateNamed',array(i18n('col' . ucfirst($col))));
            }
          }
        }
      } 
    }
    $idType='id'.ucfirst(get_class($this)).'Type';
    if (property_exists($this, $idType)) {
      $type=get_class($this).'Type';
      $objType=new $type($this->$idType);
      if (property_exists($objType, 'mandatoryDescription') and $objType->mandatoryDescription 
      and property_exists($this, 'description')) {
        if (! $this->description) {
          $result.='<br/>' . i18n('messageMandatory',array($this->getColCaption('description')));
        }
      }
      if (property_exists($objType, 'mandatoryResourceOnHandled') and $objType->mandatoryResourceOnHandled 
      and property_exists($this, 'idResource')
      and property_exists($this, 'handled')) {
        if ($this->handled and ! trim($this->idResource)) {
          $result.='<br/>' . i18n('messageMandatory',array($this->getColCaption('idResource')));
        }        
      }
      if (property_exists($objType, 'mandatoryResultOnDone') and $objType->mandatoryResultOnDone 
      and property_exists($this, 'result')
      and property_exists($this, 'done')) {
        if ($this->done and ! $this->result) {
          $result.='<br/>' . i18n('messageMandatory',array($this->getColCaption('result')));
        }
      }
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }

  /** =========================================================================
   * control data corresponding to Model constraints, before deleting an object
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function deleteControl(){
    $result="";
    $objects="";
    $relationShip=self::$_relationShip;
    if (array_key_exists(get_class($this),$relationShip)) {
      $relations=$relationShip[get_class($this)];
      foreach ($relations as $object=>$mode) {
        if ($mode=="control") {
          $where=null;
          $crit=array('id' . get_class($this) => $this->id);
          if ($object=="Assignment" or $object=="Note" or $object=="Attachement") {
            $crit=array("refType"=>get_class($this), "refId"=>$this->id);
          }
          if ($object=="Dependency") {
            $crit=null;
            $where="(predecessorRefType='" . get_class($this) . "' and predecessorRefId='" . $this->id ."')"
             . " or (successorRefType='" . get_class($this) . "' and successorRefId='" . $this->id ."')"; 
          }
          if ($object=="Link") {
            $crit=null;
            $where="(ref1Type='" . get_class($this) . "' and ref1Id='" . $this->id ."')"
             . " or (ref2Type='" . get_class($this) . "' and ref2Id='" . $this->id ."')"; 
          }
          $obj=new $object();
          $list=$obj->getSqlElementsFromCriteria($crit,false,$where);
          $nb=count($list);
          if ($nb>0) {
            $objects.="<br/>&nbsp;-&nbsp;" . i18n($object) . " (" . $nb . ")";
          }
        }
      }
      if ($objects!="") {
        $result.=i18n("errorControlDelete") . $objects;
      }
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  /** =========================================================================
   * Return the menu string for the object (from its class)
   * @param void
   * @return a string  
   */
  public function getMenuClass() {
    return "menu" . get_class($this);
  }
  
  /** =========================================================================
   * Send a mail on status change (if object is "mailable")
   * @param void
   * @return status of mail, if sent
   */
  public function sendMailIfMailable() {
    if (get_class($this)=='History') {
      return false; // exit : not for History
    }
    $mailable=SqlElement::getSingleSqlElementFromCriteria('Mailable', array('name'=>get_class($this)));
    if (! $mailable or ! $mailable->id) {
      return false; // exit if not mailable object
    }
    if (! property_exists($this, 'idStatus')) {
      return false; // exit if object has not idStatus 
    }
    if (! $this->idStatus) {
      return false; // exit if status not set
    }
    $crit=array();
    $crit['idMailable']=$mailable->id;
    $crit['idStatus']=$this->idStatus;
    $crit['idle']='0';
    $statusMail=SqlElement::getSingleSqlElementFromCriteria('StatusMail', $crit);
    if (! $statusMail or ! $statusMail->id) {
      if (property_exists($statusMail,"tooManyRows") and $statusMail->tooManyRows==true) {
        errorLog("Too many rows on StatusMail for element '" . get_class($this) . "' "
        . " and status '" . SqlList::getNameFromId('Status', $this->idStatus) . "'" );
      }
      return false; // exit not a status for mail sending (on disabled) 
    }
    if ($statusMail->mailToUser==0 and $statusMail->mailToResource==0 and $statusMail->mailToProject==0
    and $statusMail->mailToLeader==0  and $statusMail->mailToContact==0  and $statusMail->mailToOther==0) {
      return false; // exit not a status for mail sending (or disabled) 
    }
    $dest="";
    if ($statusMail->mailToUser) {
      if (property_exists($this,'idUser')) {
        $user=new User($this->idUser);
        $newDest = "###" . $user->email . "###";
        if ($user->email and strpos($dest,$newDest)===false) {
          $dest.=($dest)?', ':'';
          $dest.= $newDest;
        }
      }
    }
    if ($statusMail->mailToResource) {
      if (property_exists($this, 'idResource')) {
        $resource=new Resource($this->idResource);
        $newDest = "###" . $resource->email . "###";
        if ($resource->email and strpos($dest,$newDest)===false) {
          $dest.=($dest)?', ':'';
          $dest.= $newDest;
        }
      }    
    }
    if ($statusMail->mailToProject or $statusMail->mailToLeader) {
      $aff=new Affectation();
      $crit=array('idProject'=>$this->idProject, 'idle'=>'0');
      $affList=$aff->getSqlElementsFromCriteria($crit, false);
      if ($affList and count($affList)>0) {
        foreach ($affList as $aff) {
          $resource=new Resource($aff->idResource);
          if ($statusMail->mailToProject) {
            $newDest = "###" . $resource->email . "###";
            if ($resource->email and strpos($dest,$newDest)===false) {
              $dest.=($dest)?', ':'';
              $dest.= $newDest;
            }
          }
          if ($statusMail->mailToLeader and $resource->idProfile) {
            $prf=new Profile($resource->idProfile);
            if ($prf->profileCode=='PL') {
              $newDest = "###" . $resource->email . "###";
              if ($resource->email and strpos($dest,$newDest)===false) {
                $dest.=($dest)?', ':'';
                $dest.= $newDest;
              }
            }
          }
        }
      }
    }
    if ($statusMail->mailToContact) {
      if (property_exists($this,'idContact')) {
        $contact=new Contact($this->idContact);
        $newDest = "###" . $contact->email . "###";
        if ($contact->email and strpos($dest,$newDest)===false) {
          $dest.=($dest)?', ':'';
          $dest.= $newDest;
        }
      }
    }
    if ($statusMail->mailToOther) {
      if ($statusMail->otherMail) {
        $otherMail=str_replace(';',',', $statusMail->otherMail);
        $otherMail=str_replace(' ',',', $otherMail);
        $split=explode(',',$otherMail);
        foreach ($split as $adr) {
          if ($adr and $adr!='') {
            $newDest = "###" . $adr . "###";
            if (strpos($dest,$newDest)===false) {
              $dest.=($dest)?', ':'';
              $dest.= $newDest;
            }
          }
        }
      }
    }
    if ($dest=="") {
      return false; // exit no addressees 
    }
    $dest=str_replace('###','',$dest);
    global $paramMailTitle, $paramMailMessage, $paramMailShowDetail;
    // substituable items
    $item=i18n(get_class($this));
    $id=$this->id;
    $name=$this->name;
    $status=SqlList::getNameFromId('Status', $this->idStatus);
    $arrayFrom=array('${item}','${id}','${name}','${status}');
    $arrayTo=array($item,$id,$name,$status);
    $title=str_replace($arrayFrom, $arrayTo, $paramMailTitle);
    $message=str_replace($arrayFrom, $arrayTo, $paramMailMessage);
    $nx='<br/>' . "\n" . '<br/>' . "\n" . '<div style="font-weight: bold;">';
    $xn='</div><br/>' . "\n";
    $hx='<div style="text-decoration:underline;font-weight: bold;">';
    $xh=' :</div>' . "\n";
    $tx='';
    $xt='<br/><br/>' . "\n";
    if (getBooleanValue($paramMailShowDetail)) {
      $message.= $nx . $item . " #" . $id . $xn;

      $message.=$hx . $this->getColCaption('idProject') . $xh;
      $message.=$tx . SqlList::getNameFromId('Project', $this->idProject) . $xt;

      $message.=$hx . $this->getColCaption('id' . get_class($this) . 'Type') . $xh;
      $message.=$tx . SqlList::getNameFromId(get_class($this) . 'Type', $this->{'id' . get_class($this) . 'Type'}) . $xt;

      $message.=$hx . $this->getColCaption('name') . $xh;
      $message.=$tx . htmlEncode($this->name,'mail') . $xt;

      if (property_exists($this,'description')) {
        $message.=$hx . $this->getColCaption('description') . $xh;
        $message.=$tx . htmlEncode($this->description,'mail') . $xt;
      }
      $message.=$hx . $this->getColCaption('idUser') . $xh;
      $message.=$tx . SqlList::getNameFromId('User', $this->idUser) . $xt;

      $message.=$hx . $this->getColCaption('idStatus') . $xh;
      $message.=$tx . $status . $xt;

      $message.=$hx . $this->getColCaption('idResource') . $xh;
      $message.=$tx . SqlList::getNameFromId('Resource', $this->idResource) . $xt;

      if (property_exists($this,'result')) {
        $message.=$hx . $this->getColCaption('result') . $xh;
        $message.=$tx . htmlEncode($this->result,'mail') . $xt;
      }
    }
    $message='<html>' . "\n" .
      '<head>'  . "\n" .
      '<title>' . $title . '</title>' . "\n" .
      '</head>' . "\n" .
      '<body>' . "\n" .
      $message . "\n" .
      '<body>' . "\n" .
      '</html>';
    $message = wordwrap($message, 70); // wrapt text so that line do not exceed 70 cars per line
    $resultMail=sendMail($dest, $title, $message, $this);
 
    return $resultMail;
  }
  
  /** ========================================================================= 
   * Specific function added to setup a workaround for bug #305
   * waiting for Dojo fixing (Dojo V1.6 ?)
   * @todo : deactivate this function if Dojo fixed.
   */
  public function recalculateCheckboxes() {
    // if no status => nothing to do
    if (! property_exists($this, 'idStatus')) {
      return;
    }
    $status=new Status($this->idStatus);
    // if no type => nothong to do
    $fldType = 'id' . get_class($this) . 'Type';
    $typeClass=get_class($this) . 'Type';
    if (! property_exists($this, $fldType)) {
      return;
    }
    $type=new $typeClass($this->$fldType);
    if (property_exists($type,'lockHandled')
    and property_exists($this,'handled') 
    and $type->lockHandled) {
      $this->handled=($status->setHandledStatus)?1:0;
    }
    if (property_exists($type,'lockDone')
    and property_exists($this,'done') 
    and $type->lockDone) {
      $this->done=($status->setDoneStatus)?1:0;
    }
    if (property_exists($type,'lockIdle')
    and property_exists($this,'idle') 
    and $type->lockIdle) {
      $this->idle=($status->setIdleStatus)?1:0;
    }  
  }
}
?>