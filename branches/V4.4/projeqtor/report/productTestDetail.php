<?php
include_once '../tool/projeqtor.php';
include_once '../tool/formatter.php';
//echo 'versionReport.php';

$paramProject='';
if (array_key_exists('idProject',$_REQUEST)) {
  $paramProject=trim($_REQUEST['idProject']);
};
  
$paramProduct='';
if (array_key_exists('idProduct',$_REQUEST)) {
  $paramProduct=trim($_REQUEST['idProduct']);
};
$paramVersion='';
if (array_key_exists('idVersion',$_REQUEST)) {
  $paramVersion=trim($_REQUEST['idVersion']);
};

$user=$_SESSION['user'];
  
  // Header
$headerParameters="";
if ($paramProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project', $paramProject)) . '<br/>';
}
if ($paramProduct!="") {
  $headerParameters.= i18n("colIdProduct") . ' : ' . htmlEncode(SqlList::getNameFromId('Product', $paramProduct)) . '<br/>';
}
if ($paramVersion!="") {
  $headerParameters.= i18n("colVersion") . ' : ' . htmlEncode(SqlList::getNameFromId('Version', $paramVersion)) . '<br/>';
}
include "header.php";

$where=getAccesResctictionClause('TestCase',false);

$order="";

if ($paramProject) {
  $lstProject=array($paramProject=>SqlList::getNameFromId('Project',$paramProject));
  $where.=" and idProject=".Sql::fmtId($paramProject);
} else {
  $lstProject=SqlList::getList('Project','name',null,true);
  $lstProject[0]='<i>'.i18n('undefinedValue').'</i>';
}

if ($paramProduct) {
  $lstProduct=array($paramProduct=>SqlList::getNameFromId('Product',$paramProduct));
  $where.=" and idProduct=".Sql::fmtId($paramProduct);
} else {
  $lstProduct=SqlList::getList('Product','name',null,true);
  $lstProduct[0]='<i>'.i18n('undefinedValue').'</i>';
}

if ($paramVersion) {
  $lstVersion=array($paramVersion=>SqlList::getNameFromId('Version',$paramVersion));
  $where.=" and idVersion=".Sql::fmtId($paramVersion);
} else {
  $lstVersion=SqlList::getList('Version','name',null,true);
  $lstVersion[0]='<i>'.i18n('undefinedValue').'</i>';
}

$lstType=SqlList::getList('TestCaseType','name',null,true);

$tc=new TestCase();
$lst=$tc->getSqlElementsFromCriteria(null, false, $where,'idProject, idProduct, idVersion, id');

if (checkNoData($lst)) exit;

echo '<table style="width:' . ((isset($outMode) and $outMode=='pdf')?'90':'95') . '%" align="center">';
echo '<tr>';
echo '<td class="reportTableHeader" style="width:8%"  >' . i18n('colType') . '</td>';
echo '<td class="reportTableHeader" style="width:2%"  >' . i18n('colId') . '</td>';
echo '<td class="reportTableHeader" style="width:20%" >' . i18n('TestCase') . '</td>';
echo '<td class="reportTableHeader" style="width:25%" >' .  i18n('colDescription') . '</td>';
echo '<td class="reportTableHeader" style="width:25%" >' .  i18n('colPrerequisite') . '</td>';
echo '<td class="reportTableHeader" style="width:25%" >' .  i18n('colExpectedResult') . '</td>';
echo '</tr>';
  
$product="";
$project="";
$version="";
foreach ($lst as $tc) {
	if ($tc->idProject!=$project or $tc->idProduct!=$product or $tc->idVersion!=$version) {
		$product=$tc->idProduct;
		$project=$tc->idProject;
		$version=$tc->idVersion;
		echo '<tr>';
		echo '<td class="reportTableHeader" colspan="6" style="width:100%"  >' ;
		echo '<table><tr>';
		echo '<td width="34%">'.i18n('Project').' : '.$lstProject[$tc->idProject].'</td>';
		echo '<td width="33%">'.i18n('Product').' : '.$lstProduct[$tc->idProduct].'</td>';
		echo '<td width="33%">'.i18n('Version').' : '.$lstVersion[$tc->idVersion].'</td>';
		echo '</td>';
	}
  echo '<tr>';
  echo '<td class="reportTableData" style="width:9%">' . (($tc->idTestCaseType)?$lstType[$tc->idTestCaseType]:'') . '</td>';
  echo '<td class="reportTableData" style="width:5%">#' . $tc->id . '</td>';
  echo '<td class="reportTableData" style="text-align:left;width:35%">' . htmlEncode($tc->name) . '</td>';
  echo '<td class="reportTableData" style="width:5%">' . $countTotal . '</td>';
  echo '<td class="reportTableData" style="width:5%">' . $countPlanned . '</td>';
  echo '<td class="reportTableData" style="width:5%;' . (($countPassed and $countPassed==$countTotal)?'color:green;':'') . '">' . $countPassed . '</td>';
  echo '<td class="reportTableData" style="width:5%;' . (($countBlocked)?'color:orange;':'') . '">' . $countBlocked . '</td>';
  echo '<td class="reportTableData" style="width:5%;' . (($countFailed)?'color:red;':'') . '">' . $countFailed . '</td>';
  echo '</tr>';
  $sumTotal+=$countTotal;
  $sumPlanned+=$countPlanned;
  $sumPassed+=$countPassed;
  $sumBlocked+=$countBlocked;
  $sumFailed+=$countFailed;
  $cpt+=1;
  if ($paramDetail) {
  	if (count($lstTcr)>0) {
	  	echo '<tr><td></td><td colspan="10">';
	  	echo '<table style="width:100%">';
	  	echo '<tr>';
	  	echo '<td colspan="2" style="width:45%"></td>';
	  	echo '<td class="largeReportHeader" colspan="2" style="width:40%">' . i18n('TestSession') . '</td>';
	  	echo '<td class="largeReportHeader" colspan="2" style="width:15%">' . i18n('colResult') . '</td>';
	  	echo '</tr>';
        
      foreach ($lstTcr as $tcr) {
        echo '<tr>';
        echo '<td style="width:5%" style="text-align: center;"></td>';
        echo '<td style="width:40%""></td>';
        echo '<td class="largeReportData" style="width:5%" style="text-align: center;">' . (($tcr->idTestSession)?'#':'') . $tcr->idTestSession . '</td>';
        echo '<td class="largeReportData" style="width:35%" >' . (($tcr->idTestSession)?SqlList::getNameFromId('TestSession', $tcr->idTestSession):'') . '</td>';
          $st=new RunStatus($tcr->idRunStatus);
        echo '<td class="largeReportData" style="text-align: left;width:7%" >' . (($tcr->id)?colorNameFormatter(i18n($st->name) . '#split#' . $st->color):'') . '</td>';
        echo '<td class="largeReportData" style="text-align: center;font-size:75%;width:8%" >' . htmlFormatDate($tcr->statusDateTime, true) . '</td>';
        echo '</tr>';
      }
    }
    echo '<tr><td colspan="6" style="font-size:3px;">&nbsp;</td></tr>';
    echo '</table>';
    echo '</td></tr>';
  }
}
echo '<tr>';
echo '<td colspan="6"></td>';
echo '<td class="largeReportHeader" >' . $sumTotal . '</td>';
echo '<td class="largeReportHeader" >' . $sumPlanned . '</td>';
echo '<td class="largeReportHeader" >' . $sumPassed . '</td>';
echo '<td class="largeReportHeader" >' . $sumBlocked . '</td>';
echo '<td class="largeReportHeader" >' . $sumFailed . '</td>';
echo '</tr>';
echo '</table>';
echo '<br/>';
