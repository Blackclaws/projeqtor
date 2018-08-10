<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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
include_once ("../tool/projeqtor.php");
$keyDownEventScript=NumberFormatter52::getKeyDownEvent();
$currency=Parameter::getGlobalParameter('currency');
$currencyPosition=Parameter::getGlobalParameter('currencyPosition');

$mode = RequestHandler::getValue('mode',false,null);
$isLineMulti = RequestHandler::getValue('isLineMulti',false,null);
$idProviderOrderEdit=RequestHandler::getId('idProviderOrderEdit',false,null);
$idProviderOrder=RequestHandler::getValue('idProviderOrder',false,null);
if($idProviderOrder==null){
  $idProviderOrder = $idProviderOrderEdit;
}
$idProviderTerm=RequestHandler::getValue('id',false,null);
$line="";

if($idProviderTerm){
  $line=new ProviderTerm($idProviderTerm);
}

$providerOrder = new ProviderOrder($idProviderOrder);

$isLine = RequestHandler::getValue('isLine');
if(isset ($isLineMulti)){
  if($isLineMulti == false){
    $isLine = true;
  }else{
    $isLine = false;
  }
}
?>
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='providerTermForm' name='providerTermForm' onSubmit="return false;">
        <input id="mode" name="mode" type="hidden" value="<?php echo $mode;?>" />
        <input id="providerOrderProject" name="providerOrderProject" type="hidden" value="<?php echo $providerOrder->idProject;?>" />
        <input id="providerOrderId" name="providerOrderId" type="hidden" value="<?php echo $providerOrder->id;?>" />
        <input id="providerOrderIsLine" name="providerOrderIsLine" type="hidden" value="<?php echo $isLine;?>" />
        <?php if($mode=='edit'){ ?>  <input id="idProviderTerm" name="idProviderTerm" type="hidden" value="<?php echo $idProviderTerm;?>" />  <?php } ?>
         <table>
          <tr>
             <td class="dialogLabel" >
              <label for="providerTermName" ><?php echo i18n("colName");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
              <textarea dojoType="dijit.form.Textarea" 
	          id="providerTermName" name="providerTermName"
	          style="width: 250px;"
	          maxlength="100"
	          class="input"><?php echo $providerOrder->name;?></textarea>
	         </td>
	        </tr>
	        
          <tr>
            <td class="dialogLabel" >
               <label for="providerTermDate" ><?php echo i18n("colDate");?>&nbsp;:&nbsp;</label>
            </td>
            <td>
               <div id="providerTermDate" name="providerTermDate"
                dojoType="dijit.form.DateTextBox" required="true" hasDownArrow="false"   
                constraints="{datePattern:browserLocaleDateFormatJs}"
                <?php if (isset($readOnly['startDate'])) echo " readonly ";?>
                type="text" maxlength="10"  style="width:100px; text-align: center;" class="input"
                missingMessage="<?php echo i18n('messageMandatory',array('colDate'));?>" 
                invalidMessage="<?php echo i18n('messageMandatory',array('colDate'));?>" 
                value="">
               </div>
            </td>
          </tr>
          
          <tr>
            <td class="dialogLabel" >
              <label for="providerTermTax" ><?php echo i18n("colTaxPct");?>&nbsp;:&nbsp;</label>
           </td>
           <td>
               <input dojoType="dijit.form.NumberTextBox" 
                id="providerTermTax" name="providerTermTax"
                readonly 
                style="width:100px;"
                value="<?php echo $providerOrder->taxPct;?>"
                class="input">
               </input> 
               <?php  echo '%';?>
           </td>
           <td class="dialogLabel" >
              <label for="providerTermDiscount" ><?php echo i18n("colDiscount");?>&nbsp;:&nbsp;</label>
           </td>
           <td>
               <input dojoType="dijit.form.NumberTextBox" 
                id="providerTermDiscount" name="providerTermDiscount"
                readonly 
                style="width:100px;"
                value="<?php echo $providerOrder->discountRate;?>"
                class="input">
               </input> 
               <?php  echo '%';?>
           </td>
           
          </tr>
          </table>
          <?php if($isLine=='false'){ 
              $maxValue = $providerOrder->totalUntaxedAmount;
              $providerTerm = new ProviderTerm();
              $termList=$providerTerm->getSqlElementsFromCriteria(array("idProviderOrder"=>$providerOrder->id));
              foreach ($termList as $term) {
                $maxValue -= $term->untaxedAmount ;
              }
              if($mode == 'edit'){
                $providerTermEdit = new ProviderTerm($idProviderTerm);    
                $NewMaxValue = $maxValue+$providerTermEdit->untaxedAmount;
              }
              $percent = (100*$maxValue/$providerOrder->totalUntaxedAmount);
              $taxAmount = ($maxValue*$providerOrder->taxPct)/100;
              $totalFullAmount = $maxValue+$taxAmount;
              if($mode == 'edit'){
                $MaxPercent = $percent;
                $percent = (100*$providerTermEdit->untaxedAmount/$providerOrder->totalUntaxedAmount);
                $MaxPercent += $percent;
                $taxAmount = ($providerTermEdit->untaxedAmount*$providerOrder->taxPct)/100;
                $totalFullAmount = $providerTermEdit->untaxedAmount+$taxAmount;
              }
          ?>
          <table>  
          <tr>
           <td class="dialogLabel" >
            <label for="providerTermUntaxedAmount" ><?php echo i18n("colUntaxedAmount");?>&nbsp;:&nbsp;</label>
           </td>
           <td>
            <?php if ($currencyPosition=='before') echo $currency;?>
            <div dojoType="dijit.form.NumberTextBox" 
              id="providerTermUntaxedAmount" name="providerTermUntaxedAmount"
              style="width: 100px;"
              constraints="{max:<?php if($mode=='edit'){echo $NewMaxValue;}else{ echo $maxValue ;}?>}"
              onChange="providerTermLine(<?php echo $providerOrder->totalUntaxedAmount; ?>);"
              value="<?php if($mode=='edit'){echo $providerTermEdit->untaxedAmount ;}else { if($providerOrder->totalUntaxedAmount){echo $maxValue;}}?>" 
              class="input"
              <?php echo $keyDownEventScript;?>
            </div>
            <?php if ($currencyPosition=='after') echo $currency;?>
           </td>
          
          <td class="dialogLabel" >
            <label for="providerTermPercent" ><?php echo i18n("colRate");?>&nbsp;:&nbsp;</label>
           </td>
           <td>
            <div dojoType="dijit.form.NumberTextBox" 
              id="providerTermPercent" name="providerTermPercent"
              style="width: 100px;"
              constraints="{max:<?php if($mode=='edit'){echo $MaxPercent;}else{echo $percent;}?>}"
              onChange="providerTermLinePercent(<?php echo $providerOrder->totalUntaxedAmount; ?>);"
              value="<?php echo $percent;?>" 
              class="input"
              <?php echo $keyDownEventScript;?>
            </div>
            <?php echo '%';?>
           </td>
          
         <td class="dialogLabel" >
               <label for="providerTermTaxdAmount" ><?php echo i18n("colTaxAmount");?>&nbsp;:&nbsp;</label>
         </td>
         <td>
             <?php if ($currencyPosition=='before') echo $currency;?>
               <input dojoType="dijit.form.NumberTextBox" 
                id="providerTermTaxAmount" name="providerTermTaxAmount"
                readonly 
                style="width:100px;"
                value="<?php echo $taxAmount;?>" 
                class="input"  >  
               </input> 
               <?php if ($currencyPosition=='after') echo $currency;?>
          </td>
          
          <td class="dialogLabel" >
               <label for="providerTermFullAmount" ><?php echo i18n("colFullAmount");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
             <?php if ($currencyPosition=='before') echo $currency;?>
               <input dojoType="dijit.form.NumberTextBox" 
                id="providerTermFullAmount" name="providerTermFullAmount"
                readonly 
                style="width:100px;"
                value="<?php echo $totalFullAmount; ?>" 
                class="input">  
               </input> 
               <?php if ($currencyPosition=='after') echo $currency;?>
          </td>
	        </tr>
	        
	         <?php 
           }else{ 
	           $billLine = new BillLine();
	           $billLineList=$billLine->getSqlElementsFromCriteria(array("refType"=>"ProviderOrder","refId"=>$providerOrder->id));
	           $i = 1;
	           $style = 'text-align:center';
	         ?> 
	          <table>
	           <tr >
	            <td class="assignHeader" >
                <label  style="width:50px;<?php echo $style; ?>">  <?php echo i18n("colLineNumber");?></label>
              </td>
             <td class="assignHeader" >
              <label  style="width:180px;<?php echo $style; ?>"><?php echo i18n("colDescription");?></label>
             </td>
             <td class="assignHeader" >
              <label style="width:180px;<?php echo $style; ?>" ><?php echo i18n("colDetail");?></label>
             </td>
              <td class="assignHeader" >
               <label style="width:115px;<?php echo $style; ?>"><?php echo i18n("colUntaxedAmount");?></label>
              </td>
              <td class="assignHeader" >
                <label style="width:55px;<?php echo $style; ?>"><?php echo i18n("colRate");?></label>
              </td>
              <td class="assignHeader" >
                <label style="width:115px;<?php echo $style; ?>"><?php echo i18n("colUntaxedAmount");?></label>
              </td>
              <td class="assignHeader" >
                <label style="width:115px;<?php echo $style; ?>"><?php echo i18n("colDiscount");?></label>
              </td>
              <td class="assignHeader" >
               <label style="width:115px;<?php echo $style; ?>"><?php echo i18n("colTaxAmount");?></label>
              </td>
              <td class="assignHeader" >
               <label style="width:115px;<?php echo $style;?> "><?php echo i18n("colFullAmount");?></label>
              </td>
             </tr>
	           <?php 
	           $style2 = 'border-left:1px solid black;border-bottom:1px solid black;';
	           foreach ($billLineList as $bill) {  ?>
              <input id="providerOrderBillLineId<?php echo $i;?>" name="providerOrderBillLineId<?php echo $i;?>" type="hidden" value="<?php echo $bill->id;?>" />
              <?php 
                $i++; 
                $maxValue = $bill->amount;
                $billLine2 = new BillLine();
                $critArray = array("refType"=>"ProviderTerm","idBillLine"=>$bill->id);
                $billLineList2=$billLine2->getSqlElementsFromCriteria($critArray);
                foreach ($billLineList2 as $bill2){
                  $maxValue -= $bill2->price;
                }
                if($mode != 'edit'){
                  if($maxValue==0){
                    continue;
                  }
                }
                $discount = 0;
                $percent = (100*$maxValue/$bill->amount);
                if($providerOrder->discountRate > 0){
                  $discount = ($maxValue*$providerOrder->discountRate/100);
                }
                $taxAmount = (($maxValue-$discount)*$providerOrder->taxPct)/100;
                $totalFullAmount = $maxValue - $discount +$taxAmount;
                
                if($mode == 'edit'){
                  $discount = 0;
                  $billLine3 = new BillLine();
                  $critArray = array("refType"=>"ProviderTerm","idBillLine"=>$bill->id , "refId"=>$idProviderTerm);
                  $billLineList3=$billLine2->getSqlElementsFromCriteria($critArray);
                  foreach ($billLineList3 as $billLineTerm){
                    $newPercent = $percent;
                    $percent = $billLineTerm->rate;
                    $newPercent +=$percent; 
                    if($providerOrder->discountRate > 0){
                      $discount = ($billLineTerm->price*$providerOrder->discountRate/100);
                    }
                    $taxAmount = (($billLineTerm->price-$discount)*$providerOrder->taxPct)/100;
                    $totalFullAmount = $billLineTerm->price - $discount +$taxAmount;
                    $newMaxValue = $billLineTerm->price+$maxValue;
                  }
                }
              ?>
               <tr>
                 <td style="width:50px; <?php echo $style2;?> ">
  		            <input dojoType="dijit.form.NumberTextBox" 
  			           id="providerTermBillLineLine<?php echo $bill->line;?>" name="providerTermBillLineLine<?php echo $bill->line;?>"
  			           style="width:40px;"
  			           class="display"
  			           value="<?php echo $bill->line;?>" />
  		           </td>
                 <td style="<?php echo $style2;?> ">
                  <textarea dojoType="dijit.form.Textarea" 
        	         id="billLineDescription<?php echo $bill->line;?>" name="billLineDescription<?php echo $bill->line;?>"
        	         style="width: 180px;"
        	         maxlength="200" class="display"
        	         ><?php echo $bill->description;?></textarea>
    	           </td>
                 <td style="<?php echo $style2;?> ">
                  <textarea dojoType="dijit.form.Textarea" 
      	           id="billLineDetail<?php echo $bill->line;?>" name="billLineDetail<?php echo $bill->line;?>"
      	           style="width: 180px;"
      	           maxlength="200" class="display"
      	           ><?php echo $bill->detail;?></textarea>  
      	         </td> 
                 <td style="<?php echo $style2;?> ">
                  <?php if ($currencyPosition=='before') echo $currency;?>
                  <div dojoType="dijit.form.NumberTextBox" 
                    id="providerTermBillLineUntaxed<?php echo $bill->line;?>" name="providerTermBillLineUntaxed<?php echo $bill->line;?>"
                    style="width: 100px;"
                    value="<?php echo $bill->amount ;?>" 
                    class="display"
                    <?php echo $keyDownEventScript;?>
                  </div>
                  <?php if ($currencyPosition=='after') echo $currency;?>
                 </td>
                 <td style="<?php echo $style2;?> ">
                  <div dojoType="dijit.form.NumberTextBox" 
                    id="providerTermPercent<?php echo $bill->line;?>" name="providerTermPercent<?php echo $bill->line;?>"
                    style="width:35px;"
                    constraints="{max:<?php if($mode=='edit'){
                                              echo $newPercent;
                                            }else{
                                              echo $percent;}?>
                                  }"
                    value="<?php echo $percent;?>" 
                     onChange="providerTermLinePercentBilleLine(<?php echo $bill->line; ?>);"
                    class="input"
                    <?php echo $keyDownEventScript;?>
                  </div>
                  <?php echo '%';?>
                 </td>
                 <td style="<?php echo $style2;?> ">
                  <?php if ($currencyPosition=='before') echo $currency;?>
                  <div dojoType="dijit.form.NumberTextBox" 
                    id="providerTermUntaxedAmount<?php echo $bill->line;?>" name="providerTermUntaxedAmount<?php echo $bill->line;?>"
                    style="width: 100px;"
                    constraints="{max:<?php if($mode=='edit'){
                                              echo $newMaxValue;
                                            }else{
                                              echo $maxValue;}?>}"
                    value="<?php if($mode=='edit'){
                                  echo $billLineTerm->price;
                                 }else{
                                  echo $maxValue;}?>" 
                    class="input"
                    onChange="providerTermLineBillLine(<?php echo $bill->line; ?>);"
                    <?php echo $keyDownEventScript;?>
                  </div>
                  <?php if ($currencyPosition=='after') echo $currency;?>
                 </td>
              <td style="<?php echo $style2;?> ">
               <?php if ($currencyPosition=='before') echo $currency;?>
                 <input dojoType="dijit.form.NumberTextBox" 
                  id="providerTermDiscountAmount<?php echo $bill->line;?>" name="providerTermDiscountAmount<?php echo $bill->line;?>"
                  style="width:100px;"
                  value="<?php echo $discount;?>" 
                  class="display"  >  
                 </input> 
               <?php if ($currencyPosition=='after') echo $currency;?>
              </td>         
             <td style="<?php echo $style2;?> ">
                 <?php if ($currencyPosition=='before') echo $currency;?>
                   <input dojoType="dijit.form.NumberTextBox" 
                    id="providerTermTaxAmount<?php echo $bill->line;?>" name="providerTermTaxAmount<?php echo $bill->line;?>"
                    class="display"
                    style="width:100px;"
                    value="<?php echo $taxAmount;?>" 
                     >  
                   </input> 
                   <?php if ($currencyPosition=='after') echo $currency;?>
              </td>
             <td style="<?php echo $style2;?>  border-right:1px solid black;">
             <?php if ($currencyPosition=='before') echo $currency;?>
               <input dojoType="dijit.form.NumberTextBox" 
                id="providerTermFullAmount<?php echo $bill->line;?>" name="providerTermFullAmount<?php echo $bill->line;?>"
                class="display"
                style="width:100px;"
                value="<?php echo $totalFullAmount; ?>" 
                >  
               </input> 
               <?php if ($currencyPosition=='after') echo $currency;?>
          </td>
                 
                 </tr>
      	   <?php }
      	        } ?>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="providerTermAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogProviderTerm').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogProviderTermSubmit" onclick="protectDblClick(this);saveProviderTerm();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
