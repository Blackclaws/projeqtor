<?php 
include_once '../tool/projeqtor.php';
//echo "flashReport";

$idProject="";
if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
  $idProject=trim($_REQUEST['idProject']);
}

$headerParameters="";
if ($idProject) {
  $headerParameters.= i18n("colId") . ' : ' . htmlEncode($idProject) . '<br/>';
	$headerParameters.= i18n("colIdProject") . ' : ' . htmlEncode(SqlList::getNameFromId('Project',$idProject)) . '<br/>';
} 

ob_start();
include "header.php";
ob_end_clean();

$proj=new Project($idProject);

$user=$_SESSION['user'];
$height=600;
$borderMain="border: 1px solid black;";
//$borderMain="";
$border="border: 1px solid black;";
?>
<table style="font-size:10px;width:100%; height:<?php echo $height?>px; <?php echo $borderMain?>" >
 <tr style="height:<?php echo round(600*15/100,0);?>px;<?php echo $borderMain?>">
  <td style="width:100%;<?php echo $borderMain?>">
    <table style="width:100%;margin: 1px 5px 1px 5px;">
     <tr>
       <td style="vertical-align:top;width:25%;<?php echo $borderMain?>">
         <table style="width:100%;">
           <tr>
             <td style="width:25%;">Situation du projet</td>
             <td style="width:75%;font-size:120%; font-weight:bold; padding-left:5px;"><?php echo $proj->name;?></td>
           </tr>
           <tr>
             <td class="reportTableLineHeader" style="width:25%;white-space:nowrap;">CPU :</td>
             <td style="width:75%; padding-left:5px;"><?php echo SqlList::getNameFromId('Contact',$proj->idContact);?></td>
           </tr>
           <tr>
             <td class="reportTableLineHeader" style="width:25%;white-space:nowrap;">CPI :</td>
             <td style="width:75%; padding-left:5px;"><?php echo SqlList::getFieldFromId('User',$proj->idUser, 'fullName');?></td></tr>
           <tr>
             <td class="reportTableLineHeader" style="width:25%;white-space:nowrap;">Situation &agrave; :</td>
             <td style="width:75%; padding-left:5px;"><?php echo htmlFormatDate(date("Y-i-d"));?></td></tr>
         </table>
       </td>
       <td style="vertical-align:top; width:25%;<?php echo $borderMain?>">
         <table style="width:100%;">
           <tr>
             <td class="reportTableLineHeader" style="width:25%;white-space:nowrap;">Priorité</td>
             <td style="width:75%;padding-left:5px;"><?php echo $proj->ProjectPlanningElement->priority;?></td></tr>
           <tr>
             <td class="reportTableLineHeader" style="width:25%;white-space:nowrap;">Sponsor :</td>
             <td style="width:75%;padding-left:5px;">[sponsor]</td></tr>
           <tr>
             <td class="reportTableLineHeader" style="width:25%;white-space:nowrap;">Direction :</td>
             <td style="width:75%;padding-left:5px;"><?php echo SqlList::getNameFromId('Client',$proj->idClient);?></td></tr>
           <tr>
             <td class="reportTableLineHeader" style="width:25%;white-space:nowrap;">Etat :</td>
             <td style="width:75%;padding-left:5px;"><?php echo SqlList::getNameFromId('Status',$proj->idStatus);?></td>
           </tr>
         </table>
       </td>
       <td style="width:50%;<?php echo $borderMain?>">
       
       </td>
     </tr>
    </table>
  </td>
 </tr>
 <tr style="height: <?php echo round(600*20/100,0);?>px;<?php echo $borderMain?>">
  <td style="width:100%">
    Decisions / indicateurs
  </td>
 </tr>
 <tr style="width:100%; <?php echo $borderMain?>">
  <td style="width:100%">
    Reste
  </td>
 </tr>
</table>
