<?php
/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projector.php";

$ref1Type=$_REQUEST['linkRef1Type'];
$ref1Id=$_REQUEST['linkRef1Id'];
$ref2Type=SqlList::getNameFromId('Linkable', $_REQUEST['linkRef2Type']);
//$id=$_REQUEST['id'];

$obj=new $ref1Type($ref1Id);

$crit = array ( 'idle'=>'0', 'idProject'=>$obj->idProject);

$objList=new $ref2Type();
$list=$objList->getSqlElementsFromCriteria($crit,false,null, 'id desc');


?>
<select id="linkRef2Id" multiple="false" name="linkRef2Id"
onchange="enableWidget('dialogLinkSubmit');"  
class="selectList" >
 <?php
 foreach ($list as $lstObj) {
   echo "<option value='$lstObj->id'>#$lstObj->id - $lstObj->name</option>";
 }
 ?>
</select>