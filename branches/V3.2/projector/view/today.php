<?php
/* ============================================================================
 * List of parameter specific to a user.
 * Every user may change these parameters (for his own user only !).
 */
  require_once "../tool/projector.php";
  scriptLog('   ->/view/today.php');  
  $user=$_SESSION['user'];
  $profile=new Profile($user->idProfile);
  $cptMax=Parameter::getGlobalParameter('maxItemsInTodayLists');
  if (! $cptMax) {$cptMax=100;}
  
SqlElement::$_cachedQuery['Project']=array();
SqlElement::$_cachedQuery['ProjectPlanningElement']=array();
SqlElement::$_cachedQuery['PlanningElement']=array();

  $collapsedList=Collapsed::getCollaspedList();
  
  if (array_key_exists('refreshProjects',$_REQUEST)) {
    $_SESSION['todayCountScope']=(array_key_exists('countScope',$_REQUEST))?$_REQUEST['countScope']:'todo';
    showProjects();
    exit;
  } 
  
  function showMessages() {
  	global $cptMax;
    $user=$_SESSION['user'];
    $msg=new Message();
    $where="idle=0";
    $where.=" and (idUser is null or idUser='" .Sql::fmtId( $user->id) . "')";
    $where.=" and (idProfile is null or idProfile='" . Sql::fmtId($user->idProfile) . "')";
    $where.=" and (idProject is null or idProject in " . transformListIntoInClause($prjLst=$user->getVisibleProjects()) . ")";
    
    $sort="id desc";
    $listMsg=$msg->getSqlElementsFromCriteria(null,false,$where,$sort);
    if (count($listMsg)>0) {
    	$cpt=0;
      echo '<table align="center" style="width:95%">';
      foreach($listMsg as $msg) {
      	$cpt++;
      	if ($cpt>$cptMax) {
      		echo '<tr><td colspan="2" class="messageData">'.i18n('limitedDisplay',array($cptMax)).'</td></tr>';
      		break;
      	}
        //echo'<br />';
        $type=new MessageType($msg->idMessageType);
        echo '<tr><td class="messageHeader" style="color:' . $type->color . ';">' . htmlEncode($msg->name) . '</td></tr>';
        echo '<tr><td class="messageData" style="color:' . $type->color . ';">' . htmlEncode($msg->description, 'print') . '</td></tr>';
      }
      echo'</table>';
    }
  }
  
  function showProjects() {
  	global $cptMax;
    $user=$_SESSION['user'];
    $prjVisLst=$user->getVisibleProjects();
    $prjLst=$user->getHierarchicalViewOfVisibleProjects(true);
    $obj=new Action();
    $cptAction=$obj->countGroupedSqlElementsFromCriteria(null,array('idProject','done','idle'),'idProject in '.transformListIntoInClause($prjVisLst));
    $obj=new Risk();
    $cptRisk=$obj->countGroupedSqlElementsFromCriteria(null,array('idProject','done','idle'),'idProject in '.transformListIntoInClause($prjVisLst));    
    $obj=new Issue();
    $cptIssue=$obj->countGroupedSqlElementsFromCriteria(null,array('idProject','done','idle'),'idProject in '.transformListIntoInClause($prjVisLst));
    $obj=new Milestone();
    $cptMilestone=$obj->countGroupedSqlElementsFromCriteria(null,array('idProject','done','idle'),'idProject in '.transformListIntoInClause($prjVisLst));
    $obj=new Ticket();
    $cptTicket=$obj->countGroupedSqlElementsFromCriteria(null,array('idProject','done','idle'),'idProject in '.transformListIntoInClause($prjVisLst));
    $obj=new Activity();
    $cptActivity=$obj->countGroupedSqlElementsFromCriteria(null,array('idProject','done','idle'),'idProject in '.transformListIntoInClause($prjVisLst));
    $obj=new Question();
    $cptQuestion=$obj->countGroupedSqlElementsFromCriteria(null,array('idProject','done','idle'),'idProject in '.transformListIntoInClause($prjVisLst));
    $obj=new Project();
    $cptsubProject=$obj->countGroupedSqlElementsFromCriteria(null,array('idProject'),'idProject in '.transformListIntoInClause($prjVisLst)); 
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
           '  <td class="messageHeader" colspan="2">' . i18n('menuProject') . '</td>' . 
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . ucfirst(i18n('progress')) . '</div></td>' .
           '  <td class="messageHeader" width="' . $width . 'px;"><div xstyle="width:50px; xoverflow: hidden; xtext-overflow: ellipsis;">' . ucfirst(i18n('colLeft')) . '</div></td>' .
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
      $cpt=0;
      foreach($prjLst as $sharpid=>$sharpName) {
        $cpt++;
        if ($cpt>$cptMax) {
          echo '<tr><td colspan="12" class="messageData">'.i18n('limitedDisplay',array($cptMax)).'</td></tr>';
          break;
        }
      	$split=explode('#',$sharpName);
      	$wbs=$split[0];
      	$name=$split[1];
        $id=substr($sharpid,1);
        $nbActions=countFrom($cptAction,$id,'',$countScope);        
        $nbActionsAll=countFrom($cptAction,$id,'All',$countScope);  
        $nbActionsTodo=countFrom($cptAction,$id,'Todo',$countScope);  
        $nbActionsDone=countFrom($cptAction,$id,'Done',$countScope);  
        $nbActions=($nbActionsAll==0)?'':$nbActions;
        $nbRisks=countFrom($cptRisk,$id,'',$countScope);
        $nbRisksAll=countFrom($cptRisk,$id,'All',$countScope);
        $nbRisksTodo=countFrom($cptRisk,$id,'Todo',$countScope);
        $nbRisksDone=countFrom($cptRisk,$id,'Done',$countScope);
        $nbRisks=($nbRisksAll==0)?'':$nbRisks;
        $obj=new Issue();
        $nbIssues=countFrom($cptIssue,$id,'',$countScope);
        $nbIssuesAll=countFrom($cptIssue,$id,'All',$countScope);
        $nbIssuesTodo=countFrom($cptIssue,$id,'Todo',$countScope);
        $nbIssuesDone=countFrom($cptIssue,$id,'Done',$countScope);
        $nbIssues=($nbIssuesAll==0)?'':$nbIssues;
        $obj=new Milestone();
        $nbMilestones=countFrom($cptMilestone,$id,'',$countScope);
        $nbMilestonesAll=countFrom($cptMilestone,$id,'All',$countScope);
        $nbMilestonesTodo=countFrom($cptMilestone,$id,'Todo',$countScope);
        $nbMilestonesDone=countFrom($cptMilestone,$id,'Done',$countScope);
        $nbMilestones=($nbMilestonesAll==0)?'':$nbMilestones;
        $obj=new Ticket();
        $nbTickets=countFrom($cptTicket,$id,'',$countScope);
        $nbTicketsAll=countFrom($cptTicket,$id,'All',$countScope);
        $nbTicketsTodo=countFrom($cptTicket,$id,'Todo',$countScope);
        $nbTicketsDone=countFrom($cptTicket,$id,'Done',$countScope);
        $nbTickets=($nbTicketsAll==0)?'':$nbTickets;
        $obj=new Activity();
        $nbActivities=countFrom($cptActivity,$id,'',$countScope);
        $nbActivitiesAll=countFrom($cptActivity,$id,'All',$countScope);
        $nbActivitiesTodo=countFrom($cptActivity,$id,'Todo',$countScope);
        $nbActivitiesDone=countFrom($cptActivity,$id,'Done',$countScope);
        $nbActivities=($nbActivitiesAll==0)?'':$nbActivities;
        $obj=new Question();
        $nbQuestions=countFrom($cptQuestion,$id,'',$countScope);
        $nbQuestionsAll=countFrom($cptQuestion,$id,'All',$countScope);
        $nbQuestionsTodo=countFrom($cptQuestion,$id,'Todo',$countScope);
        $nbQuestionsDone=countFrom($cptQuestion,$id,'Done',$countScope);
        $nbQuestions=($nbQuestionsAll==0)?'':$nbQuestions;
        $prjPE=SqlElement::getSingleSqlElementFromCriteria('ProjectPlanningElement', array('refType'=>'Project', 'refId'=>$id));
        $endDate=$prjPE->plannedEndDate;
        $endDate=($endDate=='')?$prjPE->validatedEndDate:$endDate;
        $endDate=($endDate=='')?$prjPE->initialEndDate:$endDate;
        $progress='0';
        if ($prjPE->realWork!='' and $prjPE->plannedWork!='' and $prjPE->plannedWork!='0') {
          $progress=$prjPE->progress;
        }
        $real=$prjPE->realWork;
        $left=$prjPE->leftWork;
        $planned=$prjPE->plannedWork;
        $late='';
        if ($prjPE->plannedEndDate!='' and $prjPE->validatedEndDate!='') {
          $late=dayDiffDates($prjPE->validatedEndDate, $prjPE->plannedEndDate);
          $late='<div style="color:' .(($late>0)?'#DD0000':'#00AA00') . ';">' . $late;
          $late.=" " . i18n("shortDay");         
          $late.='</div>';
        }
        //$wbs=$prjPE->wbsSortable;
        $split=explode('.',$wbs);
        $level=count($split);
        $tab="";
        for ($i=1;$i<$level;$i++) {
          $tab.='&nbsp;&nbsp;&nbsp;';
          //$tab.='...';
        }
        $show=false;
        if (array_key_exists($id, $prjVisLst)) {
          $show=true;
        }
        $cptSubPrj=(isset($cptsubProject[$id]))?$cptsubProject[$id]:0;
        if ($show or $cptSubPrj>0) {
        	$goto="";
          if ($show and securityCheckDisplayMenu(null,'Project') 
          //and securityGetAccessRightYesNo('menuProject', 'read', $prj)=="YES"
          and array_key_exists($id,$prjVisLst)
          ) {
            $goto=' onClick="gotoElement(' . "'Project','" . $id . "'" . ');" style="cursor: pointer;' . ($show?'':'color:#AAAAAA;') . '" ';  
          }
          $proj=new Project($id);
          $healthColor=SqlList::getFieldFromId("Health", $proj->idHealth, "color");
          $healthName=SqlList::getNameFromId("Health", $proj->idHealth);
          echo '<tr >' .
             '  <td class="messageData" style="border-right:0px;"'. $goto . '><div style="width:100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; ">' . $tab . htmlEncode($name) . '</div></td>' .
             '  <td class="messageData" style="width:14px;margin:0;padding:0;spacing:0;border-left:0px;" '. $goto . ' ><div class="colorHealth" style="background:'.$healthColor.';" title="'.$healthName.'">&nbsp;</div></td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?displayProgress(htmlDisplayPct($progress),$planned,$left, $real,true,true):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?Work::displayWorkWithUnit($left):'') . '</td>' .
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

  function countFrom($list,$idProj,$type, $scope) {
  	$cpt00=(isset($list[$idProj.'|0|0']))?$list[$idProj.'|0|0']:0;
  	$cpt01=(isset($list[$idProj.'|0|1']))?$list[$idProj.'|0|1']:0;
  	$cpt10=(isset($list[$idProj.'|1|0']))?$list[$idProj.'|1|0']:0;
  	$cpt11=(isset($list[$idProj.'|1|1']))?$list[$idProj.'|1|1']:0;
  	if ($type=='All') {
  		return $cpt00+$cpt01+$cpt10+$cpt11;
  	} else if ($type=='Todo') {
  		return $cpt00;
  	} else if ($type=='Done') {
  		return $cpt10;
  	} else {
  		if ( $scope=='todo') {
  			return $cpt00;
  		} else if ( $scope=='notClosed') {
  			return $cpt00+$cpt10;
  		} else {
  			return $cpt00+$cpt01+$cpt10+$cpt11;
  		}
  	}
  }
  
  $cptDisplayId=0;
  function displayProgress($value,$allValue,$todoValue, $doneValue, $showTitle=true, $isWork=false) {
    global $cptDisplayId;
    if ($value==='') {return $value;}
    $width=70;
    $green=($allValue!=0 and $allValue)?round( $width*($allValue-$todoValue)/$allValue,0):$width;
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
      if ($isWork) {
        $result.='<tr style="text-align:right;"><td>' . i18n('real') . '&nbsp;:&nbsp;</td><td style="background: #AAFFAA">' . Work::displayWorkWithUnit($doneValue) . '</td></tr>';
        $result.='<tr style="text-align:right;"><td>' . i18n('left') . '&nbsp;:&nbsp;</td><td style="background: #FFAAAA">' . Work::displayWorkWithUnit($todoValue) . '</td></tr>';
        $result.='<tr style="text-align:right;font-weight:bold; border-top:1px solid #101010"><td>' . i18n('sum') . '&nbsp;:&nbsp;</td><td>' . Work::displayWorkWithUnit($allValue) . '</td></tr>';
      } else {
        $result.='<tr style="text-align:right;"><td>' . i18n('titleNbTodo') . '&nbsp;:&nbsp;</td><td style="background: #FFAAAA">' . ($todoValue) . '</td></tr>';
        $result.='<tr style="text-align:right;"><td>' . i18n('titleNbDone') . '&nbsp;:&nbsp;</td><td style="background: #AAFFAA">' . ($doneValue) . '</td></tr>';
        $result.='<tr style="text-align:right;"><td>' . i18n('titleNbClosed') . '&nbsp;:&nbsp;</td><td style="background: #AAFFAA">' . ($allValue-$todoValue-$doneValue) . '</td></tr>';
        $result.='<tr style="text-align:right;font-weight:bold; border-top:1px solid #101010"><td>' . i18n('titleNbAll') . '&nbsp;:&nbsp;</td><td>' . ($allValue) . '</td></tr>';
      }
      $result.='</table>';
      $result.='</div>';
    }
    return $result;
  }
  
  function showAssignedTasks() {
  	$user=$_SESSION['user'];
  	$ass=new Assignment();
    $act=new Activity();
  	$where="1=0";
  	$whereTicket=$where;
    $whereActivity=" (exists (select 'x' from " . $ass->getDatabaseTableName() . " x " .
      "where x.refType='Activity' and x.refId=" . $act->getDatabaseTableName() . ".id and x.idResource='" . Sql::fmtId($user->id) . "')" .
      ") and idle=0 and done=0";
    showActivitiesList($where, $whereActivity, $whereTicket, 'Today_WorkDiv', 'todayAssignedTasks');
  }
  
  function showResponsibleTasks() {
    $user=$_SESSION['user'];
    $ass=new Assignment();
    $act=new Activity();
    $where="(idResource='" . Sql::fmtId($user->id) . "'" .
      ") and idle=0 and done=0";
    $whereTicket=$where;
    $whereActivity=$where;
    showActivitiesList($where, $whereActivity, $whereTicket, 'Today_RespDiv', 'todayResponsibleTasks');
  }
  
  function showIssuerRequestorTasks() {
  	$user=$_SESSION['user'];
  	$where="(idUser='" . Sql::fmtId($user->id) . "'" . 
       ") and idle=0 and done=0";
  	$whereTicket="(idUser='" . Sql::fmtId($user->id) . "'" . 
       " or idContact='" . Sql::fmtId($user->id) . "'" .
       ") and idle=0 and done=0";
    $whereActivity=$whereTicket;
    showActivitiesList($where, $whereActivity, $whereTicket, 'Today_FollowDiv', 'todayIssuerRequestorTasks');
  }
  
  function showProjectsTasks() {
    $where="(idProject in " . getVisibleProjectsList() .
       ") and idle=0 and done=0";
    $whereTicket=$where;
    $whereActivity=$where;
    showActivitiesList($where, $whereActivity, $whereTicket, 'Today_ProjectTasks', 'todayProjectsTasks');
  }
  
  function showActivitiesList($where, $whereActivity, $whereTicket, $divName, $title) {
  	global $cptMax;
  	global $collapsedList;
    $user=$_SESSION['user'];
    $ass=new Assignment();
    $act=new Activity();
    $order="";
    $list=array();
    $ticket=new Ticket();
    $listTicket=$ticket->getSqlElementsFromCriteria(null, null, $whereTicket, $order, null, true,$cptMax+1);
    $list=array_merge($list, $listTicket);
    $activity= new Activity();
    $listActivity=$activity->getSqlElementsFromCriteria(null, null, $whereActivity, $order, null, true,$cptMax+1);
    $list=array_merge($list, $listActivity);
    $milestone= new Milestone();
    $listMilestone=$milestone->getSqlElementsFromCriteria(null, null, $where, $order, null, true,$cptMax+1);
    $list=array_merge($list, $listMilestone);
    $risk= new Risk();
    $listRisk=$risk->getSqlElementsFromCriteria(null, null, $where, $order, null, true,$cptMax+1);
    $list=array_merge($list, $listRisk);
    $action= new Action();
    $listAction=$action->getSqlElementsFromCriteria(null, null, $where, $order, null, true,$cptMax+1);
    $list=array_merge($list, $listAction);   
    $issue= new Issue();
    $listIssue=$issue->getSqlElementsFromCriteria(null, null, $where, $order, null, true,$cptMax+1);
    $list=array_merge($list, $listIssue);   
    $cptDisplayId=0;
    echo '<div id="' . $divName . '" dojoType="dijit.TitlePane"';
    echo ' open="' . (array_key_exists($divName, $collapsedList)?'false':'true') . '"';
    echo ' onHide="saveCollapsed(\'' . $divName . '\');"';
    echo ' onShow="saveExpanded(\'' . $divName . '\');"';
    echo ' title="' . ucfirst(i18n($title)) . '"';
    echo '>';
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
    $cpt=0;
    foreach($list as $elt) {
      $cpt++;
      if ($cpt>$cptMax) {
        echo '<tr><td colspan="8" class="messageData" style="text-align:center;"><b>'.i18n('limitedDisplay',array($cptMax)).'</b></td></tr>';
        break;
      }
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
      $color="background-color:#FFFFFF";
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
             '  <td class="messageData" style="'.$color.'">' . htmlEncode(SqlList::getNameFromId('Project', $elt->idProject)) . '</td>' .
             '  <td class="messageData" style="'.$color.'">' . SqlList::getNameFromId($class .'Type', $elt->$idType) . '</td>' .
             '  <td class="messageData" style="'.$color.'">' . htmlEncode($elt->name) . '</td>' .
             '  <td class="messageDataValue" style="'.$color.'" NOWRAP>' . htmlFormatDate($echeance) . '</td>' .
             '  <td class="messageData" style="'.$color.'">' . htmlDisplayColored($status,$statusColor) . '</td>' .
             '  <td class="messageDataValue" style="'.$color.'">' . htmlDisplayCheckbox($user->id==$elt->idUser) . '</td>' .
             '  <td class="messageDataValue" style="'.$color.'">' . htmlDisplayCheckbox($user->id==$elt->idResource) . '</td>' .
            '</tr>';
    }
    echo "</table>";
    echo "</div><br/>";
  }  
?>      
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Today" />
<div  class="container" dojoType="dijit.layout.BorderContainer">
  <div style="overflow: auto;" id="detailDiv" dojoType="dijit.layout.ContentPane" region="center">
    <?php $titlePane="Today_message"; ?>  
    <div dojoType="dijit.TitlePane" 
      open="<?php echo ( array_key_exists($titlePane, $collapsedList)?'false':'true');?>"
      id="<?php echo $titlePane;?>" 
      onHide="saveCollapsed('<?php echo $titlePane;?>');"
      onShow="saveExpanded('<?php echo $titlePane;?>');"
      title="<?php echo i18n('menuMessage');?>">  
<?php showMessages();?>
    </div><br/>
    <?php $titlePane="Today_project"; ?> 
    <div dojoType="dijit.TitlePane" 
      open="<?php echo ( array_key_exists($titlePane, $collapsedList)?'false':'true');?>"
      id="<?php echo $titlePane;?>" 
      onHide="saveCollapsed('<?php echo $titlePane;?>');"
      onShow="saveExpanded('<?php echo $titlePane;?>');"
      title="<?php echo i18n('menuProject');?>">
    <?php showProjects();?>
    </div><br/>
    <?php 
    showAssignedTasks();
    showResponsibleTasks();
    showIssuerRequestorTasks();
    if ($profile->profileCode=='PL') {
      showProjectsTasks();
    }
?>
  </div>
</div>