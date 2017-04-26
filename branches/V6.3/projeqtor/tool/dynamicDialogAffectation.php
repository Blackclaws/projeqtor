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
?>
<div id="dialogAff" dojoType="dijit.Dialog" title="<?php echo i18n("dialogAffectation");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='affectationForm' name='affectationForm' onSubmit="return false;">
         <input id="affectationId" name="affectationId" type="hidden" value="" />
         <input id="affectationIdTeam" name="affectationIdTeam" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="affectationProject" ><?php echo i18n("colIdProject") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
               <?php echo autoOpenFilteringSelect();?>
                id="affectationProject" name="affectationProject" 
                class="input" value="" required="required">
                 <?php //htmlDrawOptionForReference('idProject', null, null, true);
                       // no use : will be updated on dialog opening;?>
               </select>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="affectationResource" ><?php echo i18n("colIdResource") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
               <?php echo autoOpenFilteringSelect();?>
                id="affectationResource" name="affectationResource" 
                onChange="affectationChangeResource();"
                class="input" value="" required="required">
                 <?php //htmlDrawOptionForReference('idResource', null, null, true);
                       // no use : will be updated on dialog opening;?>
               </select>
             </td><td style="vertical-align: top">
               <button id="affectationDetailButton" dojoType="dijit.form.Button" showlabel="false"
                 title="<?php echo i18n('showDetail')?>"
                 iconClass="iconView">
                 <script type="dojo/connect" event="onClick" args="evt">
                    var canCreate=("<?php echo securityGetAccessRightYesNo('menuResource','create');?>"=="YES")?1:0;
                    showDetail('affectationResource', canCreate , 'Resource', false);
                 </script>
               </button>
               </td>             
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="affectationProfile" ><?php echo i18n("colIdProfile");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
               <?php echo autoOpenFilteringSelect();?>
                id="affectationProfile" name="affectationProfile" 
                class="input" value="" required="required">
                 <?php htmlDrawOptionForReference('idProfile', null, null, true);?>
               </select>
               </div>
             </td>    
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="affectationRate" ><?php echo i18n("colRate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="affectationRate" name="affectationRate" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 style="width:100px" class="input"
                 hasDownArrow="true"
               >
               <?php echo $keyDownEventScript;?>
               </div>
             </td>    
           </tr>
           <tr>
             <td colspan="2">
               <table>
                 <tr>
                   <td class="dialogLabel" >
                     <label for="affectationStartDate" ><?php echo i18n("colStartDate");?>&nbsp;:&nbsp;</label>
                   </td>
                   <td>
                     <input id="affectationStartDate" name="affectationStartDate" value=""  
			                 dojoType="dijit.form.DateTextBox" 
			                 constraints="{datePattern:browserLocaleDateFormatJs}"
                       onChange=" var end=dijit.byId('affectationEndDate');end.set('dropDownDefaultValue',this.value);
                       var start = dijit.byId('affectationStartDate').get('value');end.constraints.min=start;"
			                 style="width:100px" />
                   </td>
                   <td class="dialogLabel" >
                     <label for="affectationEndDate" ><?php echo i18n("colEndDate");?>&nbsp;:&nbsp;</label>
                   </td>
                   <td>
                   <input id="affectationEndDate" name="affectationEndDate" value=""  
		                 dojoType="dijit.form.DateTextBox" 
		                 constraints="{datePattern:browserLocaleDateFormatJs}"
		                 style="width:100px" />
                   </td>
                 </tr>
               </table>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="affectationDescription" ><?php echo i18n("colDescription");?>&nbsp;:&nbsp;</label>
             </td>
             <td> 
               <textarea dojoType="dijit.form.Textarea" 
                id="affectationDescription" name="affectationDescription"
                style="width:400px;"
                maxlength="4000"
                class="input"></textarea>   
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="affectationIdle" ><?php echo i18n("colIdle");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="affectationIdle" name="affectationIdle"
                 dojoType="dijit.form.CheckBox" type="checkbox" >
               </div>
             </td>    
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="affectationAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogAff').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogAffectationSubmit" onclick="protectDblClick(this);saveAffectation();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>