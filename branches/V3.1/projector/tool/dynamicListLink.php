<?php
/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projector.php";
scriptLog('   ->/tool/dynamicListLink.php');
$ref1Type=$_REQUEST['linkRef1Type'];
$ref1Id=$_REQUEST['linkRef1Id'];
//$ref2Type=SqlList::getNameFromId('Linkable', $_REQUEST['linkRef2Type']);
$ref2TypeObj=new Linkable($_REQUEST['linkRef2Type']);
$ref2Type=$ref2TypeObj->name;
//$id=$_REQUEST['id'];
$selected=null;
if (array_key_exists('selected',$_REQUEST)) {
  $selected=$_REQUEST['selected'];
}
$selectedArray=explode('_',$selected);

$obj=new $ref1Type($ref1Id);
if ($ref2Type) {
  $objList=new $ref2Type();
  if (property_exists($objList, "idProject")) {
    $crit = array ( 'idle'=>'0', 'idProject'=>$obj->idProject);
    $list=$objList->getSqlElementsFromCriteria($crit,false,null, 'id desc');
  } else if ($ref2Type=='DocumentVersionFull' or $ref2Type=='DocumentVersion') {
    $doc=new Document();
  	$critWhere = "idle='0' and exists(select 'x' from " . $doc->getDatabaseTableName() . " doc where doc.id=idDocument and doc.idProject='" . Sql::fmtId($obj->idProject) . "')";
    $list=$objList->getSqlElementsFromCriteria(null,false,$critWhere, 'id desc');
  } else {
  	$crit = array ( 'idle'=>'0');
  	$list=$objList->getSqlElementsFromCriteria($crit,false,null, 'id desc');
  }
} else {
  $list=array();
}

?>
<select id="linkRef2Id" size="14"" name="linkRef2Id[]" multiple
onchange="selectLinkItem();"  ondblclick="saveLink();"
class="selectList" >
 <?php
 $found=array();
 foreach ($list as $lstObj) {
   $sel="";
   if (in_array($lstObj->id,$selectedArray)) {
    $sel=" selected='selected' ";
    $found[$lstObj->id]=true;
   }
   echo "<option value='$lstObj->id'" . $sel . ">#".$lstObj->id." - ".htmlEncode($lstObj->name)."</option>";
 }
 foreach ($selectedArray as $selected) {
	 if ($selected and ! isset($found[$selected]) ) {
	   $lstObj=new $ref2Type($selected);
	   echo "<option value='$lstObj->id' selected='selected' >#".$lstObj->id." - ".htmlEncode($lstObj->name)."</option>";
	 }
 }
 ?>
</select>