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

$obj=new $ref1Type($ref1Id);

$crit = array ( 'idle'=>'0', 'idProject'=>$obj->idProject);

if ($ref2Type) {
  $objList=new $ref2Type();
  $list=$objList->getSqlElementsFromCriteria($crit,false,null, 'id desc');
} else {
  $list=array();
}

?>
<select id="linkRef2Id" size="14"" name="linkRef2Id[]" multiple
onchange="enableWidget('dialogLinkSubmit');"  ondblclick="saveLink();"
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
   $lstObj=new $ref2Type($selected);
   echo "<option value='$lstObj->id' selected='selected' >#$lstObj->id - $lstObj->name</option>";
 }
 ?>
</select>