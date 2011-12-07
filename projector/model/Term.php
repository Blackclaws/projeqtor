<?php 
/* ============================================================================
 * defines a term for a payment
 */ 
class Term extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $idProject;
  public $isBilled;
  public $idle;
  public $_col_2_2_forfait;
  public $amount; 
  public $date;
  public $_col_1_1_trigger;
  public $_Dependency_Predecessor=array();
  public $_Note=array();
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%"># ${id}</th>
    <th field="name" width="20%">${name}</th>
    <th field="nameProject" width="20%">${idProject}</th>
    <th field="amount" width="15%">${amount}</th>
    <th field="date" width="15%" formatter="dateFormatter">${date}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';
  
  private static $_fieldsAttributes=array("name"=>"required",
                                  "idProject"=>"required",
  								  "isBilled"=>"readonly"
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
  

 /** =========================================================================
   * Overrides SqlElement::deleteControl() function to add specific treatments
   * @see persistence/SqlElement#deleteControl()
   * @return the return message of persistence/SqlElement#deleteControl() method
   */  
  
  public function deleteControl()
  {
  	$result = "OK";
  	if ($this->isBilled != 0)
  	{
  		$result = "Ech&eacuteance factur&eacutee : suppression interdite.";
  	}
  	
  	return $result;
  }
  
  
/** =========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */  

	public function save() {
	
		$result = parent::save();
		
		return $result;
	}
  
 
  
  
  
  
  
  
  
}
?>