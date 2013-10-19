
<?php
if (! array_key_exists('objectClass',$_REQUEST)) {
  throwError('objectClass parameter not found in REQUEST');
}
$objectClass=$_REQUEST['objectClass'];
$obj=new $objectClass();

$idUser = $_SESSION['user']->id;
$cs=new ColumnSelector();
$crit=array('scope'=>'export','objectClass'=>$objectClass, 'idUser'=>$user->id);
$csList=$cs->getSqlElementsFromCriteria($crit);
$hiddenFields=array();
foreach ($csList as $cs) {
	if ($cs->hidden) {
		$hiddenFields[$cs->field]=true;
	}
}
$htmlresult='<td valign="top">';
$FieldsArray=$obj->getFieldsArray();
foreach($FieldsArray as $key => $val) {
	if ( ! SqlElement::isVisibleField($val) ) {
		unset($FieldsArray[$key]);
    continue;
	}
	$FieldsArray[$key]=$obj->getColCaption($val);
	if (substr($val,0,5)=='_col_') {
		if (strlen($val)>8) {
			$section=substr($val,9);
			if ($section!='predecessor' and $section!='successor') {
				$FieldsArray[$key]=i18n('section' . ucfirst($section));
			}
		}
	}
	if(substr($FieldsArray[$key],0,1)=="["){
		unset($FieldsArray[$key]);
		continue;
	}
}
$countFields=count($FieldsArray);
$htmlresult.='<input type="hidden" dojoType="dijit.form.TextBox" id="column0" name="column0" value="'.$countFields.'">';
$index=1;
$last_key = end($FieldsArray);
$allChecked="checked";
foreach($FieldsArray as $key => $val){
	if(substr($key,0,5)=="_col_"){
		if($val!=$last_key) {
			$htmlresult.='</td><td style="vertical-align:top;width: 200px;" valign="top">'
			.'<div class="section" style="width:90%"><b>'.$val.'</b></div><br/>';
		}
	} else if(substr($key,0,5)=="input"){
	}else {
		$checked='checked';
		if (array_key_exists($key, $hiddenFields)) {
			$checked='';
			$allChecked='';
		}
		//$dataType = $obj->getDataType($key);
		//$dataLength = $obj->getDataLength($key);
		//$width=5;
		//$formatter='';
		$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.'" '.$checked.'>';
		$htmlresult.='<label for="column'.$index.'" class="checkLabel">'.$val.'</label><br>';
		//$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		/*if ($key=='id') { // id
			$formatter="numericFormatter";
			$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		} else if ($key=='password') { // PassWord
			// nothing
		} else if ($dataType=='date' and $val!=null and $val != '') { // Date
			$formatter="dateFormatter";
			$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		} else if ($dataType=='datetime' and $val!=null and $val != '') { // Date and Time
			$formatter="dateFormatter";
			$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		} else if ($dataType=='time' and $val!=null and $val != '') { // Time
			$formatter="dateFormatter";
			$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		} else if ($key=='color' and $dataLength == 7 ) { // color
			$formatter="colorFormatter";
			$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		} else if ($dataType=='int' and $dataLength==1) { // boolean
			$formatter="booleanFormatter";
			$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		} else  if ($dataLength > 100) { // Text Area (must reproduce BR, spaces, ...
			$width=20;
			$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		} else if (substr($key,0,2)=='id' and $dataType=='int' and strlen($key)>2 and substr($key,2,1)==strtoupper(substr($key,2,1)) ) { // Idxxx
			if(substr($key,2,strlen($key))=='Status') {
				$formatter="colorNameFormatter";
				$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.'colorName'.substr($key,2,strlen($key)).';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
			} else if(substr($key,2,strlen($key))=='Profile') {
				$formatter="translateFormatter";
				$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.'name'.substr($key,2,strlen($key)).';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
			} else {
				$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.'name'.substr($key,2,strlen($key)).';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
			}
		} else {
			$htmlresult.='<input type="checkbox" dojoType="dijit.form.CheckBox" id="column'.$index.'" name="column'.$index.'" value="'.$key.';'.$val.';'.$width.';'.$formatter.';'.$key.'" '.$checked.'>'.$val.'<br>';
		}*/
		$index++;
	}
}
$htmlresult.='</td>';
$htmlresult.="<br>";
?>
<form id="dialogExportForm" name="dialogExportForm">
<table style="width: 100%;">
  <tr>
    <td colspan="2" class="reportTableHeader"><?php echo i18n("chooseColumnExport");?></td>
  </tr>
  <tr><td colspan="2" >&nbsp;</td></tr>
  <tr>
    <td>
      <input type="checkbox" dojoType="dijit.form.CheckBox" id="checkUncheck" name="checkUncheck" value="Check" onclick="checkExportColumns();" <?php echo $allChecked?> />
      <label for="checkUncheck" class="checkLabel"><b><?php echo i18n("checkUncheckAll")?></b></label>
    </td>
    <td>
      <input type="checkbox" dojoType="dijit.form.Button" id="checkAsList" name="checkAsList" onclick="checkExportColumns('aslist');" 
       showLabel="true" label="<?php echo i18n("checkAsList")?>" />
    </td>
  </tr>
  <tr><td colspan="2" >&nbsp;</td></tr>
</table>
<table style="width: 100%;">
  <tr>
  <?php  echo $htmlresult; ?>
  </tr>
</table>
<div style="height:10px;"></div>    
<div style="height:5px;border-top:1px solid #AAAAAA"></div>    
<table style="width: 100%">
  <tr>
    <td style="width: 50%; text-align: right;">
    <button align="right" dojoType="dijit.form.Button"
      onclick="closeExportDialog();">
      <?php echo i18n("buttonCancel");?></button>
    </td>
    <td style="width: 50%; text-align: left;">
    <button align="left" dojoType="dijit.form.Button"
      id="dialogePrintSubmit"
      onclick="executeExport('<?php echo $objectClass;?>','<?php echo $idUser;?>');">
      <?php echo i18n("buttonOK");?></button>
    </td>
  </tr>
</table>
</form>
