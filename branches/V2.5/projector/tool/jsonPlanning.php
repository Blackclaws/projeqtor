<?PHP
/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
  require_once "../tool/projector.php";  
  scriptLog('   ->/tool/jsonPlanning.php');
  $objectClass='PlanningElement';
  $obj=new $objectClass();
  $table=$obj->getDatabaseTableName();
  $displayResource=Parameter::getGlobalParameter('displayResourcePlan');
  $print=false;
  if ( array_key_exists('print',$_REQUEST) ) {
    $print=true;
    include_once('../tool/formatter.php');
  }
  $saveDates=false;
  if ( array_key_exists('listSaveDates',$_REQUEST) ) {
    $saveDates=true;
  }
  $starDate="";
  $endDate="";
  if (array_key_exists('startDatePlanView',$_REQUEST) and array_key_exists('endDatePlanView',$_REQUEST)) {
    $starDate= trim($_REQUEST['startDatePlanView']);
    $endDate= trim($_REQUEST['endDatePlanView']);
    $user=$_SESSION['user'];
    $paramStart=SqlElement::getSingleSqlElementFromCriteria('Parameter',array('idUser'=>$user->id,'idProject'=>null,'parameterCode'=>'planningStartDate'));
    $paramEnd=SqlElement::getSingleSqlElementFromCriteria('Parameter',array('idUser'=>$user->id,'idProject'=>null,'parameterCode'=>'planningEndDate'));
    if ($saveDates) {
      $paramStart->parameterValue=$starDate;
      $paramStart->save();
      $paramEnd->parameterValue=$endDate;
      $paramEnd->save();
    } else {
      if ($paramStart->id) {
        $paramStart->delete();
      }
      if ($paramEnd->id) {
        $paramEnd->delete();
      }
    }
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
  if (! isset($outMode)) { $outMode=""; }

  $accessRightRead=securityGetAccessRight('menuActivity', 'read');
  if ( ! ( $accessRightRead!='ALL' or (isset($_SESSION['project']) and $_SESSION['project']!='*')) 
   and ( ! array_key_exists('idProject',$_REQUEST) or trim($_REQUEST['idProject'])=="")) {
      $listProj=explode(',',getVisibleProjectsList());
      if (count($listProj)-1 > Parameter::getGlobalParameter('maxProjectsToDisplay')) {
        echo i18n('selectProjectToPlan');
        return;
      }
  }
  $querySelect = '';
  $queryFrom='';
  $queryWhere='';
  $queryOrderBy='';
  $idTab=0;
  if (! array_key_exists('idle',$_REQUEST) ) {
    $queryWhere= $table . ".idle=0 ";
  }
  $queryWhere.= ($queryWhere=='')?'':' and ';
  $queryWhere.=getAccesResctictionClause('Activity',$table);
  if ( array_key_exists('report',$_REQUEST) ) {
    if (array_key_exists('idProject',$_REQUEST) and $_REQUEST['idProject']!=' ') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  $table . ".idProject in " . getVisibleProjectsList(true, $_REQUEST['idProject']) ;
    }
  } else {
  	$queryWhere.= ($queryWhere=='')?'':' and ';
    $queryWhere.=  $table . ".idProject in " . getVisibleProjectsList() ;
  }
  
  // Remove administrative projects :
  $queryWhere.= ($queryWhere=='')?'':' and ';
  $queryWhere.=  $table . ".idProject not in " . Project::getAdminitrativeProjectList() ;

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
  $nbRows=0;
  if ($print) {
    if ( array_key_exists('report',$_REQUEST) ) {
      $test=array();
      if (Sql::$lastQueryNbRows > 0) $test[]="OK";
      if (checkNoData($test))  exit;
    }
    if ($outMode=='mpp') {
    	exportGantt($result);
    } else {
    	displayGantt($result);
    }
  } else {
    // return result in json format
    $d=new Dependency();
    echo '{"identifier":"id",' ;
    echo ' "items":[';
    if (Sql::$lastQueryNbRows > 0) {
    	$collapsedList=Collapsed::getCollaspedList();
      while ($line = Sql::fetchLine($result)) {
        echo (++$nbRows>1)?',':'';
        echo  '{';
        $nbFields=0;
        $idPe="";
        if ($line["plannedWork"]>0 and $line["leftWork"]==0) {
        	$line["plannedStartDate"]='';
        	$line["plannedEndDate"]='';
        }
        $line["validatedWorkDisplay"]=Work::displayWorkWithUnit($line["validatedWork"]);
        $line["assignedWorkDisplay"]=Work::displayWorkWithUnit($line["assignedWork"]);
        $line["realWorkDisplay"]=Work::displayWorkWithUnit($line["realWork"]);
        $line["leftWorkDisplay"]=Work::displayWorkWithUnit($line["leftWork"]);
        $line["plannedWorkDisplay"]=Work::displayWorkWithUnit($line["plannedWork"]);
        foreach ($line as $id => $val) {
          if ($val==null) {$val=" ";}
          if ($val=="") {$val=" ";}
          echo (++$nbFields>1)?',':'';
          echo '"' . htmlEncode($id) . '":"' . htmlEncodeJson($val) . '"';
          if ($id=='id') {$idPe=$val;}
        } 
        //add expanded status
        if (array_key_exists('Planning_'.$line['refType'].'_'.$line['refId'], $collapsedList)) {
        	echo ',"collapsed":"1"';
        } else {
        	echo ',"collapsed":"0"';
        }
        //if ($displayResource and strtoupper($displayResource)!='NO') {
        	$crit=array('refType'=>$line['refType'], 'refId'=>$line['refId']);
          $ass=new Assignment();
          $assList=$ass->getSqlElementsFromCriteria($crit,false);
	        $arrayResource=array();
	        $objElt=new $line['refType']($line['refId']);
	        foreach ($assList as $ass) {
	        	$res=new Resource($ass->idResource);
	        	if ($res->$displayResource)	{        	
	        	  $arrayResource[$res->id]=$res->$displayResource;
	        	  if ($objElt and property_exists($objElt,'idResource') and $objElt->idResource==$res->id ) {
	        		  $arrayResource[$res->id]='<b>'.$res->$displayResource.'</b>';
	        	  }
	        	}
	        }
	        $res=new Resource($ass->idResource);
	        echo ',"resource":"' . implode(', ',$arrayResource) . '"';
        //}
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
  	global $displayResource, $outMode;;
    $showWbs=false;
    if (array_key_exists('showWBS',$_REQUEST) ) {
      $showWbs=true;
    }
    $showResource=false;
    if ( array_key_exists('showResource',$_REQUEST) ) {
      $showResource=true;
    }
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
      $colWidth = 60;
      $colUnit = 30;
      $topUnit=30;
    }
    $maxDate = '';
    $minDate = '';
    if (Sql::$lastQueryNbRows > 0) {
      $resultArray=array();
      while ($line = Sql::fetchLine($result)) {
        if ($line["plannedWork"]>0 and $line["leftWork"]==0) {
          $line["plannedStartDate"]='';
          $line["plannedEndDate"]='';
        }
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
        //if ($showResource) {
          $crit=array('refType'=>$line['refType'], 'refId'=>$line['refId']);
          $ass=new Assignment();
          $assList=$ass->getSqlElementsFromCriteria($crit,false);
          $arrayResource=array();
          $objElt=new $line['refType']($line['refId']);
          foreach ($assList as $ass) {
            $res=new Resource($ass->idResource);
            if ($res->$displayResource) {         
              $arrayResource[$res->id]=$res->$displayResource;
              if ($objElt and property_exists($objElt,'idResource') and $objElt->idResource==$res->id ) {
                $arrayResource[$res->id]='<b>'.$res->$displayResource.'</b>';
              }
            }
          }
          $line["resource"]=implode(', ',$arrayResource);
        //}
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
        //$minDate=addDaysToDate($minDate,-1);
        $minDate=date('Y-m-d',firstDayofWeek(weekNumber($minDate),substr($minDate,0,4)));
        //$maxDate=addDaysToDate($maxDate,+1);
        $maxDate=date('Y-m-d',firstDayofWeek(weekNumber($maxDate),substr($maxDate,0,4)));
        $maxDate=addDaysToDate($maxDate,+6);
      } else if ($format=='month') {
        //$minDate=addDaysToDate($minDate,-1);
        $minDate=substr($minDate,0,8).'01';
        //$maxDate=addDaysToDate($maxDate,+1);
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
      $sortArray=Parameter::getPlanningColumnOrder();
      $cptSort=0;
      foreach ($sortArray as $name) {	if ($name) $cptSort++; }
      //echo '<table dojoType="dojo.dnd.Source" id="wishlistNode" class="container ganttTable" style="border: 1px solid #AAAAAA; margin: 0px; padding: 0px;">';
      echo '<table style="font-size:80%; border: 1px solid #AAAAAA; margin: 0px; padding: 0px;">';
      echo '<tr style="height: 20px;"><td colspan="' . (2+$cptSort) . '">&nbsp;</td>';
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
        echo '<td class="reportTableHeader" colspan="' . $span . '">';
        echo $title;
        echo '</td>';
        if ($format=='month') {
          $day=addMonthsToDate($day,1);
        } else {
          $day=addDaysToDate($day,$topUnit);
        }
      }
      echo '</tr>';
      echo '<TR style="height: 20px;">';
      echo '  <TD class="reportTableHeader" style="width:15px; border-right:0px;"></TD>';
      echo '  <TD class="reportTableHeader" style="width:150px; border-left:0px; text-align: left;">' . i18n('colTask') . '</TD>';
      foreach ($sortArray as $col) {
        if ($col=='ValidatedWork') echo '  <TD class="reportTableHeader" style="width:30px">' . i18n('colValidated') . '</TD>' ;
      	if ($col=='AssignedWork') echo '  <TD class="reportTableHeader" style="width:30px">' . i18n('colAssigned') . '</TD>' ;
        if ($col=='RealWork') echo '  <TD class="reportTableHeader" style="width:30px">' . i18n('colReal') . '</TD>' ;
        if ($col=='LeftWork') echo '  <TD class="reportTableHeader" style="width:30px">' . i18n('colLeft') . '</TD>' ;
        if ($col=='PlannedWork') echo '  <TD class="reportTableHeader" style="width:30px">' . i18n('colPlanned') . '</TD>' ;
        if ($col=='Duration') echo '  <TD class="reportTableHeader" style="width:30px">' . i18n('colDuration') . '</TD>' ;
        if ($col=='Progress') echo '  <TD class="reportTableHeader" style="width:30px">'  . i18n('colPct') . '</TD>' ;
        if ($col=='StartDate') echo '  <TD class="reportTableHeader" style="width:50px">'  . i18n('colStart') . '</TD>' ;
        if ($col=='EndDate') echo '  <TD class="reportTableHeader" style="width:50px">'  . i18n('colEnd') . '</TD>' ;
        if ($col=='Resource') echo '  <TD class="reportTableHeader" style="width:50px">'  . i18n('colResource') . '</TD>' ;
      }
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
        echo '<td class="reportTableColumnHeader" colspan="' . $span . '" style="width:' . $colWidth . 'px;magin:0px;padding:0px;' . $color . '">';
        echo $title . '</td>';
        if ($format=='month') {
          $day=addMonthsToDate($day,1);
        } else {
          $day=addDaysToDate($day,$topUnit);
        }
      }      
      echo '</TR>';       
      
      // lines
      $width=round($colWidth/$colUnit) . "px;";
      $collapsedList=Collapsed::getCollaspedList();
      $closedWbs='';
      $level=1;
      $wbsLevelArray=array();
      foreach ($resultArray as $line) {
        $pEnd=$line['pEnd'];
        $pStart=$line['pStart'];
        $realWork=$line['realWork'];
        $plannedWork=$line['plannedWork'];
        $progress=$line['progress'];
        
        // pGroup : is the tack a group one ?
        $pGroup=($line['elementary']=='0')?1:0;
        if ($closedWbs and strlen($line['wbsSortable'])<=strlen($closedWbs)) {
          $closedWbs="";
        }
        $scope='Planning_'.$line['refType'].'_'.$line['refId'];
        $collapsed=false;
        if ($pGroup and array_key_exists($scope, $collapsedList)) {
          $collapsed=true;
          if (! $closedWbs) {
            $closedWbs=$line['wbsSortable'];
          }
        }
        $compStyle="";
        $bgColor="";
        if( $pGroup) {
          $rowType = "group";
          $compStyle="font-weight: bold; background: #E8E8E8;";
          $bgColor="background: #E8E8E8;";
        } else if( $line['refType']=='Milestone'){
          $rowType  = "mile";
        } else {
          $rowType  = "row";
        }
        $wbs=$line['wbsSortable'];
        $wbsTest=$wbs;
        $level=1;
        while (strlen($wbsTest)>3) {
        	$wbsTest=substr($wbsTest,0,strlen($wbsTest)-4);
        	if (array_key_exists($wbsTest, $wbsLevelArray)) {
        		$level=$wbsLevelArray[$wbsTest]+1;
        		$wbsTest="";
        	}
        }
        $wbsLevelArray[$wbs]=$level;
        //$level=(strlen($wbs)+1)/4;
        $tab=""; 
        for ($i=1;$i<$level;$i++) {
          $tab.='<span class="ganttSep" >&nbsp;&nbsp;&nbsp;&nbsp;</span>';
        }       
        $pName=($showWbs)?$line['wbs']." ":"";
        $pName.= htmlEncode($line['refName']);
        $duration=($rowType=='mile' or $pStart=="" or $pEnd=="")?'-':workDayDiffDates($pStart, $pEnd) . "&nbsp;" . i18n("shortDay");
        //echo '<TR class="dojoDndItem ganttTask' . $rowType . '" style="margin: 0px; padding: 0px;">';
        
        if ($closedWbs and $closedWbs!=$line['wbsSortable']) {
          //echo ' display:none;';
          continue;
        }
        echo '<TR style="height:18px;' ;
        
        echo '">';
        echo '  <TD class="reportTableData" style="border-right:0px;' . $compStyle . '"><img style="width:16px" src="../view/css/images/icon' . $line['refType'] . '16.png" /></TD>';
        echo '  <TD class="reportTableData" style="border-left:0px; text-align: left;' . $compStyle . '"><NOBR>' . $tab ;
        echo '<span style="width: 16px;height:100%;vertical-align:middle;">';
        if ($pGroup) {
          if ($collapsed) {
            echo '<img style="width:12px" src="../view/css/images/plus.gif" />';
          } else {
            echo '<img style="width:12px" src="../view/css/images/minus.gif" />';
          }         
        } else {
        	if ($line['refType']=='Milestone') {
        		echo '<img style="width:12px" src="../view/css/images/mile.gif" />';
        	} else {
            echo '<img style="width:12px" src="../view/css/images/none.gif" />';
        	}
        }
        //<div style="float: left;width:16px;">&nbsp;</div></span>';
        echo '</span>&nbsp;';
        echo $pName . '</NOBR></TD>';
        foreach ($sortArray as $col) {
          if ($col=='ValidatedWork') echo '  <TD class="reportTableData" style="' . $compStyle . '" >' . Work::displayWorkWithUnit($line["validatedWork"])  . '</TD>' ;
          if ($col=='AssignedWork') echo '  <TD class="reportTableData" style="' . $compStyle . '" >' .  Work::displayWorkWithUnit($line["assignedWork"])  . '</TD>' ;
          if ($col=='RealWork') echo '  <TD class="reportTableData" style="' . $compStyle . '" >' .  Work::displayWorkWithUnit($line["realWork"])  . '</TD>' ;
          if ($col=='LeftWork') echo '  <TD class="reportTableData" style="' . $compStyle . '" >' .  Work::displayWorkWithUnit($line["leftWork"])  . '</TD>' ;
          if ($col=='PlannedWork') echo '  <TD class="reportTableData" style="' . $compStyle . '" >' .  Work::displayWorkWithUnit($line["plannedWork"])  . '</TD>' ;
          if ($col=='Duration') echo '  <TD class="reportTableData" style="' . $compStyle . '" >' . $duration  . '</TD>' ;
          if ($col=='Progress') echo '  <TD class="reportTableData" style="' . $compStyle . '" >' . percentFormatter($progress) . '</TD>' ;
          if ($col=='StartDate') echo '  <TD class="reportTableData" style="' . $compStyle . '">'  . (($pStart)?dateFormatter($pStart):'-') . '</TD>' ;
          if ($col=='EndDate') echo '  <TD class="reportTableData" style="' . $compStyle . '">'  . (($pEnd)?dateFormatter($pEnd):'-') . '</TD>' ;
          if ($col=='Resource') echo '  <TD class="reportTableData" style="text-align:left;' . $compStyle . '" >' . $line["resource"]  . '</TD>' ;
        }
        if ($pGroup) {
          $pColor='#505050;';
          //$pBackground='background:#505050 url(../view/img/grey.png) repeat-x;';
          $pBackground='background-color:#505050;';
        } else {         
          if (trim($line['validatedEndDate'])!="" && $line['validatedEndDate'] < $pEnd) {
            $pColor='#BB5050';
            //$pBackground='background:#BB5050 url(../view/img/red.png) repeat-x;';
            $pBackground='background-color:#BB5050;';
          } else  {
            $pColor="#50BB50";
            //$pBackground='background:#50BB50 url(../view/img/green.png) repeat-x;';
            $pBackground='background-color:#50BB50;';
          }
        }
        $dispCaption=false;
        for ($i=0;$i<$numDays;$i++) {
          $color=$bgColor;
          $noBorder="border-left: 0px;";
          if ($format=='month') {
            $fontSize='90%';
            if ( $i<($numDays-1) and substr($days[($i+1)],-2)!='01' ) {
              $noBorder="border-left: 0px;border-right: 0px;";
            }
          } else if($format=='week') {
            $fontSize='90%';
            if ( ( ($i+1) % $colUnit)!=0) {
              $noBorder="border-left: 0px;border-right: 0px;";
            }
          } else if ($format=='day') {
            $fontSize='150%';
            $color=($openDays[$i]==1)?$bgColor:'background-color:' . $weekendColor . ';';
          }
          $height=($pGroup)?'8':'12';      
          if ($days[$i]>=$pStart and $days[$i]<=$pEnd) {
            if ($rowType=="mile") {
              echo '<td class="reportTableData" style="font-size: ' . $fontSize . ';' . $color . $noBorder . ';color:' . $pColor . ';">';
              if($progress < 100) {
                echo '&loz;' ;
              } else { 
                echo '&diams;' ;
              }
            } else {
              $subHeight=round((18-$height)/2);
              echo '<td class="reportTableData" style="width:' . $width .';padding:0px;' . $color . '; vertical-align: middle;' . $noBorder . '">';
              if ($pGroup and ($days[$i]==$pStart or $days[$i]==$pEnd) and $outMode!='pdf') {
                echo '<div class="ganttTaskgroupBarExtInvisible" style="float:left; height:4px"></div>';
              }
              echo '<table width="100%" >';
              //echo '<tr style="height:' . $subHeight . 'px;"><td style="' . $noBorder . '"></td></tr>';              
              echo '<tr height="' . $height . 'px"><td style="width:100%; ' . $pBackground . 'height:' .  $height . 'px;"></td></tr>';              
              //echo '<tr style="height:' . $subHeight . 'px;"><td style="' . $noBorder . '"></td></tr>';
              echo '</table>';
              if ($pGroup and $days[$i]==$pStart and $outMode!='pdf') {
                echo '<div class="ganttTaskgroupBarExt" style="float:left; height:4px"></div>'               
                  . '<div class="ganttTaskgroupBarExt" style="float:left; height:3px"></div>'                 
                  . '<div class="ganttTaskgroupBarExt" style="float:left; height:2px"></div>'              
                  . '<div class="ganttTaskgroupBarExt" style="float:left; height:1px"></div>';
              }
              if ($pGroup and $days[$i]==$pEnd and $outMode!='pdf') {
	              echo '<div class="ganttTaskgroupBarExt" style="float:right; height:4px"></div>'               
	                . '<div class="ganttTaskgroupBarExt" style="float:right; height:3px"></div>'                 
	                . '<div class="ganttTaskgroupBarExt" style="float:right; height:2px"></div>'              
	                . '<div class="ganttTaskgroupBarExt" style="float:right; height:1px"></div>';
	            }  
              $dispCaption=($showResource)?true:false;
            } 
          } else { 
            echo '<td class="reportTableData" width="' . $width .'" style="width: ' . $width . $color . $noBorder . '">';
            //if($format=='week') {
              //echo '&nbsp;&nbsp;';
            //}
            if ($days[$i]>$pEnd and $dispCaption) {
            	echo '<div style="position: relative; top: 0px; height: 12px;">';
            	echo '<div style="position: absolute; top: -1px; left: 1px; height:12px; width:200px;">';
            	echo '<div style="clip:rect(-10px,100px,100px,0px); text-align: left">' . $line['resource'] . '</div>';
            	echo '</div>';
            	echo '</div>';
            	$dispCaption=false;
            }
          }
          echo '</td>';
        }
        echo '</TR>';        
      }
    }
    echo "</table>"; 
  }
  
  function exportGantt($result) {
  	global $paramDbDisplayName, $currency, $currencyPosition;
  	$nl="\n";
  	$hoursPerDay=Parameter::getGlobalParameter('dayTime');
    $startDate=date('Y-m-d');
    $startAM=Parameter::getGlobalParameter('startAM') . ':00';
    $endAM=Parameter::getGlobalParameter('endAM') . ':00';
    $startPM=Parameter::getGlobalParameter('startPM') . ':00';
    $endPM=Parameter::getGlobalParameter('endPM') . ':00';
    $name="export_planning_" . date('Ymd_His') . ".xml";
    $now=date('Y-m-d').'T'.date('H:i:s');
    if (array_key_exists('startDate',$_REQUEST)) {
      $startDate=$_REQUEST['startDate'];
    }
    $endDate='';
    if (array_key_exists('endDate',$_REQUEST)) {
      $endDate=$_REQUEST['endDate'];
    }
    $maxDate = '';
    $minDate = '';
    $resultArray=array();
    if (Sql::$lastQueryNbRows > 0) {
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
        if ($line['refType']=='Milestone') {
          $pStart=$pEnd;
        }
        $line['pStart']=$pStart;
        $line['pEnd']=$pEnd;
        $line['pDuration']=workDayDiffDates($pStart,$pEnd);
        $resultArray[]=$line;
        if ($maxDate=='' or $maxDate<$pEnd) {$maxDate=$pEnd;}
        if ($minDate=='' or $minDate>$pStart) {$minDate=$pStart;}
      }
      if ($endDate and $maxDate>$endDate) {
        $maxDate=$endDate;
      }
    }
    $res=New Resource();
    $resourceList=$res->getSqlElementsFromCriteria(array(), false, false, " id asc");
  	
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . $nl;
    echo '<Project xmlns="http://schemas.microsoft.com/project">' . $nl;
    echo '<Name>' . $name . '</Name>' . $nl;
    echo '<Title>' . $paramDbDisplayName . '</Title>' . $nl;
    echo '<CreationDate>' . $now . '</CreationDate>' . $nl;
    echo '<LastSaved>' . $now . '</LastSaved>' . $nl;
    echo '<ScheduleFromStart>1</ScheduleFromStart>' . $nl;
    echo '<StartDate>' . $minDate . 'T00:00:00</StartDate>' . $nl;
    echo '<FinishDate>' . $maxDate . 'T00:00:00</FinishDate>' . $nl;
    echo '<FYStartDate>1</FYStartDate>' . $nl;
    echo '<CriticalSlackLimit>0</CriticalSlackLimit>' . $nl;
    echo '<CurrencyDigits>2</CurrencyDigits>' . $nl;
    echo '<CurrencySymbol>' . $currency . '</CurrencySymbol>' . $nl;
    echo '<CurrencySymbolPosition>' . (($currencyPosition=='before')?'0':'1') . '</CurrencySymbolPosition>' . $nl;
    echo '<CalendarUID>1</CalendarUID>' . $nl;
    echo '<DefaultStartTime>' . $startAM . '</DefaultStartTime>' . $nl;
    echo '<DefaultFinishTime>' . $endPM . '</DefaultFinishTime>' . $nl;
    echo '<MinutesPerDay>' . ($hoursPerDay*60) . '</MinutesPerDay>' . $nl;
    echo '<MinutesPerWeek>' . ($hoursPerDay*60*5) . '</MinutesPerWeek>' . $nl;
    echo '<DaysPerMonth>20</DaysPerMonth>' . $nl;
    echo '<DefaultTaskType>1</DefaultTaskType>' . $nl;
    echo '<DefaultFixedCostAccrual>2</DefaultFixedCostAccrual>' . $nl;
    echo '<DefaultStandardRate>10</DefaultStandardRate>' . $nl;
    echo '<DefaultOvertimeRate>15</DefaultOvertimeRate>' . $nl;
    echo '<DurationFormat>7</DurationFormat>' . $nl;
    echo '<WorkFormat>3</WorkFormat>' . $nl;
    echo '<EditableActualCosts>0</EditableActualCosts>' . $nl;
    echo '<HonorConstraints>0</HonorConstraints>' . $nl;
    // echo '<EarnedValueMethod>0</EarnedValueMethod>' . $nl;
    echo '<InsertedProjectsLikeSummary>0</InsertedProjectsLikeSummary>' . $nl;
    echo '<MultipleCriticalPaths>0</MultipleCriticalPaths>' . $nl;
    echo '<NewTasksEffortDriven>0</NewTasksEffortDriven>' . $nl;
    echo '<NewTasksEstimated>1</NewTasksEstimated>' . $nl;
    echo '<SplitsInProgressTasks>0</SplitsInProgressTasks>' . $nl;
    echo '<SpreadActualCost>0</SpreadActualCost>' . $nl;
    echo '<SpreadPercentComplete>0</SpreadPercentComplete>' . $nl;
    echo '<TaskUpdatesResource>1</TaskUpdatesResource>' . $nl;
    echo '<FiscalYearStart>0</FiscalYearStart>' . $nl;
    echo '<WeekStartDay>1</WeekStartDay>' . $nl;
    echo '<MoveCompletedEndsBack>0</MoveCompletedEndsBack>' . $nl;
    echo '<MoveRemainingStartsBack>0</MoveRemainingStartsBack>' . $nl;
    echo '<MoveRemainingStartsForward>0</MoveRemainingStartsForward>' . $nl;
    echo '<MoveCompletedEndsForward>0</MoveCompletedEndsForward>' . $nl;
    echo '<BaselineForEarnedValue>0</BaselineForEarnedValue>' . $nl;
    echo '<AutoAddNewResourcesAndTasks>1</AutoAddNewResourcesAndTasks>' . $nl;
    echo '<CurrentDate>' . $now . '</CurrentDate>' . $nl;
    echo '<MicrosoftProjectServerURL>1</MicrosoftProjectServerURL>' . $nl;
    echo '<Autolink>1</Autolink>' . $nl;
    echo '<NewTaskStartDate>0</NewTaskStartDate>' . $nl;
    echo '<DefaultTaskEVMethod>0</DefaultTaskEVMethod>' . $nl;
    echo '<ProjectExternallyEdited>0</ProjectExternallyEdited>' . $nl;
    echo '<ExtendedCreationDate>1984-01-01T00:00:00</ExtendedCreationDate>' . $nl;
    echo '<ActualsInSync>0</ActualsInSync>' . $nl;
    echo '<RemoveFileProperties>0</RemoveFileProperties>' . $nl;
    echo '<AdminProject>0</AdminProject>' . $nl;
    echo '<OutlineCodes/>' . $nl;
    echo '<WBSMasks/>' . $nl;
    echo '<ExtendedAttributes/>' . $nl;
    /*<ExtendedAttributes>
        <ExtendedAttribute>
            <FieldID>188743731</FieldID>
            <FieldName>Text1</FieldName>
        </ExtendedAttribute>
    </ExtendedAttributes>*/
    echo '<Calendars>' . $nl;
    echo '<Calendar>' . $nl;
    echo '<UID>0</UID>' . $nl;
    echo '<Name>Standard</Name>' . $nl;
    echo '<IsBaseCalendar>1</IsBaseCalendar>' . $nl;
    echo '<BaseCalendarUID>-1</BaseCalendarUID>' . $nl;
    echo '<WeekDays>' . $nl;
    for ($i=1;$i<=7;$i++) {
      echo '<WeekDay>' . $nl;
      echo '<DayType>' . $i . '</DayType>' . $nl;
      if (($i==1 or $i==7)) {
      	echo '<DayWorking>0</DayWorking>' . $nl;
      } else {
	      echo '<DayWorking>1</DayWorking>' . $nl;
	      echo '<WorkingTimes>' . $nl;
	      echo '<WorkingTime>' . $nl;
	      echo '<FromTime>' . $startAM . '</FromTime>' . $nl;
	      echo '<ToTime>' . $endAM . '</ToTime>' . $nl;
	      echo '</WorkingTime>' . $nl;
	      echo '<WorkingTime>' . $nl;
	      echo '<FromTime>' . $startPM . '</FromTime>' . $nl;
	      echo '<ToTime>' . $endPM . '</ToTime>' . $nl;
	      echo '</WorkingTime>' . $nl;
	      echo '</WorkingTimes>' . $nl;
      }
      echo '</WeekDay>' . $nl;
    }
    echo ' </WeekDays>' . $nl;
    echo '</Calendar>' . $nl;
    foreach ($resourceList as $resource) {
    	echo "<Calendar>" . $nl;
      echo "<UID>" . $resource->id . "</UID>" . $nl;
      echo "<Name>" . $resource->name . "</Name>" . $nl;
      echo "<IsBaseCalendar>0</IsBaseCalendar>" . $nl;
      echo "<BaseCalendarUID>0</BaseCalendarUID>" . $nl;
      echo "</Calendar>" . $nl;
    } 
    echo '</Calendars>' . $nl;
    echo '<Tasks>' . $nl;
    $cpt=0;
    $arrayTask=array();
    foreach ($resultArray as $line) {
    	$cpt++;
    	$arrayTask[$line['refType'].'#'.$line['refId']]=$line['id'];
    	$pct=($line['plannedWork']>0)?round(100*$line['realWork']/$line['plannedWork'],0):'';
      echo '<Task>' . $nl;
      echo '<UID>' . $line['id'] . '</UID>' . $nl;
      echo '<ID>' . $cpt . '</ID>' . $nl;  // TODO : should be order of the tack in the list
      echo '<Name>' . htmlEncode($line['refName']) . '</Name>' . $nl;
      echo '<Type>1</Type>' . $nl; // TODO : 0=Fixed Units, 1=Fixed Duration, 2=Fixed Work.
      echo '<IsNull>0</IsNull>' . $nl;
      echo '<WBS>' . $line['wbs'] . '</WBS>' . $nl;
      echo '<OutlineNumber>' . $line['wbs'] . '</OutlineNumber>' . $nl;
      echo '<OutlineLevel>' . (substr_count($line['wbs'],'.')+1) . '</OutlineLevel>' . $nl;
      echo '<Priority>' . $line['priority'] . '</Priority>' . $nl;
      echo '<Start>' . $line['pStart'] . 'T' . $startAM . '</Start>' . $nl;
      echo '<Finish>' . $line['pEnd'] . 'T' . $endPM . '</Finish>' . $nl;
      echo '<Duration>' . formatDuration($line['pDuration'],$hoursPerDay) . '</Duration>' . $nl; // TODO : to update PT112H0M0S
      echo '<DurationFormat>7</DurationFormat>' . $nl;
      echo '<Work>PT' . round($line['plannedWork']*$hoursPerDay,0) . 'H0M0S</Work>' . $nl;
      echo '<Stop>' . $line['pStart'] . 'T' . $startAM . '</Stop>' . $nl;
      echo '<Resume>' . $line['pStart'] . 'T' . $startAM . '</Resume>' . $nl;
      echo '<ResumeValid>0</ResumeValid>' . $nl;
      echo '<EffortDriven>0</EffortDriven>' . $nl;
      echo '<Recurring>0</Recurring>' . $nl;
      echo '<OverAllocated>0</OverAllocated>' . $nl;
      echo '<Estimated>0</Estimated>' . $nl;
      echo '<Milestone>' . (($line['refType']=='Milestone')?'1':'0') . '</Milestone>' . $nl;
      echo '<Summary>' . (($line['elementary'])?'0':'1') . '</Summary>' . $nl;
      echo '<Critical>0</Critical>' . $nl;
      echo '<IsSubproject>0</IsSubproject>' . $nl;
      echo '<IsSubprojectReadOnly>0</IsSubprojectReadOnly>' . $nl;
      echo '<ExternalTask>0</ExternalTask>' . $nl;
      echo '<EarlyStart>' . $line['pStart'] . 'T' . $startAM . '</EarlyStart>' . $nl;
      echo '<EarlyFinish>' . $line['pEnd'] . 'T' . $endPM . '</EarlyFinish>' . $nl;
      echo '<LateStart>' . $line['pStart'] . 'T' . $startAM . '</LateStart>' . $nl;
      echo '<LateFinish>' . $line['pEnd'] . 'T' . $endPM . '</LateFinish>' . $nl;
      echo '<StartVariance>0</StartVariance>' . $nl;
      echo '<FinishVariance>0</FinishVariance>' . $nl;
      echo '<WorkVariance>0</WorkVariance>' . $nl;
      echo '<FreeSlack>0</FreeSlack>' . $nl;
      echo '<TotalSlack>0</TotalSlack>' . $nl;
      echo '<FixedCost>0</FixedCost>' . $nl;
      echo '<FixedCostAccrual>2</FixedCostAccrual>' . $nl;
      echo '<PercentComplete>' . $pct .'</PercentComplete>' . $nl;
      echo '<PercentWorkComplete>' . $pct .'</PercentWorkComplete>' . $nl;
      echo '<Cost>0</Cost>' . $nl;
      echo '<OvertimeCost>0</OvertimeCost>' . $nl;
      echo '<OvertimeWork>PT0H0M0S</OvertimeWork>' . $nl;
      echo '<ActualStart>' .  $line['pStart'] . 'T' . $startAM . '</ActualStart>' . $nl;
      echo '<ActualDuration>PT0H0M0S</ActualDuration>' . $nl;
      echo '<ActualCost>0</ActualCost>' . $nl;
      echo '<ActualOvertimeCost>0</ActualOvertimeCost>' . $nl;
      echo '<ActualWork>PT' . round($line['realWork']*$hoursPerDay,0) . 'H0M0S</ActualWork>' . $nl;
      echo '<ActualOvertimeWork>PT0H0M0S</ActualOvertimeWork>' . $nl;
      echo '<RegularWork>PT' . round($line['plannedWork']*$hoursPerDay,0) . 'H0M0S</RegularWork>' . $nl; 
      echo '<RemainingDuration>PT' .  round($line['plannedDuration']*$hoursPerDay,0) . 'H0M0S</RemainingDuration>' . $nl;
      echo '<RemainingCost>0</RemainingCost>' . $nl;
      echo '<RemainingWork>PT' . round($line['leftWork']*$hoursPerDay,0) . 'H0M0S</RemainingWork>' . $nl;
      echo '<RemainingOvertimeCost>0</RemainingOvertimeCost>' . $nl;
      echo '<RemainingOvertimeWork>PT0H0M0S</RemainingOvertimeWork>' . $nl;
      echo '<ACWP>0</ACWP>' . $nl;
      echo '<CV>0</CV>' . $nl;
      echo '<ConstraintType>' . (($line['elementary'])?'0':'0') . '</ConstraintType>' . $nl;
      echo '<CalendarUID>-1</CalendarUID>' . $nl;
      if ($line['elementary']) { echo '<ConstraintDate>' . $line['pStart'] . 'T' . $startAM . '</ConstraintDate>' . $nl;}
      echo '<LevelAssignments>0</LevelAssignments>' . $nl;
      echo '<LevelingCanSplit>1</LevelingCanSplit>' . $nl;
      echo '<LevelingDelay>0</LevelingDelay>' . $nl;
      echo '<LevelingDelayFormat>8</LevelingDelayFormat>' . $nl;
      echo '<IgnoreResourceCalendar>0</IgnoreResourceCalendar>' . $nl;
      echo '<HideBar>0</HideBar>' . $nl;
      echo '<Rollup>0</Rollup>' . $nl;
      echo '<BCWS>0</BCWS>' . $nl;
      echo '<BCWP>0</BCWP>' . $nl;
      echo '<PhysicalPercentComplete>0</PhysicalPercentComplete>' . $nl;
      echo '<EarnedValueMethod>0</EarnedValueMethod>' . $nl;
      /*<ExtendedAttribute>
        <FieldID>188743731</FieldID>
        <Value>lmk</Value>
        </ExtendedAttribute>*/
      //echo '<Active>1</Active>' . $nl;
      //echo '<Manual>0</Manual>' . $nl;
      echo '<ActualWorkProtected>PT0H0M0S</ActualWorkProtected>' . $nl;
      echo '<ActualOvertimeWorkProtected>PT0H0M0S</ActualOvertimeWorkProtected>' . $nl;
      $crit=array('successorId'=>$line['id']);
      $d=new Dependency();
      $depList=$d->getSqlElementsFromCriteria($crit,false);
      foreach ($depList as $dep) {
        echo '<PredecessorLink>' . $nl;
        echo '<PredecessorUID>' . $dep->predecessorId . '</PredecessorUID>' . $nl;
        echo '<Type>1</Type>' . $nl;
        echo '<CrossProject>0</CrossProject>' . $nl;
        echo '<LinkLag>0</LinkLag>' . $nl;
        echo '<LagFormat>7</LagFormat>' . $nl;
        echo '</PredecessorLink>' . $nl;
      }      
      echo '</Task>' . $nl;
    }
    echo '</Tasks>' . $nl;
    $arrayRessource=array();
    echo '<Resources>' . $nl;
    foreach ($resourceList as $resource) {
    	$arrayResource[$resource->id]=$resource;
      echo "<Resource>" . $nl;
      echo "<UID>" . $resource->id . "</UID>" . $nl;
      echo "<ID>" . $resource->id . "</ID>" . $nl;
      echo "<Name>" . $resource->name . "</Name>" . $nl;
      echo "<Type>1</Type>" . $nl;
      echo "<IsNull>0</IsNull>" . $nl;
      echo "<Initials>" . $resource->initials . "</Initials>" . $nl;
      echo "<Group>" . SqlList::getNameFromId('Team',$resource->idTeam) . "</Group>" . $nl;
      echo "<WorkGroup>0</WorkGroup>" . $nl;
      echo "<EmailAddress>" . $resource->email . "</EmailAddress>" . $nl;
      echo "<MaxUnits>" . $resource->capacity . "</MaxUnits>" . $nl;
      echo "<PeakUnits>0</PeakUnits>" . $nl;
      echo "<OverAllocated>0</OverAllocated>" . $nl;
      echo "<CanLevel>1</CanLevel>" . $nl;
      echo "<AccrueAt>3</AccrueAt>" . $nl;
      echo "<Work>PT0H0M0S</Work>" . $nl;
      echo "<RegularWork>PT0H0M0S</RegularWork>" . $nl;
      echo "<OvertimeWork>PT0H0M0S</OvertimeWork>" . $nl;
      echo "<ActualWork>PT0H0M0S</ActualWork>" . $nl;
      echo "<RemainingWork>PT0H0M0S</RemainingWork>" . $nl;
      echo "<ActualOvertimeWork>PT0H0M0S</ActualOvertimeWork>" . $nl;
      echo "<RemainingOvertimeWork>PT0H0M0S</RemainingOvertimeWork>" . $nl;
      echo "<PercentWorkComplete>0</PercentWorkComplete>" . $nl;
      $rate=0;
      $critCost=array('idResource'=>$resource->id, 'endDate'=>null);
      $rc=new ResourceCost();
      $rcList=$rc->getSqlElementsFromCriteria($critCost, false, null, ' startDate desc');
      if (count($rcList)>0) {
      	$rate=($hoursPerDay)?round($rcList[0]->cost / $hoursPerDay,2):0;
      	
      }
      echo "<StandardRate>" . $rate . "</StandardRate>" . $nl;
      echo "<StandardRateFormat>3</StandardRateFormat>" . $nl;
      echo "<Cost>0</Cost>" . $nl;
      echo "<OvertimeRate>0</OvertimeRate>" . $nl;
      echo "<OvertimeRateFormat>3</OvertimeRateFormat>" . $nl;
      echo "<OvertimeCost>0</OvertimeCost>" . $nl;
      echo "<CostPerUse>0</CostPerUse>" . $nl;
      echo "<ActualCost>0</ActualCost>" . $nl;
      echo "<ActualOvertimeCost>0</ActualOvertimeCost>" . $nl;
      echo "<RemainingCost>0</RemainingCost>" . $nl;
      echo "<RemainingOvertimeCost>0</RemainingOvertimeCost>" . $nl;
      echo "<WorkVariance>0</WorkVariance>" . $nl;
      echo "<CostVariance>0</CostVariance>" . $nl;
      echo "<SV>0</SV>" . $nl;
      echo "<CV>0</CV>" . $nl;
      echo "<ACWP>0</ACWP>" . $nl;
      echo "<CalendarUID>" . $resource->id . "</CalendarUID>" . $nl;
      echo "<BCWS>0</BCWS>" . $nl;
      echo "<BCWP>0</BCWP>" . $nl;
      echo "<IsGeneric>0</IsGeneric>" . $nl;
      echo "<IsInactive>0</IsInactive>" . $nl;
      echo "<IsEnterprise>0</IsEnterprise>" . $nl;
      echo "<BookingType>0</BookingType>" . $nl;
      echo "<ActualWorkProtected>PT0H0M0S</ActualWorkProtected>" . $nl;
      echo "<ActualOvertimeWorkProtected>PT0H0M0S</ActualOvertimeWorkProtected>" . $nl;
      echo "<CreationDate></CreationDate>" . $nl;
      echo "</Resource>" . $nl;
    } 
    echo "</Resources>" . $nl;
    $ass=new Assignment();
    $clauseWhere="";
    $lstAss=$ass->getSqlElementsFromCriteria(null, false, $clauseWhere, null, false);
    echo '<Assignments>' . $nl;
    foreach ($lstAss as $ass) {
    	if (array_key_exists($ass->refType . '#' . $ass->refId, $arrayTask)) {
        $res=$arrayResource[$ass->idResource];
	      echo "<Assignment>" . $nl;
	      echo "<UID>" . $ass->id . "</UID>" . $nl;
	      echo "<TaskUID>" . $arrayTask[$ass->refType . '#' . $ass->refId] . "</TaskUID>" . $nl;
	      echo "<ResourceUID>" . $ass->idResource . "</ResourceUID>" . $nl;
	      //echo "<PercentWorkComplete>' (($ass->plannedWork)?round($ass->realWork/$ass->plannedWork*100,0):'0') . '</PercentWorkComplete>" . $nl;
	      //echo "<ActualCost>0</ActualCost>" . $nl;
	      //echo "<ActualOvertimeCost>0</ActualOvertimeCost>" . $nl;
	      //echo "<ActualOvertimeWork>PT0H0M0S</ActualOvertimeWork>" . $nl;
	      echo "<ActualStart>" . $ass->plannedStartDate . "T" . $startAM . "</ActualStart>" . $nl;
	      //echo "<ActualWork>PT0H0M0S</ActualWork>" . $nl;
	      //echo "<ACWP>0</ACWP>" . $nl;
	      //echo "<Confirmed>0</Confirmed>" . $nl;
	      //echo "<Cost>0</Cost>" . $nl;
	      //echo "<CostRateTable>0</CostRateTable>" . $nl;
	      //echo "<CostVariance>0</CostVariance>" . $nl;
	      //echo "<CV>0</CV>" . $nl;
	      //echo "<Delay>0</Delay>" . $nl;
	      echo "<Finish>" . $ass->plannedEndDate . "T" . $endPM . "</Finish>" . $nl;
	      //echo "<FinishVariance>0</FinishVariance>" . $nl;
	      //echo "<WorkVariance>0</WorkVariance>" . $nl;
	      //echo "<HasFixedRateUnits>1</HasFixedRateUnits>" . $nl;
	      //echo "<FixedMaterial>0</FixedMaterial>" . $nl;
	      //echo "<LevelingDelay>0</LevelingDelay>" . $nl;
	      //echo "<LevelingDelayFormat>7</LevelingDelayFormat>" . $nl;
	      //echo "<LinkedFields>0</LinkedFields>" . $nl;
	      //echo "<Milestone>0</Milestone>" . $nl;
	      //echo "<Overallocated>0</Overallocated>" . $nl;
	      //echo "<OvertimeCost>0</OvertimeCost>" . $nl;
	      //echo "<OvertimeWork>PT0H0M0S</OvertimeWork>" . $nl;
	      echo "<RegularWork>PT" . $ass->plannedWork*$hoursPerDay . "H0M0S</RegularWork>" . $nl;
	      //echo "<RemainingCost>0</RemainingCost>" . $nl;
	      //echo "<RemainingOvertimeCost>0</RemainingOvertimeCost>" . $nl;
	      //echo "<RemainingOvertimeWork>PT0H0M0S</RemainingOvertimeWork>" . $nl;
	      echo "<RemainingWork>PT" . $ass->leftWork*$hoursPerDay ."H0M0S</RemainingWork>" . $nl;
	      //echo "<ResponsePending>0</ResponsePending>" . $nl;
	      //echo "<Start>2011-11-17T08:00:00</Start>" . $nl;
	      //echo "<Stop>2011-11-17T08:00:00</Stop>" . $nl;
	      //echo "<Resume>2011-11-17T08:00:00</Resume>" . $nl;
	      //echo "<StartVariance>0</StartVariance>" . $nl;
	      echo "<Units>" . round(($res->capacity * $ass->rate / 100),1) . "</Units>" . $nl;
	      //echo "<UpdateNeeded>0</UpdateNeeded>" . $nl;
	      //echo "<VAC>0</VAC>" . $nl;
	      echo "<Work>PT" . $ass->plannedWork*$hoursPerDay . "H0M0S</Work>" . $nl;
	      //echo "<WorkContour>0</WorkContour>" . $nl;
	      //echo "<BCWS>0</BCWS>" . $nl;
	      //echo "<BCWP>0</BCWP>" . $nl;
	      //echo "<BookingType>0</BookingType>" . $nl;
	      //echo "<ActualWorkProtected>PT0H0M0S</ActualWorkProtected>" . $nl;
	      //echo "<ActualOvertimeWorkProtected>PT0H0M0S</ActualOvertimeWorkProtected>" . $nl;
	      //echo "<CreationDate>2011-11-18T21:06:00</CreationDate>" . $nl;
	      //echo "<TimephasedData>" . $nl;
	      //echo "<Type>1</Type>" . $nl;
	      //echo "<UID>1</UID>" . $nl;
	      //echo "<Start>" . $ass->plannedStartDate . "T08:00:00</Start>" . $nl;
	      //echo "<Finish>" . $ass->plannedEndDate . "T08:00:00</Finish>" . $nl;
	      //echo "<Unit>2</Unit>" . $nl;
	      //echo "<Value>PT8H0M0S</Value>" . $nl;
	      //echo "</TimephasedData>" . $nl;
	      echo "</Assignment>" . $nl;
    	}
    }  
    echo "</Assignments>" . $nl;
    echo '</Project>' . $nl;
  }
  
  function formatDuration($duration, $hoursPerDay) {
    $hourDuration=$duration*$hoursPerDay;
  	$res = 'PT' . $hourDuration . 'H0M0S'; 
  	return $res;
  }
?>