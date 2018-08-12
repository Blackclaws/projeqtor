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
  public $isUnderConstruction;
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
  public $budgetStartDate;
  public $budgetEndDate;
  public $bbs;
  public $bbsSortable;
  public $_tab_2_12=array('HT','TTC','planned','initial','update1','update2','update3','transfered','actual','sub','engaged','available','billed','left');
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
    <th field="name" width="20%" >${BudgetName}</th>
    <th field="nameOrientation" width="10%" >${idOrientation}</th>
    <th field="nameBudgetType" width="10%" >${type}</th>
    <th field="articleNumber" width="10%" >${articleNumber}</th>
    <th field="actualAmount" width="8%" formatter="costFormatter">${actual}</th>
    <th field="usedAmount" width="8%" formatter="costFormatter">${used}</th>
    <th field="availableAmount" width="8%" formatter="costFormatter">${available}</th>
    <th field="billedAmount" width="8%" formatter="costFormatter">${billed}</th>
    <th field="leftAmount" width="8%" formatter="costFormatter">${left}</th>
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
   'idBudgetType'=>'type',
   'idUser'=>'issuer');
  
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

//     if ($colName=="idle") {   
//       $colScript .= '<script type="dojo/connect" event="onChange" >';
//       $colScript .= '  if (this.checked) { ';
//       $colScript .= '    if (dijit.byId("idleDate").get("value")==null) {';
//       $colScript .= '      var curDate = new Date();';
//       $colScript .= '      dijit.byId("idleDate").set("value", curDate); ';
//       $colScript .= '    }';
//       $colScript .= '    if (! dijit.byId("done").get("checked")) {';
//       $colScript .= '      dijit.byId("done").set("checked", true);';
//       $colScript .= '    }';  
//       $colScript .= '  } else {';
//       $colScript .= '    dijit.byId("idleDate").set("value", null); ';
//       $colScript .= '  } '; 
//       $colScript .= '  formChanged();';
//       $colScript .= '</script>';
//     } else if ($colName=="done") {   
//       $colScript .= '<script type="dojo/connect" event="onChange" >';
//       $colScript .= '  if (this.checked) { ';
//       $colScript .= '    if (dijit.byId("doneDate").get("value")==null) {';
//       $colScript .= '      var curDate = new Date();';
//       $colScript .= '      dijit.byId("doneDate").set("value", curDate); ';
//       $colScript .= '    }';
//       $colScript .= '  } else {';
//       $colScript .= '    dijit.byId("doneDate").set("value", null); ';
//       $colScript .= '    if (dijit.byId("idle").get("checked")) {';
//       $colScript .= '      dijit.byId("idle").set("checked", false);';
//       $colScript .= '    }'; 
//       $colScript .= '  } '; 
//       $colScript .= '  formChanged();';
//       $colScript .= '</script>';
//     } else if ($colName=="idStatus") {
//       $colScript .= '<script type="dojo/connect" event="onChange" >';
//       $colScript .= htmlGetJsTable('Status', 'setIdleStatus', 'tabStatusIdle');
//       $colScript .= htmlGetJsTable('Status', 'setDoneStatus', 'tabStatusDone');
//       $colScript .= '  var setIdle=0;';
//       $colScript .= '  var filterStatusIdle=dojo.filter(tabStatusIdle, function(item){return item.id==dijit.byId("idStatus").value;});';
//       $colScript .= '  dojo.forEach(filterStatusIdle, function(item, i) {setIdle=item.setIdleStatus;});';
//       $colScript .= '  if (setIdle==1) {';
//       $colScript .= '    dijit.byId("idle").set("checked", true);';
//       $colScript .= '  } else {';
//       $colScript .= '    dijit.byId("idle").set("checked", false);';
//       $colScript .= '  }';
//       $colScript .= '  var setDone=0;';
//       $colScript .= '  var filterStatusDone=dojo.filter(tabStatusDone, function(item){return item.id==dijit.byId("idStatus").value;});';
//       $colScript .= '  dojo.forEach(filterStatusDone, function(item, i) {setDone=item.setDoneStatus;});';
//       $colScript .= '  if (setDone==1) {';
//       $colScript .= '    dijit.byId("done").set("checked", true);';
//       $colScript .= '  } else {';
//       $colScript .= '    dijit.byId("done").set("checked", false);';
//       $colScript .= '  }';
//       $colScript .= '  formChanged();';
//       $colScript .= '</script>';     
//     } 
    
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Retrieves the hierarchic sub-Budgets of the current Budget
   * @return an array of Budgets as sub-Budgets
   */
  public function getSubBudgets($limitToActiveBudgets=false, $withoutDependantElement=false) {
//     if ($this->id==null or $this->id=='') {
//       return array();
//     }
//     $crit=array();
//     if ($this->id=='*') {
//       $crit['idBudget']='';
//     } else {
//       $crit['idBudget']=$this->id;
//     }

//     if ($limitToActiveBudgets) {
//       $crit['idle']='0';
//     }
//     $sorted=SqlList::getListWithCrit('Budget',$crit,'name');
//     $subBudgets=array();
//     foreach($sorted as $id=>$name) {
//       $subBudgets[$id]=new Budget($id, $withoutDependantElement);
//     }
//     return $subBudgets;
  }

  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   *    - subBudgets => presents sub-Budgets as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
//scriptLog("Budget($this->id)->drawSpecificItem($item)");  	
    $result="";
    if ($item=='subBudgets') {
      $result .="<table><tr><td class='label' valign='top'><label>" . i18n('subBudgets') . "&nbsp;:&nbsp;</label>";
      $result .="</td><td>";
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
  public function drawSubBudgets($selectField=null, $recursiveCall=false, $limitToUserBudgets=false, $limitToActiveBudgets=false) {
scriptLog("Budget($this->id)->drawSubBudgets(selectField=$selectField, recursiveCall=$recursiveCall, limitToUserBudgets=$limitToUserBudgets, limitToActiveBudgets=$limitToActiveBudgets)");
//     global $outMode;
//   	self::$_drawSubBudgetsDone[$this->id]=$this->name;
//     if ($limitToUserBudgets) {
//       $user=getSessionUser();
//       if (! $user->_accessControlVisibility) {
//         $user->getAccessControlRights(); // Force setup of accessControlVisibility
//       }
//       if ($user->_accessControlVisibility != 'ALL') {      
//         $visibleBudgetsList=$user->getHierarchicalViewOfVisibleBudgets($limitToActiveBudgets);
//       } else {
//       	$visibleBudgetsList=array();
//       }
//       $reachableBudgetsList=$user->getVisibleBudgets($limitToActiveBudgets);
//     } else {  
//       $visibleBudgetsList=array();
//       $reachableBudgetsList=array();
//     }  
//     $result="";
//     $clickEvent=' onClick=""';
//     if ($outMode=='html' or $outMode=='pdf') $clickEvent='';
//     if ($limitToUserBudgets and $user->_accessControlVisibility != 'ALL' and ! $recursiveCall) {
//     	$subList=array();
//     	foreach($visibleBudgetsList as $idP=>$nameP) {
//     		$split=explode('#',$nameP);
//     		if (strpos($split[0],'.')==0) {
//     			$subList[substr($idP,1)]=str_replace('&sharp;','#',$split[1]);
//     		}
//     	}
//     } else {
//   	  $subList=$this->getSubBudgetsList($limitToActiveBudgets,true);
//     }
//     if ($selectField!=null and ! $recursiveCall) { 
//       $result .= '<table ><tr><td>';
//       $clickEvent=' onClick=\'setSelectedBudget("*", "<i>' . i18n('allBudgets') . '</i>", "' . $selectField . '");\' ';
//       if ($outMode=='html' or $outMode=='pdf') $clickEvent='';
//       $result .= '<div ' . $clickEvent . ' class="'.(($outMode=='html' or $outMode=='pdf')?'':'menuTree').'" style="width:100%;">';
//       $result .= '<i>' . i18n('allBudgets') . '</i>';
//       $result .= '</div></td></tr></table>';
//     }
//     $result .='<table style="width: 100%;" >';
//     if (count($subList)>0) {
//       foreach ($subList as $idPrj=>$namePrj) {
//         $showLine=true;
//         $reachLine=true;
//         if (array_key_exists($idPrj,self::$_drawSubBudgetsDone)) {
//         	$showLine=false;
//         }
//         if ($limitToUserBudgets) {
//           if ($user->_accessControlVisibility != 'ALL') {
//             if (! array_key_exists('#' . $idPrj,$visibleBudgetsList)) {
//               $showLine=false;
//             }
//             if (! array_key_exists($idPrj,$reachableBudgetsList)) {
//               $reachLine=false;
//             }
//           }  
//         }
//         if ($showLine) {
//         	$prj=new Budget($idPrj);
//           $result .='<tr><td valign="top" width="20px"><img src="css/images/iconList16.png" height="16px" /></td>';
//           if ($selectField==null) {
//             $result .= '<td class="'.(($outMode=='html' or $outMode=='pdf')?'':'display').'"  NOWRAP>' . (($outMode=='html' or $outMode=='pdf')?htmlEncode($prj->name):htmlDrawLink($prj));
//           } else if (! $reachLine) {
//             $result .= '<td style="#AAAAAA;" NOWRAP><div class="'.(($outMode=='html' or $outMode=='pdf')?'':'display').'" style="width: 100%;">' . htmlEncode($prj->name) . '</div>';
//           } else {
//             $clickEvent=' onClick=\'setSelectedBudget("' . htmlEncode($prj->id) . '", "' . htmlEncode($prj->name,'parameter') . '", "' . $selectField . '");\' ';
//             if ($outMode=='html' or $outMode=='pdf') $clickEvent='';
//             $result .= '<td><div ' . $clickEvent . ' class="'.(($outMode=='html' or $outMode=='pdf')?'':'menuTree').'" style="width:100%;color:black">';
//             $result .= htmlEncode($prj->name);
//             $result .= '</div>';
//           }
//           $result .= $prj->drawSubBudgets($selectField,true,$limitToUserBudgets,$limitToActiveBudgets);
//           $result .= '</td></tr>';
//         }
//       }
//     }
//     $result .='</table>';
//    return $result;
  }

  public function drawBudgetsList($critArray) {
//scriptLog("Budget($this->id)->drawBudgetsList(implode('|',$critArray))");  	
//     $result="<table>";
//     $prjList=$this->getSqlElementsFromCriteria($critArray, false);
//     foreach ($prjList as $prj) {
//       $result.= '<tr><td valign="top" width="20px"><img src="css/images/iconList16.png" height="16px" /></td><td>';
//       $result.=htmlDrawLink($prj);
//       $result.= '</td></tr>';
//     }
//     $result .="</table>";
//     return $result; 
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
    if ($this->elementary) {
      $exp=new Expense();
      $expList=$exp->getSqlElementsFromCriteria(array('idBudgetItem'=>$this->id));
      foreach ($expList as $exp) {
        $this->usedAmount+=$exp->plannedAmount;
        $this->usedFullAmount+=$exp->plannedFullAmount;
        $this->billedAmount+=$exp->realAmount;
        $this->billedFullAmount+=$exp->realFullAmount;
      }
    } else {
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