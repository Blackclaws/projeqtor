<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/planningMain.php');  
  
  $listHeight='60%';
  $topDetailDivHeight=Parameter::getUserParameter('contentPaneTopResourcePlanningDivHeight');
  $screenHeight=getSessionValue('screenHeight');
  if ($screenHeight and $topDetailDivHeight>$screenHeight-300) {
    $topDetailDivHeight=$screenHeight-300;
  }
  $listHeight=($topDetailDivHeight)?$topDetailDivHeight.'px':$listHeight;
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="ResourcePlanning" />
<input type="hidden" name="resourcePlanning" id="resourcePlanning" value="true" />
<div id="mainDivContainer" class="container" dojoType="dijit.layout.BorderContainer">
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="top" splitter="true" style="height:<?php echo $listHeight;?>;">
    <script type="dojo/connect" event="resize" args="evt">
         if (switchedMode) return;
             dojo.xhrPost({
               url : "../tool/saveDataToSession.php?saveUserParam=true"
                  +"&idData=contentPaneTopResourcePlanningDivHeight"
                  +"&value="+dojo.byId("listDiv").offsetHeight
             });;
    </script>
   <?php include 'resourcePlanningList.php'?>
  </div>
  <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center">
    <div id="detailBarShow" class="dijitAccordionTitle" onMouseover="hideList('mouse');" onClick="hideList('click');">
      <div id="detailBarIcon" align="center"></div>
    </div>
   <?php $noselect=true; //include 'objectDetail.php'; ?>
  </div>
</div>  