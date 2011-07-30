<?php 
/* ============================================================================
 * Menu defines list of items to present to users.
 */ 
class Workflow extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $description;
  public $idle;
  public $workflowUpdate;
  public $_col_2_2;
  public $_col_1_1_WorkflowStatus;
  public $_spe_workflowstatus;
  public $_workflowStatus;
  
  private static $_fieldsAttributes=array(
    "workflowUpdate"=>"hidden");
    
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
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return array_merge(parent::getStaticFieldsAttributes(),self::$_fieldsAttributes);
  }
 
  /** ==========================================================================
   * Return list of workflow status for a workflow (id)
   * @return an array of WorkflowStatus
   */
  public function getWorkflowstatus() {
    if ($this->id==null or $this->id=='') {
      return array();
    }
    if ($this->_workflowStatus) {
      return $this->_workflowStatus;
    }
    $ws=new WorkflowStatus();
    $crit=array('idWorkflow'=>$this->id);
    $wsList=$ws->getSqlElementsFromCriteria($crit, false);
    return $wsList;
  }
  
   /** ==========================================================================
   * Return check value of workflow status for a workflow
   * @return a 3 level array [idStatusFrom] [idStatusTo] [idProfile] => check value
   */
  public function getWorkflowstatusArray() {
    $wsList=$this->getWorkflowstatus();
    $result=array();
    // Initialize
    $statusList=SqlList::getList('Status');
    $profileList=SqlList::getList('Status');
    foreach($statusList as $idFrom => $valFrom) {
      $result[$idFrom]=array();
      foreach($statusList as $idTo => $valTo) {
        if ($idFrom!=$idTo) {
          $result[$idFrom][$idTo]=array();
          foreach($profileList as $idProf => $valProf) {
            $result[$idFrom][$idTo][$idProf]=0;
          }
        }
      }
    }
    // Get Data
    foreach ($wsList as $ws) {
      $result[$ws->idStatusFrom][$ws->idStatusTo][$ws->idProfile]=$ws->allowed;
    }
    return $result;
  }
  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   *    - subprojects => presents sub-projects as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    global $_REQUEST;
    if (array_key_exists('destinationWidth', $_REQUEST)) {
      $detailWidth=$_REQUEST['destinationWidth'];
      $detailWidth-=30;
      $detailWidth.='px';
    } else {
      $detailWidth="100%";
    }
    $result="";
    if ($item=='workflowstatus') {
      $width="100px";
      $statusList=SqlList::getList('Status');
      $profileList=SqlList::getList('Profile');
      $profileIdList="";
      foreach ($profileList as $profileCode => $profileValue) {
        $profileIdList.=$profileCode . " ";
      }     
      $nbProfiles=count($profileList);
      $result .= '<div style="overflow: auto; width: ' . $detailWidth . '">';
      $result .= '<table>';
      $result .= ' <tr>';
      $result .= '  <th class="workflowHeader">' . i18n('from') . '&nbsp;\\&nbsp;' . i18n('to') . '</th>';
      foreach ($statusList as $statCode => $statValue) {
        $result .= '  <th class="workflowHeader">' . $statValue . '</th>';
      }
      $wsListArray=$this->getWorkflowstatusArray();
      foreach ($statusList as $statLineCode => $statLineValue) {
        $result .= '<tr>';
        $result .= '  <td class="workflowHeader">' . $statLineValue . '</td>';
        foreach ($statusList as $statColumnCode => $statColumnValue) {
          $result .= '  <td class="workflowData">';
          if ($statColumnCode!=$statLineCode) {
            $title=$statLineValue . ' => ' . $statColumnValue;
            $result .='<table title="' . $title . '">' ;
            $result .= '  <tr><td>';
            // dojotype not set to improve perfs
            $result .= '  <input xdojoType="dijit.form.CheckBox" type="checkbox" ';
            $result .= ' onclick="workflowSelectAll('. $statLineCode . ',' . $statColumnCode . ',\'' . $profileIdList .'\');"';
            $name = 'val_' . $statLineCode . '_' . $statColumnCode;
            $result .= ' name="' . $name . '" id="' . $name . '" ';
            $result .= '/>';
            $result .= ' </td>';
            $result .= '  <td><b>' . i18n('all') . '</b></td></tr>';  
            //$profileIdx=0;
            foreach ($profileList as $profileCode => $profileValue) {              
              $result .= '  <tr class="workflowDetail" ><td valign="top" style="vertical-align: top;" >';
              // dojotype not set to improve perfs
              $result .= '  <input xdojoType="dijit.form.CheckBox" type="checkbox" ';
              $result .= ' onclick="workflowChange();"';
              $name = 'val_' . $statLineCode . '_' . $statColumnCode . '_' . $profileCode;
              $result .= ' name="' . $name . '" id="' . $name . '" ';
              if ($wsListArray[$statLineCode][$statColumnCode][$profileCode]==1) { $result .=  'checked'; }
              $result .= ' />';
              $result .= ' </td> ';
              $result .= '  <td>' . $profileValue . '</td></tr>';  
            }
            $result .= '</table>';
          }
          $result .='</td>';
        }
        $result .= '</tr>';
      }  
      $result .= '</tr>';
      $result .= '</table>';
      $result .= '</div>';
    } 
    return $result;
  }
  
  public function save() {
    global $_REQUEST;
    
    set_time_limit(300);
    
    if ($this->workflowUpdate and $this->workflowUpdate!="[     ]" and $this->workflowUpdate!="[      ]") {
      $old = new Workflow($this->id);
      if (! $old->workflowUpdate or $old->workflowUpdate=="[      ]") {
        $this->workflowUpdate="[     ]";
      } else {
        $this->workflowUpdate="[      ]";
      }
    }
    $result = parent::save();   
    // save detail (workflowstatus)
    $statusList=SqlList::getList('Status');
    $profileList=SqlList::getList('Profile');
    $ws=new WorkflowStatus();
    //$ws->purge("idWorkFlow='" . $this->id . "'");
    $oldArray=$this->getWorkflowstatusArray();
    foreach ($statusList as $statLineCode => $statLineValue) {
      foreach ($statusList as $statColumnCode => $statColumnValue) {
        if ($statLineCode!=$statColumnCode) {
          foreach ($profileList as $profileCode => $profileValue) {
            $oldVal=$oldArray[$statLineCode][$statColumnCode][$profileCode];
            $valName = 'val_' . $statLineCode . '_' . $statColumnCode . '_' . $profileCode;
            if (array_key_exists($valName,$_REQUEST)) {            
              if ($oldVal!=1) {
                $ws=new WorkflowStatus();
                $ws->idWorkflow=$this->id;
                $ws->idProfile=$profileCode;
                $ws->idStatusFrom=$statLineCode;
                $ws->idStatusTo=$statColumnCode;
                $ws->allowed=1;
                $ws->save();    
              }
            } else {
              if ($oldVal==1) {
                $crit=array('idWorkflow'=>$this->id,
                            'idProfile'=>$profileCode,
                            'idStatusFrom'=>$statLineCode,
                            'idStatusTo'=>$statColumnCode);
                $ws=SqlElement::getSingleSqlElementFromCriteria('WorkflowStatus', $crit);
                $ws->delete();
              }  
            }
          }   
        }     
      }
    }
    return $result;
  }
   
  public function copy() {
     $result=parent::copy();
     $new=$result->id;
     $ws=new WorkflowStatus();
     $crit=array('idWorkflow'=>$this->id);
     $lst=$ws->getSqlElementsFromCriteria($crit);
     foreach ($lst as $ws) {
       $ws->idWorkflow=$new;
       $ws->id=null;
       $ws->save();
     }
     
     Sql::$lastQueryNewid=$new;
     return $result;
  }
}
?>