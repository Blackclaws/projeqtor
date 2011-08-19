<?php 
/** ============================================================================
 * Project is the main object of the project managmement.
 * Almost all other objects are linked to a given project.
 */ 
class Product extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $idCustomer;
  public $idContact;
  public $creationDate;
  public $idle;
  public $description;
  public $_col_2_2_Projects;
  public $_spe_projects;



  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%" ># ${id}</th>
    <th field="name" width="80%" >${projectName}</th>
    <th field="idle" width="10%" formatter="booleanFormatter" >${idle}</th>
    ';
// Removed in 1.2.0 
//     <th field="wbs" from="ProjectPlanningElement" width="5%" >${wbs}</th>

  private static $_fieldsAttributes=array("name"=>"required", 
                                  "description"=>"required"
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
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  

  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   *    - subprojects => presents sub-projects as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    $result="";
    if ($item=='projects') {
      $result .="<table><tr><td class='label' valign='top'><label>" . i18n('projects') . "&nbsp;:&nbsp;</label>";
      $result .="</td><td>";
      if ($this->id) {
        //$result .= $this->drawSubProjects();
      }
      $result .="</td></tr></table>";
      return $result;
    } 
  }

}
?>