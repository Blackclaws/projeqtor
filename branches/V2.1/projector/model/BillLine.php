<?php 
/* ============================================================================
 * Line defines right to the application for a menu and a profile.
 */ 
class BillLine extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $refType;
  public $refId;
  public $line;
  public $quantity;
  public $description;
  public $detail;
  public $price;
  public $amount;
  public $idTerm;
  public $idResource;
  public $idActivityPrice;
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
    $result="";    
  	$bill = new Bill($this->refId);
    $billingType=$bill->billingType;
	  if (is_numeric($bill->billId)) {
		  $result.='<br/>' . i18n('errorLockedBill');
	  }
	  if ($billingType=='E') {
	    if ( ! trim($this->idTerm) ){
        $result.="<br/>" . i18n('messageMandatory',array(i18n('colIdTerm')));
      }
	  }
	  if ($billingType=='R' or $billingType=='P') {
      if ( ! trim($this->idResource) ){
        $result.="<br/>" . i18n('messageMandatory',array(i18n('colIdResource')));
      }
	    if ( ! trim($this->idActivityPrice) ){
        $result.="<br/>" . i18n('messageMandatory',array(i18n('colIdActivityPrice')));
      }
	    if ( ! $this->startDate){
        $result.="<br/>" . i18n('messageMandatory',array(i18n('colStartDate')));
      }
	    if ( ! $this->endDate){
        $result.="<br/>" . i18n('messageMandatory',array(i18n('colEndDate')));
	    }
    }       
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
/** =========================================================================
   * Overrides SqlElement::deleteControl() function to add specific treatments
   * @see persistence/SqlElement#deleteControl()
   * @return the return message of persistence/SqlElement#deleteControl() method
   */  
  
  public function deleteControl() {
  	$result="";    
    $bill = new Bill($this->refId);
    if (is_numeric($bill->billId)) {
      $result.='<br/>' . i18n('errorLockedBill');
    }    
  	if (! $result) {  
      $result=parent::deleteControl();
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
  		
	  $bill=new Bill($this->refId);
    $billingType=$bill->billingType;
	  if ($billingType=='E') {
      $term=new Term($this->idTerm);
      $term->idBill=null;
      $term->save();
      $crit=array('successorRefType'=>'Term','successorRefId'=>$term->id);
      $dep=new Dependency();
      $depList=$dep->getSqlElementsFromCriteria($crit, null);
      foreach($depList as $dep) {
        $class=$dep->predecessorRefType;
        $obj=new $class($dep->predecessorRefId);
        $pe=new PlanningElement($dep->predecessorId);
        $pe->idBill=null;
        $pe->save();          
      }
    }
    if ($billingType=='R' or$billingType=='P' ) {
      $price=New ActivityPrice($this->idActivityPrice);
      $act=New Activity();
      $critAct=array("idActivityType"=>$price->idActivityType, "idProject"=>$price->idProject);
      $actList=$act->getSqlElementsFromCriteria($critAct, false);
      foreach ($actList as $act) {
        $ass=new Assignment();
        $critAss=array("refType"=>"Activity", "refId"=>$act->id, "idProject"=>$act->idProject, "idResource"=>$this->idResource);
        $assList=$ass->getSqlElementsFromCriteria($critAss, false);
        foreach ($assList as $ass) {
          $selectedAss=false;
          $work = new Work();
          $crit = "idProject='".$bill->idProject . "'";
          $crit.=" and idResource='".$this->idResource. "'";    
          $crit.=" and workDate>=\"".$this->startDate."\"";
          $crit.=" and workDate<=\"".$this->endDate."\"";
          $crit.=" and idAssignment='".$ass->id."'";
          $crit.=" and idBill='" . $bill->id . "'";   
          $workList = $work->getSqlElementsFromCriteria(null,false,$crit, "idAssignment asc");
          foreach ($workList as $work) {
            $work->idBill=null;
            $selectedAss=true;
            $ass->billedWork-=$work->work;
            $work->save();
          }
          if ($selectedAss) {
            $ass->save();
          }
        }
      }       
    }

    return parent::delete();
  }
  
  /** =========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */  
  public function save() {
  	
    $bill=new Bill($this->refId);
  	$billingType=$bill->billingType;
  	
  	if ($billingType=='E') {
  		if (! $this->id) {
  		  $term=new Term($this->idTerm);
  		  $this->description=$term->name;
  		  $this->price=$term->amount;
  		  $term->idBill=$bill->id;
  		  $term->save();
  		  $crit=array('successorRefType'=>'Term','successorRefId'=>$term->id);
  		  $dep=new Dependency();
  		  $depList=$dep->getSqlElementsFromCriteria($crit, null);
  		  $this->detail="";
  		  foreach($depList as $dep) {
  		  	$class=$dep->predecessorRefType;
  		  	$obj=new $class($dep->predecessorRefId);
  		  	$this->detail.=($this->detail)?"\n":'';
  		  	$this->detail.=$obj->name;
  		  	$pe=new PlanningElement($dep->predecessorId);
  		  	$pe->idBill=$bill->id;
  		  	$pe->save();  		  	
  		  }
  		}
  	}
  	if ($billingType=='R' or $billingType=='P' ) {
      if (! $this->id) {
      	$this->detail="";
      	$totalWork=0;
      	$billableWork=0;
      	$listDates=array();
      	$price=New ActivityPrice($this->idActivityPrice);
      	$act=New Activity();
      	$critAct=array("idActivityType"=>$price->idActivityType, "idProject"=>$price->idProject);
      	$actList=$act->getSqlElementsFromCriteria($critAct, false);
      	foreach ($actList as $act) {
      		$actWork=0;
      		$actBilled=0;
      		$actAssigned=0;
      		$actPlanned=0;
      		$selectedAct=false;
      		$ass=new Assignment();
      		$critAss=array("refType"=>"Activity", "refId"=>$act->id, "idProject"=>$act->idProject, "idResource"=>$this->idResource);
      		$assList=$ass->getSqlElementsFromCriteria($critAss, false);
      		foreach ($assList as $ass) {
      			$selectedAss=false;
      			$actBilled+=$ass->billedWork;
      			$actAssigned+=$ass->assignedWork;
      			$actPlanned+=$ass->plannedWork;
      			$work = new Work();
            $crit = "idProject='".$bill->idProject . "'";
            $crit.=" and idResource='".$this->idResource. "'";    
            $crit.=" and workDate>=\"".$this->startDate."\"";
            $crit.=" and workDate<=\"".$this->endDate."\"";
            $crit.=" and idAssignment='".$ass->id."'";
            $crit.=" and idBill is null";   
            $workList = $work->getSqlElementsFromCriteria(null,false,$crit, "idAssignment asc");
            foreach ($workList as $work) {
            	$work->idBill=$bill->id;
            	$totalWork+=$work->work;
            	$actWork+=$work->work;
            	$selectedAct=true;
            	$selectedAss=true;
            	$ass->billedWork+=$work->work;
            	// Sum of work for dates : to be displayed if needed
            	if (array_key_exists($work->workDate, $listDates)) {
            	  $listDates[$work->workDate]+=$work->work;
              } else {
                $listDates[$work->workDate]=$work->work;
              }
            	$work->save();
            }
            if ($selectedAss) {
            	$ass->save();
            }
      		}
      		if ($selectedAct) {
      			$doneWork=($actWork+$actBilled);
      			$progressWork=round( ($doneWork/$actPlanned),3);
      			$actBillable=round( ( ($actAssigned*$progressWork)-$actBilled),1);
      			$actBillable=($actBillable>0)?$actBillable:0;
      			$billableWork+=$actBillable;
      			$this->detail.=(($this->detail)?"\n":"").$act->name;
      			if ($billingType=='P') {
      				$this->detail.=" : ".$actBillable." ".i18n('days');
      				$this->detail.="\n...[" . i18n('colBillable') . "] = [" . i18n('colValidated') . "]"
      				                        . " x [" . i18n('progress')  . "] - [" . i18n('colIsBilled') . "]";
      				$this->detail.="\n...[" . $actBillable . " " . i18n('days') . "] = [" . $actAssigned . " " . i18n('days') . "]"
      				                        . " x [" . ($progressWork*100) . "%] - [" . $actBilled . " " . i18n('days') . "]";
      			} else {
      			  $this->detail.=" : ".$actWork." ".i18n('days');
      			}
      		}
      	}
      	if ($billingType=='P') {
      		$this->quantity=$billableWork;
      	} else {     	
      	  $this->quantity=$totalWork;
      	}
      	$this->price=$price->priceCost;
      	$ress=new Resource($this->idResource);
        $this->description=$ress->name 
                 . "\n" . $price->name 
                 . "\n" . htmlFormatDate($this->startDate) . " - " . htmlFormatDate($this->endDate);
      }
  	}
  	
  	$this->amount=$this->quantity*$this->price;
  	$result=parent::save();
  	
  	// Update Bill to get total of amount
  	$bill->save(); 
  	
  	return $result;
  }
}
?>
