<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2014 Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/dynamicListOrigin.php');
$refType=$_REQUEST['originRefType'];
$refId=$_REQUEST['originRefId'];
$originTypeObj=new Originable($_REQUEST['originOriginType']);
$originType=$originTypeObj->name;
$selected=null;
if (array_key_exists('selected',$_REQUEST)) {
  $selected=$_REQUEST['selected'];
}

if ($originType) {
  $obj=new $refType($refId);
  $crit = array ( 'idle'=>'0', 'idProject'=>$obj->idProject);
	$objList=new $originType();
  $list=$objList->getSqlElementsFromCriteria($crit,false,null);
} else {
	$list=array();
}

?>
<select id="originOriginId" size="14" name="originOriginId"
onchange="enableWidget('dialogOriginSubmit');"  ondblclick="saveOrigin();"
class="selectList" >
 <?php
 $found=false;
 foreach ($list as $lstObj) {
   $sel="";
   if ($lstObj->id==$selected) {
    $sel=" selected='selected' ";
    $found=true;
   }
   echo "<option value='$lstObj->id'" . $sel . ">#".$lstObj->id." - ".htmlEncode($lstObj->name)."</option>";
 }
 if ($selected and ! $found) {
   $lstObj=new $originType($selected);
   echo "<option value='$lstObj->id' selected='selected' >#".$lstObj->id." - ".htmlEncode($lstObj->name)."</option>";
 }
 ?>
</select>