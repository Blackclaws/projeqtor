<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ============================================================================
 * Budget is the main financial income for expenses
 * Almost all other objects are linked to a given Budget.
 */ 
require_once('_securityCheck.php');
class BudgetMain extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_sec_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $idBudgetType;
  public $idBudgetOrientation;
  public $idBudgetCategory;
  public $idUser;
  public $creationDate;
  public $lastUpdateDateTime;
  public $articleNumber;
  public $idOrganization;
  public $idClient;
  public $clientCode;
  public $idBudget;
  public $idSponsor;
  public $idResource;
  public $color;
  public $description;
  public $_sec_Treatment;
  public $idStatus;
  public $isUnderConstruction=1;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $cancelled;
  public $_lib_cancelled;
  public $_sec_subBudgets;
  public $_spe_subBudgets;
  public $_sec_Progress;
  public $_tab_2_1=array('startDate','endDate','budgetDates');
  public $budgetStartDate;
  public $budgetEndDate;
  public $bbs;
  public $bbsSortable;
  public $_tab_2_12=array('untaxedAmount','fullAmount','estimateAmount','initialAmount','update1Amount','update2Amount','update3Amount','update4Amount','updatedAmount','subBudgetsAmount','engagedAmount','availableAmount','billedAmount','leftAmount');
  public $plannedAmount;
  public $plannedFullAmount;
  public $initialAmount;
  public $initialFullAmount;
  public $update1Amount;
  public $update1FullAmount;
  public $update2Amount;
  public $update2FullAmount;
  public $update3Amount;
  public $update3FullAmount;
  public $update4Amount;
  public $update4FullAmount;
  public $actualAmount;
  public $actualFullAmount;
  public $actualSubAmount;
  public $actualSubFullAmount;
  public $usedAmount;
  public $usedFullAmount;
  public $availableAmount;
  public $availableFullAmount;
  public $billedAmount;
  public $billedFullAmount;
  public $leftAmount;
  public $leftFullAmount;
  public $elementary;
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();

  public $_nbColMax=3;
  // Define the layout that will be used for lists
  
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="bbsSortable" formatter="sortableFormatter" width="5%" >${bbs}</th>
    <th field="name" width="20%" >${name}</th>
    <th field="nameBudgetOrientation" width="10%" >${idBudgetOrientation}</th>
    <th field="nameBudgetType" width="10%" >${idBudgetType}</th>
    <th field="articleNumber" width="10%" >${articleNumber}</th>
    <th field="actualAmount" width="8%" formatter="costFormatter">${updatedAmount}</th>
    <th field="usedAmount" width="8%" formatter="costFormatter">${engagedAmount}</th>
  <th field="availableAmount" width="8%" formatter="costFormatter">${availableAmount}</th>
    <th field="billedAmount" width="8%" formatter="costFormatter">${billedAmount}</th>
    <th field="leftAmount" width="8%" formatter="costFormatter">${leftAmount}</th>
    ';
  
  private static $_fieldsTooltip = array(
  );  

  private static $_fieldsAttributes=array("name"=>"required",      
                                  "done"=>"nobr",
                                  "handled"=>"hidden",
                                  "handledDate"=>"hidden",
                                  "idle"=>"nobr",
                                  "idleDate"=>"nobr",
                                  "cancelled"=>"nobr",
                                  "idBudgetType"=>"required",
                                  "idStatus"=>"required",
                                  "lastUpdateDateTime"=>"hidden",
                                  "bbs"=>"display,noImport", 
                                  "bbsSortable"=>"hidden,noImport",
                                  "elementary"=>"hidden",
      "actualAmount"=>"readonly,noimport",
      "actualFullAmount"=>"readonly,noimport",
      "actualSubAmount"=>"readonly,noimport",
      "actualSubFullAmount"=>"readonly,noimport",
      "billedAmount"=>"readonly,noimport",
      "billedFullAmount"=>"readonly,noimport",
      "availableAmount"=>"readonly,noimport",
      "availableFullAmount"=>"readonly,noimport",
      "usedAmount"=>"readonly,noimport",
      "usedFullAmount"=>"readonly,noimport",
      "leftAmount"=>"readonly,noimport",
      "leftFullAmount"=>"readonly,noimport",
  );   
 
  private static $_colCaptionTransposition = array('idResource'=>'manager',
   'idBudget'=> 'isSubBudget',
   'done'=>'approved',
   'doneDate'=>'dateApproved',
   'idUser'=>'issuer',
  		'plannedAmount'=>'estimateAmount',
  		'plannedFullAmount'=>'estimateFullAmount'
  );
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
  	parent::__construct($id,$withoutDependentObjects);
  	if (!$this->id) {
  	  $year=(date('md')<'0701')?date('Y'):date('Y')+1;
  	  $this->budgetStartDate=$year.'-01-01';
  	  $this->budgetEndDate=$year.'-12-31';
  	}
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
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
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
    if (substr($colName,-6)=='Amount') {
    	$colScript .= '<script type="dojo/connect" event="onChange" >';
    	$colScript.="    var actual=0;";  
    	$colScript.="    if (dijit.byId('initialAmount').get('value')) actual+=dijit.byId('initialAmount').get('value');";
    	$colScript.="    if (dijit.byId('update1Amount').get('value')) actual+=dijit.byId('update1Amount').get('value');";
    	$colScript.="    if (dijit.byId('update2Amount').get('value')) actual+=dijit.byId('update2Amount').get('value');";
    	$colScript.="    if (dijit.byId('update3Amount').get('value')) actual+=dijit.byId('update3Amount').get('value');";
    	$colScript.="    if (dijit.byId('update4Amount').get('value')) actual+=dijit.byId('update4Amount').get('value');";
    	$colScript.="    dijit.byId('actualAmount').set('value',actual);";
    	$colScript.="    var available=actual;";
    	$colScript.="    if (dijit.byId('usedAmount').get('value')) available-=dijit.byId('usedAmount').get('value');";
    	$colScript.="    dijit.byId('availableAmount').set('value',available);";
    	$colScript.="    var left=actual;";
    	$colScript.="    if (dijit.byId('billedAmount').get('value')) left+=dijit.byId('billedAmount').get('value');";
    	$colScript.="    dijit.byId('leftAmount').set('value',left);";
    	$colScript.="    var actualFull=0;";
    	$colScript.="    if (dijit.byId('initialFullAmount').get('value')) actualFull+=dijit.byId('initialFullAmount').get('value');";
    	$colScript.="    if (dijit.byId('update1FullAmount').get('value')) actualFull+=dijit.byId('update1FullAmount').get('value');";
    	$colScript.="    if (dijit.byId('update2FullAmount').get('value')) actualFull+=dijit.byId('update2FullAmount').get('value');";
    	$colScript.="    if (dijit.byId('update3FullAmount').get('value')) actualFull+=dijit.byId('update3FullAmount').get('value');";
    	$colScript.="    if (dijit.byId('update4FullAmount').get('value')) actualFull+=dijit.byId('update4FullAmount').get('value');";
    	$colScript.="    dijit.byId('actualFullAmount').set('value',actualFull);";
    	$colScript.="    var availableFull=actualFull;";
    	$colScript.="    if (dijit.byId('usedFullAmount').get('value')) availableFull-=dijit.byId('usedFullAmount').get('value');";
    	$colScript.="    dijit.byId('availableFullAmount').set('value',availableFull);";
    	$colScript.="    var leftFull=actualFull;";
    	$colScript.="    if (dijit.byId('billedFullAmount').get('value')) left+=dijit.byId('billedFullAmount').get('value');";
    	$colScript.="    dijit.byId('leftFullAmount').set('value',leftFull);";
    	$colScript .= '  formChanged();';
    	$colScript .= '</script>';
    }
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********

  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   *    - subBudgets => presents sub-Budgets as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){ 	
    $result="";
    if ($item=='subBudgets') {
      $result .="<table><tr><td class='label' valign='top'><label>" . i18n('subBudgets') . "&nbsp;:&nbsp;</label>";
      $result .="</td><td style='padding-top:7px;'>";
      if ($this->id) {
        $result .= $this->drawSubBudgets();
      }
      $result .="</td></tr></table>";
      return $result;
    }
  }
  

  /** =========================================================================
   * Specific function to draw a recursive tree for subBudgets
   * @return string the html table for the given level of subBudgets
   *  must be redefined in the inherited class
   */  
  public function drawSubBudgets($recursiveCall=false) {
  	debugLog("sub budget for #$this->id");
    global $outMode;
    $result="";
    
 	  $subList=SqlList::getListWithCrit('Budget',array('idBudget'=>$this->id));
 	  debugLog($subList);
    $result .='<table style="width: 100%;" >';
    if (count($subList)>0) {
      foreach ($subList as $idBdg=>$nameBdg) {
      	$bdg=new Budget($idBdg,true);
        $result .='<tr><td valign="top" width="20px"><img src="css/images/iconList16.png" height="16px" /></td>';
        //$result .= '<td style="#AAAAAA;" NOWRAP><div class="'.(($outMode=='html' or $outMode=='pdf')?'':'display').'" style="width: 100%;">' . htmlEncode($bdg->name) . '</div>';
        $clickEvent=' onClick=\'gotoElement("Budget","' . htmlEncode($bdg->id) . '");\' ';
        if ($outMode=='html' or $outMode=='pdf') $clickEvent='';
        $result .= '<td><div ' . $clickEvent . ' class="'.(($outMode=='html' or $outMode=='pdf')?'':'menuTree').'" style="width:100%;color:black">';
        $result .= htmlEncode($bdg->name);
        if ($bdg->actualAmount) $result.='<div style="float:right">&nbsp;&nbsp;&nbsp;<i>('.htmlDisplayCurrency($bdg->actualAmount).')</i></div>';
        $result .= '</div>';
        $result .= $bdg->drawSubBudgets(true);
        $result .= '</td></tr>';
      }
    }
    $result .='</table>';
   return $result;
  }
  
   /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {	
    $old=$this->getOld();
    if(SqlList::getFieldFromId("Status", $this->idStatus, "setHandledStatus")!=0) {
      $this->isUnderConstruction=0;
    } 
    $this->actualAmount=$this->initialAmount
                           +$this->update1Amount
                           +$this->update2Amount
                           +$this->update3Amount
                           +$this->update4Amount;
    $this->actualFullAmount=$this->initialFullAmount
                            +$this->update1FullAmount
                            +$this->update2FullAmount
                            +$this->update3FullAmount
                            +$this->update4FullAmount;
    $this->usedAmount=0;
    $this->usedFullAmount=0;
    $this->billedAmount=0;
    $this->billedFullAmount=0;
    $this->actualSubAmount=0;
    $this->actualSubFullAmount=0;
    $bud=new Budget();
    $budList=$bud->getSqlElementsFromCriteria(array('idBudget'=>$this->id));
    foreach ($budList as $bud) {
      $this->actualSubAmount+=$bud->actualAmount;
      $this->actualSubFullAmount+=$bud->actualFullAmount;
      $this->usedAmount+=$bud->usedAmount;
      $this->usedFullAmount+=$bud->usedFullAmount;
      $this->billedAmount+=$bud->billedAmount;
      $this->billedFullAmount+=$bud->billedFullAmount;
    }
    $this->elementary=(count($budList)==0)?1:0;
    if ($this->elementary) {
      $exp=new Expense();
      $expList=$exp->getSqlElementsFromCriteria(array('idBudgetItem'=>$this->id));
      foreach ($expList as $exp) {
        $this->usedAmount+=$exp->plannedAmount;
        $this->usedFullAmount+=$exp->plannedFullAmount;
        $this->billedAmount+=$exp->realAmount;
        $this->billedFullAmount+=$exp->realFullAmount;
      }
    }
    $this->availableAmount=$this->actualAmount-$this->usedAmount;
    $this->availableFullAmount=$this->actualFullAmount-$this->usedFullAmount;
    $this->leftAmount=$this->actualAmount-$this->billedAmount;
    $this->leftFullAmount=$this->actualFullAmount-$this->billedFullAmount;
    
    // CALCULATE WBS
    $result = parent::save();
    if (! strpos($result,'id="lastOperationStatus" value="OK"')) {
      return $result;     
    }   
    // UPDATE PARENTS (recursively)
    if ($this->idBudget) {
      $parent=new Budget($this->idBudget);
      $parent->save();
    }
    
    return $result; 

  }
  public function delete() {
  	$result = parent::delete();
    return $result;
  }
  

/** =========================================================================
   * control data corresponding to Model constraints
   * @param void
   * @return "OK" if controls are good or an error message 
   *  must be redefined in the inherited class
   */
  public function control(){
    $result="";
    $old=$this->getOld();
    if ($this->id and $this->id==$this->idBudget) {
      $result.='<br/>' . i18n('errorHierarchicLoop');
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

  
  public function getColor() {
    $color="#777777";
    if ($this->color) {
      $color=$this->color;
    } else if ($this->idBudget) {
      $top=new Budget($this->idBudget);
      $color=$top->getColor();
    }
    return $color;
  }

  protected function getStaticFieldsTooltip() {
    return self::$_fieldsTooltip;
  }
}
?>