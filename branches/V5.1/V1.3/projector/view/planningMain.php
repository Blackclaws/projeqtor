<?php 
/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projector.php";
  scriptLog('   ->/view/planningMain.php');  
?>

<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="top" splitter="true" style="height:60%;">
   <?php include 'planningList.php'?>
  </div>
  <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center">
   <?php $noselect=true; //include 'objectDetail.php'; ?>
  </div>
</div>  