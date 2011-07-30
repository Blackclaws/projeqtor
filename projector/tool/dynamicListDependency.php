<?php
/** ============================================================================
 * 
 */

require_once "../tool/projector.php";

$refType=$_REQUEST['dependencyRefType'];
$refId=$_REQUEST['dependencyRefId'];
$refTypeDep=SqlList::getNameFromId('Dependable', $_REQUEST['dependencyRefTypeDep']);
//$id=$_REQUEST['id'];
$selected=null;
if (array_key_exists('selected',$_REQUEST)) {
	$selected=$_REQUEST['selected'];
}

$obj=new $refType($refId);

$crit = array ( 'idle'=>'0');
if ($refTypeDep<>"Project") {
  $crit['idProject']=$obj->idProject;
}

if (class_exists ($refTypeDep) ) {
    $objList=new $refTypeDep();
    $list=$objList->getSqlElementsFromCriteria($crit,false,null, 'id desc');
} else {
  $list=array();
}

?>
<select id="dependencyRefIdDep" multiple="false" name="dependencyRefIdDep"
onchange="enableWidget('dialogDependencySubmit');"  
class="selectList" >
 <?php
 $found=false;
 foreach ($list as $lstObj) {
 	 $sel="";
 	 if ($lstObj->id==$selected) {
 	 	$sel=" selected='selected' ";
 	 	$found=true;
 	 }
   echo "<option value='$lstObj->id'" . $sel . ">#$lstObj->id - $lstObj->name</option>";
 }
 if ($selected and ! $found) {
 	 $lstObj=new $refTypeDep($selected);
 	 echo "<option value='$lstObj->id' selected='selected' >#$lstObj->id - $lstObj->name</option>";
 }
 ?>
</select>