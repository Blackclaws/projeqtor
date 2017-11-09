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
  
  $paramVersion = '';
  if (array_key_exists ( 'idVersion', $_REQUEST )) {
    $paramVersion = trim ( $_REQUEST ['idVersion'] );
    $paramVersion = Security::checkValidId ( $paramVersion ); // only allow digits
  }
  ;
  
  if (array_key_exists ( 'nbOfDays', $_REQUEST )) {
    $paramNbOfDays = trim ( $_REQUEST ['nbOfDays'] );
  } else {
    $paramNbOfDays = 30;
  }
  
  $paramPriorities = array();
  if (array_key_exists ( 'priorities', $_REQUEST )) {
    foreach ( $_REQUEST ['priorities'] as $idPriority => $boolean ) {
      $paramPriorities [] = $idPriority;
    }
  }
  
  // Header
  $headerParameters = "";
  $headerParameters = i18n ( "numberOfDays" ) . ' : ' . htmlEncode ( $paramNbOfDays ) . '<br/>';
  
  if ($paramVersion != "") {
    $headerParameters .= i18n ( "colVersion" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Version', $paramVersion ) ) . '<br/>';
  }
  
  if ($paramProject != "") {
    $headerParameters .= i18n ( "colIdProject" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Project', $paramProject ) ) . '<br/>';
  }
  
  if ($paramProduct != "") {
    $headerParameters .= i18n ( "colIdProduct" ) . ' : ' . htmlEncode ( SqlList::getNameFromId ( 'Product', $paramProduct ) ) . '<br/>';
  }
  
  if (! empty ( $paramPriorities )) {
    $priority = new Priority ();
    $priorities = $priority->getSqlElementsFromCriteria ( null, false, null, 'id asc' );
    
    $prioritiesDisplayed = array();
    for($i = 0; $i < count ( $priorities ); $i ++) {
      if (in_array ( $i + 1, $paramPriorities )) {
        $prioritiesDisplayed [] = $priorities [$i];
      }
    }
    
    $headerParameters .= i18n ( "colPriority" ) . ' : ';
    foreach ( $prioritiesDisplayed as $priority ) {
      $headerParameters .= $priority->name . ', ';
    }
    $headerParameters = substr ( $headerParameters, 0, - 2 );
    
    if (in_array ( 'undefined', $paramPriorities )) {
      $headerParameters .= ', ' . i18n ( 'undefinedPriority' );
    }
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

$filterByPriority = false;
if (! empty ( $paramPriorities ) and $paramPriorities [0] != 'undefined') {
  $filterByPriority = true;
  $where .= " and idPriority in (";
  foreach ( $paramPriorities as $idDisplayedPriority ) {
    if ($idDisplayedPriority == 'undefined')
      continue;
    $where .= $idDisplayedPriority . ', ';
  }
  $where = substr ( $where, 0, - 2 ); // To remove the last comma and space
  $where .= ")";
}
if ($filterByPriority and in_array ( 'undefined', $paramPriorities )) {
  $where .= " or idPriority is null";
} else if (in_array ( 'undefined', $paramPriorities )) {
  $where .= " and idPriority is null";
} else if ($filterByPriority) {
  $where .= " and idPriority is not null";
}

$whereClosed = $where . " and idStatus in (";

$lstStatusClosed = SqlList::getListWithCrit ( 'Status', array('setIdleStatus' => '1'), 'id' );
foreach ( $lstStatusClosed as $s ) {
  $whereClosed .= $s . ', ';
}
$whereClosed = substr ( $whereClosed, 0, - 2 ); // To remove the last comma and space
$whereClosed .= ') ';

// Date by number of days in the past
$prevDate = time () - ($paramNbOfDays * 24 * 60 * 60);

$where .= " and creationDateTime>='" . date ( 'Y-m-d', $prevDate ) . "' ";

$order = "";
// echo $where;
$req = new Requirement ();
debugLog ( $where );
$lstReqNew = $req->getSqlElementsFromCriteria ( null, false, $where, $order );
$lstReqclosed = $req->getSqlElementsFromCriteria ( null, false, $whereClosed, $order );

$month = getArrayMonth ( 4, true );

$created = array();
$closed = array();
$arrDays = array();
for($i = 1; $i <= $paramNbOfDays; $i ++) {
  $created [$i] = 0;
  $closed [$i] = 0;
  $arrDays [$i] = '';
  if ($i == 1) {
    $arrDays [1] = $month [date ( 'n', $prevDate ) - 1] . date ( 'Y', $prevDate );
  } else if (date ( 'd', $prevDate + ($i * 24 * 60 * 60) ) == '01' and date ( 'm', $prevDate + ($i * 24 * 60 * 60) ) == '01'){
      $arrDays [$i] = $month [date ( 'n', $prevDate + ($i * 24 * 60 * 60) ) - 1] . date ( 'Y', $prevDate + ($i * 24 * 60 * 60) );
  } else if (date ( 'd', $prevDate + ($i * 24 * 60 * 60) ) == '01') {
    $arrDays [$i] = $month [date ( 'n', $prevDate + ($i * 24 * 60 * 60) ) - 1];
  }
}

foreach ( $lstReqNew as $t ) {
  if (strtotime ( $t->creationDateTime ) > $prevDate) {
    $i = ceil ( (strtotime ( $t->creationDateTime ) - $prevDate) / (24 * 60 * 60) );
    $created [$i] += 1;
    for($j = $i + 1; $j <= $paramNbOfDays; $j ++) {
      $created [$j] += 1;
    }
  }
}

foreach ( $lstReqclosed as $t ) {
  if (strtotime ( $t->idleDate ) > $prevDate) {
    $i = ceil ( (strtotime ( $t->idleDate ) - $prevDate) / (24 * 60 * 60) );
    $closed [$i] += 1;
    for($j = $i + 1; $j <= $paramNbOfDays; $j ++) {
      $closed [$j] += 1;
    }
  }
}

for($i = 1; $i <= $paramNbOfDays; $i ++) {
  if ($created [$i] == 0) {
    $created [$i] = '';
  }
  if ($closed [$i] == 0) {
    $closed [$i] = '';
  }
}

// Render graph
// pGrapg standard inclusions
if (! testGraphEnabled ()) {
  return;
}

$dataSet = new pData ();
$dataSet->AddPoint ( $created, "created" );
$dataSet->SetSerieName ( i18n ( "created" ), "created" );
$dataSet->AddSerie ( "created" );
$dataSet->AddPoint ( $closed, "closed" );
$dataSet->SetSerieName ( i18n ( "closed" ), "closed" );
$dataSet->AddSerie ( "closed" );
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
$graph->drawArea ( $dataSet->GetData (), "created", "closed", 127, 127, 127 );

// Finish the graph
$graph->setFontProperties ( "../external/pChart/Fonts/tahoma.ttf", 10 );
$graph->drawLegend ( $width - 100, 35, $dataSet->GetDataDescription (), 240, 240, 240 );

$graph->drawRightScale ( $dataSet->GetData (), $dataSet->GetDataDescription (), SCALE_START0, 0, 0, 0, true, 0, 1, true );

$imgName = getGraphImgName ( "requirement nb of days" );
$graph->Render ( $imgName );
echo '<table width="95%" align="center"><tr><td align="center">';
echo '<img src="' . $imgName . '" />';
echo '</td></tr></table>';

