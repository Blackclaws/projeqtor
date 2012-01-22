<?php 
/* ============================================================================
 * Stauts defines list stauts an activity or action can get in (lifecylce).
 */ 
class ActivityPrice extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2;
  public $id;    // redefine $id to specify its visible place
  public $idProject;
  public $name;
  public $idActivityType; 
  public $priceCost;
  //public $subcontractorCost;
  //public $commissionCost;
  //public $idTeam;
  public $sortOrder=0;
  public $idle;
  public $_col_2_2;
  //public $_sec_Abacus;
  //public $isRef;
  //public $pct;

  
  private static $_fieldsAttributes=array("idActivity"=>"required",
  								  "value"=>"required",
  								  "idProject"=>"required"
  );
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="name" width="25%" >${name}</th>
    <th field="nameProject" width="15%" >${idProject}</th>
    <th field="nameActivityType" width="15%" >${idActivityType}</th>
    <th field="priceCost" width="10%" >${priceCost}</th>
    <th field="subcontractorCost" width="10%" >${subcontractorCost}</th>
    <th field="commissionCost" width="10%" >${commissionCost}</th>
    <th field="sortOrder" width="5%" >${sortOrderShort}</th>    
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';
//  <th field="nameTeam" width="15%" >${idTeam}</th>  
//  <th field="isRef" width="5%" formatter="booleanFormatter" >${isRef}</th>
//  <th field="pct" width="8%" >${pct}</th>
  
  
  
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
    return self::$_fieldsAttributes;
  }
 
    /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
 
}
?>