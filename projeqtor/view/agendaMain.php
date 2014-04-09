<?php 
/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/agendaMain.php');  
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Agenda" />
<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="top" splitter="false" style="height:60px;">
   <?php 
   $period="month";
   $year=date('Y');
   $month=date('m');
   $week="";
   echo "$period $year-$month"; ?>
  </div>
  <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center">
   <?php include 'agenda.php'; ?>
  </div>
</div>