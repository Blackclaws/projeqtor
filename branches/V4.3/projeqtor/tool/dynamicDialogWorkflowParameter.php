<?php
$id=$_REQUEST['idWorkflow'];
$statusList=array("1"=>"Stat1", "2"=>"stat2");
?>
<form id="dialogWorkflowParameter" name="dialogWorkflowParameter" action="">
<input type="hidden" name="workflowId" value="<?php echo $id;?>" />
<table style="width: 100%;">
  <tr>
    <td style="width: 100%;">
	    <table width="100%;" >
<?php foreach($statusList as $status) { ?>
		    <tr>
			    <td class="label">label</td>
	        <td>status</td>
	      </tr>
<?php } ?>
	    </table>
    </td></tr>
    <tr><td style="width: 100%;">&nbsp;</td></tr>
    <tr>
      <td style="width: 100%;" align="center">
        <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogWorkflowParameter').hide();">
        <?php echo i18n("buttonCancel");?>
        </button>
        <button id="dialogWorkflowParameterSubmit" dojoType="dijit.form.Button" type="submit" 
         onclick="saveWorkflowParameter();return false;" >
         <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>      
  </table>
</form>
