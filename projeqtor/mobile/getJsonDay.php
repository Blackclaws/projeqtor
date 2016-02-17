<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2014 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 *
 * This file is a plugIn for ProjeQtOr.
 * This plugIn in not Open Source.
 * You must have bought the licence from Copyrigth owner to use this plgIn.
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * Display Agenda - like items, in a Json format 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/mobile/getJsonDay.php');  
  
  $cpt=0;
  $arrayActivities=array(); // Array of activities to display
  $idRessource=getSessionUser()->id;
  $period='day';
  $fullDay=$_REQUEST['currentDate'];
  if ($fullDay=='prev') {
  	$currentDay=addDaysToDate($_SESSION['mobileCurrentDay'],-1);
  } else if ($fullDay=='next') {
  	$currentDay=addDaysToDate($_SESSION['mobileCurrentDay'],1);
  } else if ($fullDay=='refresh') {
  	$currentDay=$_SESSION['mobileCurrentDay'];
  } else {
  	$currentDay=$fullDay;
  }
  $day=substr($currentDay,8,2);
  $year=substr($currentDay,0,4);
  $month=substr($currentDay,5,2);
   
  $_SESSION['mobileCurrentDay']=$currentDay;
  
  $ress=new Resource($idRessource);
  $calendar=$ress->idCalendarDefinition;
  $weekDaysCaption=array(
  		1=>i18n("Monday"),
  		2=>i18n("Tuesday"),
  		3=>i18n("Wednesday"),
  		4=>i18n("Thursday"),
  		5=>i18n("Friday"),
  		6=>i18n("Saturday"),
  		0=>i18n("Sunday"),
  );
  $projectColorArray=array();
  $projectNameArray=array();
  $endDay=$currentDay;
  $inScopeDay=true;
  $arrayActivities=getAllActivities($currentDay, $endDay, $idRessource);
  echo '{"identifier":"id",' ;
  echo '"label": "name",';
  echo '"day": "'.$currentDay.'",';
  echo '"dayCaption":"'.$weekDaysCaption[date('w',strtotime($currentDay))]." ".$day.'/'.$month.'/'.$year.'",';
  echo ' "items":[';
  drawDay($currentDay,$idRessource,$calendar);
  echo ' ] }';
  return;
  
function drawDay($date,$ress,$calendar=1) {
	global $cpt;

	$bgColor="#FFFFFF";
	if ($date==date('Y-m-d')) { 
		$bgColor="#ffffaa"; 
	} else if (isOffDay($date,$calendar)) {
		$bgColor="#dfdfdf";
	}
	$lst=getActivity($date);
	foreach ($lst as $item) {
		if ($cpt) echo ",";
		$cpt++; 
		echo '{';
		echo '"id":"'.$item['id'].'",';
		echo '"type":"'.htmlEncode($item['type'],'json').'",';
		echo '"nameType":"'.htmlEncode(i18n($item['type']),'json').'",';
		echo '"name":"'.htmlEncode($item['name'],'json').'",';
	  echo '"project":"'.htmlEncode($item['project'],'json').'",';
	  echo '"real":"'.$item['real'].'",';
	  echo '"work":"'.$item['work'].'",';
	  echo '"workUnit":"'.Work::displayWorkWithUnit($item['work']).'",';
	  echo '"color":"'.$item['color'].'",';
	  echo '"foreColor":"'.getForeColor($item['color']).'",';
	  echo '"display":"'.htmlEncode($item['display'],'json').'",';
	  echo '"icon":"../view/css/images/icon'.$item['type'].'32.png"';
	  echo "}";
	}
}

function getActivity($date) {
	global $arrayActivities;
	if (array_key_exists($date, $arrayActivities)) {
		return $arrayActivities[$date];
	} else {
		return array();
	}
}

function getAllActivities($startDate, $endDate, $ress) {
	global $projectColorArray, $projectNameArray, $allActi;
	$result=array();
	// 
	$arrObj=array(new Action(), new Ticket(), new MilestonePlanningElement());
	foreach ($arrObj as $obj) {
		$critWhere="done=0 and idResource=".Sql::fmtId($ress);
		if (property_exists($obj, 'actualDueDate') and property_exists($obj, 'initialDueDate')) {
		  $critWhere.=" and ( "
		   ." (actualDueDate>='$startDate' and actualDueDate<='$endDate') "
		   ." or ( actualDueDate is null and (initialDueDate>='$startDate' and initialDueDate<='$endDate') )"
		   ." )";
	  } else if (property_exists($obj, 'actualDueDateTime') and property_exists($obj, 'initialDueDateTime')) {
		  $critWhere.=" and ( "
		   ." (actualDueDateTime>='$startDate 00:00:00' and actualDueDateTime<='$endDate 23:59:59') "
		   ." or ( actualDueDateTime is null and (initialDueDateTime>='$startDate 00:00:00' and initialDueDateTime<='$endDate 23:59:59') )"
	     ." )";
		} else if (property_exists($obj, 'validatedEndDate') ) {
			if ($ress==getSessionUser()->id) {
				$critWhere=" refType='MileStone' and validatedEndDate>='$startDate' and validatedEndDate<='$endDate' ";
				$critWhere.=" and idProject in ".transformListIntoInClause(getSessionUser()->getVisibleProjects(true));
			} else {
				$critWhere="1=0";
			}
	  } else {
	  	$critWhere.=" and 1=0";
	  }
		$lst=$obj->getSqlElementsFromCriteria(null,false,$critWhere);
		foreach ($lst as $o) {
			if (array_key_exists($o->idProject,$projectColorArray)) {
				$color=$projectColorArray[$o->idProject];
				$projName=$projectNameArray[$o->idProject];
			} else {
				$pro=new Project($o->idProject);
				$color=$pro->color;
				$projName=$pro->name;
				$projectColorArray[$o->idProject]=$color;
				$projectNameArray[$o->idProject]=$projName;
			}
			$date=null;
			$dateField="";
			$name="";
			$id=$o->id;
			$class=get_class($o);
			if (property_exists($obj, 'actualDueDate') and property_exists($obj, 'initialDueDate')) {
				if ($o->actualDueDate) {
					$date=$o->actualDueDate;
					$dateField=i18n('colActualDueDate');
				} else {
					$date=$o->initialDueDate;
					$dateField=i18n('colInitialDueDate');
				}
				$name=$o->name;
			} else if (property_exists($obj, 'actualDueDateTime') and property_exists($obj, 'initialDueDateTime')) {
				if ($o->actualDueDateTime) {
					$date=substr($o->actualDueDateTime,0,10);
					$dateField=i18n('colActualDueDate');
				} else {
					$date=substr($o->initialDueDateTime,0,10);
					$dateField=i18n('colInitialDueDate');
				}
				$name=$o->name;
			} else if (property_exists($obj, 'validatedEndDate')) {
				$name=$o->refName;
				$id=$o->refId;
				$class=$o->refType;
				$date=$o->validatedEndDate;
				$dateField=i18n('colValidatedEndDate');
			}
			if ($date) {
				if (!array_key_exists($date, $result)) {
					$result[$date]=array();
				}				
				$result[$date][get_class($o).'#'.$o->id]=array(
						'type'=>$class,
						'id'=>$id,
						'work'=>0,
						'name'=>$name,
						'color'=>$color,
						'display'=>$name,
						'date'=>$dateField,
						'project'=>$projName,
						'real'=>false
				);
			}		
		}
	}
	// Planned Activities and real work
	$pw=new PlannedWork();
	$w=new Work();
	$critWhere="idResource=".Sql::fmtId($ress);
	$critWhere.=" and workDate>='$startDate' and workDate<='$endDate'";
	$pwList=$pw->getSqlElementsFromCriteria(null,false,$critWhere);
	$wList=$w->getSqlElementsFromCriteria(null,false,$critWhere);
	$workList=array_merge($pwList,$wList);
	foreach ($workList as $pw) {
		$item=new $pw->refType($pw->refId);
		if ($pw->refType=='Meeting') {
			$display=substr($item->meetingStartTime,0,5).' - '.$item->name;
		} else if (get_class($pw)=='Work') {
				$display=$item->name;
		} else {
		  $display=$item->name;
		}
		if (array_key_exists($item->idProject,$projectColorArray)) {
			$color=$projectColorArray[$item->idProject];
			$projName=$projectNameArray[$item->idProject];
		} else {
			$pro=new Project($item->idProject);
			$color=$pro->color;
			$projName=$pro->name;
			$projectColorArray[$item->idProject]=$color;
			$projectNameArray[$item->idProject]=$projName;
		}
		$date=$pw->workDate;
		if (!array_key_exists($date, $result)) {
			$result[$date]=array();
		}
		$result[$date][$pw->refType.'#'.$pw->refId]=array(
				'type'=>$pw->refType,
		    'id'=>$pw->refId,
				'work'=>$pw->work,
				'name'=>$item->name,
				'color'=>$color,
				'display'=>$display,
				'project'=>$projName,
				'date'=>"",
				'real'=>((get_class($pw)=='Work')?true:false)
		);
	}
	return $result;
}


?>

