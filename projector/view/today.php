<?php
/* ============================================================================
 * List of parameter specific to a user.
 * Every user may change these parameters (for his own user only !).
 */
  require_once "../tool/projector.php";
  scriptLog('   ->/view/today.php');
  
  $user=$_SESSION['user'];
  
  function showMessages() {
    $user=$_SESSION['user'];
    $msg=new Message();
    $where="idle=0";
    $where.=" and (idUser is null or idUser='" . $user->id . "')";
    $where.=" and (idProfile is null or idProfile='" . $user->idProfile . "')";
    //  transformListIntoInClause($user->getVisibleProjects());
    $sort="id desc";
    $listMsg=$msg->getSqlElementsFromCriteria(null,false,$where,$sort);
    if (count($listMsg)>0) {
      echo '<table align="center" style="width:95%">';
      foreach($listMsg as $msg) {
        echo'<br />';
        $type=new MessageType($msg->idMessageType);
        echo '<tr><td class="messageHeader" style="color:' . $type->color . ';">' . $msg->name . '</td></tr>';
        echo '<tr><td class="messageData" style="color:' . $type->color . ';">' . htmlEncode($msg->description, 'print') . '</td></tr>';
      }
      echo'</table>';
    }
  }
  
  function showProjects() {
    $user=$_SESSION['user'];
    $prjLst=$user->getVisibleProjects();
    if (count($prjLst)>0) {
      echo '<br/>';
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
      foreach($prjLst as $id=>$name) {
        $crit=array('idProject'=>$id, 'done'=>'0', 'idle'=>'0');
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
        echo '<tr >' .
             '  <td class="messageData">' . $name . '</td>' .
             '  <td class="messageDataValue">' . $progress . '</td>' .
             '  <td class="messageDataValue" NOWRAP>' . $endDate . '</td>' .
             '  <td class="messageDataValue">' . $late . '</td>' .
             '  <td class="messageDataValue">' . $nbTickets . '</td>' .
             '  <td class="messageDataValue">' . $nbActivities . '</td>' .
             '  <td class="messageDataValue">' . $nbMilestones . '</td>' .
             '  <td class="messageDataValue">' . $nbActions . '</td>' .
             '  <td class="messageDataValue">' . $nbRisks . '</td>' .
             '  <td class="messageDataValue">' . $nbIssues . '</td>' .
             '</tr>';   
      }
      echo'</table>';
    }
  }
?>      

<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="detailDiv" dojoType="dijit.layout.ContentPane" region="center"> 
    <?php 
      showMessages();
      showProjects();
    ?>
  </div>
</div>
