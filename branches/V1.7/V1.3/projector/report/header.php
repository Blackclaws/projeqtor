<?php 
// Header
echo "<table width='100%'><tr>";
echo "<td width='1%' class='reportHeader'>&nbsp;</td>";
echo "<td width='5%' class='reportHeader'>" . i18n('colParameters') . "</td>";
echo "<td width='1%' class='reportHeader'>&nbsp;</td>";
echo "<td width='1%' >&nbsp;</td>";
echo "<td width='35%'>"; 
echo $headerParameters;
echo "</td>";
echo "<td width='40%' align='center' style='font-size: 150%; font-weight: bold;'>"; 
if (array_key_exists('reportName', $_REQUEST)) {
  echo '<table><tr><td style="text-align: center; background-color: #E0E0E0; padding: 3px 10px 3px 10px;">';
  echo ucfirst($_REQUEST['reportName']);
  echo '</td></tr></table>';
}
echo "</td>";
echo "<td width='1%'>&nbsp;</td>";
echo "<td width='15%'align='right'>";
echo  htmlFormatDate(date('Y-m-d')) . " " . date('H:i');
echo "</td>";
echo "<td width='1%'>&nbsp;</td>";
echo "</tr></table>";
echo "<br/>";

$graphEnabled=true;
if (! function_exists('ImagePng')) {
  $graphEnabled=false;
  debugLog("GD Library not enabled - impossible to draw charts");
}
function getGraphImgName($root) {
  global $reportCount;
  //$user=$_SESSION['user'];
  $reportCount+=1;
  $name="../report/temp/user" . getCurrentUserId() . "_";
  $name.=$root . "_";
  $name.=date("Ymd_His") . "_";
  $name.=$reportCount;
  $name.=".png";  
  return $name;
}

function testGraphEnabled() {
  global $graphEnabled;
  if ($graphEnabled) {
    return true;
  } else {
    //echo '<table width="95%" align="center"><tr><td align="center">';
    //echo '<img src="../view/img/GDnotEnabled.png" />'; 
    //echo '</td></tr></table>';
    return false;
  }  
}

function checkNoData($result) {
  if (count($result)==0) {
    echo '<table width="95%" align="center"><tr height="50px"><td width="100%" align="center">';
    echo i18n('reportNoData');
    echo '</td></tr></table>';
    return true;
  }
  return false;
}
?>
