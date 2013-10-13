<?php 
$showIdle=(isset($_SESSION['projectSelectorShowIdle']) and $_SESSION['projectSelectorShowIdle']==1)?1:0;
$selectorFormat=(isset($_SESSION['projectSelectorFormat']) and $_SESSION['projectSelectorShowIdle']=='filtering')?'filtering':'standard';
?>
<table style="width:100%">
  <tr>
    <td style="text-align: right;width:200px">
	    <?php echo i18n("labelShowIdle");?>&nbsp;:&nbsp;
	  </td>
	  <td style="text-align: left; vertical-align: middle;width:100px">
	     <div title="<?php echo i18n('showIdleElements');?>" dojoType="dijit.form.CheckBox" type="checkbox"
         <?php if ($showIdle) echo ' checked ';?>">
	       <script type="dojo/method" event="onChange" >
           dojo.xhrPost({
             url: "../tool/saveDataToSession.php?id=projectSelectorShowIdle&value="+((this.checked)?1:0),
             load: function() {loadContent("../view/menuProjectSelector.php", 'projectSelectorDiv');}
           });
           dijit.byId('dialogProjectSelectorParameters').hide();
         </script>
	     </div>
	  </td>
  </tr>
</table>  
<table style="width:100%">
  <tr style="border-bottom:2px solid #F0F0F0;"><td></td><td>&nbsp;</td></tr>
  <tr style="height:10px;"><td></td><td>&nbsp;</td></tr>
</table>
<table style="width:100%">
	<tr style="height:10px;">
	  <td align="center">
	   <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogProjectSelectorParameters').hide();">
	     <?php echo i18n("buttonCancel");?>
	   </button>
	 </td>
	</tr>
</table>