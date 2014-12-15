<?php 
// Header
echo "<table width='100%'><tr>";
echo "<td width='2%' class='reportHeader'>&nbsp;</td>";
echo "<td width='5%' class='reportHeader'>" . i18n('colParameters') . "</td>";
echo "<td width='2%' class='reportHeader'>&nbsp;</td>";
echo "<td width='2%' >&nbsp;</td>";
echo "<td width='45%'>"; 
echo $headerParameters;
echo "<td width='2%'>&nbsp;</td>";
echo "</td><td align='right'>";
echo  htmlFormatDate(date('Y-m-d')) . " " . date('H:i');
echo "</td>";
echo "<td width='2%'>&nbsp;</td>";
echo "</tr></table>";
echo "<br/>";
?>
