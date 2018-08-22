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
 * Action is establised during meeting, to define an action to be followed.
 */ 
require_once('_securityCheck.php');
class ProviderOrderMain extends SqlElement {
  // List of fields that will be exposed in general user interface
  public $_sec_description;
  public $id; 
  public $reference;
  public $name;
  public $idProviderOrderType;
  public $idProject;
  public $idUser;
  public $creationDate;
  public $sendDate;
  public $Origin;
  public $idProvider;
  public $externalReference;
  public $description;
  public $additionalInfo;
  //treatment
  public $_sec_treatment;
  public $idStatus;
  public $idResource;
  public $idContact;
   public $_tab_4_3_smallLabel = array('untaxedAmount', 'taxPct', 'taxAmount', 'fullAmount','initial','discount', 'countTotal');
  //init
  public $untaxedAmount;
  public $taxPct;
  public $taxAmount;
  public $fullAmount;
  //remise
  public $discountAmount;
  public $_label_rate;
  public $discountRate;
  public $_void_1;
  //total
  public $totalUntaxedAmount;
  public $_void_2;
  public $totalTaxAmount;
  public $totalFullAmount;
  public $idProjectExpense;
  public $paymentCondition;
  public $deliveryDelay;
  public $_tab_3_1 = array('plannedDate','realDate','validationDate','versionDeliveryDate');
  public $deliveryExpectedDate;
  public $deliveryDoneDate;
  public $deliveryValidationDate;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $cancelled;
  public $_lib_cancelled;
  public $comment;
  public $_BillLine=array();
  public $_BillLine_colSpan="2";
  //tab term
  public $_sec_ProviderTerm;
  public $_spe_ProviderTerm;
  //link
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();
  
  public $_nbColMax=3;
 
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="4%" ># ${id}</th>
    <th field="nameProject" width="9%" >${idProject}</th>
    <th field="nameProviderOrderType" width="9%" >${idProviderOrderType}</th>
    <th field="name" width="27%" >${name}</th>
    <th field="colorNameStatus" width="9%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="nameResource" formatter="thumbName22" width="8%" >${responsible}</th>
    <th field="deliveryExpectedDate" width="8%" formatter="dateFormatter" >${deliveryExpectedDate}</th>
    <th field="untaxedAmount" width="7%" formatter="costFormatter">${untaxedAmount}</th>
    <th field="totalUntaxedAmount" width="7%" formatter="costFormatter">${totalUntaxedAmount}</th>
    <th field="handled" width="4%" formatter="booleanFormatter" >${handled}</th>
    <th field="done" width="4%" formatter="booleanFormatter" >${done}</th>
    <th field="idle" width="4%" formatter="booleanFormatter" >${idle}</th>   ';
  
  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
      "name"=>"required",
      "idProviderOrderType"=>"required",
      "handled"=>"nobr",
      "done"=>"nobr",
      "idle"=>"nobr",
      "idPaymentDelay"=>"hidden",
      "totalTaxAmount"=>"readonly",
      "taxAmount"=>"readonly",
      "fullAmount"=>"readonly",
      "totalUntaxedAmount"=>"readonly",
      "totalTaxAmount"=>"readonly",
      "totalFullAmount"=>"readonly",
      "idStatus"=>"required",
      "idleDate"=>"nobr",
      "cancelled"=>"nobr",
      "validatedWork"=>"readonly",
      "initialPricePerDayAmount"=>"hidden",
      "addPricePerDayAmount"=>"hidden",
      "validatedPricePerDayAmount"=>"hidden",
      "idProject"=>"required");
 
  
  private static $_colCaptionTransposition = array('idResource'=> 'responsible');
  
  private static $_databaseColumnName = array();
  /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
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
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
  }
  
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
  public function save() {
   if (trim($this->idProvider)) {
      $provider=new Provider($this->idProvider);
      if ($provider->taxPct!='' and !$this->taxPct) {
        $this->taxPct=$provider->taxPct;
      }
    }
    // Update amounts
    if ($this->untaxedAmount!=null) {
      if ($this->taxPct!=null) {
        $this->taxAmount=round(($this->untaxedAmount*$this->taxPct/100),2);
      } else {
        $this->taxAmount=null;
      } 
      $this->fullAmount=$this->untaxedAmount+$this->taxAmount;
    } else {
      $this->taxAmount=null;
      $this->fullAmount=null;
    }  
    if ($this->totalUntaxedAmount!=null) {
      if ($this->taxPct!=null) {
        $this->totalTaxAmount=round(($this->totalUntaxedAmount*$this->taxPct/100),2);
      } else {
        $this->totalTaxAmount=null;
      }
      $this->totalFullAmount=$this->totalUntaxedAmount+$this->totalTaxAmount;
    } else {
      $this->totalTaxAmount=null;
      $this->totalFullAmount=null;
    }
    $result=parent::save();
    
    $billLine=new BillLine();
    $crit = array("refType"=> "ProviderOrder", "refId"=>$this->id);
    $billLineList = $billLine->getSqlElementsFromCriteria($crit,false);
    if (count($billLineList)>0) {
      $amount=0;
      foreach ($billLineList as $line) {
        $amount+=$line->amount;
      }
      $this->untaxedAmount=$amount;
    }
    $this->fullAmount=$this->untaxedAmount*(1+$this->taxPct/100);
    $this->taxAmount=$this->fullAmount-$this->untaxedAmount;
    $this->totalUntaxedAmount=$this->untaxedAmount-$this->discountAmount;
    $this->totalFullAmount=$this->totalUntaxedAmount*(1+$this->taxPct/100);
    $this->totalTaxAmount=$this->totalFullAmount-$this->totalUntaxedAmount;
    
    parent::simpleSave();
    return $result;
  }
  
   public function control(){
    $result="";
    
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  public function copyTo($newClass, $newType, $newName, $setOrigin, $withNotes, $withAttachments, $withLinks, $withAssignments = false, $withAffectations = false, $toProject = NULL, $toActivity = NULL, $copyToWithResult = false,$copyToWithVersionProjects=false) {
    return parent::copyTo($newClass, $newType, $newName, $setOrigin, $withNotes, $withAttachments, $withLinks);
  }
  
  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are :
   *    - subprojects => presents sub-projects as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    global $comboDetail, $print, $outMode, $largeWidth;
    $result="";
    if ($item=='ProviderTerm') {
      $term=new ProviderTerm();
      $critArray=array('idProviderOrder'=>(($this->id)?$this->id:'0'));
      $termList=$term->getSqlElementsFromCriteria($critArray, false);
      drawProviderTermFromObject($termList, $this, 'ProviderTerm', false);
      return $result;
    } 
  }
  
  // ============================================================================**********
  // GET VALIDATION SCRIPT
  // ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo framework)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);
    if($colName=="untaxedAmount" or $colName=="taxPct" or $colName=="discountAmount") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  updateFinancialTotal();';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }else if ($colName=="discountRate") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '   var rate=dijit.byId("discountRate").get("value");';
      $colScript .= '   var untaxedAmount=dijit.byId("untaxedAmount").get("value");';
      $colScript .= '  if (!isNaN(rate)) {';
      $colScript .= '   var discount=Math.round(untaxedAmount*rate)/100;';
      $colScript .= '    dijit.byId("discountAmount").set("value",discount);';
      $colScript .= '  }';
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
  
  public function setAttributes() {
    if (count($this->_BillLine)) {
      self::$_fieldsAttributes['untaxedAmount']='readonly';
    }
    $term=new ProviderTerm();
    $critArray=array('idProviderOrder'=>$this->id);
    $cpt=$term->countSqlElementsFromCriteria($critArray, false);
    if ($cpt > 0 ) {
      self::$_fieldsAttributes['discountAmount']='readonly';
      self::$_fieldsAttributes['discountRate']='readonly';
    }
  }
  
}
?>