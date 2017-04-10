<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

include_once "../tool/projeqtor.php";
header ('Content-Type: text/html; charset=UTF-8');
projeqtor_set_time_limit(3600);

$typeToItemOK="";
$typeToItemKO="";
$workflowtoTypeOK="";
$workflowtoTypeKO="";
$lovOK="";
$lovKO="";

$start='private static $_relationShip=array(';
$end=');';

$classDir="../model/";

echo "<pre>";
$relationShip="";
$lines = file($classDir.'persistence/SqlElement.php');
foreach ($lines as $lineNumber => $lineContent) {
  if ($relationShip=="") {
    if (strpos($lineContent,$start)>0) {
      $relationShip="===START===";
    }
  } else if (strpos($lineContent,$end)>0) {
    $relationShip.="===END===";
    break;
  } else {
    $relationShip.=$lineContent."";
  }
}
$workflow=substr($relationShip,strpos($relationShip,'"Workflow" => '));

$lovList=array();
$menu=new Menu();
$menuList=$menu->getSqlElementsFromCriteria(array('idMenu'=>'36'));
foreach ($menuList as $menu) {
  $lov=substr($menu->name,4);
  $lovList[$lov]="";
}

if (is_dir($classDir)) {
  if ($dirHandler = opendir($classDir)) {
    while (($file = readdir($dirHandler)) !== false) {
      if ($file!="." and $file!=".." and filetype($classDir . $file)=="file") {
        $split=explode('.',$file);
        $class=$split[0];
        if ($class!='GeneralWork' and $class!='index' and $class!='Mutex' and $class!='NumberFormatter52'
          and $class!='ShortType' and $class!='ImapMailbox' and $class!='ContextType'
          and $class!='TicketSimple'  and $class!='ResourceSelect' and $class!='DocumentVersionFull'
          and $class!='DocumentVersionRef' 
          and substr($class,-4)!='Main' and $class!='_securityCheck'
                    //and $class>='Ti' // and $class<'B'
        ) {
          $obj=new $class();
          if (SqlElement::is_subclass_of($obj, "SqlElement")) {
            if (substr($class,-4)=='Type'){
          	  testType($obj);
            } else {
              testLov($obj);
            }
          }
        }  
      }
    }
  }
}
foreach ($lovList as $lov=>$rel) {
  if ($rel=='') {
    $lovKO.="$lov not found on object\n";
  } else if ($rel=='KO') {
    $lovKO.="$lov not defined on relationShip\n";
  }
}
$arr=explode("\n",$lovOK);
sort($arr);
$lovOK=implode("\n",$arr);
$arr=explode("\n",$lovKO);
sort($arr);
$lovKO=implode("\n",$arr);

echo "</pre>";
echo '<table>';
echo '<tr><td style="border:1px solid grey;color:green;">Type OK</td>';
echo '<td style="border:1px solid grey;color:red;">Type KO</td></tr>';
echo '<tr><td style="border:1px solid grey;color:green;">'.nl2br($typeToItemOK).'</td>';
echo '<td style="border:1px solid grey;color:red;">'.nl2br($typeToItemKO).'</td></tr>';
echo '<tr><td style="border:1px solid grey;color:green;">Workflow OK</td>';
echo '<td style="border:1px solid grey;color:red;">Workflow KO</td></tr>';
echo '<tr><td style="border:1px solid grey;color:green;">'.nl2br($workflowtoTypeOK).'</td>';
echo '<td style="border:1px solid grey;color:red;">'.nl2br($workflowtoTypeKO).'</td></tr>';
echo '<tr><td style="border:1px solid grey;color:green;">LOV OK</td>';
echo '<td style="border:1px solid grey;color:red;">LOV KO</td></tr>';
echo '<tr><td style="border:1px solid grey;color:green;">'.nl2br($lovOK).'</td>';
echo '<td style="border:1px solid grey;color:red;">'.nl2br($lovKO).'</td></tr>';
echo '</table>';

function testType($obj) {
  global $relationShip, $workflow, $typeToItemOK, $typeToItemKO, $workflowtoTypeOK, $workflowtoTypeKO;
  $class=get_class($obj);
  if ($class=='Type' or $class=='ShortType') return;
  $parentClass=substr($class,0,strlen($class)-4);
  $mustType='"'.$class.'" => ';
  $pos=strpos($relationShip,$mustType);
  if ($pos>0) {
    $endLine=strpos($relationShip,"\n",$pos+1);
    $typeToItemOK.=substr($relationShip,$pos,$endLine-$pos);
  } else {
    $typeToItemKO.=$mustType.'array("'.$parentClass.'" => "controlStrict"),'."\n";
  }
  $mustType='"'.$class.'"=>';
  $pos=strpos($workflow,$mustType);
  if ($pos>0) {
    $endLine=strpos($workflow,"\n",$pos+1);
    $workflowtoTypeOK.=substr($workflow,$pos,$endLine-$pos);
  } else {
    $workflowtoTypeKO.='"'.$class.'"=>"controlStrict",'."\n";
  }
  
}
function testLov($obj) {
  global $relationShip, $lovList, $lovOK, $lovKO;
  $class=get_class($obj);
  foreach($lovList as $lov=>$rel) {
    if (property_exists($class, "id$lov")) {
      $searchLov='"'.$lov.'" =>';
      if (!$rel) {
        $pos=strpos($relationShip,$searchLov);
        if ($pos>0) {
          $start=strpos($relationShip,'array(',$pos);
          $end=strpos($relationShip,')',$start);
          $rel=substr($relationShip,$start+6,$end-$start-6);
          $rel=str_replace(array(' '),array(''),$rel);
          $lovList[$lov]=$rel;
          //echo $lov.'<br/>'.($rel).'<br/><br/>';
        } else {
          $lovList[$lov]="KO";
        }
      } 
      if ($rel!='KO') {
        $search='"'.$class.'"=>';
        $pos=strpos($rel,$search);
        if ($pos!==false) {
          $end=strpos($rel,",",$pos);
          $length=($end)?$end-$pos:strlen($rel)-$pos;
          $posVal=(strpos($rel,'=>"',$pos)+3);
          $posValEnd=strpos($rel,'"',$posVal);
          $val=substr($rel,$posVal,$posValEnd-$posVal);
          if ($val=="controlStrict") {
            $lovOK.=$searchLov.' array('.substr($rel,$pos,$length).")\n";
          } else {
            $lovKO.=$searchLov.' array('.substr($rel,$pos,$length).")\n";
          }
        } else {
          $lovKO.=$searchLov.' array('.$search.' "controlStrict")'."\n";
        }
      }
    }
  }
}
