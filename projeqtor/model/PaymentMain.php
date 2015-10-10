<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * PAYMENT
 */ 
require_once('_securityCheck.php');
class PaymentMain extends SqlElement {

  // extends SqlElement, so has $id
  public $_sec_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $idPaymentType;
  public $description;
  public $idUser;
  public $creationDate;
  public $_sec_treatment;
  public $idPaymentMode;
  public $paymentDate;
  public $paymentAmount;
  public $paymentFeeAmount;
  public $paymentCreditAmount;
  public $idBill;
  public $referenceBill;
  public $idClient;
  public $idRecipient;
  public $idle;
  
 
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%"># ${id}</th>
    <th field="namePaymentType" width="10%" >${idPaymentType}</th>
    <th field="name" width="20%">${name}</th>
    <th field="namePaymentMode" width="10%" >${idPaymentMode}</th>
    <th field="paymentDate" width="10%" >${paymentDate}</th>
    <th field="paymentAmount" width="10%" >${paymentAmount}</th>  
    <th field="referenceBill" width="10%" >${referenceBill}</th>
    <th field="nameClient" width="10%" >${idClient}</th>
    <th field="nameRecipient" width="10%" >${idRecipient}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"required",
      "idPaymentType"=>"required",
      "paymentDate"=>"required",
      "idPaymentMode"=>"required",
      "paymentDate"=>"required",
      "paymentAmount"=>"required",
      "paymentCreditAmount"=>"readonly",
      "idClient"=>"readonly",
      "idRecipient"=>"readonly",
      "referenceBill"=>"readonly"
  );
  
  private static $_colCaptionTransposition = array('idUser'=>'issuer',
      'idTargetVersion'=>'targetVersion',
      'paymentFeeAmount'=>'paymentFee',
      'paymentCreditAmount'=>'paymentCredit');
  
  //private static $_databaseColumnName = array('idResource'=>'idUser');
  private static $_databaseColumnName = array();
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    if (!$this->id) {
      $this->paymentDate=date('Y-m-d');
    }
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
  protected function getStaticColCaptionTransposition($fld) {
    return self::$_colCaptionTransposition;
  }
  
  /** ========================================================================
   * Return the specific databaseColumnName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
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
    
    // Chek that bill is not already paid
    if ( $this->idBill and ($this->idBill!=$old->idBill)) {
      $bill=new Bill($this->idBill);
      debugLog($bill);
      if ($bill->paymentsCount>0 and $bill->paymentDone) {
        $result.="<br/>" . i18n('billAlreadyPaid',array($bill->id, $bill->name, $bill->reference));
      } else {
        $paidBill=$this->paymentAmount;
        if ($bill->paymentsCount>0) $paidBill+=$bill->paymentAmount;
        if ( $paidBill > $bill->fullAmount) {
          $result.="<br/>" . i18n('paymentExceedBill',array($paidBill, $bill->fullAmount));
        }
      }
    } else if ( $this->idBill and $this->paymentAmount > $old->paymentAmount) {
      $bill=new Bill($this->idBill);
      $paidBill=$bill->paymentAmount+$this->paymentAmount-$old->paymentAmount;
      if ( $paidBill > $bill->fullAmount) {
        $result.="<br/>" . i18n('paymentExceedBill',array($paidBill, $bill->fullAmount));
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
  
  public function save() {
    $old=$this->getOld();
    $this->paymentCreditAmount=$this->paymentAmount-$this->paymentFeeAmount;
    if ($this->idBill) {
      $bill=new Bill($this->idBill);
      $this->idRecipient=$bill->idRecipient;
      $this->idClient=$bill->idClient;
      $this->referenceBill=$bill->reference;
    }
    $result=parent::save();
    if (isset($bill) and $bill->id) {
      $bill->retreivePayments();
      if ($old->idBill and $old->idBill!=$this->idBill) {
        $oldBill=new Bill($old->idBill);
        $oldBill->retreivePayments();
      }
    } else if ($old->idBill) {
      $oldBill=new Bill($old->idBill);
      $oldBill->retreivePayments();
    }
    
    return $result;
  }
}
?>