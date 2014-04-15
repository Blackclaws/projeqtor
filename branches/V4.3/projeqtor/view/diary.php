<?php 
/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/diary.php');  
  
  $idRessource=$_SESSION['user']->id;
  if (! isset($period)) {
  	$period=htmlentities($_REQUEST['diaryPeriod']);
    $year=htmlentities($_REQUEST['diaryYear']);
    $month=htmlentities($_REQUEST['diaryMonth']);
    $week=htmlentities($_REQUEST['diaryWeek']);
    $day=htmlentities($_REQUEST['diaryDay']);
    Parameter::storeUserParameter("diaryPeriod",$period);
    $idRessource=$_REQUEST['diaryResource'];
  }
  
  $weekDaysCaption=array(
  		1=>i18n("Monday"),
  		2=>i18n("Tuesday"),
  		3=>i18n("Wednesday"),
  		4=>i18n("Thursday"),
  		5=>i18n("Friday"),
  		6=>i18n("Saturday"),
  		7=>i18n("Sunday"),
  );
  $projectColorArray=array();
  if ($period=="month") {
  	$trHeight=20;
  	$week=weekNumber($year.'-'.$month.'-01');
  	$lastWeek=weekNumber($year.'-'.$month.'-'.date('t', mktime(0, 0, 0, $month, 1, $year)));
  	$trHeight=round(100/($lastWeek-$week+1))-1;
  } else {
  	$trHeight=100;
  }

  if ($period=="month") {
  	$currentDay=date('Y-m-d',firstDayofWeek($week,$year));
  	$lastDayOfMonth=date('t',strtotime($year.'-'.$month.'-01'));
  	$weekOfLastDayOfMonth=date('W',strtotime($year.'-'.$month.'-'.$lastDayOfMonth));
  	$firstDayOfLastWeek=date('Y-m-d',firstDayofWeek($weekOfLastDayOfMonth, (($lastWeek>$week)?$year:$year+1) ));	
  	$endDay=addDaysToDate($firstDayOfLastWeek, 6);
  	$inScopeDay=false;
  } else if ($period=="week") {
  	$currentDay=date('Y-m-d',firstDayofWeek($week,$year));
  	$endDay=addDaysToDate($currentDay, 6);
  	$inScopeDay=true;
  } else if ($period=="day") {
  	$currentDay=$day;
  	$endDay=$currentDay;
  	$inScopeDay=true;
  }
  echo '<TABLE style="width:100%; height: 100%;">';
  
  if ($period!='day') {
    echo '<tr height="10px"><td></td>';
    for ($i=1; $i<=7;$i++) {
  	  echo '<td class="section" style="width: 14%;">'.$weekDaysCaption[$i].'</td>';
    }
  } else {
  	echo '<tr height="0px"><td></td>';
  }
  drawDiaryLineHeader($currentDay, $trHeight,$period); 
  while ($currentDay<=$endDay) {
  	if ($period=="month") {
  		if (substr($currentDay,5,2)==$month) {
  			$inScopeDay=true;
  		} else {
  			$inScopeDay=false;
  		}
  	}
  	echo '<td style="width: '.(($period=='day')?'100':'14').'%; border: 1px solid #AAAAAA;background-color:'.(($inScopeDay)?'white':'transparent').'">';
  	drawDay($currentDay,$idRessource,$inScopeDay,$period); 
  	$currentDay=addDaysToDate($currentDay, 1);
  	if ($currentDay<=$endDay and date('N', strtotime($currentDay))==1) {
      drawDiaryLineHeader($currentDay, $trHeight,$period);
  	}
  }
  echo '</tr></TABLE>';
  
function drawDay($date,$ress,$inScopeDay,$period) {
	echo '<table style="width:100%; height: 100%">';
	if ($period!='day') {
		echo '<tr style="height:10px">';
		echo '<td class="reportHeader" style="cursor: pointer;'.((!$inScopeDay)?'color:#AAAAAA':'').'"';
		echo ' onClick="diaryDay(\''.$date.'\');" >';
		//echo $date.'/';
		echo substr($date,8,2);
		echo '</td>';
		echo '</tr>';
	}
	echo '<tr >';
	echo '<td style="vertical-align:top">';
	echo '<div style="overflow-y: auto; overflow-y:none; height:100%;">';
	echo '<table style="width:100%">';
	$lst=getActivity($date,$ress);
	foreach ($lst as $item) {
		echo '<tr>';
		echo '<td style="padding: 3px 3px 0px 3px; width:100%">';
		echo '<div style="border:1px solid: #EEEEEE; box-shadow: 2px 2px 4px #AAAAAA; width: 100%;background-color:'.$item['color'].'">';
		echo '<table><tr><td>';
		echo '<img src="../view/css/images/icon'.$item['type'].'16.png"/></td><td style="width:1px">';
		echo '</td><td style="color:#555555">';
		echo '<div style="cursor:pointer;color:'.getForeColor($item['color']).'" onClick="gotoElement(\''.$item['type'].'\', '.$item['id'].', false);" >'.$item['display'].'</div>';
		echo '</td></tr></table>';
		echo '</div>';
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';	
	echo '</div>';
	echo '</td>';		
	echo '</tr>';
	echo '</table>';
}

function getActivity($date,$ress) {
	global $projectColorArray;
	$pw=new PlannedWork();
	$result=array();
	// 
	$arrObj=array(new Action(), new Ticket());
	foreach ($arrObj as $obj) {
		$critWhere="done=0 and idResource=".Sql::fmtId($ress);
		if (property_exists($obj, 'actualDueDate') and property_exists($obj, 'initialDueDate')) {
		  $critWhere.=" and (actualDueDate='$date' or ( actualDueDate is null and initialDueDate='$date') )";
	  } else if (property_exists($obj, 'actualDueDateTime') and property_exists($obj, 'initialDueDateTime')) {
		  $critWhere.=" and (actualDueDateTime>'$date 00:00:00' and actualDueDateTime>'$date 23:59:59') ";
		  $critWhere.=" or ( actualDueDate is null and initialDueDateTime='$date') )";
	  } else {
	  	$critWhere.=" and 1=0";
	  }
		$lst=$obj->getSqlElementsFromCriteria(null,false,$critWhere);
		foreach ($lst as $o) {
			if (array_key_exists($o->idProject,$projectColorArray)) {
				$color=$projectColorArray[$o->idProject];
			} else {
				$pro=new Project($o->idProject);
				$color=$pro->color;
				$projectColorArray[$o->idProject]=$color;
			}
			$result[get_class($o).'#'.$o->id]=array(
					'type'=>get_class($o),
					'id'=>$o->id,
					'work'=>0,
					'name'=>$o->name,
					'color'=>$color,
					'display'=>$o->name
					);
		}
	}
	// Planned Activities
	$crit=array('idResource'=>$ress,'workDate'=>$date);
	$pwList=$pw->getSqlElementsFromCriteria($crit);
	foreach ($pwList as $pw) {
		$item=new $pw->refType($pw->refId);
		if ($pw->refType=='Meeting') {
			$display=substr($item->meetingStartTime,0,5).' - '.htmlEncode($item->name);
		} else {
		  $display='<i>('.Work::displayWorkWithUnit($pw->work).')</i> '.htmlEncode($item->name);
		}
		if (array_key_exists($item->idProject,$projectColorArray)) {
			$color=$projectColorArray[$item->idProject];
		} else {
			$pro=new Project($item->idProject);
			$color=$pro->color;
			$projectColorArray[$item->idProject]=$color;
		}
		$result[$pw->refType.'#'.$pw->refId]=array(
				'type'=>$pw->refType,
		    'id'=>$pw->refId,
				'work'=>$pw->work,
				'name'=>$item->name,
				'color'=>$color,
				'display'=>$display
		);
	}
	return $result;
}

function drawDiaryLineHeader($currentDay, $trHeight,$period) {
	echo '</tr>';
	echo '<tr height="'.$trHeight.'%"><td class="buttonDiary" ';
	if ($period=="month") {
	  echo 'onClick="diaryWeek('.weekNumber($currentDay).','.substr($currentDay,0,4).');"';
	} else if ($period=="week") {
		echo 'onClick="diaryMonth('.substr($currentDay,5,2).','.substr($currentDay,0,4).');"';
	} else if ($period=="day") {
		echo 'onClick="diaryWeek('.weekNumber($currentDay).','.substr($currentDay,0,4).');"';
	}	
	echo '>';
	if ($period=='week') {
		$month=substr($currentDay,5,2);
		$monthArr=array(i18n("January"),i18n("February"),i18n("March"),
				i18n("April"), i18n("May"),i18n("June"),
				i18n("July"), i18n("August"), i18n("September"),
				i18n("October"),i18n("November"),i18n("December"));
		$dispMonth=(mb_strlen($monthArr[$month-1],'UTF-8')>4)?mb_substr($monthArr[$month-1],0,4,'UTF-8').'.':$monthArr[$month-1];
		echo '<div style="font-size:80%">'.$dispMonth.'</div>';
	} else {
	  echo '<div >'.weekNumber($currentDay).'</div>';
	}
	if ($period=="month") {
		echo '<img src="../view/css/images/right.png" /></td>';
	} else {
		echo '<img src="../view/css/images/left.png" /></td>';
	}
}
?>

