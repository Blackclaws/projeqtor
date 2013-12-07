<?php 
include_once '../tool/projeqtor.php';
include_once '../report/headerFunctions.php';
//echo "flashReport";
$showWbs=false;

SqlElement::$_cachedQuery['Status']=array();
SqlElement::$_cachedQuery['Severity']=array();
SqlElement::$_cachedQuery['Criticality']=array();
SqlElement::$_cachedQuery['Likelihood']=array();

if (! isset($outMode)) {
	$outMode='screen';
}

$idProject="";
if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
  $idProject=trim($_REQUEST['idProject']);
}

$result=array();
if ($idProject) { $result[]=$idProject;}
if (checkNoData($result)) exit;

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

// DECISIONS
$arrayDecision=array();
$dec=new Decision();
$decList=$dec->getSqlElementsFromCriteria(null, false, "idProject=$idProject", 'id asc');
foreach($decList as $dec) {
	$status=new Status($dec->idStatus);
	if ($status->setHandledStatus and ! $status->setDoneStatus) {
	  $arrayDecision[]=$dec->name;
	}
}

$notStartedCost=0;
// ACTIVITIES
$arrayActionDone=array();
$arrayActionOngoing=array();
$arrayActionTodo=array();
$pe=new ActivityPlanningElement();
$peList=$pe->getSqlElementsFromCriteria(null, false, "refType='Activity' and idProject=$idProject", "wbsSortable asc");
foreach ($peList as $pe) {
	$act=new Activity($pe->refId);
	$status=new Status($act->idStatus);
	$name=$act->name;
	if (strlen($name)>60) {
		$name=substr($name, 0,55).'[...]';
	}
	if ($showWbs) $name=$pe->wbs.' '.$name;
	if ($act->done) {
		$arrayActionDone[]=$name;
	} else if ($status->setHandledStatus and ! $status->setDoneStatus) {
		$arrayActionOngoing[]=$name;
	} else {
		$arrayActionTodo[]=$name;
		$notStartedCost+=$pe->validatedCost;
	}
}

// MILESTONES
$arrayMilestone=array();
$pe=new MilestonePlanningElement();
$peList=$pe->getSqlElementsFromCriteria(null, false, "refType='Milestone' and idProject=$idProject", "validatedEndDate asc");
foreach ($peList as $pe) {
	$arrayMilestone[]=array('name'=>$pe->refName, 
	   'initial'=>$pe->initialEndDate, 
	   'validated'=>$pe->validatedEndDate,
	   'done'=>$pe->done);
}
if (! count($arrayMilestone)) {
	$arrayMilestone[]=array('name'=>"Aucun jalon n'est défini", 
     'initial'=>'', 
     'validated'=>'',
     'done'=>false);
}

// RISKS
$arrayRisk=array();
$risk=new Risk();
$riskList=$risk->getSqlElementsFromCriteria(null, false, "idProject=$idProject", 'id asc');
foreach ($riskList as $risk) {
	$severity=new Severity($risk->idSeverity);
	$criticality=new Criticality($risk->idCriticality);
	$likelihood=new Likelihood($risk->idLikelihood);
	$order=$severity->value*$criticality->value*$likelihood->value;
	$order=htmlFixLengthNumeric($order,6).'-'.$risk->id;
	$name=$risk->name;
  if (strlen($name)>90) {
    $name=substr($name, 0,85).'[...]';
  }
	$arrayRisk[$order]=array('name'=>$name, 
	  'criticality'=>$criticality->name,
	  'criticalityColor'=>($criticality->color)?$criticality->color:"#FFFFFF", 
	  'severity'=>$severity->name,
	  'severityColor'=>($severity->color)?$severity->color:"#FFFFFF", 
	  'likelihood'=>$likelihood->name,
	  'likelihoodColor'=>($likelihood->color)?$likelihood->color:"#FFFFFF");
}
krsort($arrayRisk);

// INDICATORS
$notStartedCost=0;
$costIndicator="yellow";
$qualityIndicator="green";
$delayIndicator="red";
$riskIndicator="green";

// FORMATING VALUES
$height=185;
$width=277;
$borderMain="border: 1px solid red;";
$borderMain="";
$border="border: 1px solid #A0A0A0;";

$showHeader=1;
$showDecision=1;
$showIndicator=1;
$showActivity=1;
$showMilestone=1;
$showRisk=1;
$showCost=1;
?>
<div style="font-family: arial;font-size:<?php echo (($outMode=='pdf')?'3':'3');?>mm; width:<?php displayWidth(100);?>; height:<?php displayheight(100);?>;background-color: white; <?php echo $borderMain?>" >

  <div style="position:relative;width:<?php displayWidth(100);?>;height:25mm;<?php echo $borderMain?>">
  <?php if ($showHeader) {
    $titleLeft=0;
  	$titleWidth=18;
    $colLeft=$titleLeft+$titleWidth+3;
    $lineHeight=4;
    $curHeight=0;?>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $titleLeft;?>mm; 
      width:<?php echo $titleWidth;?>mm;font-weight: bold">Situation du <br/>projet</div>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $colLeft;?>mm;
      font-size:150%;font-weight:bold;<?php echo $borderMain?>">
      <?php displayField($proj->name);?></div>
    
    <?php $curHeight=10;?>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $titleLeft;?>mm; 
      width:<?php echo $titleWidth;?>mm; height:<?php echo $lineHeight;?>mm;white-space:nowrap;" class="reportTableLineHeader" >
      <?php displayHeader("CPU:");?></div>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $colLeft;?>mm; white-space:nowrap;">
      <?php displayField(SqlList::getNameFromId('Contact',$proj->idContact));?>
    </div>

    <?php $curHeight+=$lineHeight;?>
    <div style="position:absolute;top:<?php echo $curHeight;?>mm; left:<?php echo $titleLeft;?>mm; 
    width:<?php echo $titleWidth;?>mm;height:<?php echo $lineHeight;?>mm;white-space:nowrap;" class="reportTableLineHeader" >
      <?php displayHeader("CPI:");?>
    </div>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $colLeft;?>mm; white-space:nowrap;">
      <?php displayField(SqlList::getFieldFromId('User',$proj->idUser, 'fullName'));?>
    </div>

    <?php $curHeight+=$lineHeight;?>
    <div style="position:absolute;top:<?php echo $curHeight;?>mm; left:<?php echo $titleLeft;?>mm; 
    width:<?php echo $titleWidth;?>mm;height:<?php echo $lineHeight;?>mm;white-space:nowrap;" class="reportTableLineHeader" >
      <?php displayHeader("Situation à:");?>
    </div>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $colLeft;?>mm; white-space:nowrap;">
      <?php displayField(htmlFormatDate(date("Y-i-d")));?>
    </div>
    
    <?php $titleLeft=round($width*25/100,0);
    $titleWidth=18;
    $colLeft=$titleLeft+$titleWidth+3;
    $lineHeight=4;
    $curHeight=6;?>
    <div style="position:absolute;top:<?php echo $curHeight;?>mm; left:<?php echo $titleLeft;?>mm; 
    width:<?php echo $titleWidth;?>mm; height:<?php echo $lineHeight;?>mm;white-space:nowrap;" class="reportTableLineHeader" >
      <?php displayHeader("Priorité:");?>
    </div>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $colLeft;?>mm; white-space:nowrap;">
      <?php echo $proj->ProjectPlanningElement->priority;?>
    </div>
    
    <?php $curHeight+=$lineHeight;?>
    <div style="position:absolute;top:<?php echo $curHeight;?>mm; left:<?php echo $titleLeft;?>mm; 
    width:<?php echo $titleWidth;?>mm; height:<?php echo $lineHeight;?>mm;white-space:nowrap;" class="reportTableLineHeader" >
      <?php displayHeader("Sponsor:");?>
    </div>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $colLeft;?>mm; white-space:nowrap;">
      [sponsor]
    </div>
 
    <?php $curHeight+=$lineHeight;?>
    <div style="position:absolute;top:<?php echo $curHeight;?>mm; left:<?php echo $titleLeft;?>mm; 
    width:<?php echo $titleWidth;?>mm; height:<?php echo $lineHeight;?>mm;white-space:nowrap;" class="reportTableLineHeader" >
      <?php displayHeader("Direction:");?>
    </div>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $colLeft;?>mm; white-space:nowrap;">
      <?php echo SqlList::getNameFromId('Client',$proj->idClient);?>
    </div>
    
    <?php $curHeight+=$lineHeight;?>
    <div style="position:absolute;top:<?php echo $curHeight;?>mm; left:<?php echo $titleLeft;?>mm; 
    width:<?php echo $titleWidth;?>mm; height:<?php echo $lineHeight;?>mm;white-space:nowrap;" class="reportTableLineHeader" >
      <?php displayHeader("Etat:");?>
    </div>
    <div style="position:absolute; top:<?php echo $curHeight;?>mm; left:<?php echo $colLeft;?>mm; white-space:nowrap;">
      <?php echo SqlList::getNameFromId('Status',$proj->idStatus);?>
    </div>

    <div style="position:absolute; left:<?php displayWidth(50);?>;top:0mm;height:<?php echo $lineHeight;?>mm;
    width:<?php displayWidth(49.5);?>;white-space:nowrap;" class="reportTableLineHeader">
    <?php displayHeader("Périmètre & objectifs Projet / Process Métier impactés");?>
    </div>
    <div style="position:absolute; left:<?php displayWidth(50);?>;top:<?php echo $lineHeight;?>mm;height:18mm;
    width:<?php displayWidth(50);?>;<?php echo $border;?>">
      <?php displayField($proj->description);?>
    </div> 
  <?php }?>   
  </div>
  
  
  <div style="position:relative;top:2mm; width:<?php displayWidth(100);?>;height:40mm;<?php echo $borderMain?>" >
  <?php if ($showDecision) {?>
    <div class="reportTableLineHeader" style="width:<?php displayWidth(48.8);?>; white-space:nowrap;"><?php displayHeader("Décisions attendues");?></div>    
      <?php displayList($arrayDecision,8,49);?>
  <?php }?>  
  <?php if ($showIndicator) {?>
    <div class="reportTableLineHeader" style="position: absolute; top: 0mm; height: 10mm; text-align: center;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(60);?>;">
      <?php displayHeader("Global");?><br/>
      <i>"<?php echo htmlEncode(SqlList::getNameFromId('Health',$proj->idHealth));?>"</i></div>
    <div style="position: absolute; top: 0mm; height: 10mm; text-align: center; background-color: #FFFFFF;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(70);?>;<?php echo $border;?>">
      <div style="height:7mm; width: 7mm; position: absolute; left:10mm; top:1mm; border: 1px solid black; border-radius: 4mm;
         background-color:<?php  echo SqlList::getFieldFromId('Health',$proj->idHealth,'color');?>">&nbsp;</div></div>
    <div class="reportTableLineHeader" style="position: absolute; top: 0mm; height: 10mm; text-align: center;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(80);?>; ">
      <?php displayHeader("Tendance");?></div>  
    <div style="position: absolute; top: 0mm; height: 10mm; text-align: center; background-color: #FFFFFF;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(90);?>;<?php echo $border;?>">
      [TENDANCE]</div>  
    <div class="reportTableLineHeader" style="position: absolute; top: 10mm; height: 5mm; text-align: center;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(60);?>; ">
      <?php displayHeader("Coût");?></div>  
    <div class="reportTableLineHeader" style="position: absolute; top: 10mm; height: 5mm; text-align: center;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(70);?>;<?php echo $border;?>">
      <?php displayHeader("Qualité");?></div>
    <div class="reportTableLineHeader" style="position: absolute; top: 10mm; height: 5mm; text-align: center;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(80);?>;<?php echo $border;?>">
      <?php displayHeader("Délai");?></div>
    <div class="reportTableLineHeader" style="position: absolute; top: 10mm; height: 5mm; text-align: center;
    width:<?php displayWidth(9.5);?>; left:<?php displayWidth(90);?>;<?php echo $border;?>">
      <?php displayHeader("Risque");?></div>
    <div style="position: absolute; top: 15mm; height: 10mm; text-align: center;vertical-align: middle; background-color: #FFFFFF;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(60);?>;<?php echo $border;?>">
      <img src="../view/css/images/smiley<?php echo ucfirst($costIndicator);?>.png" /></div>  
    <div style="position: absolute; top: 15mm; height: 10mm; text-align: center; background-color: #FFFFFF;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(70);?>;<?php echo $border;?>">
      [QUALITE]
      </div>
    <div style="position: absolute; top: 15mm; height: 10mm; text-align: center; background-color: #FFFFFF;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(80);?>;<?php echo $border;?>">
      <img src="../view/css/images/smiley<?php echo ucfirst($delayIndicator);?>.png" /></div>
    <div style="position: absolute; top: 15mm; height: 10mm; text-align: center; vertical-align: middle;background-color: #FFFFFF;
    width:<?php displayWidth(10);?>; left:<?php displayWidth(90);?>;<?php echo $border;?>">
      <img src="../view/css/images/smiley<?php echo ucfirst($riskIndicator);?>.png" /></div>    
  <?php }?>  
  
  </div>  
  
 
  <div style="position:relative; top: 3mm; width:<?php displayWidth(100);?>;height:50mm;<?php echo $borderMain?>" >
  <?php if ($showActivity) {?>
    <div style="width:<?php displayWidth(32);?>; position:absolute; left:0mm; top:0mm; background-color: white;">
      <div class="reportTableLineHeader" style="width:<?php displayWidth(31.8);?>; white-space:nowrap;"><?php displayHeader("Réalisés");?></div>
      <?php displayList($arrayActionDone,10,32);?>
    </div>
    <div style="width:<?php displayWidth(32);?>; position:absolute; left:<?php displayWidth(34);?>; top:0mm; background-color: white;">
      <div class="reportTableLineHeader" style="width:<?php displayWidth(31.8);?>; white-space:nowrap;"><?php displayHeader("En cours");?></div>
      <?php displayList($arrayActionOngoing,12,32);?>
    </div>
    <div style="width:<?php displayWidth(32);?>; position:absolute; left:<?php displayWidth(67);?>; top:0mm; background-color: white;">
      <div class="reportTableLineHeader" style="width:<?php displayWidth(31.8);?>; white-space:nowrap;"><?php displayHeader("A venir");?></div>
      <?php displayList($arrayActionTodo,12,32);?>
    </div>
  <?php }?>   
  </div>
  
  
  <div style="position:relative;top: 2mm; width:<?php displayWidth(100);?>;height:30mm;<?php echo $borderMain?>" >
  <?php if ($showMilestone) {
  $mileWidth=90;
  if (count($arrayMilestone)) {
    $mileWidth=round(90/count($arrayMilestone),1);
  }
  //if ($mileWidth>30) $mileWidth=30;?>
	  <table width="100%">
	    <tr><td class="reportTableLineHeader" style="width:10%">Jalons</td>
	    <?php foreach($arrayMilestone as $mile){?>
	      <td style="padding-left:1mm; width:<?php echo $mileWidth;?>%;<?php echo $border?>"><?php echo $mile['name'];?></td>
	    <?php }?>
	    </tr>
	    <tr><td class="reportTableLineHeader" style="width:10%">Initial</td>
	    <?php foreach($arrayMilestone as $mile){?>
	      <td style="padding-left:1mm; width:<?php echo $mileWidth;?>%;<?php echo $border?>"><?php echo htmlFormatDate($mile['initial']);?></td>
	    <?php }?>
	    </tr>
	    <tr><td class="reportTableLineHeader" style="width:10%">Révisé</td>
	    <?php foreach($arrayMilestone as $mile){
	      $color=($mile['done'])?'#32cd32':'#FFFFFF';?>
	      <td style="background-color:<?php echo $color;?>;padding-left:1mm; width:<?php echo $mileWidth;?>%;<?php echo $border?>"><?php echo htmlFormatDate($mile['validated']);?></td>
	    <?php }?>
	    </tr>
	  </table>
  <?php }?>
  </div> 
  
  
  <div style="position:relative;top: 2mm; width:<?php displayWidth(100);?>;height:30mm;<?php echo $borderMain?>" >
  <?php if ($showRisk) {?>
    <div style="position:absolute;top:0mm; width:<?php displayWidth(50);?>;height:30mm;<?php echo $borderMain?>" >
	    <table style="width:95%">
	       <tr>
	         <td colspan="4" class="reportTableLineHeader" >
	           <?php displayHeader("Alertes / Risques détectés sur le chantier et plan d'action");?>
	         </td>
	       </tr>
         <tr>
           <td  style="width:55%; font-weight:bold;<?php echo $border;?>" >
             <?php displayHeader("Risque");?>
           </td>
           <td  style="text-align: center;width:15%; font-weight:bold;<?php echo $border;?>" >
             <?php displayHeader("Criticité");?>
           </td>
           <td  style="text-align: center;width:15%; font-weight:bold;<?php echo $border;?>" >
             <?php displayHeader("Sévérité");?>
           </td>
           <td  style="text-align: center;width:15%; font-weight:bold;<?php echo $border;?>" >
             <?php displayHeader("Probabilité");?>
           </td>
         </tr>
         <?php 
          $nb=0;
          $max=5;
          foreach ($arrayRisk as $risk) {
            $nb++;
            if ($nb>$max) break;?>
          <tr>
           <td  style="position:relative; width:55%; <?php echo $border;?>" >
             <?php echo $risk['name'];?>
           </td>
           <td  style="background-color:<?php echo $risk['criticalityColor'];?>;
               color:<?php echo htmlForeColorForBackgroundColor($risk['criticalityColor'])?>;
               text-align: center;width:15%; <?php echo $border;?>" >
             <?php echo $risk['criticality'];?>
           </td>
           <td  style="background-color:<?php echo $risk['severityColor'];?>;
               color:<?php echo htmlForeColorForBackgroundColor($risk['severityColor'])?>;
               text-align: center;width:15%; <?php echo $border;?>" >
             <?php echo $risk['severity'];?>
           </td>
           <td  style="background-color:<?php echo $risk['likelihoodColor'];?>;
               color:<?php echo htmlForeColorForBackgroundColor($risk['likelihoodColor'])?>;
               text-align: center; position:relative; width:15%; <?php echo $border;?>" >
             <?php echo $risk['likelihood'];
             if ($nb==$max and count($arrayRisk)>$max) {
              echo '<div class="reportTableLineHeader"';
              echo ' style="position:absolute;top:0mm;right:'.(($outMode=='pdf')?'-5':'0').'mm; width:10mm;">';
              echo '...'.$nb.'/'.count($arrayRisk).'&nbsp;';
              echo '</div>';
             }?>
           </td>
          </tr>
         <?php }?>
	     </table>
    </div>
  <?php }?>
  <?php if ($showCost) {?>
    <div style="position:absolute;top:0mm; left:<?php displayWidth(50);?>;height:30mm;width:<?php displayWidth(50);?>;<?php echo $borderMain?>" >
      <table style="width:100%">
	      <tr>
	        <td style="width:15%" class="reportTableLineHeader" >
	          <?php displayHeader("Budget\nProjet");?>
	        </td>
          <td style="text-align: center;width:20%" class="reportTableLineHeader" >
            <?php displayHeader("AE Budgété");?>
          </td>
          <td style="text-align: center;width:20%" class="reportTableLineHeader" >
            <?php displayHeader("AE Engagé");?>
          </td>
          <td style="text-align: center;width:20%" class="reportTableLineHeader" >
            <?php displayHeader("CP consommé");?>
          </td>
          <td style="text-align: center;width:25%" class="reportTableLineHeader" >
            <?php displayHeader("Charge consommée de l'année (Jours Homme)");?>
          </td>
	      </tr>
        <tr style="height:7mm">
          <td style="width:15%" class="reportTableLineHeader" >
            <?php displayHeader("TTC");?>
          </td>
          <td style="text-align: center;width:20%;<?php echo $border;?>" >
            [AE budgété]
          </td>
          <td style="text-align: center;width:20%;<?php echo $border;?>" >
            [AE Engagé]
          </td>
          <td style="text-align: center;width:20%;<?php echo $border;?>"  >
            [CP comsommé]
          </td>
          <td style="text-align: center;width:20%;<?php echo $border;?>" >
            [Charge consommée]
          </td>
         </tr>
         <tr style="height:7mm">
          <td style="width:15%; border-right:#A0A0A0;">
            &nbsp;
          </td>
          <td style="text-align: center;width:20%;<?php echo $border;?>" >
            [AE budgété]%
          </td>
          <td style="text-align: center;width:20%;<?php echo $border;?>" >
            [AE Engagé]%
          </td>
          <td style="text-align: center;width:20%;<?php echo $border;?>"  >
            [CP comsommé]%
          </td>
          <td style="text-align: center;width:25%;<?php echo $border;?>" >
            [Charge consommée]%
          </td>
         </tr>
      </table>
    </div>
  <?php }?>
  </div> 
</div>
<?php 

function displayField($value,$height=null) {
  $res="";
  if ($height) {
	  $res.='<div style="top:0px;width:100%;';
    $res.='height:'.$height.'mm;';
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

function displayList($list, $max, $width) {
  $nb=0;
	foreach ($list as $item) {
    $nb++;
    if ($nb>$max) break;
    echo '<div style="position:relative;vertical-align:top; width:';
    displayWidth($width);
    echo ';padding-left:1mm;border: 1px solid #A0A0A0;">';
    displayField($item);
	  if ($nb==$max and count($list)>$max) {
      echo '<div class="reportTableLineHeader" style="position:absolute;top:0mm;right:0mm; width:10mm;">';
      echo '...'.$nb.'/'.count($list).'&nbsp;';
      echo '</div>';
    }
    echo '</div>';
    
  }
}

function displayWidth($widthPct) {
  global $width;
  echo (round($width*$widthPct/100,1)).'mm';
}
function displayheight($heightPct) {
  global $height;
  echo (round($height*$heightPct/100,1)).'mm';
}
?>