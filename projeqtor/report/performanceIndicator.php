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

include_once '../tool/projeqtor.php';
include_once '../tool/formatter.php';
include("../external/pChart2/class/pData.class.php");
include("../external/pChart2/class/pDraw.class.php");
include("../external/pChart2/class/pImage.class.php");

//Parameters
$idProject=RequestHandler::getId('idProject');
$scale=RequestHandler::getValue('format');
$startDateReport=RequestHandler::getDatetime('startDate');
$endDateReport=RequestHandler::getDatetime('endDate');
$element=RequestHandler::getValue('activityOrTicket');
$team = RequestHandler::getValue('idTeam');
$resource = RequestHandler::getValue('idResource');
$today=date('Y-m-d');

//Header 
$headerParameters="";
if ($idProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project',$idProject)) . '<br/>';
}
if ( $scale) {
  $headerParameters.= i18n("colFormat") . ' : ' . i18n($scale) . '<br/>';
}
if ($startDateReport!="") {
  $headerParameters.= i18n("colStartDate") . ' : ' . htmlFormatDate($startDateReport) . '<br/>';
}
if ($endDateReport!="") {
  $headerParameters.= i18n("colEndDate") . ' : ' . htmlFormatDate($endDateReport) . '<br/>';
}
if ($team!="") {
  $headerParameters.= i18n("Team") . ' : ' . htmlEncode(SqlList::getNameFromId('Team',$team)) . '<br/>';
}
if ($resource!="") {
  $headerParameters.= i18n("Resource") . ' : ' . htmlEncode(SqlList::getNameFromId('Resource',$resource)) . '<br/>';
}
include "header.php";

if (! testGraphEnabled()) { return;}

if($idProject == ' ' ){
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
   echo i18n('messageNoData',array(i18n('Project'))); // TODO i18n message
  echo '</div>';
  exit;
}

// project seleted without date
if ($idProject AND ($startDateReport == null OR $endDateReport == null)) {
  $proj = new ProjectPlanningElement($idProject);
  if($startDateReport == null){
    if($proj->realStartDate != null){
      $startDateReport = $proj->realStartDate;
    }elseif ($proj->plannedStartDate != null){
      $startDateReport = $proj->plannedStartDate;
    }elseif ($proj->validatedStartDate != null){     
      $startDateReport = $proj->validatedStartDate;
    }elseif ($proj->initialStartDate != null){
      $startDateReport = $proj->initialStartDate;
    }
  }
  if($endDateReport == null){
    if($proj->realEndDate != null){
      $endDateReport = $proj->realEndDate;
    }elseif ($proj->plannedEndDate != null){
      $endDateReport = $proj->plannedEndDate;
    }elseif ($proj->validatedEndDate != null){
      $endDateReport = $proj->validatedEndDate;
    }elseif ($proj->initialEndDate != null){
      $endDateReport = $proj->initialEndDate;
    }
  }
}
$start="";
$end="";

if($element == 'activities' or $element =='both'){
  
  $querySelect = " SELECT DISTINCT  assignment.idResource,
                                    assignment.refId as idActivite,
          			                    assignment.plannedWork,
                                    assignment.assignedWork,
                                    assignment.realEndDate ";
  
  $queryFrom = "   FROM assignment ";
  
  $queryWhere = "  WHERE assignment.refType = 'Activity'";
  $queryWhere .= " AND  assignment.idProject = ".$idProject;
  if($resource != ' '){
    $queryWhere .= " AND assignment.idResource = ".$resource;
  }else{
    $queryWhere .= " AND assignment.idResource <> 'NULL' ";
  }
  if($startDateReport != null ){
    if($endDateReport != null && $endDateReport >= $today ){
      $queryWhere .=  " AND   (assignment.realEndDate >= '$startDateReport'";
      $queryWhere .= "         OR assignment.realEndDate IS NULL )";
    }else{
      $queryWhere .= "  AND assignment.realEndDate >= '$startDateReport'";
    }
  }
  if($endDateReport != null ){
    $queryWhere .=  "  AND ( assignment.realStartDate <= '$endDateReport'";
    $queryWhere .= "      OR assignment.realStartDate IS NULL )";
 }

  $queryOrder = " order by idResource, idActivite ;";

  $query=$querySelect.$queryFrom.$queryWhere.$queryOrder;
  $result=Sql::query($query);
  
  $tabResource = array();
  while ($line = Sql::fetchLine($result)) {
     $idResource = $line['idResource'];
     if($line['realEndDate'] == null){
       $line['realEndDate'] = $today;
     }
     if($line['assignedWork'] == 0){
       if($line['plannedWork'] != 0){
         $line['assignedWork'] = $line['plannedWork'];
       }else{
         continue;
       }
     }
     $tabResource[$idResource][$line['idActivite']][1] = $line['realEndDate'] ;
     $tabResource[$idResource][$line['idActivite']][2] = ($line['plannedWork']) / ($line['assignedWork']) ;
  }
  
}elseif($element == 'tickets'){
 $tabResource = ticket($resource,$idProject,$startDateReport,$endDateReport,$today);
}

//General CASE
foreach ($tabResource as $idResource=>$valResourceTab){
  $i = 0;
  foreach ($valResourceTab as $idAct=>$value){
    $i++;
    $tabDate[$idResource][$value[1]][$idAct] = $value[2];
  }
  ksort($tabDate[$idResource]);
}

if($element !='both'){
  if(!isset($tabDate) ){
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n('reportNoData');
    echo '</div>';
    exit;
  }
}

$nb = array();
$dateAct1 = array();
$indice = array();

if(isset($tabDate) ){
  
  $tabValues1 = array();
  foreach ($tabDate as $idResource=>$val){
    $i = 0;
    foreach ($val as $date=>$tabIdActIndice){
      foreach ($tabIdActIndice as $valueIndice){
        if($i == 0){
          $tabValues1[$idResource][$date]['sum'] = $valueIndice;
          $tabValues1[$idResource][$date]['nb'] = 1;
          $tabValues1[$idResource][$date]['indice'] = ($tabValues1[$idResource][$date]['sum'] / $tabValues1[$idResource][$date]['nb']) ;
        }else{
          if (array_key_exists($date, $tabValues1[$idResource])) {
            $tabValues1[$idResource][$date]['sum'] = $tabValues1[$idResource][$date]['sum']+$valueIndice;
            $tabValues1[$idResource][$date]['nb'] = $tabValues1[$idResource][$date]['nb']+1;
            $tabValues1[$idResource][$date]['indice'] = ($tabValues1[$idResource][$date]['sum'] / $tabValues1[$idResource][$date]['nb']) ;
          }else{
            $tabValues1[$idResource][$date]['sum'] = $valueIndice;
            $tabValues1[$idResource][$date]['nb'] = 1;
            $tabValues1[$idResource][$date]['indice'] = ($tabValues1[$idResource][$date]['sum'] / $tabValues1[$idResource][$date]['nb']) ;
          }
        }
        $i++;
      }
    }
  }
  
  foreach ($tabValues1 as $id=>$value){
    $i = 0;
    foreach ($value as $idd=>$val){
      $i++;
      $dateAct1[$idd] = $idd;
      if ($scale=='day') {
        $idd = htmlFormatDate($idd);
      }elseif($scale=='week'){
        $idd=weekFormat($idd);
      } elseif ($scale=='month') {
        $idd=date('Y-m',strtotime($idd));
      }elseif ($scale=='quarter') {
        $year=date('Y',strtotime($idd));
        $month=date('m',strtotime($idd));
        $quarter=1+intval(($month-1)/3);
        $idd=$year.'-Q'.$quarter;
      }
      if($i == 1 ){
        $nb[$id][$idd] = $val['nb'];
        $indice[$id][$idd] = round($val['indice'],2);
      }else{
        if ( array_key_exists($idd, $nb[$id])) {
          $nb[$id][$idd] += $val['nb'];        
          if($val['nb']==1){
            $indice[$id][$idd] = round(((($nb[$id][$idd]-$val['nb'])*$indice[$id][$idd])+ $val['indice'] ) / $nb[$id][$idd],2);
          }else{
            $indice[$id][$idd] = round(((($nb[$id][$idd]-$val['nb'])*$indice[$id][$idd])+ $val['nb']*$val['indice'] ) / $nb[$id][$idd],2);
          }
        }else{
          $nb[$id][$idd] = $val['nb'];
          $indice[$id][$idd] = round($val['indice'],2);
        }
      }
    }
  }
}
if($element == "both"){
  $tabResource2 = ticket($resource,$idProject,$startDateReport,$endDateReport,$today);
  foreach ($tabResource2 as $idResource=>$valResourceTab){
    $i = 0;
    foreach ($valResourceTab as $idAct=>$value){
      $i++;
      $tabDate2[$idResource][$value[1]][$idAct] = $value[2];
    }
    ksort($tabDate2[$idResource]);
  }
  
  //no value ticket and activity
  if(!isset($tabDate) && !isset($tabDate2) ){
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n('reportNoData');
    echo '</div>';
    exit;
  }
  
  $tabValues2 = array();
  foreach ($tabDate2 as $idResource=>$val){
    $i = 0;
    foreach ($val as $date=>$tabIdActIndice){
      foreach ($tabIdActIndice as $valueIndice){
        if($i == 0){
          $tabValues2[$idResource][$date]['sum'] = $valueIndice;
          $tabValues2[$idResource][$date]['nb'] = 1;
          $tabValues2[$idResource][$date]['indice'] = ($tabValues2[$idResource][$date]['sum'] / $tabValues2[$idResource][$date]['nb']) ;
        }else{
          if (array_key_exists($date, $tabValues2[$idResource])) {
            $tabValues2[$idResource][$date]['sum'] = $tabValues2[$idResource][$date]['sum']+$valueIndice;
            $tabValues2[$idResource][$date]['nb'] = $tabValues2[$idResource][$date]['nb']+1;
            $tabValues2[$idResource][$date]['indice'] = ($tabValues2[$idResource][$date]['sum'] / $tabValues2[$idResource][$date]['nb']) ;
          }else{
            $tabValues2[$idResource][$date]['sum'] = $valueIndice;
            $tabValues2[$idResource][$date]['nb'] = 1;
            $tabValues2[$idResource][$date]['indice'] = ($tabValues2[$idResource][$date]['sum'] / $tabValues2[$idResource][$date]['nb']) ;
          }
        }
        $i++;
      }
    }
  }
  
  $resourceName2 = array();
  foreach ($tabValues2 as $idResource=>$value){
    $resourceName2[]=SqlList::getNameFromId('Resource',$idResource);
  }
  
  foreach ($tabValues2 as $id=>$value){
    foreach ($value as $idd=>$val){
      $dateAct1[$idd] = $idd;
      if ($scale=='day') {
        $idd = htmlFormatDate($idd);
      }elseif($scale=='week'){
        $idd=weekFormat($idd);
      } elseif ($scale=='month') {
        $idd=date('Y-m',strtotime($idd));
      }elseif ($scale=='quarter') {
        $year=date('Y',strtotime($idd));
        $month=date('m',strtotime($idd));
        $quarter=1+intval(($month-1)/3);
        $idd=$year.'-Q'.$quarter;
      }
      if ( array_key_exists($id, $nb)) {
        if ( array_key_exists($idd, $nb[$id])) {
          $nb[$id][$idd] += $val['nb'];
          if($val['nb']==1){
            $indice[$id][$idd] = round(((($nb[$id][$idd]-$val['nb'])*$indice[$id][$idd])+ $val['indice'] ) / $nb[$id][$idd],2);
          }else{
            $indice[$id][$idd] = round(((($nb[$id][$idd]-$val['nb'])*$indice[$id][$idd])+ $val['nb']*$val['indice'] ) / $nb[$id][$idd],2);
          }
          }else{
            $nb[$id][$idd] = $val['nb'];
            $indice[$id][$idd] = round($val['indice'],2);
          }  
        }else{
          $nb[$id][$idd] = $val['nb'];
          $indice[$id][$idd] = round($val['indice'],2);
        }   
    }
  }
}

$start = $startDateReport;
$date=$start;
$end = $endDateReport;

if (!$start or !$end) {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n('reportNoData');
  echo '</div>';
  exit;
}

$dateAct = array();
while ($date<=$end) {
  if ($scale=='week') {
    $dateAct[$date]=weekFormat($date);
  } else if ($scale=='month') {
    $dateAct[$date]=date('Y-m',strtotime($date));
  } else if ($scale=='quarter') {
    $year=date('Y',strtotime($date));
    $month=date('m',strtotime($date));
    $quarter=1+intval(($month-1)/3);
    $dateAct[$date]=$year.'-Q'.$quarter;  }
    else {
      $dateAct[$date]=$date;
    }
    $date=addDaysToDate($date, 1);
}

$startDatePeriod=null;
$endDatePeriod=null;
if ($startDateReport and isset($dateAct[$startDateReport])){
  $startDatePeriod=$dateAct[$startDateReport];
}
if ($endDateReport and isset($dateAct[$endDateReport])){
  $endDatePeriod=$dateAct[$endDateReport];
}

if ($startDatePeriod or $endDatePeriod) {
  foreach ($dateAct as $date => $period) {
    if ( ($startDatePeriod and $period<$startDatePeriod) or ($endDatePeriod and $period>$endDatePeriod) ) {
      unset($dateAct[$date]);
    }
  }
}

$graphWidth=1000;
$graphHeight=600;
$indexToday=0;
$cpt=0;

$modulo=intVal(50*count($dateAct)/$graphWidth);
if ($modulo<0.5) $modulo=0;
foreach ($dateAct as $date => $period) {
  if ($period<$today) $indexToday++;
  if (0 and $cpt % $modulo !=0 ) {
    $dateAct[$date]=VOID;
  } else {
    if ($scale=='day') {
      $dateAct[$date]=htmlFormatDate($date);
    }  else {
      $dateAct[$date]=$period;
    }
  }
  $cpt++;
}
$arrLabel=array();
foreach($dateAct as $date){
  $arrLabel[]=$date;
}

$nb2 = array();
$indice2 =array();
foreach ($arrLabel as $val){
    foreach ($nb as $iddd=>$tabNumber){
      if (! array_key_exists($val, $nb[$iddd])) {
        $nb2[$iddd][$val]=0;
      }else{
        $nb2[$iddd][$val]=$nb[$iddd][$val];
      }
    } 
    foreach ($indice as $id=>$tabNumber){
      if (! array_key_exists($val, $indice[$id])) {
        $indice2[$id][$val]=VOID;
      }else{
        $indice2[$id][$val]=$indice[$id][$val];
      }
    }
}

$datesResource = array();
foreach ($nb2 as $id=>$value){
 foreach ($value as $idddd=>$val){
   $datesResource[$id][]= $idddd;
 }
 $idDateResource = $id;
}

//DRAW TODAY
if($scale!='day'){
  $indexToday=0;
  if ($scale=='week') {
    $today=weekFormat(date('Y-m-d'));
  }elseif ($scale=='month'){
    $today = date('Y-m',strtotime($today));
  }elseif ($scale=='quarter'){
    $year=date('Y',strtotime($today));
    $month=date('m',strtotime($today));
    $quarter=1+intval(($month-1)/3);
    $today=$year.'-Q'.$quarter;
  }

  foreach ($datesResource[$idDateResource] as $val){
    if ($val<$today){
      $indexToday++;
    }
  }
}

$maxPlotted=30; // max number of point to get plotted lines. If over lines are not plotted/
 
if ($team != ' ') {
  foreach ($indice2 as $idR=>$ress) {
    $res=new Resource($idR);
    if ($res->idTeam!=$team) {
      unset($indice2[$idR]);
    }
  }
  foreach ($nb2 as $idR=>$ress) {
    $res=new Resource($idR);
    if ($res->idTeam!=$team) {
      unset($nb2[$idR]);
    }
  }
  if (count($nb2) == 0) {
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n('reportNoData');
    echo '</div>';
    exit;
  }
}

// GRAPH INDICE
$MyData = new pData();
$dateId = "";
foreach ($indice2 as $id=>$val){
  $name = SqlList::getNameFromId('Resource',$id);
  $MyData->addPoints($val,$name);
  $MyData->setSerieDescription($name,$name);
  $dateIdResource =  $id;
}
//modulo scale
$modulo=intVal(50*count($datesResource[$dateIdResource])/$graphWidth);
if ($scale=='day' or $scale=='week') {
  if ($modulo<0.5) $modulo=0;
}elseif ($scale == 'month' or $scale =='quarter'){
  if ($modulo<1) $modulo=0;
}
$MyData->addPoints($datesResource[$dateIdResource],"myDates");
$MyData->setAbscissa("myDates");
$MyData->setAxisName(0,i18n("indicatorValue"));

$myPicture = new pImage($graphWidth,$graphHeight,$MyData);

/* Draw the background */
$myPicture->Antialias = FALSE;
$Settings = array("R"=>240, "G"=>240, "B"=>240, "Dash"=>0, "DashR"=>0, "DashG"=>0, "DashB"=>0);
$myPicture->drawFilledRectangle(0,0,$graphWidth,$graphHeight,$Settings);

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,$graphWidth-1,$graphHeight-1,array("R"=>150,"G"=>150,"B"=>150));

/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>9,"R"=>100,"G"=>100,"B"=>100));

/* title */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>8,"R"=>100,"G"=>100,"B"=>100));
$myPicture->drawLegend(10,10,array("Mode"=>LEGEND_HORIZONTAL, "Family"=>LEGEND_FAMILY_BOX ,
    "R"=>255,"G"=>255,"B"=>255,"Alpha"=>100,
    "FontR"=>55,"FontG"=>55,"FontB"=>55,
    "Margin"=>5));
$myPicture->drawText($graphWidth/2,50,i18n("reportPerformanceIndicatorValue"),array("FontSize"=>14,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
/* Draw the scale */
$myPicture->setGraphArea(60,30,$graphWidth-20,$graphHeight-(($scale=='month')?75:75));
$myPicture->drawFilledRectangle(60,30,$graphWidth-20,$graphHeight-(($scale=='month')?75:75),array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>230));
$formatGrid=array("LabelSkip"=>$modulo, "SkippedAxisAlpha"=>(($modulo>9)?0:20), "SkippedGridTicks"=>0,
    "Mode"=>SCALE_MODE_START0, "GridTicks"=>0,
    "DrawYLines"=>(0), "DrawXLines"=>true,"Pos"=>SCALE_POS_LEFTRIGHT,
    "LabelRotation"=>60, "GridR"=>200,"GridG"=>200,"GridB"=>200);
$myPicture->drawText($graphWidth/2,20,i18n("reportPerformanceIndicatorValue"),array("FontSize"=>14,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
$myPicture->drawScale($formatGrid);
$myPicture->Antialias = TRUE;

//curve and color
foreach ($indice2 as $id=>$val){
  $name = SqlList::getNameFromId('Resource',$id);
  $MyData->setSerieWeight($name,0.2);
  $MyData->setSerieDrawable($name,true);
}

/* add plots */
$myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-40,"BorderAlpha"=>50));
$myPicture->drawLineChart();
//draw today
$myPicture->drawXThreshold(array($indexToday),array("Alpha"=>70,"Ticks"=>0));
/* Render the picture (choose the best way) */
$imgName=getGraphImgName("performanceIndicator");
$myPicture->Render($imgName);
 
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img style="width:1000px;height:600px" src="' . $imgName . '" />';
echo '</td></tr></table>';
echo '<br/>';

// GRAPH NUMBER
$MyData = new pData();

$dateId = "";
foreach ($nb2 as $id=>$val){
  $name = SqlList::getNameFromId('Resource',$id);
  $MyData->addPoints($val,$name);
  $MyData->setSerieDescription($name,$name);
  $dateIdResource =  $id;
}
$MyData->addPoints($datesResource[$dateIdResource],"myDates");
$MyData->setAbscissa("myDates");
$MyData->setAxisName(0,i18n("colWorkElementCount"));

/* Je crée l'image qui contiendra mon graphique précédemment crée */
$myPicture = new pImage($graphWidth,$graphHeight,$MyData);

/* Draw the background */
$myPicture->Antialias = FALSE;
$Settings = array("R"=>240, "G"=>240, "B"=>240, "Dash"=>0, "DashR"=>0, "DashG"=>0, "DashB"=>0);
$myPicture->drawFilledRectangle(0,0,$graphWidth,$graphHeight,$Settings);

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,$graphWidth-1,$graphHeight-1,array("R"=>150,"G"=>150,"B"=>150));

/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>9,"R"=>100,"G"=>100,"B"=>100));

/*title */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>8,"R"=>100,"G"=>100,"B"=>100));
$myPicture->drawLegend(10,10,array("Mode"=>LEGEND_HORIZONTAL, "Family"=>LEGEND_FAMILY_BOX ,
   "R"=>255,"G"=>255,"B"=>255,"Alpha"=>100,
   "FontR"=>55,"FontG"=>55,"FontB"=>55,
   "Margin"=>5));
$myPicture->drawText($graphWidth/2,20,i18n("reportPerformanceNumber"),array("FontSize"=>14,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Draw the scale */
$myPicture->setGraphArea(60,30,$graphWidth-20,$graphHeight-(($scale=='month')?100:75));
$myPicture->drawFilledRectangle(60,30,$graphWidth-20,$graphHeight-(($scale=='month')?100:75),array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>230));
$formatGrid=array("LabelSkip"=>$modulo, "SkippedAxisAlpha"=>(($modulo>9)?0:20), "SkippedGridTicks"=>0,
   "Mode"=>SCALE_MODE_START0, "GridTicks"=>0,
   "DrawYLines"=>array(0), "DrawXLines"=>true,"Pos"=>SCALE_POS_LEFTRIGHT,
   "LabelRotation"=>60, "GridR"=>200,"GridG"=>200,"GridB"=>200);
$myPicture->drawScale($formatGrid);

$myPicture->Antialias = TRUE;

//courbe and color
foreach ($nb2 as $id=>$val){
  $name = SqlList::getNameFromId('Resource',$id);
  $MyData->setSerieWeight($name,0.2);
  $MyData->setSerieDrawable($name,true);
}

foreach ($datesResource as $val){
  $taille = count($val);
  if($taille < 2){
    $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-40,"BorderAlpha"=>50));
  }
}
$myPicture->drawPlotChart(array("DisplayValues"=>false,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-40,"BorderAlpha"=>50));

$myPicture->drawXThreshold(array($indexToday),array("Alpha"=>70,"Ticks"=>0));
$myPicture->drawLineChart();

/* Render the picture (choose the best way) */
$imgName=getGraphImgName("performanceIndicator");
$myPicture->Render($imgName);

echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img style="width:1000px;height:600px" src="' . $imgName . '" />';
echo '</td></tr></table>';
echo '<br/>';

//FUNCTION
function ticket($resource,$idProject,$startDateReport,$endDateReport,$today){
  
  $querySelect = " SELECT DISTINCT  ticket.idResource,
                          workelement.refId as idTicket,
			                    workelement.realwork,
                          workelement.leftWork,
                          workelement.plannedWork,
                          ticket.doneDateTime as date";
  
  $queryFrom = "   FROM ticket,workelement ";
  
  $queryWhere = "  WHERE  ticket.id = workelement.refId";
  $queryWhere .=  " AND workelement.idProject = ".$idProject;
  
  if($resource != ' '){
    $queryWhere .= " AND ticket.idResource = ".$resource;
  }else{
    $queryWhere .= " AND ticket.idResource <> 'NULL' ";
  }
  if($startDateReport != null ){
    if($endDateReport != null && $endDateReport >= $today ){
      $queryWhere .=  "  AND   (ticket.doneDateTime >= '$startDateReport'";
      $queryWhere .= " OR ticket.doneDateTime IS NULL )";
    }else{
      $queryWhere .=  "  AND ticket.doneDateTime >= '$startDateReport'";
    }
  }
  
  if($endDateReport != null ){
    $queryWhere .=  "  AND  (ticket.doneDateTime <= '$endDateReport'";
    $queryWhere .= " OR ticket.doneDateTime IS NULL )";
  }
  
  $queryOrder = " order by idResource, idTicket, date ;";
  
  $query=$querySelect.$queryFrom.$queryWhere.$queryOrder;
  $result=Sql::query($query);
  $tabResource = array();
  while ($line = Sql::fetchLine($result)) {
    $idResource = $line['idResource'];
    if($line['date'] == null){
      $line['date'] = $today;
    }
    if($line['plannedWork'] == 0){
      if($line['realwork'] != 0){
        $line['plannedWork'] = $line['realwork'];
      }else{
        continue;
      }
    }
      $tabResource[$idResource][$line['idTicket']][1] = date('Y-m-d',strtotime($line['date']));
      $tabResource[$idResource][$line['idTicket']][2] = ($line['realwork'] + $line['leftWork'] ) / ($line['plannedWork']) ;
  }
  
  return $tabResource;
}
?>