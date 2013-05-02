<?php
/* ============================================================================
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projector.php";
scriptLog('   ->/view/planningPrint.php');
?>
  <div style="border: 2px solid blue;position:relative; overflow:hidden;" class="ganttDiv" 
    id="leftGanttChartDIV_print" name="leftGanttChartDIV_print">
  </div>
  <div style="border: 2px solid blue; height:100%; overflow:hidden;" class="ganttDiv" 
    id="GanttChartDIV_print" name="GanttChartDIV_print" >
    <div style="width:100%; height:43px; overflow:hidden;" class="ganttDiv"
      id="topGanttChartDIV_print" name="topGanttChartDIV_print">
    </div>
    <div style="z-index:-4; width:100%; overflow-x:scroll; overflow-y:scroll; position: relative; top:-10px;" class="ganttDiv"
      id="rightGanttChartDIV_print" name="rightGanttChartDIV_print">
    </div>
  </div>