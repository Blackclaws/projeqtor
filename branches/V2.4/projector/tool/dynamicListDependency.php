<?php
/** ============================================================================
 * 
 */

require_once "../tool/projector.php";
scriptLog('   ->/tool/dynamicListDependency.php');
$refType=$_REQUEST['dependencyRefType'];
$refId=$_REQUEST['dependencyRefId'];
//$refTypeDep=SqlList::getNameFromId('Dependable', $_REQUEST['dependencyRefTypeDep']);
$refTypeDepObj=new Dependable($_REQUEST['dependencyRefTypeDep']);
$refTypeDep=$refTypeDepObj->name;
//$id=$_REQUEST['id'];
$selected=null;
if (array_key_exists('selected',$_REQUEST)) {
	$selected=$_REQUEST['selected'];
}
$selectedArray=explode('_',$selected);

$crit = array ( 'idle'=>'0');

if ($refType) {
  $obj=new $refType($refId);
  if ($refTypeDep<>"Project") {
    $crit['idProject']=$obj->idProject;
  }
}

if (class_exists ($refTypeDep) ) {
  $objList=new $refTypeDep();
  $list=$objList->getSqlElementsFromCriteria($crit,false,null, 'id desc');
} else {
  $list=array();
}

?>
<select id="dependencyRefIdDep" size="14" name="dependencyRefIdDep[]" multiple
onchange="enableWidget('dialogDependencySubmit');" ondblclick="saveDependency();" 
class="selectList" >
 <?php
 $found=array();
 foreach ($list as $lstObj) {
 	 $sel="";
 	 if (in_array($lstObj->id,$selectedArray)) {
 	 	$sel=" selected='selected' ";
 	 	$found[$lstObj->id]=true;
 	 }
   echo "<option value='$lstObj->id'" . $sel . ">#$lstObj->id - $lstObj->name</option>";
 }
 foreach ($selectedArray as $selected) {
	 if ($selected and ! isset($found[$selected]) ) {
	 	 $lstObj=new $refTypeDep($selected);
	 	 echo "<option value='$lstObj->id' selected='selected' >#$lstObj->id - $lstObj->name</option>";
	 }
 }
 ?>
</select>