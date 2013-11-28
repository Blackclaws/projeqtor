<?php 
include_once '../tool/projeqtor.php';
//echo "flashReport";

if (! isset($outMode)) {
	$outMode='screen';
}

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
$borderMain="border: 1px solid red;";
//$borderMain="";
$border="border: 1px solid black;";

$arrayDecision=array();
$arrayDecision[1]="[test décision 1]";
$arrayDecision[2]="[test décision 2]";

$arrayActionDone=array();
$arrayActionDone[1]="[test action 1]";

$arrayActionOngoing=array();
$arrayActionOngoing[1]="[test action 2]";
$arrayActionOngoing[2]="[test action 3]";
$arrayActionOngoing[3]="[test action 4]";

$arrayActionTodo=array();
$arrayActionTodo[1]="[test action 5]";
$arrayActionTodo[2]="[test action 6]";

?>
<div style="font-size:<?php echo (($outMode=='pdf')?'9':'7');?>pt; width:99%; height:700px; <?php echo $borderMain?>background-color: white;" >
  <div style="position:relative;width:100%;height:75px;<?php echo $borderMain?>">
    <div style="width:25%; position:absolute; left:0%;top:0px; background-color: white;">
      <table style="width:100%;">
        <tr>
          <td style="width:27%;font-weight: bold">Situation du projet</td>
          <td style="width:73%;font-size:120%; font-weight:bold; padding-left:5px;"><?php displayField($proj->name);?></td>
        </tr>
        <tr>
          <td class="reportTableLineHeader" style="width:27%;white-space:nowrap;"><?php displayHeader("CPU:");?></td>
          <td style="width:77%; padding-left:5px;"><?php displayField(SqlList::getNameFromId('Contact',$proj->idContact));?></td>
        </tr>
        <tr>
          <td class="reportTableLineHeader" style="width:27%;white-space:nowrap;"><?php displayHeader("CPI:");?></td>
          <td style="width:73%; padding-left:5px;"><?php displayField(SqlList::getFieldFromId('User',$proj->idUser, 'fullName'));?></td>
        </tr>
        <tr>
          <td class="reportTableLineHeader" style="width:27%;"><?php displayHeader("Situation à:",12);?></td>
          <td style="width:73%; padding-left:5px;"><?php displayField(htmlFormatDate(date("Y-i-d")));?></td>
        </tr>
      </table>
    </div>
    <div style="width:25%; position:absolute; left:25%; top:0px; background-color: white;">
      <table style="width:100%;">
        <tr>
          <td class="reportTableLineHeader" style="width:27%;white-space:nowrap;"><?php displayHeader("Priorité:");?></td>
          <td style="width:73%;padding-left:5px;"><?php echo $proj->ProjectPlanningElement->priority;?></td>
        </tr>
        <tr>
          <td class="reportTableLineHeader" style="width:27%;white-space:nowrap;"><?php displayHeader("Sponsor:");?></td>
          <td style="width:73%;padding-left:5px;">[sponsor]</td>
        </tr>
        <tr>
          <td class="reportTableLineHeader" style="width:27%;white-space:nowrap;"><?php displayHeader("Direction:");?></td>
          <td style="width:73%;padding-left:5px;"><?php echo SqlList::getNameFromId('Client',$proj->idClient);?></td>
        </tr>
        <tr>
          <td class="reportTableLineHeader" style="width:27%;white-space:nowrap;"><?php displayHeader("Etat:");?></td>
          <td style="width:73%;padding-left:5px;"><?php echo SqlList::getNameFromId('Status',$proj->idStatus);?></td>
        </tr>
      </table>
    </div>
    <div style="width:50%; position:absolute; left:50%;top:0px; background-color: white;">
      <table style="width:100%;">
        <tr>
          <td class="reportTableLineHeader" style="width:100%;white-space:nowrap;"><?php displayHeader("Périmètre & objectifs Projet / Process Métier impactés");?></td>
        </tr>
        <tr height="50px" style="height:50px">
          <td style="vertical-align:top; width:100%;padding-left:5px;<?php echo $border;?>">
            <?php displayField($proj->description,55);?>
          </td>
        </tr>
      </table>
    </div>      
  </div>
  <div style="position:relative;top: 5px; width:100%;height:100px;<?php echo $borderMain?>" >
    <div style="width:50%; position:absolute; left:0%; top:0px; background-color: white;">
      <table style="width:100%;">
        <tr>
          <td class="reportTableLineHeader" style="width:100%;white-space:nowrap;"><?php displayHeader("Décisions attendues");?></td>
        </tr>
        <tr height="50px">
          <td style="vertical-align:top; width:100%;">
            <div style="vertical-align:top; width:100%;height:85px;<?php echo $border;?>">
	            <table style="vertical-align:top; width:100%;">
	              <?php foreach ($arrayDecision as $decision) {?>
	              <tr>
	               <td style="vertical-align:top; width:100%;padding-left:5px;border-bottom: 1px solid #A0A0A0;">
	                 <?php displayField($decision);?>
	               </td>
	              </tr>
	              <?php }?>
	            </table>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>  
  <div style="position:relative; top:10px; width:100%;height:150px;<?php echo $borderMain?>" >
    <div style="width:33%; position:absolute; left:0%; top:0px; background-color: white;">
      <table style="width:100%;">
        <tr>
          <td class="reportTableLineHeader" style="width:100%;white-space:nowrap;"><?php displayHeader("Réalisés");?></td>
        </tr>
        <tr height="50px">
          <td style="vertical-align:top; width:100%;">
            <div style="vertical-align:top; width:100%;height:130px;<?php echo $border;?>">
              <table style="vertical-align:top; width:100%;">
                <?php foreach ($arrayActionDone as $action) {?>
                <tr>
                 <td style="vertical-align:top; width:100%;padding-left:5px;border-bottom: 1px solid #A0A0A0;">
                   <?php displayField($action);?>
                 </td>
                </tr>
                <?php }?>
              </table>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div style="width:33%; position:absolute; left:33%; top:0px; background-color: white;">
      <table style="width:100%;">
        <tr>
          <td class="reportTableLineHeader" style="width:100%;white-space:nowrap;"><?php displayHeader("En cours");?></td>
        </tr>
        <tr>
          <td style="vertical-align:top; width:100%;">
            <div style="vertical-align:top; width:100%;height:130px;<?php echo $border;?>">
              <table style="vertical-align:top; width:100%;">
                <?php foreach ($arrayActionOngoing as $action) {?>
                <tr>
                 <td style="vertical-align:top; width:100%;padding-left:5px;border-bottom: 1px solid #A0A0A0;">
                   <?php displayField($action);?>
                 </td>
                </tr>
                <?php }?>
              </table>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div style="width:33%; position:absolute; left:66%; top:0px; background-color: white;">
      <table style="width:100%;">
        <tr>
          <td class="reportTableLineHeader" style="width:100%;white-space:nowrap;"><?php displayHeader("A venir");?></td>
        </tr>
        <tr>
          <td style="vertical-align:top; width:100%;">
            <div style="vertical-align:top; width:100%;height:130px;<?php echo $border;?>">
              <table style="vertical-align:top; width:100%;">
                <?php foreach ($arrayActionTodo as $action) {?>
                <tr>
                 <td style="vertical-align:top; width:100%;padding-left:5px;border-bottom: 1px solid #A0A0A0;">
                   <?php displayField($action);?>
                 </td>
                </tr>
                <?php }?>
              </table>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div> 
</div>
<?php 
function displayField($value,$height=null) {
  $res="";
  if ($height) {
	  $res.='<div style="top:0px;width:100%;';
    $res.='height:'.$height.'px;';
    $res.='white-space:nowrap; text-overflow:ellipsis;">';
  }
  $res.=htmlEncode($value,'print');
  if ($height) {
    $res.='</div>';
  }
	echo $res;
	
}
function displayHeader($value,$height=null) {
  $res='';
  if ($height) {
	  $res.='<div style="top:0px;';
	  $res.='height:'.$height.'px;';
	  $res.='white-space:nowrap;width:100%;">';
  }
  $res.=htmlEncode($value,'print');
  if ($height) {
    $res.='</div>';
  }
  echo $res;
  
}
?>