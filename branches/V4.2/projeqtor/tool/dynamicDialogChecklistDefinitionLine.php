<?php
if (! array_key_exists('checkId',$_REQUEST)) {
  throwError('objectClass checkId not found in REQUEST');
}
$checkId=$_REQUEST['checkId'];
$lineId=0;
if ( array_key_exists('lineId',$_REQUEST)) {
	$lineId=$_REQUEST['$lineId'];
}
$line=new ChecklistDefinitionLine($lineId);

?>
<form id="dialogChecklistDefinitionLineForm" name="dialogChecklistDefinitionLineForm" action="">
<table style="width: 100%;">
  <tr>
    <td class="dialogLabel" ><label><?php echo i18n('colName');?> : </label></td>
    <td><input type="text" dojoType="dijit.form.TextBox" 
      id="dialogChecklistDefinitionLineName" 
      name="dialogChecklistDefinitionLineName"
      value="<?php echo $line->name;?>"
      style="width: 300px;" maxlength="100" class="input">
    </td>
  </tr>
  <tr>
    <td class="dialogLabel" ><label><?php echo i18n('colSortOrder');?> : </label></td>
    <td><input type="text" dojoType="dijit.form.TextBox" 
      id="dialogChecklistDefinitionLineSortOrder" 
      name="dialogChecklistDefinitionLineSortOrder"
      value="<?php echo $line->sortOrder;?>"
      style="width: 30px;" maxlength="3" class="input">
    </td>
  </tr>
<?php for ($i=1;$i<=5;$i++) {?>
  <tr>
    <td class="dialogLabel" ><label><?php echo i18n('colChoice') . ' #'.$i;?> : </label></td>
    <td><input type="text" dojoType="dijit.form.TextBox" 
      id="dialogChecklistDefinitionLineChoice_<?php echo $i?>" 
      name="dialogChecklistDefinitionLineChoice_<?php echo $i?>"
      value="<?php $var="check0$i";echo $line->$var;?>"
      style="width: 300px;" maxlength="100" class="input">
    </td>  
  </tr>
<?php }?>
  <tr>
    <td class="dialogLabel" ><label><?php echo i18n('colExclusive');?> : </label></td>
    <td> 
      <input dojoType="dijit.form.CheckBox" 
       name="dialogChecklistDefinitionLineExclusive" 
       id="dialogChecklistDefinitionLineExclusive"
       <?php echo ($line->exclusive)?' checked="checked" ':'';?>
       value="" style="background-color:white;"/>
   </td>
 </tr>
 <tr><td colspan="2">&nbsp;</td></tr>
 <tr>
   <td colspan="2" align="center">
     <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogChecklistDefinitionLine').hide();">
       <?php echo i18n("buttonCancel");?>
     </button>
     <button id="submitChecklistDefinitionLine" dojoType="dijit.form.Button" type="submit" 
       onclick="saveChecklistDefinitionLine();return false;" >
       <?php echo i18n("buttonOK");?>
     </button>
   </td>
 </tr>      
</table>
</form>
