<?php 
/* ============================================================================
 * Client is the owner of a project.
 */ 
class WorkElement extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visiblez place 
  public $refType;
  public $refId;
  public $idActivity;
  public $refName;
  public $plannedWork;
  public $realWork;
  public $_spe_run;
  public $idUser;
  public $ongoing;
  public $ongoingStartDateTime;
  public $leftWork;
  public $done;
  public $idle;
   
   private static $_fieldsAttributes=array("refType"=>"hidden", "refId"=>"hidden", "refName"=>"hidden",
                                           "realWork"=>"", "ongoing"=>"hidden", "ongoingStartDateTime"=>"hidden",
                                           "idUser"=>"hidden", "idActivity"=>"hidden",
                                           "leftWork"=>"readonly", "done"=>"hidden", "idle"=>"hidden");

   private static $_colCaptionTransposition = array('plannedWork'=>'estimatedWork');
   
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
    
  public function save() {
  	$old=new WorkElement($this->id);
  	if (! array_key_exists('user', $_SESSION)) return parent::save();
    $user=$_SESSION['user'];
    $this->leftWork=$this->plannedWork-$this->realWork;
  	if ($this->leftWork<0 or $this->done) {
  		$this->leftWork=0;
  	}
  	if ($this->refType) {
      $top=new $this->refType($this->refId);
  	} else {
  		$top=new Project();
  	}
    if ($top and isset($top->idActivity)) {
      $this->idActivity=$top->idActivity;
      // Check if changed Planning Activity
      if ($old->idActivity!=$this->idActivity) {
        if (! $old->idActivity) {
          $crit=array('idResource'=>$user->id, 'refType'=>$this->refType, 'refId'=>$this->refId);
          $work=new Work();
          $workList=$work->getSqlElementsFromCriteria($crit);
          foreach ($workList as $work) {
            $crit=array('idResource'=>$user->id, 'refType'=>'Activity', 'refId'=>$this->idActivity, 'workDate'=>$work->workDate);
            $newWork=SqlElement::getSingleSqlElementFromCriteria('Work',$crit);
            if (! $newWork->id) {
              $ass=new Assignment();
              $crit=array('refType'=>'Activity', 'refId'=>$top->idActivity, 'idResource'=>$user->id);
              $lstAss=$ass->getSqlElementsFromCriteria($crit);
              if (count($lstAss)>0) {
                $ass=$lstAss[count($lstAss)-1];
              } else {
                $ass=new Assignment();
                $ass->refType='Activity';
                $ass->refId=$top->idActivity;
                $ass->idResource=$user->id;
              }
              $ass->leftWork-=$work->work;
              if ($ass->leftWork<0) {$ass->leftWork=0;}
              $ass->save();
              $newWork->idAssignment=$ass->id;
              if (!$newWork->refType) {
              	$newWork->refType='Activity';
              	$newWork->refId=$this->idActivity;
              }
            }
            $newWork->work+=$work->work;
            $newWork->setDates($work->workDate);
            $newWork->idProject=$top->idProject;
            $newWork->save();
            $work->delete();
          }
        }
      }

    }
  	$result = parent::save();
    $diff=$this->realWork-$old->realWork;
    if ($diff!=0) {
      $ass=new Assignment();
      if (isset($top->idActivity) and $top->idActivity) {
        $crit=array('refType'=>'Activity', 'refId'=>$top->idActivity, 'idResource'=>$user->id);
        $lstAss=$ass->getSqlElementsFromCriteria($crit);
        if (count($lstAss)>0) {
          $ass=$lstAss[count($lstAss)-1];
        } else {
          $ass=new Assignment();
          $ass->refType='Activity';
          $ass->refId=$top->idActivity;
          $ass->idResource=$user->id;
        }
        $crit['workDate']=date('Y-m-d');
        $work=SqlElement::getSingleSqlElementFromCriteria('Work',$crit);
        if (! $work or ! $work->id) {
          $work->refType='Activity';
          $work->refId=$top->idActivity;
          $work->idResource=$user->id;
          $work->idProject=$ass->idProject;
          $work->idAssignment=$ass->id;
          $work->setDates(date('Y-m-d'));
        }
        $ass->leftWork-=$diff;
        if ($ass->leftWork<0) {$ass->leftWork=0;}
        $ass->save();
        $work->idAssignment=$ass->id;
        $work->work+=$diff;
        if ($work->work<0) {$work->work=0;}
        if (! $work->refType) {
        	$work->refType='Activity';
          $work->refId=$top->idActivity;
        }
        $work->save();
      } else {
        $crit=array('refType'=>$this->refType, 'refId'=>$this->refId, 'idResource'=>$user->id, 'idProject'=>$top->idProject);
        $crit['workDate']=date('Y-m-d');
        $work=new Work();
        $workList=$work->getSqlElementsFromCriteria($crit,true);
        if (count($workList)>0) {
          $work=$workList[count($workList)-1];
        } else {
          $work=new Work();
          $work->refType=$this->refType;
          $work->refId=$this->refId;
          $work->idResource=$user->id;
          $work->idProject=$top->idProject;
        }
        $work->work+=$diff;
        $work->setDates(date('Y-m-d'));
        if ($work->work<0) {$work->work=0;}
        if (! $work->refType) {
          $work->refType=$this->refType;
          $work->refId=$this->refId;
        }
        $work->save();
      }
    }
    return $result;
  }

  public function start() {
    // First, stop all ongoing work
    $_SESSION['user']->stopAllWork();
    // Then start current work
    $this->idUser=$_SESSION['user']->id;
    $this->ongoing=1;
    $this->ongoingStartDateTime=date('Y-m-d H:i');
    $this->save();
    // save to database
  }

  /**
   *
   */
  public function stop() {
    $start=$this->ongoingStartDateTime;
    $stop=date('Y-m-d H:i');
    $work=workTimeDiffDateTime($start,$stop);
    $this->realWork+=$work;
    $this->idUser=null;
    $this->ongoing=0;
    $this->ongoingStartDateTime=null;
    $this->save();
  }

  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are :
   *    - subprojects => presents sub-projects as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    global $print, $comboDetail;
    $result="";
    $refObj=new $this->refType($this->refId);
    if ($item=='run' and ! $comboDetail and !$this->idle) {
      if ($print) {
        return "";
      }
      $user=$_SESSION['user'];
      $title= i18n('startWork');
      if ($this->ongoing) {
        $title = i18n('stopWork');
      }
      $canUpdate=(securityGetAccessRightYesNo('menu' . $this->refType, 'update', $refObj)=='YES');
      if ($user->isResource and $canUpdate) {
        $result .= '<div style="position: absolute; right: 12px; top : 175px;
                     border: 0px solid #FFFFFF; -moz-border-radius: 15px; border-radius: 15px; text-align: right;">';
        $result .= '<button id="startStopWork" dojoType="dijit.form.Button" showlabel="true"';
        if ( ($this->ongoing and $this->idUser!=$user->id) or ! $user->isResource ) {
          $result .= ' disabled="disabled" ';
        }
        $result .= ' title="' . $title . '" style="vertical-align: middle;">';
        $result .= '<span>' . $title . '</span>';
        $result .=  '<script type="dojo/connect" event="onClick" args="evt">';
        $result .=  '    loadContent("../tool/startStopWork.php?action=' . (($this->ongoing)?'stop':'start') .'","resultDiv","objectForm",true);';
        $result .= '</script>';
        $result .= '</button><br/>';
      }
      if ($this->ongoing) {
        if ($this->idUser==$user->id) {
          $days=workDayDiffDates($this->ongoingStartDateTime,date('Y-m-d H:i'));
          if ($days>0) {
            $result .= i18n('workStartedSince', array($days)) ;
          } else {
            $result .= i18n('workStartedAt', array(substr($this->ongoingStartDateTime,11,5)));
          }
        } else {
          $result .= i18n('workStartedBy',array(SqlList::getNameFromId('Resource',$this->idUser)));
        }
      }
      $result .= '</div>';
      return $result;
      return $result;
    }
    return $result;
  }
}
?>
