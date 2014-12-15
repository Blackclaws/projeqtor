<?php
/* ============================================================================
 * List of parameter specific to a user.
 * Every user may change these parameters (for his own user only !).
 */
  require_once "../tool/projector.php";
  scriptLog('   ->/view/today.php');
  
  $user=$_SESSION['user'];
  
  if (array_key_exists('refreshProjects',$_REQUEST)) {
    $_SESSION['todayCountIdle']=(array_key_exists('countIdle',$_REQUEST))?true:false;
    $_SESSION['todayCountDone']=(array_key_exists('countDone',$_REQUEST))?true:false;
    showProjects();
    exit;
  } 
  
  function showMessages() {
    $user=$_SESSION['user'];
    $msg=new Message();
    $where="idle=0";
    $where.=" and (idUser is null or idUser='" . $user->id . "')";
    $where.=" and (idProfile is null or idProfile='" . $user->idProfile . "')";
    $where.=" and (idProject in " . transformListIntoInClause($prjLst=$user->getVisibleProjects()) . ")";
    
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
    if (array_key_exists('todayCountIdle',$_SESSION)) {
      $showIdle=$_SESSION['todayCountIdle'];
    }
    if (array_key_exists('todayCountDone',$_SESSION)) {
      $showDone=$_SESSION['todayCountDone'];
    }
    if (count($prjLst)>0) {
      echo '<form id="todayProjectsForm" name="todayProjectsForm">';
      echo '<table align="center" style="width:95%">';
      echo '<tr><td align="right">';
      echo i18n('countDone');
      echo '&nbsp;<div title="' . i18n('countDone') . '" dojoType="dijit.form.CheckBox" type="checkbox" '
       . 'id="countDone" name="countDone" ' . ($showDone?'checked="checked"':'') . '>';
      echo ' <script type="dojo/connect" event="onChange" > refreshTodayProjectsList();</script>';
      echo '</div>&nbsp;&nbsp;&nbsp;';
      echo i18n('countIdle');
      echo '&nbsp;<div title="' . i18n('countIdle') . '" dojoType="dijit.form.CheckBox" type="checkbox" '
        . 'id="countIdle" name="countIdle" ' . ($showIdle?'checked="checked"':'') . '>';
      echo ' <script type="dojo/connect" event="onChange" > refreshTodayProjectsList();</script>';
      echo '</div>&nbsp;';      
      echo '</td></tr>';
      echo '</table></form>';
      echo '<table align="center" style="width:95%">';
      echo '<tr>' . 
           '  <td class="messageHeader">' . i18n('menuProject') . '</td>' . 
           '  <td class="messageHeader" width="5%">' . ucfirst(i18n('progress')) . '</td>' . 
           '  <td class="messageHeader" width="5%">' . ucfirst(i18n('colEndDate')) . '</td>' . 
           '  <td class="messageHeader" width="5%">' . ucfirst(i18n('colLate')) . '</td>' . 
           '  <td class="messageHeader" width="5%">' . i18n('menuTicket') . '</td>' . 
           '  <td class="messageHeader" width="5%">' . i18n('menuActivity') . '</td>' . 
           '  <td class="messageHeader" width="5%">' . i18n('menuMilestone') . '</td>' . 
           '  <td class="messageHeader" width="5%">' . i18n('menuAction') . '</td>' . 
           '  <td class="messageHeader" width="5%">' . i18n('menuRisk') . '</td>' . 
           '  <td class="messageHeader" width="5%">' . i18n('menuIssue') . '</td>' . 
           '</tr>';   
      foreach($prjLst as $sharpid=>$name) {
        $id=substr($sharpid,1);
        $crit=array('idProject'=>$id);
        if ( ! $showIdle) {$crit['idle']='0';}
        if ( ! $showDone and ! $showIdle) {$crit['done']='0';}
        $obj=new Action();
        $nbActions=count($obj->getSqlElementsFromCriteria($crit, false));
        $nbActions=($nbActions==0)?'':$nbActions;
        $obj=new Risk();
        $nbRisks=count($obj->getSqlElementsFromCriteria($crit, false));
        $nbRisks=($nbRisks==0)?'':$nbRisks;
        $obj=new Issue();
        $nbIssues=count($obj->getSqlElementsFromCriteria($crit, false));
        $nbIssues=($nbIssues==0)?'':$nbIssues;
        $obj=new Milestone();
        $nbMilestones=count($obj->getSqlElementsFromCriteria($crit, false));
        $nbMilestones=($nbMilestones==0)?'':$nbMilestones;
        $obj=new Ticket();
        $nbTickets=count($obj->getSqlElementsFromCriteria($crit, false));
        $nbTickets=($nbTickets==0)?'':$nbTickets;
        $obj=new Activity();
        $nbActivities=count($obj->getSqlElementsFromCriteria($crit, false));
        $nbActivities=($nbActivities==0)?'':$nbActivities;
        $prj=new Project($id);
        $endDate=$prj->ProjectPlanningElement->plannedEndDate;
        $endDate=($endDate=='')?$prj->ProjectPlanningElement->validatedEndDate:$endDate;
        $endDate=($endDate=='')?$prj->ProjectPlanningElement->initialEndDate:$endDate;
        $progress='';
        if ($prj->ProjectPlanningElement->realWork!='' and $prj->ProjectPlanningElement->plannedWork!='' and $prj->ProjectPlanningElement->plannedWork!='0') {
          $progress=round(($prj->ProjectPlanningElement->realWork) / ( $prj->ProjectPlanningElement->plannedWork) * 100 );
          $progress.=" %";
        }        
        $late='';
        if ($prj->ProjectPlanningElement->plannedEndDate!='' and $prj->ProjectPlanningElement->validatedEndDate!='') {
          $late=dayDiffDates($prj->ProjectPlanningElement->validatedEndDate, $prj->ProjectPlanningElement->plannedEndDate);
          $late.=" " . i18n("shortDay");
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
        echo '<tr >' .
             '  <td class="messageData" '.($show?'':'style="color:#AAAAAA;"') . '>' . $tab . $name . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$progress:'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'" NOWRAP>' . ($show?htmlFormatDate($endDate):'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$late:'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$nbTickets:'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$nbActivities:'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$nbMilestones:'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$nbActions:'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$nbRisks:'') . '</td>' .
             '  <td class="messageDataValue'.($show?'':'Grey').'">' . ($show?$nbIssues:'') . '</td>' .
             '</tr>';   
      }
      echo'</table>';
    }
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
         
    foreach($list as $elt) {
      $idType='id' . get_class($elt) . 'Type';
      $echeance="";
      $class=get_class($elt);
      if ($class=='Ticket') {
        $echeance=($elt->actualDueDateTime)?$elt->actualDueDateTime:$elt->initialDueDateTime;
        $echeance=substr($echeance, 0,10);
      } else if ($class=='Activity' or $class=='Milestone') {
        $pe=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', array('refType'=>$class,'refId'=>$elt->id));
        $echeance=($pe->realEndDate)?$pe->realEndDate
            :($pe->plannedEndDate)?$pe->plannedEndDate
            :($pe->validatedEndDate)?$pe->validatedEndDate
            :$pe->initialEndDate;
          
      } else if ($class=="Risk" or $class=="Issue") {
        $echeance=($elt->actualEndDate)?$elt->actualEndDate:$elt->initialEndDate;
      } else if ($class=="Action" ) {
        $echeance=($elt->actualDueDate)?$elt->actualDueDate:$elt->initialDueDate;
      } 

      $statusColor=SqlList::getFieldFromId('Status', $elt->idStatus, 'color');
      $status=SqlList::getNameFromId('Status',$elt->idStatus);
      echo '<tr onClick="gotoElement(' . "'" . $class . "','" . $elt->id . "'" . ');" style="cursor: pointer;">' .
             '  <td class="messageData">' . 
                   '<table><tr><td><img src="css/images/icon' . $class . '16.png" width="16" height="16" title="' . i18n($class). '"/>' .
                   '</td><td>&nbsp;</td><td>#' . $elt->id. '</td></tr></table></td>' .
             '  <td class="messageData">' . SqlList::getNameFromId('Project', $elt->idProject) . '</td>' .
             '  <td class="messageData">' . SqlList::getNameFromId($class .'Type', $elt->$idType) . '</td>' .
             '  <td class="messageData">' . $elt->name . '</td>' .
             '  <td class="messageDataValue" NOWRAP>' . htmlFormatDate($echeance) . '</td>' .
             '  <td class="messageData">' . htmlDisplayColored($status,$statusColor) . '</td>' .
             '  <td class="messageDataValue">' . htmlDisplayCheckbox($user->id==$elt->idUser) . '</td>' .
             '  <td class="messageDataValue">' . htmlDisplayCheckbox($user->id==$elt->idResource) . '</td>' .
            '</tr>';
      }
      echo "</table>";
  }  
?>      
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
