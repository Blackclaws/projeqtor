<?php
if (! array_key_exists('objectClass',$_REQUEST)) {
	throwError('Parameter objectClass not found in REQUEST');
}
$objectClass=$_REQUEST['objectClass'];

if (! array_key_exists('objectId',$_REQUEST)) {
	throwError('Parameter objectId not found in REQUEST');
}
$objectId=$_REQUEST['objectId'];

$checklistDefinition=null;
$obj=new $objectClass($objectId);
$type='id'.$objectClass.'Type';
$checklist=SqlElement::getSingleSqlElementFromCriteria('Checklist', array('refType'=>$objectClass, 'refId'=>$objectId));
if ($checklist and $checklist->id) {
	$checklistDefinition=new CheckListDefinition($checklist->idChecklistDefinition);
	if ($checklistDefinition->id and 
      ( ( $checklistDefinition->nameChecklistable!=$objectClass) 
      or( $checklistDefinition->idType and $checklistDefinition->idType!=$obj->$type)
      ) ) {
		$checklist->delete();
		unset($checklist);
	}
}
if (!$checklist or !$checklist->id) {
	$checklist=new Checklist();
}

if (!$checklistDefinition or ! $checklistDefinition->id) {
	if (property_exists($obj,$type)) {
		$crit=array('nameChecklistable'=>$objectClass, 'idType'=>$obj->$type);
  	$checklistDefinition=SqlElement::getSingleSqlElementFromCriteria('ChecklistDefinition', $crit);
	}
	if (!$checklistDefinition or !$checklistDefinition->id) {
		$crit=array('nameChecklistable'=>$objectClass);
		$checklistDefinition=SqlElement::getSingleSqlElementFromCriteria('ChecklistDefinition', $crit);
	}
}
if (!$checklistDefinition or !$checklistDefinition->id) {
	echo '<span class="ERROR" >'.i18n('noChecklistDefined').'</span>';
	exit;
}
$cdl=new ChecklistDefinitionLine();
$defLines=$cdl->getSqlElementsFromCriteria(array('idChecklistDefinition'=>$checklistDefinition->id),false, null, 'sortOrder asc');
//usort($defLines,"ChecklistDefinitionline::sort");
$cl=new ChecklistLine();
$linesTmp=$cl->getSqlElementsFromCriteria(array('idChecklist'=>$checklist->id));

$linesVal=array();
foreach ($linesTmp as $line) {
	$linesVal[$line->idChecklistDefinitionLine]=$line;
}

$canUpdate=(securityGetAccessRightYesNo('menu' . $objectClass, 'update', $obj)=='YES');
if ($obj->idle) $canUpdate=false;
?>
<form id="dialogChecklistForm" name="dialogChecklistForm" action="">
<input type="hidden" name="checklistDefinitionId" value="<?php echo $checklistDefinition->id;?>" />
<input type="hidden" name="checklistId" value="<?php echo $checklist->id;?>" />
<input type="hidden" name="checklistObjectClass" value="<?php echo $objectClass;?>" />
<input type="hidden" name="checklistObjectId" value="<?php echo $objectId;?>" />
<table style="width: 100%;">
  <tr><td>
	  <table width="100%">
<?php foreach($defLines as $line) {
	      if (isset($linesVal[$line->id])) {
          $lineVal=$linesVal[$line->id];
        } else {
          $lineVal=new ChecklistLine();
        }?>	 
		  <tr>
<?php if ($line->check01) {?>
			  <td class="noteData" style="position: relative; border-right:0; text-align:right" title="<?php echo $line->title;?>"> 
				  <?php echo htmlEncode( $line->name);?> :   
		    </td>
			  <td class="noteData" style="border-left:0;">
			    <table witdh="100%"><tr>
					<?php for ($i=1;$i<=5;$i++) {
						$check='check0'.$i;
						$title='title0'.$i;
						$value='value0'.$i;?>
						<td style="min-width:100px; white-space:nowrap; vertical-align:top;" title="<?php echo $line->$title;?>" >
						<?php if ($line->$check) {
						  $checkName="check_".$line->id."_".$i;?>
						  <div dojoType="dijit.form.CheckBox" type="checkbox"
				        <?php if ($line->exclusive) {?>onClick="checkClick(<?php echo $line->id;?>, <?php echo $i;?>)" <?php }?>
				        name="<?php echo $checkName;?>" id="<?php echo $checkName;?>"
				        <?php if (! $canUpdate) echo 'readonly';?>
		            <?php if ($lineVal->$value) { echo 'checked'; }?> ></div>
						    <span style="cursor:pointer;" onClick="dojo.byId('<?php echo $checkName;?>').click();"><?php echo $line->$check;?>&nbsp;&nbsp;</span>
					  <?php }?></td>
					<?php }?>
				  </tr></table>
				</td>
<?php } else { ?>
				<td class="reportTableHeader" colspan="2" style="text-align:center" title="<?php echo $line->title;?>">
				  <?php echo $line->name;?>
				</td>
<?php }?>		
	    </tr>
<?php } // end foreach($defLine?>
      <tr>
        <td class="noteDataClosetable">&nbsp;</td>
	      <td class="noteDataClosetable">&nbsp;</td>
	    </tr>
	  </table>
  </td></tr>
 <tr><td>&nbsp;</td></tr>
 <tr>
   <td align="center">
     <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogChecklist').hide();">
       <?php echo i18n("buttonCancel");?>
     </button>
     <button id="dialogChecklistSubmit" dojoType="dijit.form.Button" type="submit" 
       onclick="saveChecklist();return false;" >
       <?php echo i18n("buttonOK");?>
     </button>
   </td>
 </tr>      
</table>
</form>
