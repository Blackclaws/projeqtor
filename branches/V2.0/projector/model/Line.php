<?php 
/* ============================================================================
 * Line defines right to the application for a menu and a profile.
 */ 
class Line extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $refType;
  public $refId;
  public $line;
  public $quantity;
  public $description;
  public $reference;
  public $price;
  public $sum;
  public $idTerm;
  public $idResource;
  public $idActivity;
  public $startDate;
  public $endDate;
  
  public $_noHistory=true; // Will never save history for this object
  
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
// GET VALIDATION SCRIPT
// ============================================================================**********
 
/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="OK";
    
  	$bill = new Bill($this->refId);
	if (is_numeric($bill->billId))
	{
		$result = "Facture v&eacuterouill&eacutee";
	}
    
    return $result;
  }
  
/** =========================================================================
   * Overrides SqlElement::deleteControl() function to add specific treatments
   * @see persistence/SqlElement#deleteControl()
   * @return the return message of persistence/SqlElement#deleteControl() method
   */  
  
  public function deleteControl()
  {
  	$result = "OK";
  	$bill = new Bill($this->refId);
	if (is_numeric($bill->billId))
	{
		$result = "Facture v&eacuterrouill&eacutee";
	}
  	
  	return $result;
  }
  
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);
  }
  
  
  /** =========================================================================
   * Overrides SqlElement::delete() function to add specific treatments
   * @see persistence/SqlElement#delete()
   * @return the return message of persistence/SqlElement#delete() method
   */  
  
  public function delete()
  {
  	
  	global $paramDbPrefix;
  	
  	$bill = new Bill($this->refId);
  	if (is_numeric($this->idActivity) && is_numeric($this->quantity) && !is_numeric($this->idTerm))
  	{
  		$act = new Activity($this->idActivity);
  		$prj = new Project($act->idProject);
  		$type =new Type($prj->idProjectType);

  		$work = new Work();
		$crit = "idProject=".$prj->id;
		$crit.=" and ";
		$crit.= "idResource=".$this->idResource;
		
		$crit.=" and ";
		$crit.="workDate>=\"".$bill->startDate."\"";
		$crit.=" and ";
		$crit.="workDate<=\"".$bill->endDate."\"";
		$crit.=" and isBilled != 0";
		$crit.=" and refId=".$this->idActivity;
		
		$workList = $work->getSqlElementsFromCriteria(null,false,$crit);
		foreach ($workList as $work)
		{
			$query = "UPDATE `".$paramDbPrefix."assignment` SET billedWork = billedWork - ".$work->work." WHERE id =".$work->idAssignment;
			Sql::query($query);	
		}
  	}	
  	
  	if ($this->refId!=null && $this->idResource!=null)
	{
		$query = "UPDATE `".$paramDbPrefix."work` SET isBilled=0 WHERE isBilled=".$this->refId." AND idResource=".$this->idResource;
		if(is_numeric($this->idActivity)) $query.= " AND refId=".$this->idActivity;
		Sql::query($query);
	}
	
	if ($this->idTerm != null)
	{
		$term = new Term($this->idTerm);
		$term->isBilled = 0;
		$term->save();
		
		if($this->idActivity != null)
		{
			$query = "UPDATE `".$paramDbPrefix."planningelement` SET isBilled=0 WHERE isBilled=".$this->idTerm." AND refId=".$this->idActivity;
			Sql::query($query);
		}
		
	}
	
	return parent::delete();
  }
}
?>
