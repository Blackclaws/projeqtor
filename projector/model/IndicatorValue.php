<?php 
/* ============================================================================
 * RiskType defines the type of a risk.
 */ 
class IndicatorValue extends SqlElement {

  // extends SqlElement, so has $id
  public $_col_1_2_Description;
  public $id;
  public $code;
  public $type;
  public $refType;
  public $refId;
  public $idIndicatorDefinition;
  public $targetDateTime;
  public $targetValue;
  public $warningTargetDateTime;
  public $warningTargetValue;
  public $warningSent;
  public $alertTargetDateTime;
  public $alertTargetValue;
  public $alertSent;
  public $handled;
  public $done;
  public $idle;
  
  public $_noHistory=true;
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%"># ${id}</th>
    <th field="refType" width="20%">${name}</th>
    <th field="refId" width="20">${code}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
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

    /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
    
  static public function addIndicatorValue($def, $obj) {
  	$class=get_class($obj);
  	if ($def->nameIndicatorable!=$class) {
  		debugLog("ERROR in IndicatorValue::addIndicatorValue() => incoherent class between def ($def->nameIndicatorable) and obj ($class) ");
  		return;
  	}
  	$crit=array('idIndicatorDefinition'=>$def->id, 'refType'=>$class, 'refId'=>$obj->id);
  	$indVal=new IndicatorValue();
  	$lst=$indVal->getSqlElementsFromCriteria($crit, true);
  	if (count($lst)==1) {
  		$indVal=$lst[0];
  	} else if (count($lst)==0) {
  		$indVal=new IndicatorValue();
  		$indVal->idIndicatorDefinition=$def->id;
  		$indVal->refType=$class;
  		$indVal->refId=$obj->id; 		
  	} else {
  		$cpt=count($lst);
      debugLog("ERROR in IndicatorValue::addIndicatorValue() => more than 1 (exactely $cpt) line of IndicatorValue for refType=$class, refId=$obj->id, idIndicatorDefinition=$def->id");
      return;  		
  	}
  	$fld="";
  	$fldVal;
  	$sub="";
    $indVal->idle=$obj->idle;
    if (property_exists($obj, 'handled')) {
      $indVal->handled=$obj->handled;
    }
    if (property_exists($obj, 'done')) {
      $indVal->done=$obj->done;
    }
    $indVal->code=$def->codeIndicator;
    $indVal->type=$def->typeIndicator;
  	$ind=new Indicator($def->idIndicator);
  	if ($ind->type=="delay") {
  		$fld=$ind->name;
  		if (substr($fld,-7)=='EndDate' or substr($fld,-8)=='StartDate') {
  		  $sub=$class . "PlanningElement";
  		  $indVal->targetDateTime=$obj->$sub->$fld;
  	  } else {
  	    $indVal->targetDateTime=$fldVal=$obj->$fld;
  	  }
  	  $indVal->targetValue=null;
  	  $indVal->warningTargetValue=null;
  	  $indVal->alertTargetValue=null;
  	  $indVal->warningTargetDateTime=addDelayToDatetime($indVal->targetDateTime, (-1)*$def->warningValue, $def->codeWarningDelayUnit);
  	  $indVal->alertTargetDateTime=addDelayToDatetime($indVal->targetDateTime, (-1)*$def->alertValue, $def->codeAlertDelayUnit);
  	  $indVal->checkDates($obj);  	  
  	} else if ($ind-typ=="percent") {
  	  if (strpos($ind->name, 'Cost')>0) {
  		  $indVal->trigger='Cost';
  	  } else {
  	  	$indVal->trigger='Work';
  	  }
    } else {
      debugLog("ERROR in IndicatorValue::addIndicatorValue() => uncknown indicator type = $ind->type");    	
    }
    $indVal->save();
  	
  }
  
  public function checkDates($obj=null) {
//debugLog('checkDates');
//debugLog("type=$this->type");
    if ($this->type!='delay') {
  		return;
  	}
  	if (!$obj and ($this->idle or $this->done)) {
  		return;
  	} 
//debugLog("code=$this->code");
  	switch ($this->code) {
  		case 'IDDT' :   //InitialDueDateTime
  		case 'ADDT' :   //ActualDueDateTime
      case 'IDD' :    //InitialDueDate
      case 'ADD' :    //ActualDueDate
      	if (substr($this->code,-3)=='DDT'){
          $date=date('Y-m-d H:i');
      	} else {
      		$date=date('Y-m-d');
      	}
        if ($obj and $obj->done) {
          if (substr($this->code,-3)=='DDT'){
          	$date=$obj->doneDateTime;
          } else {
          	$date=$obj->doneDate;
          }
        }        
      	break;
      case 'IED' :    //InitialEndDate
      case 'VED' :    //ValidatedEndDate
      case 'PED' :    //PlannedEndDate
      	$date=date('Y-m-d');
        if ($obj and $obj->done) {
        	$date=$obj->doneDate;
        }        
      	break;
      case 'ISD' :    //InitialStartDate
      case 'VSD' :    //ValidatedStartDate
      case 'PSD' :    //PlannedStartDate
      	$date=date('Y-m-d');
        if ($obj and property_exists($obj,'handeledDate') and $obj->handeled) {
          $date=$obj->handledDate;
        }
        $pe=get_class($obj).'PlanningElement';
        if ($obj->pe->realStartDate and $obj->pe->realStartDate<$date) {
        	$date=$obj->pe->realStartDate;
        }        
        break;
  	}
    if ($date>$this->warningTargetDateTime) {
      if (! $this->warningSent) {
        $this->sendWarning();
        $this->warningSent=true;
      }
    } else {
      $this->warningSent=false;
    }
    if ($date>$this->alertTargetDateTime) {
      if (! $this->alertSent) {
        $this->sendAlert();
        $this->alertSent=true;
      }
    } else {
      $this->alertSent=false;
    }        
  	if (!$obj) $this->save();
  }
  
  public function sendAlert() {
debugLog ("alert sent for refType=$this->refType refId=$this->refId id=$this->id");  	
  	
  }
  
  public function sendWarning() {
debugLog ("warning sent for refType=$this->refType refId=$this->refId id=$this->id");   
  	  	
  }
}
?>