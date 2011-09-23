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
           <div id="resultDiv" dojoType="dijit.layout.ContentPane" region="center" style="height:20px">
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
                <td class="label"><?php echo i18n("alertCronStatus"). "&nbsp;:&nbsp;";?></td>
                <td class="display">
                  <?php 
                    $cronStatus=Cron::check();
                    echo i18n($cronStatus);
                  ?>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
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
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td width="100%" colspan="2" class="section"><?php echo i18n('sendAlert');?></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label"><?php echo i18n("colMailTo"). "&nbsp;:&nbsp;";?></td>
                <td>
                  <select dojoType="dijit.form.FilteringSelect" class="input" required="true"
                    style="width: 98%;" name="alertSendTo" id="alertSendTo">
                    <option value="*"><?php echo i18n('allUsers')?></option>
                    <?php htmlDrawOptionForReference('idUser', null, null, true);?>
                  </select>
                </td>
              </tr>
              <tr>
                <td class="label"><?php echo i18n("colCreationDateTime"). "&nbsp;:&nbsp;";?></td>
                <td>
                  <div dojoType="dijit.form.DateTextBox" name="alertSendDate" id="alertSendDate"
                    invalidMessage="<?php echo i18n('messageInvalidDate')?>" 
                    type="text" maxlength="10"
                    style="width:75px; text-align: center;" class="input" required="true"
                    value="<?php echo date('Y-m-d');?>"
                    hasDownArrow="false">
                  </div>
                  <div dojoType="dijit.form.TimeTextBox" name="alertSendTime" id="alertSendTime"
                    invalidMessage="<?php echo i18n('messageInvalidTime')?>" 
                    type="text" maxlength="5" required="true"
                    style="width:50px; text-align: center;" class="input"
                    value="T<?php echo date('H:i');?>" 
                    hasDownArrow="false">
                  </div>      
                </td>
              </tr>
              <tr>
                <td class="label"><?php echo i18n("colType"). "&nbsp;:&nbsp;";?></td>
                <td>
                  <select dojoType="dijit.form.FilteringSelect" class="input" 
                    style="width: 98%;" name="alertSendType" id="alertSendType" required="true">
                    <option value="INFO"><?php echo i18n('INFO')?></option>
                    <option value="WARNING"><?php echo i18n('WARNING')?></option>
                    <option value="ALERT"><?php echo i18n('ALERT')?></option>
                  </select>
                </td>
              </tr>
              <tr>
                <td class="label"><?php echo i18n("colTitle"). "&nbsp;:&nbsp;";?></td>
                <td>
                  <div dojoType="dijit.form.TextBox"
                    style="width:98%;" required="true"
                    name="alertSendTitle" id="alertSendTitle">
                  </div>
                </td>
              </tr>
              <tr>
                <td class="label"><?php echo i18n("colMessage"). "&nbsp;:&nbsp;";?></td>
                <td>
                  <textarea dojoType="dijit.form.Textarea"
                    name="alertSendMessage" id="alertSendMessage"
                    style="width:99%;" required="true"
                    maxlength="4000"
                    class="input"></textarea>
                </td>
              </tr>
              <tr>
                <td class="label"></td>
                <td>
                  <button id="alertSend" dojoType="dijit.form.Button" showlabel="true">
                    <?php echo i18n('send'); ?>
                   <script type="dojo/connect" event="onClick" args="evt">                 
                     adminSendAlert();
                   </script>
                 </button>
                </td>
              </tr>
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
                <td class="label" style="width:200px">
                  <?php echo i18n("closeEmails"). "&nbsp;:&nbsp;";?>
                </td>
                <td class="display">
                  <?php echo i18n('sentSinceMore');?>&nbsp;
                  <div dojoType="dijit.form.NumberTextBox" constraints="{min:0,max:999}"
                    style="width:30px;"
                    value="7"
                    name="closeMailDays" id="closeMailDays">
                  </div>
                  &nbsp;<?php echo i18n('days');?>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <button id="closeEmails" dojoType="dijit.form.Button" showlabel="true">
                    <?php echo i18n('close'); ?>
                     <script type="dojo/connect" event="onClick" args="evt">
                       maintenance('close','Mail');
                     </script>
                 </button>
                </td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label" style="width:200px">
                  <?php echo i18n("deleteEmails"). "&nbsp;:&nbsp;";?>
                </td>
                <td class="display">
                  <?php echo i18n('sentSinceMore');?>&nbsp;
                   <div dojoType="dijit.form.NumberTextBox" constraints="{min:0,max:999}"
                    style="width:30px;"
                    value="30"
                    name="deleteMailDays" id="deleteMailDays">
                  </div>
                  &nbsp;<?php echo i18n('days');?>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <button id="deleteEmails" dojoType="dijit.form.Button" showlabel="true">
                    <?php echo i18n('delete'); ?>
                     <script type="dojo/connect" event="onClick" args="evt">
                       maintenance('delete','Mail');
                     </script>
                 </button>
                </td>
              </tr>
                       <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label" style="width:200px">
                  <?php echo i18n("closeAlerts"). "&nbsp;:&nbsp;";?>
                </td>
                <td class="display">
                  <?php echo i18n('sentSinceMore');?>&nbsp;
                   <div dojoType="dijit.form.NumberTextBox" constraints="{min:0,max:999}"
                    style="width:30px;"
                    value="7"
                    name="closeAlertDays" id="closeAlertDays">
                  </div>
                  &nbsp;<?php echo i18n('days');?>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <button id="closeAlerts" dojoType="dijit.form.Button" showlabel="true">
                    <?php echo i18n('close'); ?>
                     <script type="dojo/connect" event="onClick" args="evt">
                       maintenance('close','Alert');
                     </script>
                 </button>
                </td>
              </tr>
                       <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label" style="width:200px">
                  <?php echo i18n("deleteAlerts"). "&nbsp;:&nbsp;";?>
                </td>
                <td class="display">
                  <?php echo i18n('sentSinceMore');?>&nbsp;
                   <div dojoType="dijit.form.NumberTextBox" constraints="{min:0,max:999}"
                    style="width:30px;"
                    value="30"
                    name="deleteAlertDays" id="deleteAlertDays">
                  </div>
                  &nbsp;<?php echo i18n('days');?>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <button id="deleteAlerts" dojoType="dijit.form.Button" showlabel="true">
                    <?php echo i18n('delete'); ?>
                     <script type="dojo/connect" event="onClick" args="evt">
                       maintenance('delete','Alert');
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
