<?php
/** ============================================================================
 * 
 */

require_once "../tool/projector.php";

$refType=$_REQUEST['dependencyRefType'];
$refId=$_REQUEST['dependencyRefId'];
$refTypeDep=SqlList::getNameFromId('Dependable', $_REQUEST['dependencyRefTypeDep']);
//$id=$_REQUEST['id'];

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
 foreach ($list as $lstObj) {
   echo "<option value='$lstObj->id'>#$lstObj->id - $lstObj->name</option>";
 }
 ?>
</select>