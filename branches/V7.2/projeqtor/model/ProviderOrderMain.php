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
  public $receptionDateTime;
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
  public $_tab_4_2 = array('untaxedAmountShort', 'tax', '', 'fullAmountShort','initial', 'negotiated');
  public $initialAmount;
  public $taxPct;
  public $initialTaxAmount;
  public $initialFullAmount;
  public $plannedAmount;
  public $_void_1;
  public $plannedTaxAmount;
  public $plannedFullAmount;
  public $paymentCondition;
  public $deliveryDelay;
  public $_tab_3_1 = array('expectedDate','doneDate','validatedDate','dateDelivery');
  public $deliveryExpectedDate;
  public $deliveryDoneDate;
  public $deliveryValitedDate;
  public $handled;
  public $handledDate;
  public $done;
  public $doneDate;
  public $idle;
  public $idleDate;
  public $cancelled;
  public $_lib_cancelled;
  public $comment;
  //link
  public $_sec_Link;
  public $_Link=array();
  public $_Attachment=array();
  public $_Note=array();
  
  public $_BillLine=array();
  public $_BillLine_colSpan="2";
  
  public $_nbColMax=3;
 
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="4%" ># ${id}</th>
    <th field="nameProject" width="10%" >${idProject}</th>
    <th field="nameProviderOrderType" width="10%" >${idProviderOrderType}</th>
    <th field="name" width="30%" >${name}</th>
    <th field="colorNameStatus" width="9%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="nameResource" formatter="thumbName22" width="8%" >${responsible}</th>
    <th field="handled" width="4%" formatter="booleanFormatter" >${handled}</th>
    <th field="done" width="4%" formatter="booleanFormatter" >${done}</th>
    <th field="idle" width="4%" formatter="booleanFormatter" >${idle}</th>   ';
  
  private static $_fieldsAttributes=array("id"=>"nobr", "reference"=>"readonly",
      "name"=>"required",
      "idCommandType"=>"required",
      "handled"=>"nobr",
      "done"=>"nobr",
      "idle"=>"nobr",
      "idPaymentDelay"=>"hidden",
      "taxAmount"=>"calculated,readonly",
      "fullAmount"=>"readonly",
      "addTaxAmount"=>"calculated,readonly",
      "addFullAmount"=>"readonly",
      "totalTaxAmount"=>"calculated,readonly",
      "totalFullAmount"=>"readonly",
      "totalUntaxedAmount"=>"readonly",
      "externalReference"=>"required",
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
    if ($this->initialAmount!=null) {
      if ($this->taxPct!=null) {
        $this->initialTaxAmount=round(($this->initialAmount*$this->taxPct/100),2);
      } else {
        $this->initialTaxAmount=null;
      }
      $this->initialFullAmount=$this->initialAmount+$this->initialTaxAmount;
    } else {
      $this->initialTaxAmount=null;
      $this->initialFullAmount=null;
    }
    if ($this->plannedAmount!=null) {
      if ($this->taxPct!=null) {
        $this->plannedTaxAmount=round(($this->plannedAmount*$this->taxPct/100),2);
      } else {
        $this->plannedTaxAmount=null;
      }
      $this->plannedFullAmount=$this->plannedAmount+$this->plannedTaxAmount;
    } else {
      $this->plannedTaxAmount=null;
      $this->plannedFullAmount=null;
    }
  
    $billLine=new BillLine();
    $crit = array("refType"=> "ProviderOrder", "refId"=>$this->id);
    $billLineList = $billLine->getSqlElementsFromCriteria($crit,false);
    if (count($billLineList)>0) {
      $amount=0;
      $numberDays=0;
      foreach ($billLineList as $line) {
        $amount+=$line->amount;
      }
      $this->initialAmount=$amount;
    }
    $this->initialFullAmount=$this->initialAmount*(1+$this->taxPct/100);
    //parent::simpleSave();
    $result=parent::save();
    return $result;
  }
  
}
?>