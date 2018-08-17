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
$providerBillId = RequestHandler::getId('providerBillId');
$provBill = new ProviderBill($providerBillId);
$obj=new ProviderTerm();
$critFld ='idProviderBill';
$critVal = null;
if($provBill->taxPct > 0 ){
  $critFld=array($critFld, 'taxPct');
  $critVal=array($critVal, $provBill->taxPct);
}
?>
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='providerTermFromProviderBillForm' name='providerTermFromProviderBillForm' onSubmit="return false;">
         <input type="hidden" id="ProviderBillId" name="ProviderBillId" value="<?php echo $providerBillId ;?>" />
	         <table>
	            <tr>
             <td class="dialogLabel"  >
               <label for="linkRef2TypeProviderTerm" ><?php echo i18n("ProviderTerm") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" id="linkRef2TypeProviderTerm" name="linkRef2TypeProviderTerm"
               <?php echo autoOpenFilteringSelect();?>
                class="input" value="">
                 <?php htmlDrawOptionForReference('idProviderTerm', null, $obj, true,$critFld,$critVal);?>
               </select>
             </td>
           </tr>
	         </table>
        </form>
      </td>
    </tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
      <td align="center">
        <input type="hidden" id="ProviderTermFromProviderBillAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogProviderTermFromProviderBill').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogProviderTermFromProviderBillSubmit" onclick="protectDblClick(this);saveProviderTermFromProviderBill();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
