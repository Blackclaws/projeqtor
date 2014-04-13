<?php 
/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/diaryMain.php');  
?>
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Diary" />
<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="listDiv" dojoType="dijit.layout.ContentPane" region="top" class="listTitle" splitter="false" style="height:58px;">
  <table width="100%" height="27px" class="listTitle" >
    <tr height="17px">
      <td width="50px" align="center">
        <img src="css/images/iconDiary32.png" width="32" height="32" />
      </td>
      <td width="200px" ><span class="title"><?php echo i18n('menuDiary');?></span></td>
      <td style="text-align: center"> 
		   <?php 
		   $period="month";
		   $year=date('Y');
		   $month=date('m');
		   $week=date('W');
		   $day=date('Y-m-d');
		   echo '<div style="font-size:20px" id="diaryCaption">'.i18n(date("F",mktime(0,0,0,$month,1,$year))).' '.$year.'</div>'; ?>
		   </td><td>
		   <form id="diaryForm" name="diaryForm">
		   <input type="hidden" name="diaryPeriod" id="diaryPeriod" value="<?php echo $period;?>" />
		   <input type="hidden" name="diaryYear" id="diaryYear" value="<?php echo $year;?>" />
		   <input type="hidden" name="diaryMonth" id="diaryMonth" value="<?php echo $month;?>" />
		   <input type="hidden" name="diaryWeek" id="diaryWeek" value="<?php echo $week;?>" />
		   <input type="hidden" name="diaryDay" id="diaryDay" value="<?php echo $week;?>" />
		   </form> 
		   </td>
		   <td width="250px" ></td>
   	</tr>
   	<tr height="18px" vertical-align="middle">
   	  <td colspan="5">
   	    <table width="100%"><tr><td width="50%;">
   	    <div class="buttonDiary" onClick="diaryPrevious();"><img src="../view/css/images/left.png" /></div>
   	    </td><td style="width:1px"></td><td width="50%">
   	    <div class="buttonDiary" onClick="diaryNext();"><img src="../view/css/images/right.png" /></div>
   	    </td></tr>
   	    </table>
   	  </td>
   	</tr>
   </table>
  </div>
  <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center">
   <?php include 'diary.php'; ?>
  </div>
</div>