<?php
/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projector.php";
scriptLog('   ->/tool/dynamicListApprover.php');
$refType=$_REQUEST['approverRefType'];
$refId=$_REQUEST['approverRefId'];

$selected=null;
if (array_key_exists('selected',$_REQUEST)) {
  $selected=$_REQUEST['selected'];
}

$obj=new $refType($refId);

$objList=new Affectable();
$aff=new Affectation();
$critWhere = "idle='0' and exists(select 'x' from " . $aff->getDatabaseTableName() . " aff ";
$critWhere .= " where aff.idResource=" . $objList->getDatabaseTableName() . ".id ";
$critWhere .= ($obj->idProject)?" and aff.idProject='" . $obj->idProject . "'":"";
$critWhere .= ")";
$list=$objList->getSqlElementsFromCriteria(null,false,$critWhere, 'name asc');
?>
<select id="approverId" size="14"" name="approverId[]" multiple
onchange="selectApproverItem();"  ondblclick="saveApprover();"
class="selectList" >
 <?php
 $found=false;
 foreach ($list as $lstObj) {
   $sel="";
   if ($lstObj->id==$selected) {
    $sel=" selected='selected' ";
    $found=true;
   }
   $name=($lstObj->name)?$lstObj->name:$lstObj->userName;
   echo "<option value='$lstObj->id'" . $sel . ">#$lstObj->id - $name</option>";
 }
 if ($selected and ! $found) {
   $lstObj=new Affectable($selected);
   $name=($lstObj->name)?$lstObj->name:$lstObj->userName;
   echo "<option value='$lstObj->id' selected='selected' >#$lstObj->id - $name</option>";
 }
 ?>
</select>