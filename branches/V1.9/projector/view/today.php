<?php
/* ============================================================================
 * List of parameter specific to a user.
 * Every user may change these parameters (for his own user only !).
 */
  require_once "../tool/projector.php";
  scriptLog('   ->/view/today.php');
  
  $user=$_SESSION['user'];
  
  if (array_key_exists('refreshProjects',$_REQUEST)) {
    $_SESSION['todayCountScope']=(array_key_exists('countScope',$_REQUEST))?$_REQUEST['countScope']:'todo';
    showProjects();
    exit;
  } 
  
  function showMessages() {
    $user=$_SESSION['user'];
    $msg=new Message();
    $where="idle=0";
    $where.=" and (idUser is null or idUser='" . $user->id . "')";
    $where.=" and (idProfile is null or idProfile='" . $user->idProfile . "')";
    $where.=" and (idProject is null or idProject in " . transformListIntoInClause($prjLst=$user->getVisibleProjects()) . ")";
    
    $sort="id desc";
    $listMsg=$msg->getSqlElementsFromCriteria(null,false,$where,$sort);
    if (count($listMsg)>0) {
      echo '<table align="center" style="width:95%">';
      foreach($listMsg as $msg) {
        //echo'<br />';
        $type=new MessageType($msg->idMessageType);
        echo '<tr><td class="messageHeader" style="color:' . $type->color . ';">' . $msg->name . '</td></tr>';
        echo '<tr><td class="messageData" style="color:' . $type->color . ';">' . htmlEncode($msg->description, 'print') . '</td></tr>';
      }
      echo'</table>';
    }
  }
  
  function showProjects() {
    $user=$_SESSION['user'];
    $prjVisLst=$user->getVisibleProjects();
    $prjLst=$user->getHierarchicalViewOfVisibleProjects();
    $showIdle=false;
    $showDone=false;
    $countScope='todo';

    if (array_key_exists('todayCountScope',$_SESSION)) {
      $countScope=$_SESSION['todayCountScope'];
    }
    if (count($prjLst)>0) {
      echo '<form id="todayProjectsForm" name="todayProjectsForm">';
      echo '<table align="center" style="width:95%">'; 
      echo '<tr><td style="text-align:left;width:40%" class="tabLabel" >';
      echo i18n('titleCountScope') . " : ";
      echo '</td>';
      echo '<td style="text-align:right; width:5%" class="tabLabel">';
      echo '<label for="countScopeTodo">' . i18n('titleCountTodo') . '&nbsp;</label>';
      echo '</td><td style="text-align:left;" class="tabLabel">';
      echo '<input onChange="refreshTodayProjectsList();" type="radio" dojoType="dijit.form.RadioButton" name="countScope" id="countScopeTodo" ' 
          . (($countScope=='todo')?'checked':'') . ' value="todo" />';         
      echo '</td>';
      echo '<td style="text-align:right; width:5%" class="tabLabel">';
      echo '<label for="countScopeNotClosed">' . i18n('titleCountNotClosed') . '&nbsp;</label>';
      echo '</td><td style="text-align:left;" class="tabLabel">';      
      echo '<input onChange="refreshTodayProjectsList();" type="radio" dojoType="dijit.form.RadioButton" name="countScope" id="countScopeNotClosed" ' 
          . (($countScope=='notClosed')?'checked':'') . ' value="notClosed" />';
      echo '</td>';
      echo '<td style="text-align:right; width:5%" class="tabLabel">';
      echo '<label for="countScopeAll">' . i18n('titleCountAll') . '&nbsp;</label>';
      echo '</td><td style="text-align:left;" class="tabLabel">';
      echo '<input onChange="refreshTodayProjectsList();" type="radio" dojoType="dijit.form.RadioButton" name="countScope" id="countScopeAll" ' 
          . (($countScope=='all')?'checked':'') . ' value="all" />';
      echo '</td></tr>';
      echo '</table></form>';          
      $width=70;
      echo '<table align="center" style="width:95%">';
      echo '<tr>' . 
           '  <td class="messageHeader">' . i18n('menuProject') . '</td>' . 
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . ucfirst(i18n('progress')) . '</div></td>' . 
           '  <td class="messageHeader" width="5%"><div xstyle="width:80px; xoverflow: hidden; xtext-overflow: ellipsis;">' . ucfirst(i18n('colEndDate')) . '</div></td>' . 
           '  <td class="messageHeader" width="5%"><div xstyle="width:60px; xoverflow: hidden; xtext-overflow: ellipsis;">' . ucfirst(i18n('colLate')) . '</div></td>' . 
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . i18n('menuTicket') . '</div></td>' . 
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . i18n('menuActivity') . '</div></td>' . 
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . i18n('menuMilestone') . '</div></td>' . 
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . i18n('menuAction') . '</div></td>' . 
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . i18n('menuRisk') . '</div></td>' . 
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . i18n('menuIssue') . '</div></td>' .
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . i18n('menuQuestion') . '</div></td>' . 
           '</tr>';   
      foreach($prjLst as $sharpid=>$name) {
        $id=substr($sharpid,1);
        $crit=array('idProject'=>$id);
        $critAll=array('idProject'=>$id);
        $critTodo=array('idProject'=>$id, 'done'=>'0', 'idle'=>'0');
        $critDone=array('idProject'=>$id, 'done'=>'1', 'idle'=>'0');
        if ( $countScope=='todo') {
          $crit['idle']='0';
          $crit['done']='0';
        }
        if ( $countScope=='notClosed') {
          $crit['idle']='0';
        }
        $obj=new Action();
        $nbActions=$obj->countSqlElementsFromCriteria($crit);        
        $nbActionsAll=$obj->countSqlElementsFromCriteria($critAll);
        $nbActionsTodo=$obj->countSqlElementsFromCriteria($critTodo);
        $nbActionsDone=$obj->countSqlElementsFromCriteria($critDone);
        $nbActions=($nbActionsAll==0)?'':$nbActions;
        $obj=new Risk();
        $nbRisks=$obj->countSqlElementsFromCriteria($crit);
        $nbRisksAll=$obj->countSqlElementsFromCriteria($critAll);
        $nbRisksTodo=$obj->countSqlElementsFromCriteria($critTodo);
        $nbRisksDone=$obj->countSqlElementsFromCriteria($critDone);
        $nbRisks=($nbRisksAll==0)?'':$nbRisks;
        $obj=new Issue();
        $nbIssues=$obj->countSqlElementsFromCriteria($crit);
        $nbIssuesAll=$obj->countSqlElementsFromCriteria($critAll);
        $nbIssuesTodo=$obj->countSqlElementsFromCriteria($critTodo);
        $nbIssuesDone=$obj->countSqlElementsFromCriteria($critDone);
        $nbIssues=($nbIssuesAll==0)?'':$nbIssues;
        $obj=new Milestone();
        $nbMilestones=$obj->countSqlElementsFromCriteria($crit);
        $nbMilestonesAll=$obj->countSqlElementsFromCriteria($critAll);
        $nbMilestonesTodo=$obj->countSqlElementsFromCriteria($critTodo);
        $nbMilestonesDone=$obj->countSqlElementsFromCriteria($critDone);
        $nbMilestones=($nbMilestonesAll==0)?'':$nbMilestones;
        $obj=new Ticket();
        $nbTickets=$obj->countSqlElementsFromCriteria($crit);
        $nbTicketsAll=$obj->countSqlElementsFromCriteria($critAll);
        $nbTicketsTodo=$obj->countSqlElementsFromCriteria($critTodo);
        $nbTicketsDone=$obj->countSqlElementsFromCriteria($critDone);
        $nbTickets=($nbTicketsAll==0)?'':$nbTickets;
        $obj=new Activity();
        $nbActivities=$obj->countSqlElementsFromCriteria($crit);
        $nbActivitiesAll=$obj->countSqlElementsFromCriteria($critAll);
        $nbActivitiesTodo=$obj->countSqlElementsFromCriteria($critTodo);
        $nbActivitiesDone=$obj->countSqlElementsFromCriteria($critDone);
        $nbActivities=($nbActivitiesAll==0)?'':$nbActivities;
        $obj=new Question();
        $nbQuestions=$obj->countSqlElementsFromCriteria($crit);
        $nbQuestionsAll=$obj->countSqlElementsFromCriteria($critAll);
        $nbQuestionsTodo=$obj->countSqlElementsFromCriteria($critTodo);
        $nbQuestionsDone=$obj->countSqlElementsFromCriteria($critDone);
        $nbQuestions=($nbQuestionsAll==0)?'':$nbQuestions;
        $prj=new Project($id);
        $endDate=$prj->ProjectPlanningElement->plannedEndDate;
        $endDate=($endDate=='')?$prj->ProjectPlanningElement->validatedEndDate:$endDate;
        $endDate=($endDate=='')?$prj->ProjectPlanningElement->initialEndDate:$endDate;
        $progress='0';
        if ($prj->ProjectPlanningElement->realWork!='' and $prj->ProjectPlanningElement->plannedWork!='' and $prj->ProjectPlanningElement->plannedWork!='0') {
          $progress=round(($prj->ProjectPlanningElement->realWork) / ( $prj->ProjectPlanningElement->plannedWork) * 100 );
        }        
        $late='';
        if ($prj->ProjectPlanningElement->plannedEndDate!='' and $prj->ProjectPlanningElement->validatedEndDate!='') {
          $late=dayDiffDates($prj->ProjectPlanningElement->validatedEndDate, $prj->ProjectPlanningElement->plannedEndDate);
          $late='<div style="color:' .(($late>0)?'#DD0000':'#00AA00') . ';">' . $late;
          $late.=" " . i18n("shortDay");         
          $late.='</div>';
        }
        $wbs=$prj->ProjectPlanningElement->wbsSortable;
        $level=(strlen($wbs)+1)/4;
        $tab="";
        for ($i=1;$i<$level;$i++) {
          $tab.='&nbsp;&nbsp;&nbsp;';
          //$tab.='...';
        }
        $show=false;
        if (array_key_exists($prj->id, $prjVisLst)) {
          $show=true;
        }
        $subPrj=$prj->getSqlElementsFromCriteria(array('idProject'=>$prj->id), false);
        if ($show or count($subPrj)>0) {
          echo '<tr >' .
             '  <td class="messageData" '.($show?'':'style="color:#AAAAAA;"') . '><div style="width:100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; ">' . $tab . $name . '</div></td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress(htmlDisplayPct($progress),100,100-$progress, null, false):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'" NOWRAP>' . ($show?htmlFormatDate($endDate):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$late:'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress($nbTickets,$nbTicketsAll,$nbTicketsTodo, $nbTicketsDone):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress($nbActivities,$nbActivitiesAll,$nbActivitiesTodo,$nbActivitiesDone):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress($nbMilestones,$nbMilestonesAll,$nbMilestonesTodo,$nbMilestonesDone):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress($nbActions,$nbActionsAll,$nbActionsTodo,$nbActionsDone):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress($nbRisks,$nbRisksAll,$nbRisksTodo,$nbRisksDone):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress($nbIssues,$nbIssuesAll,$nbIssuesTodo,$nbIssuesDone):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress($nbQuestions,$nbQuestionsAll,$nbQuestionsTodo,$nbQuestionsDone):'') . '</td>' .
             '</tr>';
        }
      }
      echo'</table>';
    }
  }

  $cptDisplayId=0;
  function displayProgress($value,$allValue,$todoValue, $doneValue, $showTitle=true) {
    global $cptDisplayId;
    if ($value=='') {return $value;}
    $width=70;
    $green=($allValue)?round( $width*($allValue-$todoValue)/$allValue,0):$width;
    $red=$width-$green;

    $cptDisplayId+=1;
    $result='<div style="position:relative; width:' . $width . 'px" id="displayProgress_' . $cptDisplayId . '">';
    $result.='<div style="position:absolute; left:0px; width:' . $green . 'px;background: #AAFFAA;">&nbsp;</div>';
    $result.='<div style="position:absolute; width:' . $red . 'px;left:' . $green . 'px;background: #FFAAAA;">&nbsp;</div>';
    $result.='<div style="position:relative;">' . $value . '</div>';
    $result.='</div>';
    if ($showTitle) {
      $result.='<div dojoType="dijit.Tooltip" connectId="displayProgress_' . $cptDisplayId . '" position="below">';
      $result.="<table>";
      $result.='<tr style="text-align:right;"><td>' . i18n('titleNbTodo') . '&nbsp;:&nbsp;</td><td style="background: #FFAAAA">' . ($todoValue) . '</td></tr>';
      $result.='<tr style="text-align:right;"><td>' . i18n('titleNbDone') . '&nbsp;:&nbsp;</td><td style="background: #AAFFAA">' . ($doneValue) . '</td></tr>';
      $result.='<tr style="text-align:right;"><td>' . i18n('titleNbClosed') . '&nbsp;:&nbsp;</td><td style="background: #AAFFAA">' . ($allValue-$todoValue-$doneValue) . '</td></tr>';
      $result.='<tr style="text-align:right;font-weight:bold; border-top:1px solid #101010"><td>' . i18n('titleNbAll') . '&nbsp;:&nbsp;</td><td>' . ($allValue) . '</td></tr>';
      $result.='</table>';
      $result.='</div>';
    }
    return $result;
  }
  
  
  function showWork() {
    echo '<table align="center" style="width:95%">';
    echo '<tr>' . 
           ' <td class="messageHeader" width="6%">' . ucfirst(i18n('colId')) . '</td>' .  
           ' <td class="messageHeader" width="12%">' . ucfirst(i18n('colIdProject')) . '</td>' . 
           '  <td class="messageHeader" width="12%">' .  ucfirst(i18n('colType')) . '</td>' . 
           '  <td class="messageHeader" width="40%">' . ucfirst(i18n('colName')) . '</td>' . 
           '  <td class="messageHeader" width="8%">' . ucfirst(i18n('colDueDate')) . '</td>' . 
           '  <td class="messageHeader" width="12%">' . ucfirst(i18n('colIdStatus')) . '</td>' . 
           '  <td class="messageHeader" width="5%" title="'. i18n('isIssuerOf') . '">' . ucfirst(i18n('colIssuerShort')) . '</td>' . 
           '  <td class="messageHeader" width="5%" title="'. i18n('isResponsibleOf') . '">' . ucfirst(i18n('colResponsibleShort')) . '</td>' . 
           '</tr>';
    $user=$_SESSION['user'];
    $ass=new Assignment();
    $act=new Activity();
    $where="(idUser='" . $user->id . "'" . 
       " or idResource='" . $user->id . "'" .
       ") and idle=0 and done=0";
    $whereActivity="(idUser='" . $user->id . "'" . 
       " or idResource='" . $user->id . "'" .
       " or exists (select 'x' from " . $ass->getDatabaseTableName() . " x " . 
                   "where x.refType='Activity' and x.refId=" . $act->getDatabaseTableName() . ".id and x.idResource='" . $user->id . "')" .
       ") and idle=0 and done=0";
    $order="";
    $list=array();
    $ticket=new Ticket();
    $listTicket=$ticket->getSqlElementsFromCriteria(null, null, $where, $order);
    $list=array_merge($list, $listTicket);
    $activity= new Activity();
    $listActivity=$activity->getSqlElementsFromCriteria(null, null, $whereActivity, $order);
    $list=array_merge($list, $listActivity);
    $milestone= new Milestone();
    $listMilestone=$milestone->getSqlElementsFromCriteria(null, null, $where, $order);
    $list=array_merge($list, $listMilestone);
    $risk= new Risk();
    $listRisk=$risk->getSqlElementsFromCriteria(null, null, $where, $order);
    $list=array_merge($list, $listRisk);
    $action= new Action();
    $listAction=$action->getSqlElementsFromCriteria(null, null, $where, $order);
    $list=array_merge($list, $listAction);   
    $issue= new Issue();
    $listIssue=$issue->getSqlElementsFromCriteria(null, null, $where, $order);
    $list=array_merge($list, $listIssue);   
    $cptDisplayId=0;     
    foreach($list as $elt) {
    	$cptDisplayId++;
      $idType='id' . get_class($elt) . 'Type';
      $echeance="";
      $class=get_class($elt);
      if ($class=='Ticket') {
        $echeance=($elt->actualDueDateTime)?$elt->actualDueDateTime:$elt->initialDueDateTime;
        $echeance=substr($echeance, 0,10);
      } else if ($class=='Activity' or $class=='Milestone') {
        $pe=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', array('refType'=>$class,'refId'=>$elt->id));
        $echeance=($pe->realEndDate)?$pe->realEndDate
                 :(($pe->plannedEndDate)?$pe->plannedEndDate
                 :(($pe->validatedEndDate)?$pe->validatedEndDate
                 :$pe->initialEndDate));
      } else if ($class=="Risk" or $class=="Issue") {
        $echeance=($elt->actualEndDate)?$elt->actualEndDate:$elt->initialEndDate;
      } else if ($class=="Action" ) {
        $echeance=($elt->actualDueDate)?$elt->actualDueDate:$elt->initialDueDate;
      } 

      $statusColor=SqlList::getFieldFromId('Status', $elt->idStatus, 'color');
      $status=SqlList::getNameFromId('Status',$elt->idStatus);
      $status=($status=='0')?'':$status;
      $goto="";
      if (securityCheckDisplayMenu(null,$class) 
      and securityGetAccessRightYesNo('menu' . $class, 'read', $elt)=="YES") {
        $goto=' onClick="gotoElement(' . "'" . $class . "','" . $elt->id . "'" . ');" style="cursor: pointer;" ';  
      }
      $alertLevelArray=$elt->getAlertLevel(true);
      $alertLevel=$alertLevelArray['level'];
      $color="#FFFFFF";
      if ($alertLevel=='ALERT') {
      	$color='background-color:#FFAAAA;';
      } else if ($alertLevel=='WARNING') {
      	$color='background-color:#FFFFAA;';         
      }
      echo '<tr ' . $goto . ' id="displayWork_' . $cptDisplayId . '" >';
      if ($alertLevel!='NONE') {
        echo '<div dojoType="dijit.Tooltip" connectId="displayWork_' . $cptDisplayId . '" position="below">';
        echo $alertLevelArray['description'];
        echo '</div>';
      }
      echo '  <td class="messageData" style="'.$color.'">' . 
                   '<table><tr><td><img src="css/images/icon' . $class . '16.png" width="16" height="16" title="' . i18n($class). '"/>' .
                   '</td><td>&nbsp;</td><td>#' . $elt->id. '</td></tr></table></td>' .
             '  <td class="messageData" style="'.$color.'">' . SqlList::getNameFromId('Project', $elt->idProject) . '</td>' .
             '  <td class="messageData" style="'.$color.'">' . SqlList::getNameFromId($class .'Type', $elt->$idType) . '</td>' .
             '  <td class="messageData" style="'.$color.'">' . $elt->name . '</td>' .
             '  <td class="messageDataValue" style="'.$color.'" NOWRAP>' . htmlFormatDate($echeance) . '</td>' .
             '  <td class="messageData" style="'.$color.'">' . htmlDisplayColored($status,$statusColor) . '</td>' .
             '  <td class="messageDataValue" style="'.$color.'">' . htmlDisplayCheckbox($user->id==$elt->idUser) . '</td>' .
             '  <td class="messageDataValue" style="'.$color.'">' . htmlDisplayCheckbox($user->id==$elt->idResource) . '</td>' .
            '</tr>';
      }
      echo "</table>";
  }  
?>      
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Today" />
<div  class="container" dojoType="dijit.layout.BorderContainer">
  <div style="overflow: auto;" id="detailDiv" dojoType="dijit.layout.ContentPane" region="center"> 
    <div id="todayMessageDiv" dojoType="dijit.TitlePane" open="true" title="<?php echo i18n('menuMessage');?>">  
<?php showMessages();?>
    </div><br/>
    <div id="todayProjectDiv" dojoType="dijit.TitlePane" open="true" title="<?php echo i18n('menuProject');?>">
    <?php showProjects();?>
    </div><br/>
    <div id="todayWorkDiv" dojoType="dijit.TitlePane" open="true" title="<?php echo i18n('menuWork');?>">
    <?php showWork();?>
  </div><br/>
  </div>
</div>
