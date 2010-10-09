<?php
include_once '../tool/projector.php';
$paramYear='';
if (array_key_exists('yearSpinner',$_REQUEST)) {
  $paramYear=$_REQUEST['yearSpinner'];
};

$paramMonth='';
if (array_key_exists('monthSpinner',$_REQUEST)) {
  $paramMonth=$_REQUEST['monthSpinner'];
};

$paramWeek='';
if (array_key_exists('weekSpinner',$_REQUEST)) {
  $paramWeek=$_REQUEST['weekSpinner'];
};

$paramProject='';
if (array_key_exists('idProject',$_REQUEST)) {
  $paramProject=trim($_REQUEST['idProject']);
};

$paramTicketType='';
if (array_key_exists('idTicketType',$_REQUEST)) {
  $paramTicketType=trim($_REQUEST['idTicketType']);
};

$paramIssuer='';
if (array_key_exists('issuer',$_REQUEST)) {
  $paramIssuer=trim($_REQUEST['issuer']);
};

$paramResponsible='';
if (array_key_exists('responsible',$_REQUEST)) {
  $paramResponsible=trim($_REQUEST['responsible']);
};

$user=$_SESSION['user'];
$lstProj=$user->getVisibleProjects();

$periodType='year';
//$periodValue=$_REQUEST['periodValue'];
$periodValue=$paramYear;

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

$where="idProject in " . transformListIntoInClause($user->getVisibleProjects());

$where.=" and ( (    creationDateTime>= '" . $paramYear . "-01-01'";
$where.="        and creationDateTime<='" . $paramYear . "-12-31' )";
$where.="    or (    doneDateTime>= '" . $paramYear . "-01-01'";
$where.="        and doneDateTime<='" . $paramYear . "-12-31' )";
$where.="    or (    idleDateTime>= '" . $paramYear . "-01-01'";
$where.="        and idleDateTime<='" . $paramYear . "-12-31' ) )";
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
$created=array();
$done=array();
$closed=array();
for ($i=1; $i<=13; $i++) {
  $created[$i]=0;
  $done[$i]=0;
  $closed[$i]=0;
}
$sumProj=array();
foreach ($lstTicket as $t) {
  if (substr($t->creationDateTime,0,4)==$paramYear) {
    $month=intval(substr($t->creationDateTime,5,2));
    $created[$month]+=1;
    $created[13]+=1;
  }
  if (substr($t->doneDateTime,0,4)==$paramYear) {
    $month=intval(substr($t->doneDateTime,5,2));
    $done[$month]+=1;
    $done[13]+=1;
  }
  if (substr($t->idleDateTime,0,4)==$paramYear) {
    $month=intval(substr($t->idleDateTime,5,2));
    $closed[$month]+=1;
    $closed[13]+=1;
  }
}
// title
echo '<table width="95%" align="center">';
echo '<tr><td class="reportTableHeader" rowspan="2">' . i18n('Ticket') . '</td>';
echo '<td colspan="13" class="reportTableHeader">' . $periodValue . '</td>';
echo '</tr><tr>';
for ($i=1; $i<=12; $i++) {
  echo '<td class="reportTableColumnHeader">' . (($i<10)?'0':'') . $i . '</td>';
}
echo '<td class="reportTableHeader" >' . i18n('sum') . '</td>';
echo '</tr>';

$sum=0;
for ($line=1; $line<=3; $line++) {
  if ($line==1) {
    $tab=$created;
    $caption=i18n('created');
  } else if ($line==2) {
    $tab=$done;
    $caption=i18n('done');
  } else if ($line==3) {
    $tab=$closed;
    $caption=i18n('closed');
  }
  echo '<tr><td class="reportTableLineHeader">' . $caption . '</td>';
  foreach ($tab as $id=>$val) {
    if ($id=='13') {
      echo '<td class="reportTableColumnHeader">';
    } else {
      echo '<td class="reportTableData reportTableDataCenter">';
    }
    echo $val;
    echo '</td>';
  }
  
  echo '</tr>';
}
echo '</table>';