<?php
/* ============================================================================
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projector.php";
scriptLog('   ->/view/objectList.php');

$objectClass=$_REQUEST['objectClass'];
$objectType='';
if (array_key_exists('objectType',$_REQUEST)) {
  $objectType=$_REQUEST['objectType'];
}
$obj=new $objectClass;
?>
<div dojoType="dojo.data.ItemFileReadStore" id="objectStore" jsId="objectStore" clearOnClose="true"
  url="../tool/jsonQuery.php?objectClass=<?php echo $objectClass;?>" >
</div>
  
<div dojoType="dijit.layout.BorderContainer">
<div dojoType="dijit.layout.ContentPane" region="top" id="listHeaderDiv">
<table width="100%" height="27px" class="dojoxGridRowSelected" >
  <tr height="27px">
    <td width="50px" align="center">
      <span style="position:absolute; left:+5px; top: 0px"><img src="css/images/icon<?php echo $objectClass;?>22.png" width="22" height="22" /></span>
      <span style="position:absolute; left:+10px; top: 5px"><img src="css/images/icon<?php echo $objectClass;?>22.png" width="22" height="22" /></span>
    </td>
    <td><span class="title"><?php echo i18n("menu" . $objectClass);?></span></td>
    <td>   
      <form dojoType="dijit.form.Form" id="listForm" action="" method="" >
        <table style="width: 100%;">
          <tr>
            <td>
              <input type="hidden" id="objectClass" name="objectClass" value="<?php echo $objectClass;?>" /> 
              <input type="hidden" id="objectId" name="objectId" value="" />
              &nbsp;&nbsp;
              <?php echo i18n("colId");?> 
              <div title="<?php echo i18n('filterOnId')?>" style="width:50px" class="filterField" dojoType="dijit.form.TextBox" 
               type="text" id="listIdFilter" name="listIdFilter">
                <script type="dojo/method" event="onKeyUp" >
                  filterJsonList() ;
                </script>
              </div>
              <?php if ( property_exists($obj,'name')) { ?>
                &nbsp;&nbsp;&nbsp;
                <?php echo i18n("colName");?>
                <div title="<?php echo i18n('filterOnName')?>" type="text" class="filterField" dojoType="dijit.form.TextBox" 
                id="listNameFilter" name="listNameFilter">
                  <script type="dojo/method" event="onKeyUp" >
                  filterJsonList() ;
                </script>
                </div>
              <?php }?>
              &nbsp;&nbsp;&nbsp;
              <?php if ( property_exists($obj,'id' . $objectClass . 'Type') ) { 
                echo i18n("colType");
              ?>
                <select title="<?php echo i18n('filterOnType')?>" type="text" class="filterField" dojoType="dijit.form.FilteringSelect" 
                id="listTypeFilter" name="listTypeFilter">
                  <?php htmlDrawOptionForReference('id' . $objectClass . 'Type', $objectType, $obj, false); ?>
                  <script type="dojo/method" event="onChange" >
                    refreshJsonList('<?php echo $objectClass;?>');
                  </script>
                </select>
              <?php }?>
              &nbsp;&nbsp;&nbsp;
              <?php echo i18n("colFilter");?>
              <?php $activeFilter=false;
                 if (is_array($_SESSION['user']->_arrayFilters)) {
                   if (array_key_exists($objectClass, $_SESSION['user']->_arrayFilters)) {
                     if (count($_SESSION['user']->_arrayFilters[$objectClass])>0) {
                       $activeFilter=true;
                     }
                   }
                 }
                 ?>
              <button title="<?php echo i18n('advancedFilter')?>" style="width:10px" class="filterField" 
               dojoType="dijit.form.Button" 
               id="listFilterFilter" name="listFilterFilter"
               iconClass="icon<?php echo($activeFilter)?'Active':'';?>Filter16" showLabel="false">
                <script type="dojo/connect" event="onClick" args="evt">
                  showFilter();
                </script>
              </button>
              <span id="gridRowCountShadow1" class="gridRowCountShadow1"></span>
              <span id="gridRowCountShadow2" class="gridRowCountShadow2"></span>              
              <span id="gridRowCount" class="gridRowCount"></span>             
              <input type="hidden" id="listFilterClause" name="listFilterClause" value="" style="width: 50px;" />
            </td>
            <td style="width: 200px;text-align: right; align: right;">
              <?php echo i18n("labelShowIdle");?>
              <div title="<?php echo i18n('showIdleElements')?>" dojoType="dijit.form.CheckBox" type="checkbox" id="listShowIdle" name="listShowIdle">
                <script type="dojo/method" event="onChange" >
                  refreshJsonList('<?php echo $objectClass;?>');
                </script>
              </div>&nbsp;
            </td>
          </tr>
        </table>    
      </form>
    </td>
  </tr>
</table>
</div>
<div dojoType="dijit.layout.ContentPane" region="center" id="gridContainerDiv">
<table id="objectGrid" jsId="objectGrid" dojoType="dojox.grid.DataGrid"
  query="{ id: '*' }" store="objectStore"
  queryOptions="{ignoreCase:true}" 
  rowPerPage="<?php echo $paramRowPerPage;?>"
  columnReordering="true"
  selectionMode="single" >
  <thead>
    <tr>
      <?php echo $obj->getLayout();?>
    </tr>
  </thead>
  <script type="dojo/connect" event="onSelected" args="evt">
	actionYes = function () {
      rows=objectGrid.selection.getSelected();
      row=rows[0]; 
      var id = row.id;
	  dojo.byId('objectId').value=id;
	  //cleanContent("detailDiv");
      formChangeInProgress=false; 
      loadContent("objectDetail.php", "detailDiv", 'listForm');
   	}
    actionNo = function () {
	  unselectAllRows("objectGrid");
    }
    if (checkFormChangeInProgress(actionYes, actionNo)) {
      return true;
    }
  </script>
</table>
</div>
</div>
