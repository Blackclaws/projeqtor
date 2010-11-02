<?PHP
/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
  require_once "../tool/projector.php";  
  $objectClass='PlanningElement';
  $obj=new $objectClass();
  $table=$obj->getDatabaseTableName();
  $print=false;
  if ( array_key_exists('print',$_REQUEST) ) {
    $print=true;
    include_once('../tool/formatter.php');
  }
  
  // Header
  $headerParameters="";
  if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
    $headerParameters.= i18n("colIdProject") . ' : ' . SqlList::getNameFromId('Project', $_REQUEST['idProject']) . '<br/>';
  }
  include "header.php";

  $accessRightRead=securityGetAccessRight('menuProject', 'read');
  
  $querySelect = '';
  $queryFrom='';
  $queryWhere='';
  $queryOrderBy='';
  $idTab=0;
  if (! array_key_exists('idle',$_REQUEST) ) {
    $queryWhere= $table . ".idle=0 ";
  }
  if (array_key_exists('idProject',$_REQUEST) ) {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    if ($_REQUEST['idProject']!=' ') {
      $queryWhere.=  $table . ".idProject in " . getVisibleProjectsList(true, $_REQUEST['idProject']) ;
    } else {
      $queryWhere.=  $table . ".idProject in " . getVisibleProjectsList() ;
    }
  } else if (property_exists($obj, 'idProject') and array_key_exists('project',$_SESSION)) {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    $queryWhere.=  $table . ".idProject in " . getVisibleProjectsList() ;
  }
  
  if ($accessRightRead=='NO') {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    $queryWhere.=  "(1 = 2)";      
  } else if ($accessRightRead=='OWN') {
    $queryWhere.= ($queryWhere=='')?'':' and '; 
    $queryWhere.=  "(1 = 2)"; // If visibility = own => no visibility            
  } else if ($accessRightRead=='PRO') {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    $queryWhere.=  $table . ".idProject in " . transformListIntoInClause($_SESSION['user']->getVisibleProjects()) ;      
  } else if ($accessRightRead=='ALL') {
    // No restriction to add
  }

  $querySelect .= $table . ".* ";
  $queryFrom .= $table;  
  $queryOrderBy .= $table . ".wbsSortable ";

  // constitute query and execute
  $queryWhere=($queryWhere=='')?' 1=1':$queryWhere;
  $query='select ' . $querySelect 
       . ' from ' . $queryFrom
       . ' where ' . $queryWhere 
       . ' order by ' . $queryOrderBy;
  $result=Sql::query($query);

  $test=array();
  if (Sql::$lastQueryNbRows > 0) $test[]="OK";
  if (checkNoData($test))  exit;
  
  if (Sql::$lastQueryNbRows > 0) {
    // Header
    echo '<table class="ganttTable" style="border: 1px solid #AAAAAA; margin: 0px; padding: 0px;" align="center">';
    echo '<tr class="ganttHeight"><td colspan="6">&nbsp;</td>';
    echo '</tr>';
    echo '<TR class="ganttHeight">';
    echo '  <TD class="ganttLeftTitle" width="15px"></TD>';
    echo '  <TD class="ganttLeftTitle" width="200px" style="border-left:0px; text-align: left;">' . i18n('colTask') . '</TD>';
    echo '  <TD class="ganttLeftTitle" width="50px" nowrap>' . i18n('colValidated') . '</TD>' ;
    echo '  <TD class="ganttLeftTitle" width="50px" nowrap>' . i18n('colAssigned') . '</TD>' ;
    echo '  <TD class="ganttLeftTitle" width="50px" nowrap>' . i18n('colPlanned') . '</TD>' ;
    echo '  <TD class="ganttLeftTitle" width="50px" nowrap>' . i18n('colReal') . '</TD>' ;
    echo '  <TD class="ganttLeftTitle" width="50px" nowrap>' . i18n('colLeft') . '</TD>' ;
    echo '  <TD class="ganttLeftTitle" width="50px" nowrap>' . i18n('progress') . '</TD>' ;
    echo '</TR>';       
    // Treat each line
    while ($line = Sql::fetchLine($result)) {
      $validatedWork=$line['validatedWork'];
      $assignedWork=$line['assignedWork'];
      $plannedWork=$line['plannedWork'];
      $realWork=$line['realWork'];
      $leftWork=$line['leftWork'];
      $progress=' 0';
      if ($plannedWork>0) {
        $progress=round(100*$realWork/$plannedWork);
      } else {
        if ($line['done']) {
          $progress=100;
        }
      }
      // pGroup : is the tack a group one ?
      $pGroup=($line['elementary']=='0')?1:0;
      if( $pGroup) {
        $rowType = "group";
      } else if( $line['refType']=='Milestone'){
        $rowType  = "mile";
      } else {
        $rowType  = "row";
      }
      $wbs=$line['wbsSortable'];
      $level=(strlen($wbs)+1)/4;
      $tab="";
      for ($i=1;$i<$level;$i++) {
        $tab.='<span class="ganttSep">&nbsp;&nbsp;&nbsp;&nbsp;</span>';
      }
      echo '<TR class="ganttTask' . $rowType . '" style="margin: 0px; padding: 0px;">';
      echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;"><img style="width:16px" src="../view/css/images/icon' . $line['refType'] . '16.png" /></TD>';
      echo '  <TD class="ganttName" style="margin: 0px; padding: 0px;" nowrap><NOBR>' . $tab . $line['refName'] . '</NOBR></TD>';
      echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>' . $validatedWork  . '</NOBR></TD>' ;
      echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>' . $assignedWork  . '</NOBR></TD>' ;
      echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>' . $plannedWork  . '</NOBR></TD>' ;
      echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>' . $realWork  . '</NOBR></TD>' ;
      echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>' . $leftWork  . '</NOBR></TD>' ;
      echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>'  . percentFormatter($progress) . '</NOBR></TD>' ;
      echo '</TR>';        
    }
  }
  echo "</table>"; 
?>