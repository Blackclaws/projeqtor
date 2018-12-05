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
    //recup list projet administratif
    $proj = new Project();
    $listIdProjAdm = $proj->getAdminitrativeProjectList(true);
    $act = new Activity();
    $where = "idProject in " . Project::getAdminitrativeProjectList() ;
    $where .= "and idle = 0 ";
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
    $absenceValue = 0.5;
    $sltActId = "";
    $max = 1;
    $assId = "";
    
    //Activity Table view
    $result .='<div id="activityDiv" align="center" style="margin-top:20px; overflow-y:auto; height:200px; width:100%;">';
    $result .=' <table align="left" style="margin-left:20px; border: 1px solid grey; width: 50%;">';
    $result .='   <tr>';
    $result .='     <td class="reportHeader" style="height:30px;">'.i18n('colProjectName').'</td>';
    $result .='     <td class="reportHeader" style="height:30px; width: 10%;">'.i18n('activityId').'</td>';
    $result .='     <td class="reportHeader" style="height:30px;">'.i18n('activityName').'</td>';
    $result .='   </tr>';

    foreach ($listAct as $id=>$val){
    	foreach ($listAct[$id] as $id2=>$val2){
    	  if ($id2 == 'id') {
    	    $actId = htmlEncode($val2);
    	  }
    	  if($id2 == 'name') {
    	    $actName = htmlEncode($val2);
    	  }
    	  if ($id2 == 'idProject') {
    	    $idProject = $val2;
    	    $projName = htmlEncode(SqlList::getNameFromId('Project',$val2));
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
    	  $actRowId = "actRow$actId";
    	  $result .='  <tr class="absActityRow" id="'.$actRowId.'" align="center" style="height:20px; border: 1px solid grey; cursor:pointer;" onClick="selectActivity('.$actRowId.','.$actId.','.$idProject.','.$assId.')">';
    	  $result .= '   <input type="hidden" name="inputActId" id="inputActId" value=""/>';
    	  $result .= '   <input type="hidden" name="inputIdProject" id="inputIdProject" value=""/>';
    	  $result .= '   <input type="hidden" name="inputAssId" id="inputAssId" value=""/>';
    	  $result .='    <td align="left" style="border:1px solid grey;">&nbsp;'.$projName.'</td>';
    	  $result .='    <td align="center" style="border:1px solid grey;">#'.$actId.'</td>';
    	  $result .='    <td align="left" style="border:1px solid grey;">&nbsp;'.$actName.'</td>';
    	  $result .='  </tr>';
    	}
    }
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
                  		dojoType="dijit.form.NumberTextBox" constraints="{min:0,max:'.$max.'}"  required="true"
                  		style="width:50px; margin-top:4px; height:20px;">';
    $result .='   </div> ';
    $result .='   <span id="absButton_1" style="width:40px; height:18px !important;" type="button" dojoType="dijit.form.Button" showlabel="true">'.$max
            . '     <script type="dojo/method" event="onClick" >'
            . '        dojo.byId("absenceInput").value = '.$max.';'
            . '     </script>'
            . '   </span>&nbsp;';
    $result .='   <span id="absButton_0_5" style="width:40px; height:18px !important;" type="button" dojoType="dijit.form.Button" showlabel="true">'.$max/2
            . '     <script type="dojo/method" event="onClick" >'
            . '       dojo.byId("absenceInput").value = '.($max/2).';'
            . '     </script>'
            . '    </span>&nbsp;';
    $result .='   <span id="absButton_0" style="width:40px; height:18px;" type="button" dojoType="dijit.form.Button" showlabel="true">0'
            . '     <script type="dojo/method" event="onClick" >'
            . '       dojo.byId("absenceInput").value = 0;'
            . '     </script>'
            . '   </span>';
    $result .='   </td>';
    $result .=' </tr>';
    $result .='</table>';
    $result .='</div>';

    // Activity calendar view
    $res = new Resource($userID);
    $today=date('Y-m-d');
    global $bankHolidays,$bankWorkdays;
    $result .= '<div id="absenceCalendar" align="center">';
    $result .='<table>';
    $result .='<tr><td class="calendarHeader" colspan="32">' .$currentYear. '</td></tr>';
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
    		$style2='';
    		if ($day==$today) {
    			$style.='font-weight: bold; font-size: 9pt;';
    		}
    		if($isOpen){
    		  $style.='background: #FFFFFF; cursor: pointer;';
    		}else{
    		  $style.='background: #DDDDDD;';
    		}
    		$result.= '<td class="calendar" style="'.$style.'">';
    		if($isOpen){
    		  $dateId = date('M', $iDay).mb_substr(date('l',$iDay),0,1,"UTF-8").$d;
    		  $dateDay = date('Ymd',$iDay);
    		  $workDay = date('Y-m-d', $iDay);
    		  $week=date('Y', $iDay).date('W',$iDay) ;
    		  $month = date('Ym', $iDay);
    		  $year = date('Y', $iDay);
    		  $result .='<div id="'.$dateId.'" onClick="selectAbsenceDay(\''.$dateId.'\',\''.$dateDay.'\',\''.$workDay.'\',\''.$month.'\',\''.$year.'\',\''.$week.'\',\''.$userID.'\')">';
    		}else {
    		  $result .='<div>';
    		}
    		$result.=  mb_substr(i18n(date('l',$iDay)),0,1,"UTF-8") . $d ;
    		$result.= '</div>';
    		$result.= '</td>';
    	}
    	$result .= '</tr>';
    }
    $result .='</table>';
    $result .='</div>';
    echo $result;
  }
}
?>