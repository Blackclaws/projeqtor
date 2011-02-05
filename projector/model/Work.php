<?php 
/** ============================================================================
 * Project is the main object of the project managmement.
 * Almost all other objects are linked to a given project.
 */ 
class Work extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $id;    // redefine $id to specify its visible place 
  public $idResource;
  public $idProject;
  public $refType;
  public $refId;
  public $idAssignment;
  public $work;
  public $workDate;
  public $day;
  public $week;
  public $month;
  public $year;
  public $dailyCost;
  public $cost;

  public $_noHistory;
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%" ># ${id}</th>
    <th field="nameResource" width="35%" >${resourceName}</th>
    <th field="nameProject" width="35%" >${projectName}</th>
    <th field="rate" width="15%" formatter="percentFormatter">${rate}</th>  
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  
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


// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);

    if ($colName=="idle") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("PlanningElement_realEndDate").value==null) {';
      $colScript .= '      dijit.byId("PlanningElement_realEndDate").set("value", new Date); ';
      $colScript .= '    }';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("PlanningElement_realEndDate").set("value", null); ';
      //$colScript .= '    dijit.byId("PlanningElement_realDuration").set("value", null); ';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Set all date values : workDate, 
   * @param $workDate
   * @return void
   */
  public function setDates($workDate) {
    $year=substr($workDate,0,4);
    $month=substr($workDate,5,2);
    $day=substr($workDate,8,2);
    $this->workDate=$workDate;
    $this->day=$year . $month . $day;
    $this->month=$year . $month; 
    $this->year=$year;
    $this->week=$year . weekNumber($workDate);
  }
  
  public function save() {
    if ($this->dailyCost==null) {
      $ass=new Assignment($this->idAssignment);
      $where="idResource='" . $this->idResource . "' and idRole='" . $ass->idRole . "'"
       . " and (startDate is null or startDate<='" . $this->workDate . "')"
       . " and (endDate is null or endDate>='" . $this->workDate . "')";
      $order="startDate asc";
      $rc=new ResourceCost();
      $rcList=$rc->getSqlElementsFromCriteria(null, false, $where, $order);
      $this->dailyCost=(count($rcList)>0)?$rcList[0]->cost:0;
    }
    $this->cost=$this->dailyCost*$this->work;
    return parent::save();
  }
}
?>