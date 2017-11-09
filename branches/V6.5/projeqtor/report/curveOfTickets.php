<?php
/*
 * @author: atrancoso ticket #84
 */
include_once '../tool/projeqtor.php';

if (! isset ( $includedReport )) {
  include ("../external/pChart/pData.class");
  include ("../external/pChart/pChart.class");
  
  $paramProject = '';
  if (array_key_exists ( 'idProject', $_REQUEST )) {
    $paramProject = trim ( $_REQUEST ['idProject'] );
    Security::checkValidId ( $paramProject );
  }
  
  $paramProduct = '';
  if (array_key_exists ( 'idProduct', $_REQUEST )) {
    $paramProduct = trim ( $_REQUEST ['idProduct'] );
    $paramProduct = Security::checkValidId ( $paramProduct ); // only allow digits
  }
  ;
  
  $paramVersion = '';
  if (array_key_exists ( 'idVersion', $_REQUEST )) {
    $paramVersion = trim ( $_REQUEST ['idVersion'] );
    $paramVersion = Security::checkValidId ( $paramVersion ); // only allow digits
  }
  ;
  
  $paramPriority = '';
  if (array_key_exists ( 'idPriority', $_REQUEST )) {
    $paramPriority = trim ( $_REQUEST ['idPriority'] );
    $paramPriority = Security::checkValidId ( $paramPriority ); // only allow digits
  }
  ;
  
  // Header
  $headerParameters = "";
  
  if ($paramVersion != "") {
    $headerParameters .= i18n ( "colVersion" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Version', $paramVersion ) ) . '<br/>';
  }
  
  if ($paramProject != "") {
    $headerParameters .= i18n ( "colIdProject" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Project', $paramProject ) ) . '<br/>';
  }
  
  if ($paramProduct != "") {
    $headerParameters .= i18n ( "colIdProduct" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Product', $paramProduct ) ) . '<br/>';
  }
  
  if ($paramPriority != "") {
    $headerParameters .= i18n ( "colPriority" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Priority', $paramPriority ) ) . '<br/>';
  }
  
  include "header.php";
}

$where = getAccesRestrictionClause ( 'Requirement', false );

if ($paramProject != "") {
  $where .= " and idProject in " . getVisibleProjectsList ( false, $paramProject );
}
if ($paramProduct != "") {
  $where .= " and idProduct=" . Sql::fmtId ( $paramProduct ) . "'";
}
if ($paramVersion != "") {
  $where .= " and idVersion=" . Sql::fmtId ( $paramVersion ) . "'";
}
if ($paramPriority != "") {
  $where .= " and idPriority=" . Sql::fmtId ( $paramPriority ) . "'";
}

$startDate = '';
$endDate = '';
if ($paramVersion != '') {
  $pe = new Version ();
  $pe = SqlElement::getSingleSqlElementFromCriteria ( 'Version', array('id' => $paramVersion) );
  if ((($pe->initialStartDate != '') or ($pe->plannedStartDate != '')) and (($pe->initialEndDate != '') or ($pe->plannedEndDate != ''))) {
    if ($pe->initialStartDate != '') {
      $startDate = $pe->initialStartDate;
    } else {
      $startDate = $pe->plannedStartDate;
    }
    if ($pe->initialEndDate != '') {
      $endDate = $pe->initialEndDate;
    } else {
      $endDate = $pe->plannedEndDate;
    }
  } else {
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n ( 'wrongDate' );
    echo '</div>';
    exit ();
  }
} else if ($paramProject != '') {
  $pe = new PlanningElement ();
  $pe = SqlElement::getSingleSqlElementFromCriteria ( 'PlanningElement', array('refType' => 'Project', 'refId' => $paramProject) );
  if ((($pe->validatedStartDate != '') or ($pe->plannedStartDate != '')) and (($pe->validatedEndDate != '') or ($pe->plannedEndDate != ''))) {
    if ($pe->validatedStartDate != '') {
      $startDate = $pe->validatedStartDate;
    } else {
      $startDate = $pe->plannedStartDate;
    }
    if ($pe->validatedEndDate != '') {
      $endDate = $pe->validatedEndDate;
    } else {
      $endDate = $pe->plannedEndDate;
    }
  } else {
    echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
    echo i18n ( 'wrongDate' );
    echo '</div>';
    exit ();
  }
} else {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n ( 'messageNoData', array(i18n ( 'Project' )) );
  echo i18n ( 'messageNoData', array(i18n ( 'Version' )) );
  echo '</div>';
  exit ();
}
$order = "";
// echo $where;
$ticket = new Ticket ();
$lstTicNew = $ticket->getSqlElementsFromCriteria ( null, false, $where, $order );
$nbTicket = 0;
foreach ( $lstTicNew as $t ) {
  if ($t->creationDateTime != '') {
    $nbTicket = $nbTicket + 1;
  }
}
$start = date_create ( $startDate );
$end = date_create ( $endDate );
$nbDay = $start->diff ( $end )->days;

$perfect = array();
for($i = 1; $i <= $nbDay; $i ++) {
  $perfect [$i] = ((- $nbTicket) / ($nbDay)) * $i + $nbTicket;
}
$created = array();
if ($nbDay != 0) {
  for($i = 1; $i <= $nbDay; $i ++) {
    foreach ( $lstTicNew as $t ) {
      if ($t->idleDateTime != '') {
        $startTicket = strtotime ( $t->idleDateTime );
        if ($startTicket < (strtotime ( $startDate ) + ($i * 24 * 60 * 60)) and $t->idleDateTime != '') {
          $nbTicket = $nbTicket - 1;
          $t->idleDateTime = '';
        }
      }
    }
    $created [$i] = $nbTicket;
  }
} else {
  echo '<div style="background: #FFDDDD;font-size:150%;color:#808080;text-align:center;padding:20px">';
  echo i18n ( 'invalidNbOfDay' );
  echo '</div>';
  exit ();
}
$month = getNbMonth ( 4, true );
$arrDays = array();
for($i = 1; $i <= $nbDay; $i ++) {
  $arrDays [$i] = '';
  if ($i == 1) {
    $arrDays [1] = $month [date ( 'n', strtotime ( $startDate ) ) - 1] . '/' . date ( 'Y', strtotime ( $startDate ) );
  } else if (date ( 'm', strtotime ( $startDate ) + ($i * 24 * 60 * 60) ) == '01' and (date ( 'd', strtotime ( $startDate ) + ($i * 24 * 60 * 60) ) == '01')) {
    $arrDays [$i] = $month [date ( 'n', strtotime ( $startDate ) + ($i * 24 * 60 * 60) ) - 1] . '/' . date ( 'Y', strtotime ( $startDate ) + ($i * 24 * 60 * 60) );
  } else if (date ( 'd', strtotime ( $startDate ) + ($i * 24 * 60 * 60) ) == '01') {
    $arrDays [$i] = $month [date ( 'n', strtotime ( $startDate ) + ($i * 24 * 60 * 60) ) - 1];
  }
}

// Render graph
// pGrapg standard inclusions
if (! testGraphEnabled ()) {
  return;
}

$dataSet = new pData ();
$dataSet->AddPoint ( $created, "created" );
$dataSet->SetSerieName ( i18n ( "ticketLeft" ), "created" );
$dataSet->AddSerie ( "created" );
$dataSet->AddPoint ( $perfect, "perfect" );
$dataSet->SetSerieName ( i18n ( "idealNbofTicket" ), "perfect" );
$dataSet->AddSerie ( "perfect" );
$dataSet->AddPoint ( $arrDays, "days" );
$dataSet->SetAbsciseLabelSerie ( "days" );

// Initialise the graph
$width = 1000;

$graph = new pChart ( $width, 230 );
$graph->setFontProperties ( "../external/pChart/Fonts/tahoma.ttf", 10 );
$graph->setColorPalette ( 0, 200, 100, 100 );
$graph->setColorPalette ( 1, 100, 200, 100 );
$graph->setColorPalette ( 2, 100, 100, 200 );
$graph->setColorPalette ( 3, 200, 100, 100 );
$graph->setColorPalette ( 4, 100, 200, 100 );
$graph->setColorPalette ( 5, 100, 100, 200 );
$graph->setGraphArea ( 40, 30, $width - 140, 200 );
$graph->drawGraphArea ( 252, 252, 252 );
$graph->setFontProperties ( "../external/pChart/Fonts/tahoma.ttf", 10 );
$graph->drawScale ( $dataSet->GetData (), $dataSet->GetDataDescription (), SCALE_START0, 0, 0, 0, TRUE, 0, 1, true );
$graph->drawGrid ( 0, TRUE, 230, 230, 230, 255 );

// Draw the line graph
$graph->drawLineGraph ( $dataSet->GetData (), $dataSet->GetDataDescription () );
$graph->drawPlotGraph ( $dataSet->GetData (), $dataSet->GetDataDescription (), 3, 2, 255, 255, 255 );

// Draw the area between points
$graph->drawArea ( $dataSet->GetData (), "created", "perfect", 127, 127, 127 );

// Finish the graph
$graph->setFontProperties ( "../external/pChart/Fonts/tahoma.ttf", 10 );
$graph->drawLegend ( $width - 100, 35, $dataSet->GetDataDescription (), 240, 240, 240 );

$graph->drawRightScale ( $dataSet->GetData (), $dataSet->GetDataDescription (), SCALE_START0, 0, 0, 0, true, 0, 1, true );

$imgName = getGraphImgName ( "Curve Of Tickets" );
$graph->Render ( $imgName );
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />';
echo '</td></tr></table>';
