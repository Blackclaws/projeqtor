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
          <img src="css/images/icon<?php echo ucfirst($type);?>32.png" width="32" height="32" />
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
      <table>
        <tr>
          <td class="label"></td>
          <td>test</td>
        </tr>
      </table>
    </form>
  </div>
</div>
