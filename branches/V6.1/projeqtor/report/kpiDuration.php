<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

$kpiColoFull=false; // decide how kpi color is displayed correspondng on threshold : false will display rounded badge, true will fill the cell 

$idProject="";
if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
  $idProject=trim($_REQUEST['idProject']);
  $idProject = Security::checkValidId($idProject);
}
$idOrganization="";
if (array_key_exists('idOrganization',$_REQUEST) and trim($_REQUEST['idOrganization'])!="") {
  $idOrganization=trim($_REQUEST['idOrganization']);
  $idOrganization = Security::checkValidId($idOrganization);
}
$idProjectType="";
if (array_key_exists('idProjectType',$_REQUEST) and trim($_REQUEST['idProjectType'])!="") {
  $idProjectType=trim($_REQUEST['idProjectType']);
  $idProjectType = Security::checkValidId($idProjectType);
}
$year="";
if (array_key_exists('yearSpinner',$_REQUEST)) {
  $year=trim($_REQUEST['yearSpinner']);
  $year = Security::checkValidYear($year);
}
$month="";
if (array_key_exists('monthSpinner',$_REQUEST)) {
  $month=trim($_REQUEST['monthSpinner']);
  $month = Security::checkValidMonth($month);
  if (!$year) $year=date('Y');
}
$done=false;
if (array_key_exists('doneProjects',$_REQUEST)) {
  $done=true;
}

$headerParameters="";
if ($idProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project',$idProject)) . '<br/>';
}
if ($idOrganization!="") {
  $headerParameters.= i18n("colIdOrganization") . ' : ' . htmlEncode(SqlList::getNameFromId('Organization',$idOrganization)) . '<br/>';
}
if ($idProjectType!="") {
  $headerParameters.= i18n("colIdProjectType") . ' : ' . htmlEncode(SqlList::getNameFromId('ProjectType',$idProjectType)) . '<br/>';
}
if ($year!="") {
  $headerParameters.= i18n("year") . ' : ' . htmlFormatDate($year) . '<br/>';
}
if ($month!="") {
  $headerParameters.= i18n("month") . ' : ' . htmlFormatDate($month) . '<br/>';
}
if ($done) {
  $headerParameters.= i18n("doneProjects").'<br/>';
}

include "header.php";

$scope=$_REQUEST['scope'];
if ($scope=='Project') {
  if (!$idProject) {
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n('messageNoData',array(i18n('Project'))); 
    echo '</div>';
    exit;
  }
} else if ($scope=='Organization') {
  $projectVisibility=securityGetAccessRight('menuProject','read');
  if ($projectVisibility=='ALL' and !$idProjectType and !$idOrganization) {
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n('messageNoData',array(i18n('colIdOrganization').' / '.i18n('colIdProjectType'))); 
    echo '</div>';
    exit;
  }
} else {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n('error : scope is not defined'); 
  echo '</div>';
}

$user=getSessionUser();
$listProjects=array();
$visibleProjects=$user->getVisibleProjects(false);
if ($idProject) {
  $listProjects[$idProject]=new Project($idProject);
} else {
  $crit=array();
  $where=null;
  if ($idOrganization) {
    $crit['idOrganization']=$idOrganization;
  }
  if ($idProjectType) {
    $crit['idProjectType']=$idProjectType;
  }
  if (count($crit)==0) {
    $where='id in '.transformListIntoInClause($visibleProjects);
  } 
  $prj=new Project();
  $listProjects=$prj->getSqlElementsFromCriteria($crit,false,$where);
}

if (checkNoData($listProjects)) exit;

$period=null;
$periodValue='';
if ($month) {
  $period='month';
  $periodValue=$year.$month;
} else if ($year) {
  $period='year';
  $periodValue=$year;
}


$kpi=new KpiDefinition(1);
$thresholds=(new KpiThreshold())->getSqlElementsFromCriteria(array('idKpiDefinition'=>$kpi->id),false,null,'thresholdValue desc');
echo '<table width="90%" align="center">';
echo '<tr>';
echo '<td class="reportTableHeader" style="width:20%">' . i18n('Project') . '</td>';
echo '<td class="reportTableHeader" style="width:20%">' . i18n('Client') . '</td>';
echo '<td class="reportTableHeader" style="width:10%">' . i18n('colValidatedStartDate') . '</td>';
echo '<td class="reportTableHeader" style="width:10%">' . i18n('colValidatedEndDate') . '</td>';
echo '<td class="reportTableHeader" style="width:10%">' . i18n('colPlannedEndDate') . '</td>';
echo '<td class="reportTableHeader" style="width:10%">' . i18n('colRealEndDate') . '</td>';
echo '<td class="reportTableHeader" style="width:20%">' . htmlEncode($kpi->name) . '</td>';
echo '</tr>';
echo '<tr>';
$arrayProj=array();
foreach($listProjects as $prj) {
  $arrayProj[$prj->id]=$prj->name;
  if (! array_key_exists($prj->id, $visibleProjects)) continue; // Will avoid to display projects not visible to user
  echo '<tr>';
  echo '<td class="reportTableDataSpanned" style="width:20%;text-align:left">' . htmlEncode($prj->name) . '</td>';
  echo '<td class="reportTableDataSpanned" style="width:20%;text-align:left">' . htmlEncode(SqlList::getNameFromId('Client', $prj->idClient)) . '</td>';
  echo '<td class="reportTableDataSpanned" style="width:10%">' . htmlFormatDate($prj->ProjectPlanningElement->validatedStartDate) . '</td>';
  echo '<td class="reportTableDataSpanned" style="width:10%">' . htmlFormatDate($prj->ProjectPlanningElement->validatedEndDate) . '</td>';
  echo '<td class="reportTableDataSpanned" style="width:10%">' . htmlFormatDate($prj->ProjectPlanningElement->plannedEndDate) . '</td>';
  echo '<td class="reportTableDataSpanned" style="width:10%">' . htmlFormatDate($prj->ProjectPlanningElement->realEndDate) . '</td>';
  $critKpi=array('idKpiDefinition'=>$kpi->id,'refType'=>'Project','refId'=>$prj->id);
  if (!$period) {
    $kpiValue=SqlElement::getSingleSqlElementFromCriteria('KpiValue', $critKpi);
  } else {
    $critKpi[$period]=$periodValue;
    $lstKpi=(new KpiHistory())->getSqlElementsFromCriteria($critKpi,false,null,'kpiDate desc');
    $kpiValue=reset($lstKpi);
  }
  if (!$kpiValue) $kpiValue=new KpiValue();
  $color='#ffffff';
  foreach ($thresholds as $th) {
    if ($kpiValue->kpiValue>$th->thresholdValue) {
      $color=$th->thresholdColor;
      break;
    }
  }
  if ($kpiColoFull) {
    echo '<td class="reportTableData" style="width:20%;background-color:'.$color.'">' . (($kpiValue->kpiValue)?htmlDisplayColoredFull($kpiValue->kpiValue, $color):'') . '</td>';
  } else {
    echo '<td class="reportTableDataSpanned" style="width:20%;">' . (($kpiValue->kpiValue)?htmlDisplayColored($kpiValue->kpiValue, $color):'') . '</td>';
  }
  echo '</tr>';
}
echo '</table>';

// Graph
if (! testGraphEnabled()) { return;}

$scale='month';

// constitute query and execute for planned post $end (last real work day)
$h=new KpiHistory();
$hTable=$h->getDatabaseTableName();
$query = "select AVG(prj.valueP) as value, prj.periodP as period";
$query.= " from (select MAX(h.kpiValue) as valueP, h.$scale as periodP, h.refId as idP";
$query.= " from $hTable h";
$query.= " where h.idKpiDefinition=$kpi->id and h.refType='Project' and h.refId in " . transformListIntoInClause($arrayProj);
$query.= " group by h.$scale, h.refId) prj ";
$query.= " group by periodP";

echo  $query;
$result=Sql::query($query);

$end='';
$start='';
$valArray=array();
foreach ($result as $line) {
  if ($end=='' or $line['period']>$end) $end=$line['period'];
  if ($start=='' or $line['period']<$start) $start=$line['period'];
  $arrValues[$line['period']]=$line['value'];
}


if (!$start or !$end) {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n('reportNoData'); 
  echo '</div>';
  exit;
}
$lastValue=VOID;
$arrDates=array();
$date=$start;
while ($date<=$end) {
  if (isset($arrValues[$date])) {
    $lastValue=$arrValues[$date];
  } else {
    $arrValues[$date]=$lastValue;
  }
  $arrDates[$date]=$date;
  if ($scale=='day') {
    $day=substr($date,0,4).'-'.substr($date,4,2).'-'.substr($date,6,2);
    $day=addDaysToDate($day, 1);
    $date=str_replace('-','',$day);
  } else if ($scale=='week') { 
    $week=substr($date,4,2);
    $year=substr($date,0,4);
    $week++;
    if ($week<10) $week='0'.intval($week);
    $lastDay=$year.'-12-31';
    $arrDates[$date]=weekFormat($date); 
  } else if ($scale=='month') { 
    $arrDates[$date]=date('Y-m',strtotime($date));  
  } else if ($scale=='year') { 
    $year=date('Y',strtotime($date));
    $month=date('m',strtotime($date));
    $quarter=1+intval(($month-1)/3);
    $arrDates[$date]=$year.'-Q'.$quarter;  
  }
  else { 
    $arrDates[$date]=$date;
  }
  
}
$resReal=array();
$sumReal=0;
$resPlanned=array();
$sumPlanned=0;
$resBaseline=array();
$sumBaseline=0;
foreach ($arrDates as $date => $period) {
  if (isset($tableReal[$date])) {
    $sumReal+=$tableReal[$date];
  }
  if ($date==$endReal) {
    $sumPlanned=$sumReal;
  }
  if (isset($tablePlanned[$date])) {
    $sumPlanned+=$tablePlanned[$date];
  }
  if (isset($tableBaseline[$date])) {
    $sumBaseline+=$tableBaseline[$date];
  }
  if ($date<$endReal) {
    $resReal[$period]=$sumReal;
    $resPlanned[$period]=VOID;
  } else if ($date==$endReal) {
    $resReal[$period]=$sumReal;
    $resPlanned[$period]=$sumPlanned;
  } else if ($date>$endReal) {
    if (!isset($resReal[$period])) $resReal[$period]=VOID;
    if ($date>$endACWP) {
      if (!isset($resPlanned[$period])) {$resPlanned[$period]=VOID;}
    } else {
      $resPlanned[$period]=$sumPlanned;
    }
  }
  if (($date>$endBCWS)) {
    if (!isset($resBaseline[$period])) {$resBaseline[$period]=VOID;}
  } else {
    $resBaseline[$period]=$sumBaseline;
  }
}
$startDatePeriod=null;
$endDatePeriod=null;
if ($startDateReport and isset($arrDates[$startDateReport])) $startDatePeriod=$arrDates[$startDateReport];
if ($endDateReport and isset($arrDates[$endDateReport])) $endDatePeriod=$arrDates[$endDateReport];

if ($startDatePeriod or $endDatePeriod) {
  foreach ($arrDates as $date => $period) {
    if ( ($startDatePeriod and $period<$startDatePeriod) or ($endDatePeriod and $period>$endDatePeriod) ) {
      unset($arrDates[$date]);
      unset($resReal[$period]);
      unset($resPlanned[$period]);
      unset($resBaseline[$period]);
    }
  }
}

$graphWidth=1200;
$graphHeight=720;
$indexToday=0;

$arrDates=array_flip($arrDates);
$cpt=0;
$modulo=intVal(50*count($arrDates)/$graphWidth);
if ($modulo<0.5) $modulo=0;
foreach ($arrDates as $date => $period) {
  if ($period<$today) $indexToday++;
  if (0 and $cpt % $modulo !=0 ) {
    $arrDates[$date]=VOID;
  } else {
    if ($scale=='day') {
      $arrDates[$date]=htmlFormatDate($date); 
    } else if ($scale=='month') {
      $arrDates[$date]=getMonthName(substr($date,5)).' '.substr($date,0,4);
    } else {
      $arrDates[$date]=$date;
    }
  }
  $cpt++;
}
$arrLabel=array();
foreach($arrDates as $date){
  $arrLabel[]=$date;
}

$maxPlotted=30; // max number of point to get plotted lines. If over lines are not plotted/

$dataSet = new pData();
// Definition of series
$dataSet->addPoints($resReal,"real");
$dataSet->addPoints($resPlanned,"planned");
$dataSet->addPoints($resBaseline,"baseline");
$dataSet->addPoints($arrLabel,"dates");

$dataSet->setSerieOnAxis("real",0);
$dataSet->setSerieOnAxis("planned",0);
$dataSet->setSerieOnAxis("baseline",0);

$dataSet->setAxisName(0,i18n("colWork"). ' ('.i18n(Work::getWorkUnit()).')');
$dataSet->setAxisUnit(0,' '.Work::displayShortWorkUnit().' ');

$dataSet->setSerieDescription("real",i18n("legendACWP")."  ");
$dataSet->setSerieDescription("planned",i18n("legendACWP").' ('.i18n('planned').')  ');
$dataSet->setSerieDescription("baseline",i18n("legendBCWS")."  ");

$dataSet->setAbscissa("dates");

/* Create the pChart object */
$graph = new pImage($graphWidth,$graphHeight,$dataSet);

/* Draw the background */
$graph->Antialias = FALSE;
$Settings = array("R"=>240, "G"=>240, "B"=>240, "Dash"=>0, "DashR"=>0, "DashG"=>0, "DashB"=>0);
$graph->drawFilledRectangle(0,0,$graphWidth,$graphHeight,$Settings);

/* Add a border to the picture */
$graph->drawRectangle(0,0,$graphWidth-1,$graphHeight-1,array("R"=>150,"G"=>150,"B"=>150));

/* Set the default font */
$graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>9,"R"=>100,"G"=>100,"B"=>100));

/* Draw the scale */
$graph->setGraphArea(60,30,$graphWidth-20,$graphHeight-(($scale=='month')?100:75));
$graph->drawFilledRectangle(60,30,$graphWidth-20,$graphHeight-(($scale=='month')?100:75),array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>230));
$formatGrid=array("LabelSkip"=>$modulo, "SkippedAxisAlpha"=>(($modulo>9)?0:20), "SkippedGridTicks"=>0,
    "Mode"=>SCALE_MODE_START0, "GridTicks"=>0, 
    "DrawYLines"=>array(0), "DrawXLines"=>true,"Pos"=>SCALE_POS_LEFTRIGHT, 
    "LabelRotation"=>60, "GridR"=>200,"GridG"=>200,"GridB"=>200);
$graph->drawScale($formatGrid);

$graph->Antialias = TRUE;
$dataSet->setSerieWeight("real",1);
$dataSet->setSerieWeight("planned",1);
$dataSet->setSerieWeight("baseline",1);
$dataSet->setPalette("real",array("R"=>120,"G"=>140,"B"=>250,"Alpha"=>255));
$dataSet->setPalette("planned",array("R"=>180,"G"=>180,"B"=>250,"Alpha"=>50));
$dataSet->setPalette("baseline",array("R"=>250,"G"=>180,"B"=>210,"Alpha"=>255));
$dataSet->setSerieTicks("planned",3);

$dataSet->setSerieDrawable("real",true);
$dataSet->setSerieDrawable("planned",true);
$dataSet->setSerieDrawable("baseline",true);
$graph->drawLineChart();
if (count($arrLabel)<$maxPlotted) {
  $graph->drawPlotChart();
}
if ($showToday) $graph->drawXThreshold(array($indexToday),array("Alpha"=>70,"Ticks"=>0));

if ($legend=="top") {
  $graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>10.8,"R"=>100,"G"=>100,"B"=>100));
  $graph->drawLegend(10,10,array("Mode"=>LEGEND_HORIZONTAL, "Family"=>LEGEND_FAMILY_BOX ,
      "R"=>255,"G"=>255,"B"=>255,"Alpha"=>0,
      "FontR"=>55,"FontG"=>55,"FontB"=>55,
      "Margin"=>0));
  $graph->drawText($graphWidth/2,50,i18n("reportSCurveChart"),array("FontSize"=>14,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
} else {
  $graph->setFontProperties(array("FontName"=>"../external/pChart2/fonts/verdana.ttf","FontSize"=>11,"R"=>100,"G"=>100,"B"=>100));
  $graph->drawLegend(100,50,array("Mode"=>LEGEND_VERTICAL, "Family"=>LEGEND_FAMILY_BOX ,
      "R"=>255,"G"=>255,"B"=>255,"Alpha"=>100,
      "FontR"=>55,"FontG"=>55,"FontB"=>55,
      "Margin"=>5));
  $graph->drawText($graphWidth/2,20,i18n("reportSCurveChart"),array("FontSize"=>14,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
}

$workGap=$sumBaseline-$sumPlanned;
if ($workGap>0) {
  $format=array("R"=>50, "G"=>100, "B"=>50, "Align"=>TEXT_ALIGN_BOTTOMRIGHT, "FontSize"=>'12');
  $title=i18n('legendWorkPositive');
} else {
  $format=array("R"=>100, "G"=>50, "B"=>50, "Align"=>TEXT_ALIGN_BOTTOMRIGHT, "FontSize"=>'12');
  $title=i18n('legendWorkNegative');
}
$title.=" : ".str_replace('&nbsp;',' ',Work::displayWorkWithUnit(abs($workGap)));
$graph->drawText($graphWidth-40,$graphHeight-120,$title,$format);

if ($endACWP>$endBCWS) {
  $delayGap=dayDiffDates($endBCWS, $endACWP);
  $delayGapOpen=workDayDiffDates($endBCWS, $endACWP)-1;
  $format=array("R"=>100, "G"=>50, "B"=>50, "Align"=>TEXT_ALIGN_BOTTOMRIGHT, "FontSize"=>'12');
  $title=i18n('legendDelayNegative');
} else {
  $delayGap=dayDiffDates($endACWP, $endBCWS);
  $delayGapOpen=workDayDiffDates($endACWP, $endBCWS)-1;
  $format=array("R"=>50, "G"=>100, "B"=>50, "Align"=>TEXT_ALIGN_BOTTOMRIGHT, "FontSize"=>'12');
  $title=i18n('legendDelayPositive');
}
$title.=" : ".$delayGap.' '.i18n('days');
$graph->drawText($graphWidth-40,$graphHeight-100,$title,$format);
$title='('.$delayGapOpen.' '.i18n('openDays').')';
$graph->drawText($graphWidth-40,$graphHeight-80,$title,$format);

/* Render the picture (choose the best way) */
$imgName=getGraphImgName("scurvechart");
$graph->Render($imgName);

echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img style="width:1000px;height:600px" src="' . $imgName . '" />'; 
echo '</td></tr></table>';
echo '<br/>';

?>