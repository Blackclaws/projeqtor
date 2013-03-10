<?php
include_once '../tool/projector.php';
//echo "detailPlan.php";
$paramYear='';
if (array_key_exists('yearSpinner',$_REQUEST)) {
  $paramYear=$_REQUEST['yearSpinner'];
};
$paramMonth='';
if (array_key_exists('monthSpinner',$_REQUEST)) {
  $paramMonth=$_REQUEST['monthSpinner'];
};
//$paramWeek='';
//if (array_key_exists('weekSpinner',$_REQUEST)) {
//  $paramWeek=$_REQUEST['weekSpinner'];
//};

$user=$_SESSION['user'];

$periodType='month';
$periodValue=$_REQUEST['periodValue'];

// Header
$headerParameters="";
if ($periodType=='year' or $periodType=='month' or $periodType=='week') {
  $headerParameters.= i18n("year") . ' : ' . $paramYear . '<br/>';
}
if ($periodType=='month') {
  $headerParameters.= i18n("month") . ' : ' . $paramMonth . '<br/>';
}
//if ( $periodType=='week') {
//  $headerParameters.= i18n("week") . ' : ' . $paramWeek . '<br/>';
//}

include "header.php";

$crit="auditDay like '" . $periodValue . "%'";

$as=new AuditSummary();
$result=$as->getSqlElementsFromCriteria(null, false, $crit);

if (checkNoData($result)) exit;
$days=array();
for ($i=1;$i<=31;$i++) {
  $nb[$i]=0;
  $days[$i]=$i;
}
//$day=array();
foreach ($result as $as) {
	$nb[intval(substr($as->auditDay,6))]=$as->numberSessions;
}


// Graph
if (! testGraphEnabled()) { echo "pChart not enabled. See log file."; return;}
include("../external/pChart/pData.class");  
include("../external/pChart/pChart.class");  
/*
  
//$dataSet->AddPoint($arrLabel,"dates");   


//for ($i=0;$i<=$nbItem;$i++) {
//  $graph->setColorPalette($i,$rgbPalette[($i % 12)]['R'],$rgbPalette[($i % 12)]['G'],$rgbPalette[($i % 12)]['B']);
//}
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",10);
$graph->drawRoundedRectangle(5,5,$width-5,258,5,230,230,230);  
$graph->setGraphArea(40,30,$width-200,200);  
$graph->drawGraphArea(252,252,252);  
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);  
$graph->drawRightScale($dataSet->GetData(),$dataSet->GetDataDescription(),SCALE_START0,0,0,0,true,90,1, true);
$graph->drawGrid(5,TRUE,230,230,230,255);  
$graph->drawLineGraph($dataSet->GetData(),$dataSet->GetDataDescription());  
$graph->drawPlotGraph($dataSet->GetData(),$dataSet->GetDataDescription(),3,2,255,255,255);  
*/
$DataSet = new pData;  
$DataSet->AddPoint($nb,'Serie1');
$DataSet->AddSerie('Serie1');  
$DataSet->SetSerieName("Connexions","Serie1");  
$DataSet->AddPoint($days,'Serie2');
//$DataSet->AddSerie('Serie2');  

$DataSet->SetAbsciseLabelSerie("Serie2");  
// Initialise the graph  
$width=700;
$graph = new pChart($width,260);  
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",10);
$graph->drawRoundedRectangle(5,5,$width-5,258,5,230,230,230);  
$graph->setGraphArea(40,30,$width-30,230);  
$graph->drawGraphArea(252,252,252);  

$graph->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);  
$graph->drawGrid(4,TRUE,230,230,230,255);  
  
// Draw the line graph  
$graph->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());  
$graph->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);  
  
// Finish the graph  
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",10); 
//$graph->drawLegend(45,35,$DataSet->GetDataDescription(),255,255,255);  
$graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",10);
$graph->drawTitle(60,22,i18n('connectionsNumberPerDay'),50,50,50,585);  
$graph->Render("Naked.png");  
$imgName=getGraphImgName("audit");
$graph->Render($imgName);
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />'; 
echo '</td></tr></table>';
echo '<br/>';
?>

