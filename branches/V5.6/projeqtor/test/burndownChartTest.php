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
$showCompleted=true;

include "header.php";

if (!$idProject) {
  echo '<div style="background: #FFDDDD;font-size:200%;text-align:center;padding:20px">';
  echo i18n('messageNoData',array(i18n('Project'))); // TODO i18n message
  echo '</div>';
  exit; 
}
// Graph
if (! testGraphEnabled()) { return;}

$user=getSessionUser();
$proj=new Project($idProject);

// constitute query and execute for left work (history)
$ph=new ProjectHistory();
$phTable=$ph->getDatabaseTableName();
$querySelect= "select leftWork as leftwork, realWork as realwork, day "; 
$queryFrom=   " from $phTable ph";
$queryWhere=  " where ph.idProject=".Sql::fmtId($idProject);
$queryWhere.= " and ph.idProject in ".transformListIntoInClause($user->getVisibleProjects(false));
$queryOrder= "  order by day asc";
$query=$querySelect.$queryFrom.$queryWhere.$queryOrder;
//echo $query.'<br/>'; // debugLog
$result=Sql::query($query);
$tabLeft=array();
$resLeft=array();
$start="";
$end="";
$hasReal=false;
$lastLeft=0;
while ($line = Sql::fetchLine($result)) {
  $day=substr($line['day'],0,4).'-'.substr($line['day'],4,2).'-'.substr($line['day'],6);
  $left=$line['leftwork'];
  $tabLeft[$day]=$left;
  $lastLeft=$left;
  if ($start=="" or $start>$day) {$start=$day;}
  if ($end=="" or $end<$day) { $end=$day;}
  if ($day>date('Y-m-d')) break;
}
$endReal=$end;

// constitute query and execute for planned post $end (last real work day)
$pw=new PlannedWork();
$pwTable=$pw->getDatabaseTableName();
$querySelect= "select sum(pw.work) as work, pw.workDate as day ";
$queryFrom=   " from $pwTable pw";
$queryWhere=  " where pw.workDate>'$end'";
$proj=new Project($idProject);
$queryWhere.= " and pw.idProject in " . transformListIntoInClause($proj->getRecursiveSubProjectsFlatList(false, true));
$queryWhere.= " and pw.idProject in ".transformListIntoInClause($user->getVisibleProjects(false));
$queryOrder= "  group by pw.workDate";
$query=$querySelect.$queryFrom.$queryWhere.$queryOrder;
//echo $query.'<br/>'; // debugLog
$resultPlanned=Sql::query($query);
$tabLeftPlanned=array();
$resLeftPlanned=array();
$resBest=array();
$tabLeftPlanned[$end]=$lastLeft;
$newLastLeft=$lastLeft;
while ($line = Sql::fetchLine($resultPlanned)) {
  $day=$line['day'];
  $planned=$line['work'];
  $newLastLeft-=$planned;
  if ($newLastLeft<0) $newLastLeft=0;
  $tabLeftPlanned[$day]=$newLastLeft;
  if ($start=="" or $start>$day) {$start=$day;}
  if ($end=="" or $end<$day) { $end=$day;}
  if ($newLastLeft==0) break;
}

// constitute query and execute for completed tasks
$pe=new PlanningElement();
$peTable=$pe->getDatabaseTableName();
$querySelect= "select plannedEndDate as plannedend, realEndDate as realend ";
$queryFrom=   " from $peTable pe";
$queryWhere=  " where pe.idProject in " . transformListIntoInClause($proj->getRecursiveSubProjectsFlatList(false, true));
$queryWhere.= " and pe.idProject in ".transformListIntoInClause($user->getVisibleProjects(false));
$queryWhere.= "  and pe.elementary=1";
$queryOrder= "  order by COALESCE(pe.realEndDate, pe.plannedEndDate)";
$query=$querySelect.$queryFrom.$queryWhere.$queryOrder;
//echo $query.'<br/>'; // debugLog
$tabCompletedTasks=array();
$tabCompletedTasksPlanned=array();
$resCompletedTasks=array();
$resCompletedTasksPlanned=array();
$resLeftTasks=array();
$resLeftTasksPlanned=array();
$nbTasks=0;
if ($showCompleted) {
  $resultTasks=Sql::query($query);
  while ($line = Sql::fetchLine($resultTasks)) {
    if ($line['realend']) {
      $day=$line['realend'];
      if (isset($tabCompletedTasks[$day])){ $tabCompletedTasks[$day]++;}
      else {$tabCompletedTasks[$day]=1;}
      $nbTasks++;
    } else if ($line['plannedend']){
      $day=$line['plannedend'];
      if (isset($tabCompletedTasksPlanned[$day])) {$tabCompletedTasksPlanned[$day]++;}
      else {$tabCompletedTasksPlanned[$day]=1;}
      $nbTasks++;
    } else {
      // No real, no planned => not taken into account
    }
  }
}

if (checkNoData(array_merge($tabLeft,$tabLeftPlanned))) exit;

$pe=SqlElement::getSingleSqlElementFromCriteria('PlanningElement',array('refType'=>'Project', 'refId'=>$idProject));
if (trim($pe->realStartDate)) $start=$pe->realStartDate;
if (trim($pe->realEndDate)) $end=$pe->realEndDate;
if (trim($pe->validatedEndDate) and $pe->validatedEndDate>$end) $end=$pe->validatedEndDate;
$arrDates=array();
$date=$start;
while ($date<=$end) {
  if ($scale=='week') { $arrDates[$date]=date('Y-W',strtotime($date)); } 
  else if ($scale=='month') { $arrDates[$date]=date('Y-m',strtotime($date));  } 
  else if ($scale=='quarter') { 
    $year=date('Y',strtotime($date));
    $month=date('m',strtotime($date));
    $quarter=1+intval(($month-1)/3);
    $arrDates[$date]=$year.'-Q'.$quarter;  }
  else { $arrDates[$date]=$date;}
  $date=addDaysToDate($date, 1);
}

$old=null;
$old=reset($tabLeft);
$oldPlanned=$lastLeft;
$nbSteps=0;
$leftTasks=$nbTasks;
foreach ($arrDates as $date => $period) {
  if ($date>$endReal) {
    if (!isset($resLeft[$period])) $resLeft[$period]="";
  } else if (isset($tabLeft[$date])) {
    $resLeft[$period]=Work::displayWork($tabLeft[$date]);
    $old=$tabLeft[$date];
  } else {
    $resLeft[$period]=($old===null)?'':Work::displayWork($old);
  }
  if (isset($tabLeftPlanned[$date])) {
    $resLeftPlanned[$period]=$tabLeftPlanned[$date];
    $oldPlanned=$tabLeftPlanned[$date];
  } else {
    if ($date>=$endReal) {
      $resLeftPlanned[$period]=$oldPlanned;
    } else  {
      //$resLeftPlanned[$period]="";
    }
  }
  if ($showCompleted) {
    if (isset($tabCompletedTasks[$date])) {
      if (isset($resCompletedTasks[$period])) { $resCompletedTasks[$period]+=$tabCompletedTasks[$date];}
      else {$resCompletedTasks[$period]=$tabCompletedTasks[$date];}
      $leftTasks-=$tabCompletedTasks[$date];
      unset($tabCompletedTasks[$date]);
    }  
    if (count($tabCompletedTasks>0)) { $resLeftTasks[$period]=$leftTasks; }
    else $resLeftTasks[$period]='';
    
  }
  if ($date<=$pe->validatedEndDate) $nbSteps++;
}


$maxLeft=$pe->validatedWork;
if (!$maxLeft) $maxLeft=max(array($resLeft[$start],$resLeftPlanned[$start]));
$minLeft=0;
//$nbSteps=count($arrDates)-1;
$stepValue=($nbSteps)?(($maxLeft-$minLeft)/($nbSteps-1)):0;
$val=$maxLeft;

$graphWidth=1000;
$graphHeight=500;

foreach ($arrDates as $date => $period) {
  if ($val!=="" or ! isset($resBest[$period])) $resBest[$period]=$val;
  if ($val) {
    $val-=$stepValue;
    if ($val<0.01) $val=0;
  } else {
    $val="";
  }
}
$arrDates=array_flip($arrDates);
$cpt=0;
$modulo=intVal(30*count($arrDates)/$graphWidth);
if ($modulo<1) $modulo=1;
foreach ($arrDates as $date => $period) {
  if ($cpt % $modulo !=0 ) {
    //$arrDates[$date]="";
  } else {
    $arrDates[$date]=htmlFormatDate($date);
  }
  $cpt++;
}

/*
$maxPlotted=30; // max number of point to get plotted lines. If over lines are not plotted/
include("../external/pChart/pData.class");  
include("../external/pChart/pChart.class");  
$dataSet=new pData;
$graph = new pChart($graphWidth,$graphHeight);
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",10);
$graph->drawRoundedRectangle(5,5,$graphWidth-5,$graphHeight-5,5,230,230,230);
$graph->setGraphArea(60,20,$graphWidth-50,$graphHeight-90);
$graph->drawGraphArea(252,252,252);

$arrLabel=array();
foreach($arrDates as $date){
  $arrLabel[]=$date;
}
$dataSet->AddPoint($arrLabel,"dates");
$dataSet->SetAbsciseLabelSerie("dates");

// Definition of series
$dataSet->AddPoint($resBest,"best");
$dataSet->AddPoint($resLeft,"left");
$dataSet->AddPoint($resLeftPlanned,"leftPlanned");
$dataSet->AddPoint($resLeftTasks,"leftTasks");
$dataSet->SetSerieName(i18n("legendBestBurndown"),"best");
$dataSet->SetSerieName(i18n("legendRemainingEffort"),"left");
$dataSet->SetSerieName(i18n("legendRemainingEffort").' ('.i18n('planned').')',"leftPlanned");
$dataSet->SetSerieName(i18n('legendCompletedTasks'),'leftTasks');

// Draw grid and scales
$dataSet->AddSerie("best");
$dataSet->AddSerie("left");
$dataSet->SetYAxisName(i18n("legendRemainingEffort"));
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);
$graph->setColorPalette(0,250,180,210);
$graph->setColorPalette(1,120,140,250);
$graph->setColorPalette(2,180,180,250);
$graph->drawScale($dataSet->GetData(),$dataSet->GetDataDescription(),SCALE_START0,0,0,0,true,90,1, true);
$graph->drawGrid(3,TRUE,230,230,230,255);
$graph->setLineStyle(1,0);
$dataSet->RemoveSerie('best');
$dataSet->RemoveSerie('left');

// Draw complete tasks line
$dataSet->AddSerie('leftTasks');
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);
$dataSet->SetYAxisName(i18n("legendLeftTasks"));
$graph->drawRightScale($dataSet->GetData(),$dataSet->GetDataDescription(), SCALE_START0 ,0,0,0,TRUE,90,1, true);
$graph->drawStackedBarGraph($dataSet->GetData(),$dataSet->GetDataDescription(),TRUE);
$dataSet->RemoveSerie('completedTasks');

// Draw "left" lines
$dataSet->AddSerie("best");
$dataSet->AddSerie("left");
$graph->drawLineGraph($dataSet->GetData(),$dataSet->GetDataDescription());
$dataSet->RemoveSerie('left');
$graph->setLineStyle(1,3);
$dataSet->AddSerie("leftPlanned");
$graph->drawLineGraph($dataSet->GetData(),$dataSet->GetDataDescription());
if (count($resLeft)<$maxPlotted) {
 $graph->drawPlotGraph($dataSet->GetData(),$dataSet->GetDataDescription(),3,2,255,255,255);
}

$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);
$graph->drawLegend($graphWidth-200,30,$dataSet->GetDataDescription(),240,240,240);
$graph->clearScale();
 

$imgName=getGraphImgName("burndownChart");
$graph->Render($imgName);
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />'; 
echo '</td></tr></table>';
echo '<br/>';
*/
/* CAT:Scaling */

/* pChart library inclusions */
include("../external/pChart2/class/pData.class.php");
include("../external/pChart2/class/pDraw.class.php");
include("../external/pChart2/class/pImage.class.php");

/* Create and populate the pData object */
$MyData = new pData();
$MyData->addPoints($resLeft,"left");
$MyData->addPoints(array(1,2,null,9,10),"Humidity 1");
$MyData->addPoints(array(1,null,7,-9,0),"Humidity 2");
$MyData->addPoints(array(-1,-1,-1,-1,-1),"Humidity 3");
$MyData->addPoints(array(0,0,0,0,0),"Vide");
$MyData->setSerieOnAxis("left",0);
$MyData->setSerieOnAxis("Humidity 1",1);
$MyData->setSerieOnAxis("Humidity 2",1);
$MyData->setSerieOnAxis("Humidity 3",1);
$MyData->setSerieOnAxis("Vide",2);
$MyData->setAxisPosition(2,AXIS_POSITION_RIGHT);
$MyData->setAxisName(0,"left");
$MyData->setAxisName(1,"Humidity");
$MyData->setAxisName(2,"Empty value");

/* Create the abscissa serie */
$arrLabel=array();
foreach($arrDates as $date){
  $arrLabel[]=$date;
}
$MyData->addPoints($arrLabel,"dates");
$MyData->setSerieDescription("dates","My labels");
$MyData->setAbscissa("dates");

/* Create the pChart object */
$myPicture = new pImage(700,230,$MyData);

/* Draw the background */
$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
$myPicture->drawFilledRectangle(0,0,700,230,$Settings);


/* Overlay with a gradient */
$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$Settings);
$myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,699,229,array("R"=>100,"G"=>100,"B"=>100));

/* Write the picture title */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>6));
$myPicture->drawText(10,13,"drawScale() - draw the X-Y scales",array("R"=>255,"G"=>255,"B"=>255));

/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>6));

/* Draw the scale */
$myPicture->setGraphArea(90,60,660,190);
$myPicture->drawFilledRectangle(90,60,660,190,array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10));
$myPicture->drawScale(array("DrawYLines"=>array(0),"Pos"=>SCALE_POS_LEFTRIGHT));

/* Write the chart title */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>11));
$myPicture->drawText(350,55,"My chart title",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Render the picture (choose the best way) */
/*
 * $imgName=getGraphImgName("burndownChart");
$myPicture->Render($imgName);
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />'; 
echo '</td></tr></table>';
echo '<br/>';
*/



/* Create and populate the pData object */
$MyData = new pData();
$MyData->addPoints($resLeft,"left");
$MyData->addPoints(array(3,12,15,8,5,-5),"Probe 2");
$MyData->addPoints(array(2,7,5,18,19,22),"Probe 3");
$MyData->setSerieTicks("Probe 2",4);
$MyData->setSerieWeight("Probe 3",2);
$MyData->setSerieWeight("left",2);
$MyData->setAxisName(0,"Temperatures");
$arrLabel=array();
foreach($arrDates as $date){
  $arrLabel[]=$date;
}
$MyData->addPoints($arrLabel,"dates");
$MyData->setSerieDescription("dates","time");
$MyData->setAbscissa("dates");


/* Create the pChart object */
$myPicture = new pImage($graphWidth,$graphHeight,$MyData);

/* Turn of Antialiasing */
$myPicture->Antialias = FALSE;

/* Add a border to the picture */
$myPicture->drawRoundedRectangle(0,0,$graphWidth-1,$graphHeight-1,10,array("R"=>200,"G"=>200,"B"=>200,"Alpha"=>50));

/* Write the chart title */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>11));
$myPicture->drawText(150,35,"Average temperature",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>6));

/* Define the chart area */
$myPicture->setGraphArea(60,40,$graphWidth-60,$graphHeight-40);

/* Draw the scale */
$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
$myPicture->drawScale($scaleSettings);

/* Turn on Antialiasing */
$myPicture->Antialias = TRUE;

/* Draw the line chart */
$myPicture->drawLineChart();

/* Write the chart legend */
$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

/* Render the picture (choose the best way) */
/* Render the picture (choose the best way) */
$imgName=getGraphImgName("burndownChart");
$myPicture->Render($imgName);
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />';
echo '</td></tr></table>';
echo '<br/>';





$maxPlotted=30; // max number of point to get plotted lines. If over lines are not plotted/
include("../external/pChart/pData.class");
include("../external/pChart/pChart.class");
$dataSet=new pData;
$graph = new pChart($graphWidth,$graphHeight);
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",10);
$graph->drawRoundedRectangle(5,5,$graphWidth-5,$graphHeight-5,5,230,230,230);
$graph->setGraphArea(60,20,$graphWidth-50,$graphHeight-90);
$graph->drawGraphArea(252,252,252);

$arrLabel=array();
foreach($arrDates as $date){
  $arrLabel[]=$date;
}
$dataSet->AddPoint($arrLabel,"dates");
$dataSet->SetAbsciseLabelSerie("dates");

// Definition of series
$dataSet->AddPoint($resBest,"best");
$dataSet->AddPoint($resLeft,"left");
$dataSet->AddPoint($resLeftPlanned,"leftPlanned");
$dataSet->AddPoint($resLeftTasks,"leftTasks");
$dataSet->SetSerieName(i18n("legendBestBurndown"),"best");
$dataSet->SetSerieName(i18n("legendRemainingEffort"),"left");
$dataSet->SetSerieName(i18n("legendRemainingEffort").' ('.i18n('planned').')',"leftPlanned");
$dataSet->SetSerieName(i18n('legendCompletedTasks'),'leftTasks');

// Draw grid and scales
$dataSet->AddSerie("best");
$dataSet->AddSerie("left");
$dataSet->SetYAxisName(i18n("legendRemainingEffort"));
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);
$graph->setColorPalette(0,250,180,210);
$graph->setColorPalette(1,120,140,250);
$graph->setColorPalette(2,180,180,250);
$graph->drawScale($dataSet->GetData(),$dataSet->GetDataDescription(),SCALE_START0,0,0,0,true,90,1, true);
$graph->drawGrid(3,TRUE,230,230,230,255);
$graph->setLineStyle(1,0);
$dataSet->RemoveSerie('best');
$dataSet->RemoveSerie('left');

// Draw complete tasks line
$dataSet->AddSerie('leftTasks');
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);
$dataSet->SetYAxisName(i18n("legendLeftTasks"));
$graph->drawRightScale($dataSet->GetData(),$dataSet->GetDataDescription(), SCALE_START0 ,0,0,0,TRUE,90,1, true);
$graph->drawStackedBarGraph($dataSet->GetData(),$dataSet->GetDataDescription(),TRUE);
$dataSet->RemoveSerie('completedTasks');

// Draw "left" lines
$dataSet->AddSerie("best");
$dataSet->AddSerie("left");
$graph->drawLineGraph($dataSet->GetData(),$dataSet->GetDataDescription());
$dataSet->RemoveSerie('left');
$graph->setLineStyle(1,3);
$dataSet->AddSerie("leftPlanned");
$graph->drawLineGraph($dataSet->GetData(),$dataSet->GetDataDescription());
if (count($resLeft)<$maxPlotted) {
  $graph->drawPlotGraph($dataSet->GetData(),$dataSet->GetDataDescription(),3,2,255,255,255);
}

$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);
$graph->drawLegend($graphWidth-200,30,$dataSet->GetDataDescription(),240,240,240);
$graph->clearScale();

/*


// Completed Tasks
$vals=array('2016-10-12'=>2);

//$graph->setColorPalette(0,$rgbPalette[(0)]['R'],$rgbPalette[(5)]['G'],$rgbPalette[(10)]['B']);


*/



$imgName=getGraphImgName("burndownChart");
$graph->Render($imgName);
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />';
echo '</td></tr></table>';
echo '<br/>';
?>