<?php
include_once '../tool/projector.php';

if (! isset($includedReport)) {
  include("../external/pChart/pData.class");  
  include("../external/pChart/pChart.class");  
  
  $paramYear='';
  if (array_key_exists('yearSpinner',$_REQUEST)) {
    $paramYear=$_REQUEST['yearSpinner'];
  }
  
  $paramMonth='';
  if (array_key_exists('monthSpinner',$_REQUEST)) {
    $paramMonth=$_REQUEST['monthSpinner'];
  }
  
  $paramWeek='';
  if (array_key_exists('weekSpinner',$_REQUEST)) {
    $paramWeek=$_REQUEST['weekSpinner'];
  }
  
  $paramProject='';
  if (array_key_exists('idProject',$_REQUEST)) {
    $paramProject=trim($_REQUEST['idProject']);
  }
  
  $paramTicketType='';
  if (array_key_exists('idTicketType',$_REQUEST)) {
    $paramTicketType=trim($_REQUEST['idTicketType']);
  }
  
  $paramIssuer='';
  if (array_key_exists('issuer',$_REQUEST)) {
    $paramIssuer=trim($_REQUEST['issuer']);
  }
  
  $paramResponsible='';
  if (array_key_exists('responsible',$_REQUEST)) {
    $paramResponsible=trim($_REQUEST['responsible']);
  }
  
  $user=$_SESSION['user'];
  $lstProj=$user->getVisibleProjects();
  
  $periodType="";
  $periodValue="";
  if (array_key_exists('periodType',$_REQUEST)) {
    $periodType=$_REQUEST['periodType'];
    $periodValue=$_REQUEST['periodValue'];
  }
  
  // Header
  $headerParameters="";
  if ($paramProject!="") {
    $headerParameters.= i18n("colIdProject") . ' : ' . SqlList::getNameFromId('Project', $paramProject) . '<br/>';
  }
  if ($periodType=='year' or $periodType=='month' or $periodType=='week') {
    $headerParameters.= i18n("year") . ' : ' . $paramYear . '<br/>';  
  }
  if ($periodType=='month') {
    $headerParameters.= i18n("month") . ' : ' . $paramMonth . '<br/>';
  }
  if ( $periodType=='week') {
    $headerParameters.= i18n("week") . ' : ' . $paramWeek . '<br/>';
  }
  if ($paramTicketType!="") {
    $headerParameters.= i18n("colIdTicketType") . ' : ' . SqlList::getNameFromId('TicketType', $paramTicketType) . '<br/>';
  }
  if ($paramIssuer!="") {
    $headerParameters.= i18n("colIssuer") . ' : ' . SqlList::getNameFromId('User', $paramIssuer) . '<br/>';
  }
  if ($paramResponsible!="") {
    $headerParameters.= i18n("colResponsible") . ' : ' . SqlList::getNameFromId('Resource', $paramResponsible) . '<br/>';
  }
  include "header.php";
}

$where="idProject in " . transformListIntoInClause($user->getVisibleProjects());
if ($periodType) {
  $start=date('Y-m-d');
  $end=date('Y-m-d');
  if ($periodType=='year') {
    $start=$paramYear . '-01-01';
    $end=$paramYear . '-12-31';
  } else if ($periodType=='month') {
    $start=$paramYear . '-' . (($paramMonth<10)?'0':'') . $paramMonth . '-01';
    $end=$paramYear . '-' . (($paramMonth<10)?'0':'') . $paramMonth . '-' . date('t',mktime(0,0,0,$paramMonth,1,$paramYear));  
  } if ($periodType=='week') {
    $start=date('Y-m-d', firstDayofWeek($paramWeek, $paramYear));
    $end=addDaysToDate($start,6);
  }
  //echo $start . ' - ' . $end . '<br/>';
  $where.=" and (  creationDateTime>= '" . $start . "'";
  $where.="        and creationDateTime<='" . $end . "' )";
  //$where.="    or (    doneDateTime>= '" . $start . "'";
  //$where.="        and doneDateTime<='" . $end . "' )";
  //$where.="    or (    idleDateTime>= '" . $start . "'";
  //$where.="        and idleDateTime<='" . $end . "') )";
}
if ($paramProject!="") {
  $where.=" and idProject='" . $paramProject . "'";
}
if ($paramTicketType!="") {
  $where.=" and idTicketType='" . $paramTicketType . "'";
}
if ($paramIssuer!="") {
  $where.=" and idUser='" . $paramIssuer . "'";
}
if ($paramResponsible!="") {
  $where.=" and idResource='" . $paramResponsible . "'";
}
$order="";
//echo $where;
$ticket=new Ticket();
$lstTicket=$ticket->getSqlElementsFromCriteria(null,false, $where, $order);

$lstUrgency=array();
$lstCriticality=array();
$lstPriority=array();
$lstType=array();
$lstIssuer=array();
$lstResponsible=array();

foreach ($lstTicket as $t) {
  $urgency=($t->idUrgency==null or trim($t->idUrgency)=='')?'0':$t->idUrgency;
  $criticality=($t->idCriticality==null or trim($t->idCriticality)=='')?'0':$t->idCriticality;
  $priority=($t->idPriority==null or trim($t->idPriority)=='')?'0':$t->idPriority;
  $type=$t->idTicketType;
  $issuer=$t->idUser;
  $responsible=($t->idResource==null or trim($t->idResource)=='')?'0':$t->idResource;
  //urgency
  if (! array_key_exists($urgency, $lstUrgency)) {
    $lstUrgency[$urgency]=0;
  }
  $lstUrgency[$urgency]+=1;
  //criticality
  if (! array_key_exists($criticality, $lstCriticality)) {
    $lstCriticality[$criticality]=0;
  }
  $lstCriticality[$criticality]+=1;
  //priority
  if (! array_key_exists($priority, $lstPriority)) {
    $lstPriority[$priority]=0;
  }
  $lstPriority[$priority]+=1;
  //type
  if (! array_key_exists($type, $lstType)) {
    $lstType[$type]=0;
  }
  $lstType[$type]+=1;
  //issuer
  if (! array_key_exists($issuer, $lstIssuer)) {
    $lstIssuer[$issuer]=0;
  }
  $lstIssuer[$issuer]+=1;
  //responsible
  if (! array_key_exists($responsible, $lstResponsible)) {
    $lstResponsible[$responsible]=0;
  }
  $lstResponsible[$responsible]+=1;
}

if (checkNoData($lstTicket)) exit;

echo '<table width="95%" align="center">';
echo '<tr>';
echo '<td class="section" style="width:49%">' . i18n('TicketType') . '</td>';
echo '<td style="width:2%">&nbsp;</td>';
echo '<td class="section" style="width:49%">' . i18n('Urgency') . '</td>';
echo '<tr><td valign="top">';
drawSynthesisTable('TicketType', $lstType); 
echo '</td><td></td><td valign="top">';
drawSynthesisTable('Urgency', $lstUrgency);  
echo '</td></tr>';
echo '</tr>';
echo '<tr><td colspan="3">&nbsp;</td></tr>';
echo '<tr>';
echo '<td class="section" style="width:49%">' . i18n('Priority') . '</td>';
echo '<td style="width:2%">&nbsp;</td>';
echo '<td class="section" style="width:49%">' . i18n('Criticality') . '</td>';
echo '<tr><td valign="top">';
drawSynthesisTable('Priority',$lstPriority); 
echo '</td><td></td><td valign="top">';
drawSynthesisTable('Criticality', $lstCriticality);  
echo '</td></tr>';
echo '</tr>';
echo '<tr><td colspan="3">&nbsp;</td></tr>';
echo '<tr>';
echo '<td class="section" style="width:49%">' . i18n('colIssuer') . '</td>';
echo '<td style="width:2%">&nbsp;</td>';
echo '<td class="section" style="width:49%">' . i18n('colResponsible') . '</td>';
echo '<tr><td valign="top">';
drawSynthesisTable('User',$lstIssuer); 
echo '</td><td></td><td valign="top">';
drawSynthesisTable('Resource', $lstResponsible);  
echo '</td></tr>';
echo '</tr>';
echo '</table>';

function drawSynthesisTable($scope, $lst) {
  echo '<table valign="top" width="100%"><tr>';
  echo '<td width="50%" valign="top"><table width="100%" valign="top">';
  $lstRef=SqlList::getList($scope,'name',false,true);
  if (array_key_exists('0', $lst)) {
    echo '<tr><td class="reportTableHeader" width="80%">';
    echo '<i>'.i18n('undefined').'</i>';
    echo '</td><td class="reportTableData reportTableDataCenter" width="20%">' . $lst['0'] . '</td></tr>'; 
  }
  foreach ($lstRef as $code=>$val) {
    if (array_key_exists($code, $lst)) {
      echo '<tr><td class="reportTableHeader" width="80%">';
      echo $val;
      echo '</td><td class="reportTableData reportTableDataCenter" width="20%">' . $lst[$code] . '</td></tr>'; 
    }
  }
  echo '</td></table>';
  echo '<td width="50%">';
  drawsynthesisGraph($scope, $lst);
  echo '</td>';
  echo "</tr></table>";
}

function drawsynthesisGraph($scope, $lst) {
  if (! testGraphEnabled()) { return;}
  if (count($lst)==0) { return;}  
  $valArr=array();
  $legArr=array();
  $lstRef=SqlList::getList($scope,'name',false,true);
  if (array_key_exists('0', $lst)) {
    $legArr[]=i18n('undefined');
    $valArr[]=$lst['0'];
  }
  foreach ($lstRef as $code=>$val) {
    if (array_key_exists($code, $lst)) {
      $valArr[]=$lst[$code];
      $legArr[]=$val;
    }
  }
  $dataSet=new pData;
  $dataSet->AddPoint($valArr,$scope); 
  $dataSet->SetSerieName(i18n($scope),$scope);  
  $dataSet->AddSerie($scope);
  $dataSet->AddPoint($legArr,"legend");  
  $dataSet->SetAbsciseLabelSerie("legend"); 
  
  // Initialise the graph  
  $graph = new pChart(220,110);
  //$graph->drawRoundedRectangle(2,2,196,96,2,230,230,230);    
  $graph->setFontProperties("../external/pChart/Fonts/tahoma.ttf",8);
    
  $graph->drawPieGraph($dataSet->GetData(),$dataSet->GetDataDescription(),52,50,50,PIE_NOLABEL,TRUE,80,10,0);
  //$graph->drawFlatPieGraph($dataSet->GetData(),$dataSet->GetDataDescription(),52,52,50,PIE_NOLABEL,0);
  //$graph->clearShadow();
  $graph->SetShadowProperties(0,0,255,255,255); 
  $graph->drawPieLegend(110,10,$dataSet->GetData(),$dataSet->GetDataDescription(),240,240,240);  
  $imgName=getGraphImgName("ticketYearlyReport");
  
  $graph->Render($imgName);
  echo '<table width="95%" align="center"><tr><td align="center">';
  echo '<img src="' . $imgName . '" />'; 
  echo '</td></tr></table>';
}
