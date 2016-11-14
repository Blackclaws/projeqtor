<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

//
// THIS IS THE PRODUCT STRUCTURE REPORT
//
include_once '../tool/projeqtor.php';
include_once '../tool/formatter.php';

$objectClass="";
if (array_key_exists('objectClass', $_REQUEST)){
  $objectClass=trim($_REQUEST['objectClass']);
}
Security::checkValidClass($objectClass);
$objectId="";
if (array_key_exists('objectId', $_REQUEST)){
  $objectId=trim($_REQUEST['objectId']);
}
Security::checkValidId($objectId);
if (!$objectClass or !$objectId) return;
if ($objectClass!='Product' and $objectClass!='Component') return;

$format="print";
if (array_key_exists('format', $_REQUEST)){
  $format=trim($_REQUEST['format']);
}

$item=new $objectClass($objectId);
$canRead=securityGetAccessRightYesNo('menu' . $objectClass, 'read', $item)=="YES";
if (!$canRead) exit;

$subProducts=array();
if ($objectClass=='Product') {
  $subProducts=$item->getRecursiveSubProducts();
  $parentProducts=$item->getParentProducts();
}
$result=array();
//showProduct($objectClass,$item->id,$item->name,$level,'current');
$result=getSubItems('Product',$subProducts,$result);
debugLog($result);

if ($format=='print') {
  echo "<table style='width:100%'>";
  echo "<tr><td style='width:50%;vertical-align:top;padding:5px;'>";
  // Items
  echo "<table style='width:100%;'>";
  echo "<tr><th style='padding:5px;text-align:center;'>".i18n('sectionComposition',array(i18n($objectClass),intval($objectId))).'</th></tr>';
  foreach ($result as $item) {
    echo "<tr><td>";
    showProduct($item['class'], $item['id'], $item['name']);
    echo "</td></tr>";
  }
  echo "</table>";
  echo "</td><td style='width:50%;vertical-align:top;padding:5px;'>";
  // Parents  
  echo "<table style='width:100%;'>";
  echo "<tr><th style='padding:5px;text-align:center;'>".i18n('parentProductList').'</th></tr>';
  foreach ($parentProducts as $prdId=>$prdName) {
    echo "<tr><td>";
    showProduct('Product', $prdId, $prdName);
    echo "</td></tr>";
  }
  echo "</table>";
  echo "</td></tr>";
  echo "</table>";
} else if ($format=='csv') {
  
} else {
  debugLog("productFlatStructure : incorrect format '$format'");
  exit;
}

function getSubItems($class,$subItems,$result){
  if (!$subItems) return $result;
  foreach ($subItems as $item) {
    $result[$item['id']]=array('class'=>'Product','id'=>$item['id'],'name'=>$item['name']);
    //showProduct($class,$item['id'],$item['name'],$level,'sub');
    if (isset($item['subItems']) and is_array($item['subItems'])) {
      $result=getSubItems('Product',$item['subItems'],$result);
    }
  }
  return $result;
}

function showProduct($class,$id,$name) {
  $name="#$id - $name";
  $style="width:100%";
  $item=new $class($id);
  echo '<table style="'.$style.'"><tr><td style="padding-left:5px;padding-top:2px;width:20px;"><img src="../view/css/images/icon'.$class.'16.png" /></td>'
      .'<td style="padding:0px 5px;vertical-align:middle;">'.$name.'</td></tr></table>';
}
