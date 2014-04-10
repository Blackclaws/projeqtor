<?php 
/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/diaryMain.php');  
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Diary" />
<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="top" class="listTitle" splitter="false" style="height:60px;">
  <table width="100%" height="27px" class="listTitle" >
    <tr height="27px">
      <td width="50px" align="center">
        <img src="css/images/iconDiary32.png" width="32" height="32" />
      </td>
      <td width="200px" ><span class="title"><?php echo i18n('menuDiary');?></span></td>
      <td> 
        
		   <?php 
		   $period="month";
		   $year=date('Y');
		   $month=date('m');
		   $week="";
		   echo "$period $year-$month"; ?>
		   </td>
   	</tr>
   </table>
  </div>
  <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center">
   <?php include 'diary.php'; ?>
  </div>
</div>