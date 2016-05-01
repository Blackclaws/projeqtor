<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
* Copyright 2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
*
******************************************************************************
*** WARNING *** T H I S    F I L E    I S    N O T    O P E N    S O U R C E *
******************************************************************************
*
* This file is an add-on to ProjeQtOr, packaged as a plug-in module.
* It is NOT distributed under an open source license.
* It is distributed in a proprietary mode, only to the customer who bought
* corresponding licence.
* The company ProjeQtOr remains owner of all add-ons it delivers.
* Any change to an add-ons without the explicit agreement of the company
* ProjeQtOr is prohibited.
* The diffusion (or any kind if distribution) of an add-on is prohibited.
* Violators will be prosecuted.
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
$showVersionsForAll=false;
if (array_key_exists('showVersionsForAll', $_REQUEST)){
  if ($_REQUEST['showVersionsForAll']!='0') {
    $showVersionsForAll=true;
  }
}
$showProjectsLinked=true;
if (array_key_exists('showProjectsLinked', $_REQUEST)){
  if ($_REQUEST['showProjectsLinked']=='0') {
    $showProjectsLinked=false;
  }
}

$item=new $objectClass($objectId);
$canRead=securityGetAccessRightYesNo('menu' . $objectClass, 'read', $item)=="YES";
if (!$canRead) exit;

$subProducts=array();
if ($objectClass=='Product') {
  $subProducts=$item->getRecursiveSubProducts();
  $parentProducts=$item->getParentProducts();
}
$level=0;
foreach ($parentProducts as $parentId=>$parentName) {
  $level++;
  showProduct('Product',$parentId,$parentName,$level,'top');
}
$level++;
showProduct($objectClass,$item->id,$item->name,$level,'current');
showSubItems('Product',$subProducts,$level+1);

function showSubItems($class,$subItems,$level){
  if (!$subItems) return;
  foreach ($subItems as $item) {
    showProduct($class,$item['id'],$item['name'],$level,'sub');
    if (isset($item['subItems']) and is_array($item['subItems'])) {
      showSubItems('Product',$item['subItems'],$level+1);
    }
  }
}

function showProduct($class,$id,$name,$level,$position) {
  global $showVersionsForAll, $showProjectsLinked;
  $padding=30;
  $name="#$id - $name";
  $style="";
  $current=($position=='current');
  $item=new $class($id);
  if ($current) $style.='border:2px solid #000;border-radius:5px;';
  echo '<div style="padding-bottom:5px;padding-left:'.($level*$padding).'px;">'
      .'<table style="border:1px dotted #ddd;width:100%"><tr><td style="vertical-align:top;width:10px;white-space:nowrap">'
      .'<table style="'.$style.'"><tr><td style="padding-left:5px;padding-top:2px;"><img src="../view/css/images/icon'.$class.'16.png" /></td>'
      .'<td style="padding:0px 5px;vertical-align:middle;">'.$name.'</td></tr></table>'
      .'</td>';
  if ($showVersionsForAll or $current) {
    echo '<td style="padding-top:5px;">';
    echo $item->drawSpecificItem('versions'.(($showProjectsLinked)?'WithProjects':''));
    echo "</td>";
  }
  echo'</tr>';
  echo'</table></div>';
  if ($position!='top') {
    $compList=$item->getComposition(true,false);
    foreach ($compList as $compId=>$compName) {
      //echo '<tr><td></td><td>';
      showProduct('Component',$compId,$compName,$level+1,'sub');
      //echo '</td></tr>';
    }
  }
  
}
