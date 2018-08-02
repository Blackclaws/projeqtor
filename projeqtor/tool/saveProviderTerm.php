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

/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/saveProviderTerm.php');

$mode = RequestHandler::getValue('mode');
$idProviderOrder = RequestHandler::getId('providerOrderId');
$idProject = RequestHandler::getId('providerOrderProject');
$isLine = RequestHandler::getValue('providerOrderIsLine');
$idProviderTerm = RequestHandler::getId('idProviderTerm');
$date = RequestHandler::getDatetime('providerTermDate');
$name = RequestHandler::getValue('providerTermName');
$taxPct = RequestHandler::getNumeric('providerTermTax');
Sql::beginTransaction();
$result = "";

if($mode == 'edit'){

//   $idProviderTerm = RequestHandler::getId('idAffectation');
//   $providerTerm=new ProviderTerm($idProviderTerm);
//  $result=$providerTerm->save();

}else{

  if ($isLine ==  'false'){
    $untaxedAmount = RequestHandler::getNumeric('providerTermUntaxedAmount');
    $taxAmount = RequestHandler::getNumeric('providerTermTaxAmount');
    $fullAmount = RequestHandler::getNumeric('providerTermFullAmount');
    
    $providerTerm=new ProviderTerm();
    $providerTerm->idProject = $idProject;
    $providerTerm->idProviderOrder = $idProviderOrder;
    $providerTerm->date = $date;
    $providerTerm->name = $name;
    $providerTerm->untaxedAmount = $untaxedAmount;
    $providerTerm->taxPct = $taxPct;
    $providerTerm->taxAmount = $taxAmount;
    $providerTerm->fullAmount = $fullAmount;
    $res=$providerTerm->save();
    
  }else{
    $providerTerm=new ProviderTerm();
    $providerTerm->idProject = $idProject;
    $providerTerm->idProviderOrder = $idProviderOrder;
    $providerTerm->date = $date;
    $providerTerm->name = $name;
    $providerTerm->taxPct = $taxPct;
    
    $billLine = new BillLine();
    $critArray = array("refType"=>"ProviderOrder","refId"=>$idProviderOrder);
    $number=$billLine->countSqlElementsFromCriteria($critArray);
    for($i=1;$i<=$number;$i++){
      $untaxedAmount = RequestHandler::getNumeric('providerTermUntaxedAmount'.$i);
      $taxAmount = RequestHandler::getNumeric('providerTermTaxAmount'.$i);
      $fullAmount = RequestHandler::getNumeric('providerTermFullAmount'.$i);
      $discount = RequestHandler::getNumeric('providerTermDiscountAmount'.$i);
      $providerTerm->untaxedAmount += ($untaxedAmount-$discount); 
      $providerTerm->taxAmount += $taxAmount;
      $providerTerm->fullAmount += $fullAmount;
    }
    $res=$providerTerm->save();
    for($i=1;$i<=$number;$i++){
      $rate = RequestHandler::getValue('providerTermPercent'.$i);
      $idBillLine = RequestHandler::getId('providerOrderBillLineId'.$i);
      $newBillLine = new BillLine();
      $newBillLine->refType = "ProviderTerm";
      $newBillLine->refId = $providerTerm->id;
      $newBillLine->idBillLine = $idBillLine;
      $newBillLine->rate = $rate;
      $newBillLine->price = RequestHandler::getNumeric('providerTermUntaxedAmount'.$i);
      $newBillLine->save();
    }
  }
  
  if (!$result) {
    $result=$res;
  }
}
// Message of correct saving
displayLastOperationStatus($result);

?>