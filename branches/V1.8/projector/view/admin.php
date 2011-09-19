<?php
/* ============================================================================
 * List of parameter specific to a user.
 * Every user may change these parameters (for his own user only !).
 */
  require_once "../tool/projector.php";
  scriptLog('   ->/view/parameter.php');
  

  $user=$_SESSION['user'];
      
?>
<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="adminButtonDiv" class="listTitle" dojoType="dijit.layout.ContentPane" region="top">
    <table width="100%">
      <tr>
        <td width="50px" align="center">
          <img src="css/images/iconAdmin32.png" width="32" height="32" />
        </td>
        <td NOWRAP width="50px" class="title" >
          <?php echo i18n("menuAdmin");?>&nbsp;&nbsp;&nbsp;        
        </td>
        <td width="10px" >&nbsp;
        </td>
        <td width="50px"> 
        </td>
        <td>
           <div id="resultDiv" dojoType="dijit.layout.ContentPane" region="center" >
           </div>       
        </td>
      </tr>
    </table>
  </div>
  <div id="formAdminDiv" dojoType="dijit.layout.ContentPane" region="center"> 
    <form dojoType="dijit.form.Form" id="adminForm" jsId="adminForm" name="adminForm" encType="multipart/form-data" action="" method="" >
      <table style="width:98%;margin:10px;padding:10px;vertical-align:top;">
        <tr style="">
          <td style="width:49%;vertical-align:top;">
            <table style="width:100%;">
              <tr>
                <td width="100%" colspan="2" class="section"><?php echo i18n('cronTasks');?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label adminLabel"><?php echo i18n("alertCronStatus"). " : ";?></td>
                <td class="display"> &nbsp;&nbsp;
                  <?php if (file_exists('../files/cron/RUNNING')) {
                  	$cronStatus='running';
                  } else {
                  	$cronStatus='stopped';
                  }
                  echo i18n($cronStatus);
                  ?>
                  &nbsp;&nbsp;
                  <button id="alertRunStop" dojoType="dijit.form.Button" showlabel="true">
                    <?php echo ($cronStatus=='stopped')?i18n('run'):i18n('stop'); ?>
                   <script type="dojo/connect" event="onClick" args="evt">                 
                  <?php if ($cronStatus=='stopped') {
                  	echo 'showWait();adminLaunchScript("cronRun");';
                  	echo 'disableWidget("alertRunStop");';
                  } else {
                  	echo 'showWait();adminLaunchScript("cronStop");';
                  	echo 'disableWidget("alertRunStop");';  
                  }
                  ?> 
                   </script>
                 </button>
                </td>
            </table> 
          </td>
          <td width="10px">&nbsp;</td>
          <td style="width:49%;vertical-align:top;">
            <table style="width:100%;">
              <tr>
                <td width="100%" colspan="2" class="section"><?php echo i18n('dbMaintenance');?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label adminLabel">
                  <?php echo i18n("closeEmails"). " : ";?>
                </td>
                <td class="display adminLabel">&nbsp;&nbsp;
                  <?php echo i18n('sendSinceMore');?>&nbsp;&nbsp;
                  <input type="text" style="width:50px" />
                  <button id="closeEmails" dojoType="dijit.form.Button" showlabel="true">
                    <?php echo i18n('stop'); ?>
                     <script type="dojo/connect" event="onClick" args="evt">
                 
                     </script>
                 </button>
                </td>
              </tr>
            </table> 
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
