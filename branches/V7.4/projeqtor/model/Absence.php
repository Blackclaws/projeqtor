<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
* Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
* Contributors : -
*
* This file is part of ProjeQtOr.
*
* ProjeQtOr is free software: you can redistribute it and/or modify it under
* the terms of the GNU Affero General Public License as published by the Free
* Software Foundation, either version 3 of the License, or (at your option)
* any later version.
*
* ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
* WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
* FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for
* more details.
*
* You should have received a copy of the GNU Affero General Public License along with
* ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
*
* You can get complete code of ProjeQtOr, other resource, help and information
* about contributors at http://www.projeqtor.org
*
*** DO NOT REMOVE THIS NOTICE ************************************************/
require_once('_securityCheck.php');
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";

class Absence{
  public $id;
  public $name;
  public $idProject;
  public $idActivity;
  
  /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */
  function __construct($id=NULL, $withoutDependentObjects=false) {
    
  }
  /** ==========================================================================
   * Destructor
   * @return void
   */
  function __destruct() {}
  
  static function drawActivityDiv($userID, $currentYear){
    $keyDownEventScript=NumberFormatter52::getKeyDownEvent();
    // Insert new lines for admin projects
    Assignment::insertAdministrativeLines($userID);
    //Get administrative project list 
    $proj = new Project();
    $listIdProjAdm = $proj->getAdminitrativeProjectList(true);
    $act = new Activity();
    $where = "idProject in " . Project::getAdminitrativeProjectList() ;
    //$where .= "and idle = 0 ";
    $listAct = $act->getSqlElementsFromCriteria(null,false,$where,"idProject asc");
    $ass = new Assignment();
    
    //Variable parameter
    $result="";
    $actName = "";
    $actId = "";
    $actProject = "";
    $projName = "";
    $idProject = "";
    $listAss = "";
    $sltActId = "";
    $idle = "";
    $max = 1;
    $assId = "";
    $idColor = 0;
    global $tabColor;
    $tabColor = array();
    //Activity Table view
    
    $result .='<div id="activityDiv" align="center" style="margin-top:20px; overflow-y:auto; width:100%;">';
    $result .=' <table align="left" style="margin-left:20px; border: 1px solid grey; width: 50%;">';
    $result .='   <tr>';
    $result .='     <td class="reportHeader" style="border-right: 1px solid grey; height:30px;">'.i18n('colProjectName').'</td>';
    $result .='     <td class="reportHeader" style="border-right: 1px solid grey; height:30px; width: 10%;">'.i18n('activityId').'</td>';
    $result .='     <td class="reportHeader" style="height:30px;">'.i18n('activityName').'</td>';
    $result .='   </tr>';

    
    $listActId="(";
    foreach ($listAct as $id=>$val){
    	foreach ($listAct[$id] as $id2=>$val2){
    	  if ($id2 == 'id') {
    	    $listActId.= $val2 .',';
    	    $actId = htmlEncode($val2);
    	  }
    	  if($id2 == 'name') {
    	    $actName = htmlEncode($val2);
    	  }
    	  if ($id2 == 'idProject') {
    	    $idProject = $val2;
    	    $projName = htmlEncode(SqlList::getNameFromId('Project',$val2));
    	  }
    	  if ($id2 == 'idle') {
    	  	$idle = $val2;
    	  }
    	}
    	if($actId != null and $userID != null ){
    		$where2 = "refType = 'Activity' and refId = ".$actId." and idResource =".$userID;
    		$listAss = $ass->getSqlElementsFromCriteria(null,false,$where2);
    	}else{
    	  continue;
    	}
    	
    	foreach ($listAss as $id3=>$val3){
      	foreach ($listAss[$id3] as $id4=>$val4){
      	  if ($id4 == 'id') {
      	    $assId = htmlEncode($val4);
      	  }
      	}
    	  $actRowId = "actRow".$actId;
    	  if(!$idle){
    	    $result .=' <tr class="absActivityRow dojoxGridRow" id="'.$actRowId.'" align="center" style="height:20px; border: 1px solid grey; cursor:pointer;" onClick="selectActivity('.$actRowId.','.$actId.','.$idProject.','.$assId.')">';
    	  }else{
    	    $workClose = new Work();
    	    $where3 = " refType = 'Activity' and refId = ".$actId." and idResource =".$userID." and year = ".$currentYear;
    	    $listWorkClose = $workClose->getSqlElementsFromCriteria(null,false,$where3);
    	    if($listWorkClose){
    	      $result .=' <tr class="absActivityRow dojoxGridRow" id="'.$actRowId.'" align="center" style="background: #DDDDDD; height:20px; border: 1px solid grey;">';
  	      }else {
  	        continue;
  	      }
  	    }
    	  $result .= '   <input type="hidden" name="inputActId" id="inputActId" value=""/>';
    	  $result .= '   <input type="hidden" name="inputIdProject" id="inputIdProject" value=""/>';
    	  $result .= '   <input type="hidden" name="inputAssId" id="inputAssId" value=""/>';
    	  $result .='    <td align="left" style="border:1px solid grey;">&nbsp;'.$projName.'</td>';
    	  $result .='    <td align="center" style="border:1px solid grey;">#'.$actId.'</td>';
    	  $result .='    <td align="left" style="border:1px solid grey;">&nbsp;'.formatAbsenceColor($idColor, 15, 'left').$actName.'</td>';
    	  $result .='  </tr>';
    	  $tabColor[$actId]=$idColor;
    	  $idColor++;
    	}
    }
    $tabColor = json_encode($tabColor);
    $listActId = substr($listActId, 0, -1);
    $listActId .= ')';
    $result .='</table>';
    
    $result .='<table align="left" style="margin-top:50px; margin-left:100px;">';
    $result .=' <tr>';
    $unitAbs = Parameter::getGlobalParameter('imputationUnit');
    if($unitAbs == 'days'){
      $result .=' <td style="margin-top:30px; height:20px;">'.i18n('numberOfDays').'&nbsp;</td>';
    }else{
      $result .=' <td style="margin-top:30px; height:20px;">'.i18n('numberOfHours').'&nbsp;</td>';
      $max = Parameter::getGlobalParameter('dayTime');
    }
    $result .='   <td>';
    $result .='   <div id="absenceInput" name="absenceInput" value="'.$max.'"
                  		dojoType="dijit.form.NumberTextBox" constraints="{min:0.00,max:'.$max.'}"  required="true"
                  		style="width:50px; margin-top:4px; height:20px;">';
    $result .= $keyDownEventScript;
    $result .='   </div> ';
    $result .='   <span id="absButton_1" style="width:40px; height:18px !important;" type="button" dojoType="dijit.form.Button" showlabel="true">'.$max
            . '     <script type="dojo/method" event="onClick" >'
            . '        dijit.byId("absenceInput").setAttribute("value" ,'.$max.');'
            . '     </script>'
            . '   </span>&nbsp;';
    $result .='   <span id="absButton_0_5" style="width:40px; height:18px !important;" type="button" dojoType="dijit.form.Button" showlabel="true">'.($max/2)
            . '     <script type="dojo/method" event="onClick" >'
            . '       dijit.byId("absenceInput").setAttribute("value" ,'.($max/2).');'
            . '     </script>'
            . '    </span>&nbsp;';
    $result .='   <span id="absButton_0" style="width:40px; height:18px;" type="button" dojoType="dijit.form.Button" showlabel="true">0'
            . '     <script type="dojo/method" event="onClick" >'
            . '       dijit.byId("absenceInput").setAttribute("value" ,0);'
            . '     </script>'
            . '   </span>';
    $result .='   </td>';
    $result .=' </tr>';
    $result .='</table>';
    $result .='</div>';
    $result .='<div id="warningExceedWork" class="messageWARNING" style="z-index:99;display: none; text-align: center; position:absolute; top:45%;margin-left: 32%; height:20px; width: 35%;">'.i18n('exceedWork').'</div></br>';
    $result .='<div id="warningNoActivity" class="messageWARNING" style="z-index:99;display: none; text-align: center; position:absolute; top:45%;margin-left: 32%; height:20px; width: 35%;">'.i18n('noActivitySelected').'</div></br>';
    echo $result;
  }
  
  static function drawCalandarDiv($userID, $currentYear){
    // Activity calendar view
    $proj = new Project();
    $listIdProjAdm = $proj->getAdminitrativeProjectList(true);
    $act = new Activity();
    $where = "idProject in " . Project::getAdminitrativeProjectList() ;
    //$where .= "and idle = 0 ";
    $listAct = $act->getSqlElementsFromCriteria(null,false,$where,"idProject asc");
    $ass = new Assignment();
    $res = new Resource($userID);
    
    $actId = "";
    $actProject = "";
    $idProject = "";
    $listAss = "";
    $assId = "";
    $result="";
    $idColor = 0;
    $tabColor = array();
    $colorTab= array('#f08080','#ffc266', '#ffff66','#84e184', '#87ceeb', '#ff66ff', '#c68c53', '#ff99cc');
    
    $listActId="(";
    foreach ($listAct as $id=>$val){
    	foreach ($listAct[$id] as $id2=>$val2){
    		if ($id2 == 'id') {
    			$listActId.= $val2 .',';
    			$actId = htmlEncode($val2);
    		}
    		if ($id2 == 'idProject') {
    			$idProject = $val2;
    		}
    	}
    	if($actId != null and $userID != null ){
    		$where2 = "refType = 'Activity' and refId = ".$actId." and idResource =".$userID;
    		$listAss = $ass->getSqlElementsFromCriteria(null,false,$where2);
    	}else{
    		continue;
    	}
    	foreach ($listAss as $id3=>$val3){
    		foreach ($listAss[$id3] as $id4=>$val4){
    			if ($id4 == 'id') {
    				$assId = htmlEncode($val4);
    			}
    		}
    		$tabColor[$actId]=$idColor;
    		$idColor++;
    	}
    }
    $listActId = substr($listActId, 0, -1);
    $listActId .= ')';
    
    $today=date('Y-m-d');
    global $bankHolidays,$bankWorkdays;
    $result .= '<div id="absenceCalendar" name="absenceCalendar" align="center">';
    $result .='<table>';
    $result .='<tr><td class="calendarHeader" colspan="32">' .$currentYear. '</td></tr>';
    setlocale(LC_TIME, "en_US");
    setlocale(LC_TIME, "en_US");
    for ($m=1; $m<=12; $m++) {
    	$mx=($m<10)?'0'.$m:''.$m;   	
    	$time=mktime(0, 0, 0, $m, 1, $currentYear);
    	$libMonth=i18n(strftime("%B", $time));
    	$result .= '<tr style="height:30px">';
    	$result .= '<td class="calendar" style="background:#F0F0F0; width: 150px;">' . $libMonth . '</td>';
    	for ($d=1;$d<=date('t',strtotime($currentYear.'-'.$mx.'-01'));$d++) {
    		$dx=($d<10)?'0'.$d:''.$d;
    		$day=$currentYear.'-'.$mx.'-'.$dx;
    		$iDay=strtotime($day);
    		$isOff=isOffDay($day,$res->idCalendarDefinition);
    		$isOpen=isOpenDay($day,$res->idCalendarDefinition);
    		$style='';
    		if ($day==$today) {
    			$style.='font-weight: bold; font-size: 9pt;';
    		}
    		if($isOpen){
    			$style.='background: #FFFFFF; cursor: pointer;';
    		}else{
    			$style.='background: #DDDDDD;';
    		}
    
    		$dateId = date('M', $iDay).mb_substr(date('l',$iDay),0,1,"UTF-8").$d;
    		$dateDay = date('Ymd',$iDay);
    		$workDay = date('Y-m-d', $iDay);
    		$week=date('Y', $iDay).date('W',$iDay) ;
    		$month = date('Ym', $iDay);
    		$year = date('Y', $iDay);
    		$result.= '<td id="'.$dateId.'" class="calendar" style="'.$style.'">';
    		$transHeight = 100;
    		$workHeigth = 0;
    		$onClick = 'onClick="selectAbsenceDay(\''.$dateId.'\',\''.$dateDay.'\',\''.$workDay.'\',\''.$month.'\',\''.$year.'\',\''.$week.'\',\''.$userID.'\')"';
    		if($isOpen){
    		  $result.= '<div style="position:relative; width:30px; height:30px;"'.$onClick.'>';
    		}else{
    			$result.= '<div style="position:relative; width:30px; height:30px;">';
    		}
    		$result.= '<div style="width:30px; height:15px;position:absolute; padding-top:10px; text-align:center; vertical-align:middle">';
    		$result.= mb_substr(i18n(date('l',$iDay)),0,1,"UTF-8").$d;
    		$result.= '</div>';
    		if($isOpen){
    			$listWork = self::getWorkAdmActList($listActId, $userID, $workDay);
    			foreach ($listWork as $work){
    				$workV = $work->work;
    				$idActWork = $work->refId;
    				if($workV){
    				  $workHeigth = $workHeigth + (($workV/1)*100);
    				  if($workHeigth <= 100){
    				    if($tabColor){
    				    $idColor = $tabColor[$idActWork];
    				    $background = $colorTab[$idColor];
    				    $result.='<div style="background:'.$background.'; height:'.(($workV/1)*100).'%"> </div>';
    				  }
    				  }
    				}
    			}
    			if($transHeight > 0){
    			  $transHeight = $transHeight-$workHeigth;
    			  $result.='<div style="background:transparent; height:'.$transHeight.'%"> </div>';
    			}else {
    			  $transHeight = 0;
    			  $result.='<div style="background:transparent; height:'.$transHeight.'%"> </div>';
    			}
    		}
    		$result.= '</div>';
    		$result.= '</td>';
    	}
    	$result .= '</tr>';
    }
    $result .='</table>';
    $result .='</div>';
    echo $result;
  }
  
  static function getWorkAdmActList($listActId, $userId, $workDate){
  	$work = new Work();
  	$where = "refId in ".$listActId;
    $where .= " and refType = 'Activity' and idResource =".$userId." and workDate='".$workDate."'";
    $listWork = $work->getSqlElementsFromCriteria(null,false,$where);
    return $listWork;
  }
}

function formatAbsenceColor($idColor, $size=20, $float='right') {
	$color= array('#f08080','#ffc266', '#ffff66','#84e184', '#87ceeb', '#ff66ff', '#c68c53', '#ff99cc');
	$radius=round($size/2,0);
	$res='<div style="margin-left:2px; border: 1px solid #AAAAAA;background:'.$color[$idColor].';';
	$res.='width:'.($size-2).'px;height:'.($size-2).'px;float:'.$float.';border-radius:'.$radius.'px"';
	$res.='>&nbsp;</div>';
	return $res;
}
?>