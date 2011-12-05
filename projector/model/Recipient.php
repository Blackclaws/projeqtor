<?php 
/* ============================================================================
 * defines recipient for a bill
 */ 
class Recipient extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $siret;
  public $numTva;  
  public $bank;
  public $numBank;
  public $numGuichet;
  public $numCompte;
  public $cleRib;
  public $idle;
  public $_col_2_2_Projects;
  public $_spe_projects;
  public $_sec_Contacts;
  public $_spe_contacts;
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%"># ${id}</th>
    <th field="name" width="20%">${name}</th>
    <th field="siret" width="20%">${siret}</th>
    <th field="numTva" width="20%">${numTva}</th>
    <th field="bank" width="10%">${bank}</th>
    <th field="idle" formatter="booleanFormatter" width="5%">${idle}</th>
    ';
  
  private static $_fieldsAttributes=array("name"=>"required");

  
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
      $prj=new Project();
      $result .="<table><tr><td class='label' valign='top'><label>" . i18n('projects') . "&nbsp;:&nbsp;</label>";
      $result .="</td><td>";
      $result .= $prj->drawProjectsList(array('idRecipient'=>$this->id,'idle'=>'0'));
      $result .="</td></tr></table>";
      return $result;
    } else if ($item=='contacts') {
      $con=new Contact();
      $result .="<table><tr><td class='label' valign='top'><label>" . i18n('contacts') . "&nbsp;:&nbsp;</label>";
      $result .="</td><td>";
      $result .= $con->drawContactsList(array('idRecipient'=>$this->id,'idle'=>'0'));
      $result .="</td></tr></table>";
      return $result;
    }
  }
  
  
  
  /** =========================================================================
   * Overrides SqlElement::deleteControl() function to add specific treatments
   * @see persistence/SqlElement#deleteControl()
   * @return the return message of persistence/SqlElement#deleteControl() method
   */  
  
  public function deleteControl()
  {
  	$result = "OK";
  	
  	$proj = new Project();
  	$crit = array("idRecipient"=>$this->id);
  	$projList = $proj->getSqlElementsFromCriteria($crit,false);
  	
  	if (count($projList)!=0) $result = "Suppression impossible : contractant rattach&eacute a un ou plusieurs projets";

  	return $result;
  }
  
}
?>