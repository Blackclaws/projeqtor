<?php
/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projector.php";

$refType=$_REQUEST['originRefType'];
$refId=$_REQUEST['originRefId'];
$originType=SqlList::getNameFromId('Originable', $_REQUEST['originOriginType']);
$selected=null;
if (array_key_exists('selected',$_REQUEST)) {
  $selected=$_REQUEST['selected'];
}

$obj=new $refType($refId);

$crit = array ( 'idle'=>'0', 'idProject'=>$obj->idProject);

if ($originType) {
  $objList=new $originType();
  $list=$objList->getSqlElementsFromCriteria($crit,false,null, 'id desc');
} else {
	$list=array();
}

?>
<select id="originOriginId" multiple="false" name="originOriginId"
onchange="enableWidget('dialogOriginSubmit');"  
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
   $lstObj=new $originType($selected);
   echo "<option value='$lstObj->id' selected='selected' >#$lstObj->id - $lstObj->name</option>";
 }
 ?>
</select>