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

include_once '../tool/projeqtor.php';

$idProject="";
if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
  $idProject=trim($_REQUEST['idProject']);
  $idProject = Security::checkValidId($idProject);
}
$scale="";
if (array_key_exists('format',$_REQUEST)) {
	$scale=$_REQUEST['format'];
};
$headerParameters="";
if ($idProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project',$idProject)) . '<br/>';
}
if ( $scale) {
  $headerParameters.= i18n("colFormat") . ' : ' . i18n($scale) . '<br/>';
}

include "header.php";

if (!$idProject) {
  echo i18n('messageNoData',array(i18n('Project'))); // TODO i18n message
  exit; 
}
  
$ph=new ProjectHistory();
$phTable=$ph->getDatabaseTableName();
$user=getSessionUser();

$querySelect= "select leftWork as leftwork, realWork as realwork, day "; 
$queryFrom=   " from $phTable ph";
$queryWhere=  " where ph.idProject=".Sql::fmtId($idProject);
$queryWhere.= " and ph.idProject in ".transformListIntoInClause($user->getVisibleProjects(false));
$queryOrder= "  order by day asc";
$query=$querySelect.$queryFrom.$queryWhere.$queryOrder;
echo $query;
// constitute query and execute

$tabLeft=array();
$resLeft=array();
$start="";
$end="";
$hasReal=false;

$result=Sql::query($query);
while ($line = Sql::fetchLine($result)) {
  $day=substr($line['day'],0,4).'-'.substr($line['day'],4,2).'-'.substr($line['day'],6);
  $left=$line['leftwork'];
  $tabLeft[$day]=$left;
  if ($start=="" or $start>$day) {$start=$day;}
  if ($end=="" or $end<$day) { $end=$day;}
}

if (checkNoData($tabLeft)) exit;
debugLog("1");
$pe=SqlElement::getSingleSqlElementFromCriteria('PlanningElement',array('refType'=>'Project', 'refId'=>$idProject));
if (trim($pe->realStartDate)) $start=$pe->realStartDate;
if (trim($pe->realEndDate)) $end=$pe->realEndDate;

$arrDates=array();
$date=$start;
while ($date<=$end) {
  debugLog($date);
  if ($scale=='week') { $arrDates[$date]=date('Y-W',strtotime($date)); } 
  else if ($scale=='month') { $arrDates[$date]=date('Y-m');  } 
  else { $arrDates[$date]=$date;}
  $date=addDaysToDate($date, 1);
  
}

$old="";
foreach ($arrDates as $date => $period) {
  if (isset($tabLeft[$date])) {
    $resLeft[$period]=Work::displayWork($tabLeft[$date]);
    $old=$tabLeft[$date];
  } else {
    $resLeft[$period]=Work::displayWork($old);
  }
  
}


// Graph
if (! testGraphEnabled()) { return;}
include("../external/pChart/pData.class");  
include("../external/pChart/pChart.class");  
$dataSet=new pData;

$vals=array('2016-10-12'=>2);
$dataSet->AddPoint($vals,0);
$dataSet->SetSerieName(i18n('legendCompletedTasks'),0);
$dataSet->AddSerie(0);

$arrLabel=array();
foreach($arrDates as $date){
  $arrLabel[]=$date;
}
$dataSet->AddPoint($arrLabel,"dates");  
$dataSet->SetAbsciseLabelSerie("dates");   
$width=900;
$height=700;
$graph = new pChart($width,360);  
//$graph->setColorPalette(0,$rgbPalette[(0)]['R'],$rgbPalette[(5)]['G'],$rgbPalette[(10)]['B']);

$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",10);
$graph->drawRoundedRectangle(5,5,$width-5,358,5,230,230,230);  
$graph->setGraphArea(60,20,$width-300,280);  
$graph->drawGraphArea(252,252,252);  
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);  
$graph->drawRightScale($dataSet->GetData(),$dataSet->GetDataDescription(), SCALE_START0 ,0,0,0,TRUE,90,1, true);  

$graph->drawGrid(3,TRUE,230,230,230,255);  
$graph->drawStackedBarGraph($dataSet->GetData(),$dataSet->GetDataDescription(),TRUE);  
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);  
$graph->drawLegend($width-150,15,$dataSet->GetDataDescription(),240,240,240);  
$graph->clearScale();

$dataSet->RemoveSerie(0);
$dataSet->AddPoint($resLeft,1);
//$dataSet->AddPoint(array("",120,110,100,"","",10,5,2,0),1);
$dataSet->SetSerieName(i18n("legendRemainingEffort"),1);  
$dataSet->AddSerie(1);
$dataSet->SetYAxisName(i18n("sum"));
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);
//$graph->setColorPalette(0,0,0,0);  
$graph->drawScale($dataSet->GetData(),$dataSet->GetDataDescription(),SCALE_START0,0,0,0,true,90,1, true);
$graph->drawLineGraph($dataSet->GetData(),$dataSet->GetDataDescription());  
$graph->drawPlotGraph($dataSet->GetData(),$dataSet->GetDataDescription(),3,2,255,255,255);  

$imgName=getGraphImgName("burndownChart");
$graph->Render($imgName);
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />'; 
echo '</td></tr></table>';
echo '<br/>';
?>