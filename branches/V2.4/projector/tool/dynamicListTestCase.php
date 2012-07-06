<?php
/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projector.php";
scriptLog('   ->/tool/dynamicListTestCase.php');
$idProject=$_REQUEST['idProject'];
$idProduct=$_REQUEST['idProduct'];
$selected="";
if (array_key_exists('selected', $_REQUEST)) {
	$selected=$_REQUEST['selected'];
}
$obj=new TestCase();

$crit = array ( 'idle'=>'0');
if (trim($idProject)) {
	$crit['idProject']=$idProject;
}
if (trim($idProduct)) {
  $crit['idProduct']=$idProduct;
}

$list=$obj->getSqlElementsFromCriteria($crit,false,null, 'id desc',true);
if ($selected and ! array_key_exists("#" . $selected, $list)) {
	$list["#".$selected]=new TestCase($selected);
}

?>
<select xdojoType="dijit.form.MultiSelect" multiple
  id="testCaseRunTestCaseList" name="testCaseRunTestCaseList[]" 
  class="selectList" value="" required="required" size="10"
  onchange="enableWidget('dialogTestCaseRunSubmit');"  
  ondblclick="saveTestCaseRun();" >
 <?php
 foreach ($list as $lstObj) {
   echo "<option value='$lstObj->id'" . (($lstObj->id==$selected)?' selected ':'') . ">#$lstObj->id - $lstObj->name</option>";
 }
 ?>
</select>