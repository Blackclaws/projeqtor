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
  if ( array_key_exists('report',$_REQUEST) ) {
    $headerParameters="";
    if (array_key_exists('startDate',$_REQUEST) and trim($_REQUEST['startDate'])!="") {
      $headerParameters.= i18n("colStartDate") . ' : ' . dateFormatter($_REQUEST['startDate']) . '<br/>';
    }
    if (array_key_exists('endDate',$_REQUEST) and trim($_REQUEST['endDate'])!="") {
      $headerParameters.= i18n("colEndDate") . ' : ' . dateFormatter($_REQUEST['endDate']) . '<br/>';
    }
    if (array_key_exists('format',$_REQUEST)) {
      $headerParameters.= i18n("colFormat") . ' : ' . i18n($_REQUEST['format']) . '<br/>';
    }
    if (array_key_exists('idProject',$_REQUEST) and trim($_REQUEST['idProject'])!="") {
      $headerParameters.= i18n("colIdProject") . ' : ' . SqlList::getNameFromId('Project', $_REQUEST['idProject']) . '<br/>';
    }
    include "../report/header.php";
  }
  
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
  } else  if (property_exists($obj, 'idProject') and array_key_exists('project',$_SESSION)) {
      //if ($_SESSION['project']!='*') {
        $queryWhere.= ($queryWhere=='')?'':' and ';
        $queryWhere.=  $table . ".idProject in " . getVisibleProjectsList() ;
      //}
  }
  
  if ($accessRightRead=='NO') {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    $queryWhere.=  "(1 = 2)";      
  } else if ($accessRightRead=='OWN') {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    //$queryWhere.=  $table . ".idUser = '" . $_SESSION['user']->id . "'";     
    $queryWhere.=  "(1 = 2)"; // If visibility = own => no visibility            
  } else if ($accessRightRead=='PRO') {
    $queryWhere.= ($queryWhere=='')?'':' and ';
    $queryWhere.=  $table . ".idProject in " . transformListIntoInClause($_SESSION['user']->getVisibleProjects()) ;      
  } else if ($accessRightRead=='ALL') {
    // No restriction to add
  }

  $querySelect .= $table . ".* ";
  $queryFrom .= $table;
  // Link to resource
  //$querySelect .= ", user.fullName as nameResource ";
  //$queryFrom .= " left join user on ( task.idResource=user.id )";    
  
  $queryOrderBy .= $table . ".wbsSortable ";

  // constitute query and execute
  $queryWhere=($queryWhere=='')?' 1=1':$queryWhere;
  $query='select ' . $querySelect 
       . ' from ' . $queryFrom
       . ' where ' . $queryWhere 
       . ' order by ' . $queryOrderBy;
//echo $query;
  $result=Sql::query($query);
  $nbRows=0;
  if ($print) {
    if ( array_key_exists('report',$_REQUEST) ) {
      $test=array();
      if (Sql::$lastQueryNbRows > 0) $test[]="OK";
      if (checkNoData($test))  exit;
    }
    displayGantt($result);
  } else {
    // return result in json format
    $d=new Dependency();
    echo '{"identifier":"id",' ;
    echo ' "items":[';
    if (Sql::$lastQueryNbRows > 0) {
      while ($line = Sql::fetchLine($result)) {
        echo (++$nbRows>1)?',':'';
        echo  '{';
        $nbFields=0;
        $idPe="";
        foreach ($line as $id => $val) {
          if ($val==null) {$val=" ";}
          if ($val=="") {$val=" ";}
          echo (++$nbFields>1)?',':'';
          echo '"' . htmlEncode($id) . '":"' . htmlEncodeJson($val) . '"';
          if ($id=='id') {$idPe=$val;}
        }
        $crit=array('successorId'=>$idPe);
        $listPred="";
        $depList=$d->getSqlElementsFromCriteria($crit,false);
        foreach ($depList as $dep) {
          $listPred.=($listPred!="")?',':'';
          $listPred.=$dep->predecessorId;
        }
        echo ', "depend":"' . $listPred . '"';
        echo '}';       
      }
    }
    echo ' ] }'; 
  }

  function displayGantt($result) {
    // calculations
    $startDate=date('Y-m-d');
    if (array_key_exists('startDate',$_REQUEST)) {
      $startDate=$_REQUEST['startDate'];
    }
    $endDate='';
    if (array_key_exists('endDate',$_REQUEST)) {
      $endDate=$_REQUEST['endDate'];
    }
    $format='day';
    if (array_key_exists('format',$_REQUEST)) {
      $format=$_REQUEST['format'];
    }
    if($format == 'day') {
      $colWidth = 18;
      $colUnit = 1;
      $topUnit=7;
    } else if($format == 'week') {
      $colWidth = 50;
      $colUnit = 7;
      $topUnit=7;
    } else if($format == 'month') {
      $colWidth = 80;
      $colUnit = 30;
      $topUnit=30;
    }
    $maxDate = '';
    $minDate = '';
    if (Sql::$lastQueryNbRows > 0) {
      $resultArray=array();
      while ($line = Sql::fetchLine($result)) {
        $pStart="";
        $pStart=(trim($line['initialStartDate'])!="")?$line['initialStartDate']:$pStart;
        $pStart=(trim($line['validatedStartDate'])!="")?$line['validatedStartDate']:$pStart;
        $pStart=(trim($line['plannedStartDate'])!="")?$line['plannedStartDate']:$pStart;
        $pStart=(trim($line['realStartDate'])!="")?$line['realStartDate']:$pStart;
        if (trim($line['plannedStartDate'])!=""
        and trim($line['realStartDate'])!=""
        and $line['plannedStartDate']<$line['realStartDate'] ) {
          $pStart=$line['plannedStartDate'];
        }
        $pEnd="";
        $pEnd=(trim($line['initialEndDate'])!="")?$line['initialEndDate']:$pEnd;
        $pEnd=(trim($line['validatedEndDate'])!="")?$line['validatedEndDate']:$pEnd;
        $pEnd=(trim($line['plannedEndDate'])!="")?$line['plannedEndDate']:$pEnd;
        $pEnd=(trim($line['realEndDate'])!="")?$line['realEndDate']:$pEnd;
        //if ($pEnd=="") {$pEnd=date('Y-m-d');}
        if ($line['refType']=='Milestone') {
          $pStart=$pEnd;
        }
        $line['pStart']=$pStart;
        $line['pEnd']=$pEnd;
        $resultArray[]=$line;
        if ($maxDate=='' or $maxDate<$pEnd) {$maxDate=$pEnd;}
        if ($minDate=='' or $minDate>$pStart) {$minDate=$pStart;}
      }
      if ($minDate<$startDate) {
        $minDate=$startDate;
      }
      if ($endDate and $maxDate>$endDate) {
        $maxDate=$endDate;
      }
      if ($format=='day' or $format=='week') {   
        $minDate=addDaysToDate($minDate,-1);
        $minDate=date('Y-m-d',firstDayofWeek(weekNumber($minDate),substr($minDate,0,4)));
        $maxDate=addDaysToDate($maxDate,+1);
        $maxDate=date('Y-m-d',firstDayofWeek(weekNumber($maxDate),substr($maxDate,0,4)));
        $maxDate=addDaysToDate($maxDate,+6);
      } else if ($format=='month') {
        //$minDate=addDaysToDate($minDate,-1);
        $minDate=substr($minDate,0,8).'01';
        $maxDate=addDaysToDate($maxDate,+1);
        $maxDate=addMonthsToDate($maxDate,+1);
        $maxDate=substr($maxDate,0,8).'01';
        $maxDate=addDaysToDate($maxDate,-1);
      }
      $numDays = (dayDiffDates($minDate, $maxDate) +1);
      $numUnits = round($numDays / $colUnit);
      $topUnits = round($numDays / $topUnit);
      $days=array();
      $openDays=array();
      $day=$minDate;
      for ($i=0;$i<$numDays; $i++) {
        $days[$i]=$day;
        $openDays[$i]=isOpenDay($day);
        $day=addDaysToDate($day,1);
      }
      //echo "mindate:$minDate maxdate:$maxDate numDays:$numDays numUnits:$numUnits topUnits:$topUnits" ;     
      // Header
      //echo '<table dojoType="dojo.dnd.Source" id="wishlistNode" class="container ganttTable" style="border: 1px solid #AAAAAA; margin: 0px; padding: 0px;">';
      echo '<table id="wishlistNode" class="ganttTable" style="border: 1px solid #AAAAAA; margin: 0px; padding: 0px;">';
      echo '<tr class="ganttHeight"><td colspan="6">&nbsp;</td>';
      $day=$minDate;
      for ($i=0;$i<$topUnits;$i++) {
        $span=$topUnit;
        $title="";
        if ($format=='month') {
          $title=substr($day,0,4);
          $span=numberOfDaysOfMonth($day);
        } else if($format=='week') {
          $title=substr($day,2,2) . " #" . weekNumber($day);
        } else if ($format=='day') {
          $tDate = explode("-", $day);
          $date= mktime(0, 0, 0, $tDate[1], $tDate[2]+1, $tDate[0]);
          $title=substr($day,0,4) . " #" . weekNumber($day);
          $title.=' (' . substr(i18n(date('F', $date)),0,4) . ')';
        }
        echo '<td class="ganttRightTitle" colspan="' . $span . '">';
        echo $title;
        echo '</td>';
        if ($format=='month') {
          $day=addMonthsToDate($day,1);
        } else {
          $day=addDaysToDate($day,$topUnit);
        }
      }
      echo '</tr>';
      echo '<TR class="ganttHeight">';
      echo '  <TD class="ganttLeftTitle" width="15px"></TD>';
      echo '  <TD class="ganttLeftTitle" width="200px" style="border-left:0px; text-align: left;">' . i18n('colTask') . '</TD>';
      echo '  <TD class="ganttLeftTitle" width="60px" nowrap>' . i18n('colDuration') . '</TD>' ;
      echo '  <TD class="ganttLeftTitle" width="50px" nowrap>'  . i18n('colPct') . '</TD>' ;
      echo '  <TD class="ganttLeftTitle" width="80px" nowrap>'  . i18n('colStart') . '</TD>' ;
      echo '  <TD class="ganttLeftTitle" width="80px" nowrap>'  . i18n('colEnd') . '</TD>' ;
      $weekendColor="#cfcfcf";
      $day=$minDate;
      for ($i=0;$i<$numUnits;$i++) {
        $color="";
        $span=$colUnit;
        if ($format=='month') {
          $tDate = explode("-", $day);
          $date= mktime(0, 0, 0, $tDate[1], $tDate[2]+1, $tDate[0]);
          $title=i18n(date('F', $date));
          $span=numberOfDaysOfMonth($day);
        } else if($format=='week') {
          $title=substr(htmlFormatDate($day),0,5);
        } else if ($format=='day') {
          $color=($openDays[$i]==1)?'':'background-color:' . $weekendColor . ';';
          $title=substr($days[$i],-2);
        }
        echo '<td class="ganttRightSubTitle" colspan="' . $span . '" width="' . $colWidth . '" style="' . $color . '">';
        echo '<div style="width:' . $colWidth . 'px;">' . $title . '</div></td>';
        if ($format=='month') {
          $day=addMonthsToDate($day,1);
        } else {
          $day=addDaysToDate($day,$topUnit);
        }
      }      
      echo '</TR>';       
      
      // lines
      $width=round($colWidth/$colUnit) . "px;";
      foreach ($resultArray as $line) {
        $pEnd=$line['pEnd'];
        $pStart=$line['pStart'];
        $realWork=$line['realWork'];
        $plannedWork=$line['plannedWork'];
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
        $duration=($rowType=='mile' or $pStart=="" or $pEnd=="")?'-':workDayDiffDates($pStart, $pEnd) . " " . i18n("shortDay");
        //echo '<TR class="dojoDndItem ganttTask' . $rowType . '" style="margin: 0px; padding: 0px;">';
        echo '<TR class="ganttTask' . $rowType . '" style="margin: 0px; padding: 0px;">';
        echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;"><img style="width:16px" src="../view/css/images/icon' . $line['refType'] . '16.png" /></TD>';
        echo '  <TD class="ganttName" style="margin: 0px; padding: 0px;" nowrap><NOBR>' . $tab . $line['refName'] . '</NOBR></TD>';
        echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>' . $duration  . '</NOBR></TD>' ;
        echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>'  . percentFormatter($progress) . '</NOBR></TD>' ;
        echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>'  . (($pStart)?dateFormatter($pStart):'-') . '</NOBR></TD>' ;
        echo '  <TD class="ganttDetail" style="margin: 0px; padding: 0px;" align="center" nowrap><NOBR>'  . (($pEnd)?dateFormatter($pEnd):'-') . '</NOBR></TD>' ;
        if ($pGroup) {
          $pColor='#505050';
        } else {         
          if (trim($line['validatedEndDate'])!="" && $line['validatedEndDate'] < $pEnd) {
            $pColor='#BB5050'; 
          } else  {
            $pColor='#50BB50';
          }
        }
        for ($i=0;$i<$numDays;$i++) {
          $color="";
          $noBorder="";

          if ($format=='month') {
            $fontSize='90%';
            if ( substr($days[$i],-2)!='01' ) {
              $noBorder="border-left: 0px solid white;";
            }
          } else if($format=='week') {
            $fontSize='90%';
            if ( $i % $colUnit) {
              $noBorder="border-left: 0px solid white;";
            }
          } else if ($format=='day') {
            $fontSize='150%';
            $color=($openDays[$i]==1)?'':'background-color:' . $weekendColor . ';';
          }
          $height=($pGroup)?'6':'12';         
          if ($days[$i]>=$pStart and $days[$i]<=$pEnd) {
            if ($rowType=="mile") {
              echo '<td class="ganttDetail" style="margin:0; paging: 0;text-align: center;font-size: ' . $fontSize . ';' . $color . $noBorder . ';color:' . $pColor . ';">';
              if($progress < 100) {
                echo '&loz;' ;
              } else { 
                echo '&diams;' ;
              }
            } else {
              $subHeight=round((20-$height)/2);
              echo '<td class="ganttDetailNoborder" style="' . $color . '">';
              echo '<table width="100%" >';
              echo '<tr style="height:' . $subHeight . 'px;"><td class="ganttDetailBoderleft" style="' . $noBorder . '"></td></tr>';              
              echo '<tr height="' . $height . 'px"><td class="ganttDetailNoborder" style="width:1px; background-color:' . $pColor . ';height:' .  $height . 'px;"></td></tr>';              
              echo '<tr style="height:' . $subHeight . 'px;"><td class="ganttDetailBoderleft" style="' . $noBorder . '"></td></tr>';
              echo '</table>';
            }
          } else { 
            echo '<td class="ganttDetail" style="' . $color . $width . $noBorder . '">';
            if($format=='week') {
              echo '&nbsp;&nbsp;';
            }
          }
          echo '</td>';
        }
        echo '</TR>';        
      }
    }
    echo "</table>"; 
  }
?>
