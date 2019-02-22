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

class ImputationValidation{
	public $id;
	public $idUser;
	public $idProject;

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
	
	static function drawUserWorkList($idUser, $idTeam, $week){
	  $showSubmitted = RequestHandler::getValue('showSubmitWork');
	  $showValidated = RequestHandler::getValue('showValidatedWork');
	  $user=getCurrentUserId();
	  $noData = true;
	  $critDraw = "";
	  $result="";
	  $startWeek = $week;
	  $endWeek = date('Y-m-d');
	  $proj = new Project();
	  $listAdmProj = $proj->getAdminitrativeProjectList(true);
	  $userVisbileResourceList = getUserVisibleResourcesList(true);
	  if(trim($idUser) != ''){
	    unset($userVisbileResourceList);
	    foreach (getUserVisibleResourcesList(true) as $id=>$name){
	      if($id == $idUser){
	        $userVisbileResourceList[$id]=$name;
	      }
	    }
	    if(trim($idTeam) != ''){
	      $res = new Resource($idUser,true);
	      if($res->idTeam != $idTeam){
	        $noResource=true;
	      }
	    }
	  }
	  if(!isset($noResource)){
  	  if($idUser == '' and trim($idTeam) != ''){
  	    unset($userVisbileResourceList);
  	    foreach (getUserVisibleResourcesList(true) as $id=>$name){
  	      $res = new Resource($id, true);
  	      if($res->idTeam == $idTeam){
  	        $userVisbileResourceList[$id]=$name;
  	      }
  	    }
  	  }
  	  
  	  $critWhere = "";
  	  if($showSubmitted != ''){
  	    $critWhere .= " and submitted=".$showSubmitted;
  	  }
  	  if($showValidated != ''){
  	  	$critWhere .= " and validated=".$showValidated;
  	  }
	  }
	  $isChecked = "refreshImputationValidation();";
	  
	  //Header
	  $result .='<div id="imputationValidationDiv" align="center" style="margin-top:20px;margin-bottom:20px; overflow-y:auto; width:100%;">';
	  $result .='<table width="98%" style="margin-left:20px;margin-right:20px;border: 1px solid grey;">';
	  $result .='   <tr class="reportHeader">';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:16%;text-align:center;vertical-align:center;">'.i18n('Resource').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colWeek').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:8%;text-align:center;vertical-align:center;">'.i18n('expectedWork').'</td>';
	  $result .='     <td style="width:20%;border: 1px solid grey;border-right: 1px solid white;">';
	  $result .='      <table width="100%"><tr><td colspan="3" style="height:30px;text-align:center;vertical-align:center;">'.i18n('inputWork').'</td></tr>';
	  $result .='      <tr><td style="border-top: 1px solid white;border-right: 1px solid white;width:33%;height:30px;text-align:center;vertical-align:center;">'.i18n('operationalWork').'</td>';
	  $result .='      <td style="border-top: 1px solid white;border-right: 1px solid white;width:33%;height:30px;text-align:center;vertical-align:center;">'.i18n('administrativeWork').'</td>';
	  $result .='      <td style="border-top: 1px solid white;border-right: 1px solid white;width:33%;height:30px;text-align:center;vertical-align:center;">'.i18n('sum').'</td></tr></table>';
	  $result .='     </td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:23%;text-align:center;vertical-align:center;">'.i18n('ImputationSubmit').'</td>';
	  $result .='     <td colspan="2" style="border: 1px solid grey;height:60px;width:23%;text-align:center;vertical-align:center;">';
    $result .='       <table width="100%"><tr><td>'.i18n('menuImputationValidation').'</td>';
	  $result.='        <td style="float:right;margin-right: 2px;">
	                     <div title="'.i18n('selectionAll').'" dojoType="dijit.form.CheckBox" type="checkbox" 
	                     class="whiteCheck" id="selectAll" name="selectAll" onChange="'.$isChecked.'"></div></td></table></td>';
	  $result .='   </tr>';
	  if(!isset($noResource)){
	  $weekArray = array();
	  while ($startWeek<=$endWeek){
	    $startWeek=addDaysToDate($startWeek, 1);
	    $weekArray[$startWeek]="'".date('YW', strtotime($startWeek))."'";
	  }
	  $weekArray = array_flip($weekArray);
	  $weekList = transformListIntoInClause($weekArray);
	  $idCheckBox = 0;
	  foreach ($userVisbileResourceList as $idResource=>$name){
	  	$periodValue = new WorkPeriod();
	  	$where = "idResource=".$idResource;
	  	if($critWhere){
	  	  $where .= $critWhere." and periodValue in ".$weekList;
	  	}else{
	  	  $where .= " and periodValue in ".$weekList;
	  	}
	  	$periodValueList = $periodValue->getSqlElementsFromCriteria(null,null,$where);
	  	if(!$periodValueList)continue;
	  	$res = new Resource($idResource,true);
	  	$idCalendar = $res->idCalendarDefinition;
	  	$countWeek = 0;
	  	foreach ($periodValueList as $week){
	  	  $noData = false;
  			$firstDay = date('Y-m-d', firstDayofWeek(substr($week->periodValue, 4, 2),substr($week->periodValue, 0, 4)));
  			$lastDay = lastDayofWeek(substr($week->periodValue, 4, 2),substr($week->periodValue, 0, 4));
  			$excepted = round(countDayDiffDates($firstDay, $lastDay, $idCalendar)*($res->capacity),2);
  			$work = new Work();
  			$crit = array('idResource'=>$idResource, 'week'=>$week->periodValue);
  			$critWorkList = $work->getSqlElementsFromCriteria($crit);
  			$inputWork = 0;
  			$inputAdm = 0;
  			if($critWorkList){
  				foreach ($critWorkList as $critWork){
  					if (isset($listAdmProj[$critWork->idProject])) {
  						$inputAdm += $critWork->work;
  					}else{
  						$inputWork += $critWork->work;
  					}
  				}
  			}
  			$inputTotal = $inputWork + $inputAdm;
			  $excepted = Work::displayImputationWithUnit($excepted);
				$inputWork = Work::displayImputationWithUnit($inputWork);
				$inputAdm = Work::displayImputationWithUnit($inputAdm);
  			$inputTotal = Work::displayImputationWithUnit($inputTotal);
  			$backgroundColor = "background-color:#ff7777;";
  			if($inputTotal == $excepted)$backgroundColor = "background-color:#a3d179;";
  			$weekValue = substr($week->periodValue, 0, 4).'-'.substr($week->periodValue, 4, 2);
  			$goto="showWait();saveDataToSession('userName',$idResource,false, function() {
  			       saveDataToSession('yearSpinner',".intval(substr($week->periodValue, 0, 4)).",false, function() {
		           saveDataToSession('weekSpinner',".intval(substr($week->periodValue, 4, 2)).",false, function() {
		           saveDataToSession('dateSelector','$firstDay',false, function() {
	             loadContent('../view/imputationMain.php','centerDiv');}); }); }); });";
  			
  			//List body
				$result .='   <tr>';
  			if($countWeek == 0){
  				$result .='     <td style="border: 1px solid grey;height:30px;width:16%;text-align:left;vertical-align:center;background:white;">';
  				$result .='     <table width="100%">';
  				$result .='       <tr><td width="40%">'.formatUserThumb($idResource, $name, null, 22, 'right').'</td>';
  				$result .='       <td width="60%" float="left">&nbsp'.$name.'</td></tr>';
  				$result .='     </table></td>';
  			}else{
  				$result .='     <td style="border-left: 1px solid grey;border-rgiht: 1px solid grey;height:30px;width:16%;background-color:transparent;"></td>';
  			}
  			$displayWeek=$weekValue.'&nbsp;<span style="font-size:80%;font-style:italic;">('.htmlFormatDate($firstDay).' - '.htmlFormatDate($lastDay).')</span>';
  			$result .='     <td onClick="'.$goto.'" style="cursor:pointer;border: 1px solid grey;height:30px;width:10%;text-align:center;vertical-align:center;">'.$displayWeek.'</td>';
  			$result .='     <td onClick="'.$goto.'" style="cursor:pointer;border: 1px solid grey;height:30px;width:8%;text-align:center;vertical-align:center;">'.$excepted.'</td>';
  			$result .='     <td onClick="'.$goto.'" style="cursor:pointer;width:23%;border: 1px solid grey;">';
  			$result .='      <table width="100%">';
  			$result .='        <tr><td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputWork.'</td>';
  			$result .='        <td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputAdm.'</td>';
  			$result .='        <td style="'.$backgroundColor.'width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputTotal.'</td></tr>';
  			$result .='      </table>';
  			$result .='     </td>';
  			$result .='   <td style="border: 1px solid grey;height:30px;width:23%;text-align:left;vertical-align:center;">';
  			$result .='   <div id="submittedDiv'.$week->id.'" name="submittedDiv'.$week->id.'" width="100%" dojoType="dijit.layout.ContentPane" region="center">';
  			if($week->submitted){
  				$result .='     <table width="100%"><tr><td style="height:30px;">'.formatIcon('Submitted', 32, i18n('submittedWork', array($name, htmlFormatDate($week->submittedDate)))).'</td>';
  				$result .='     <td style="width:73%;padding-left:5px;height:30px;">'.i18n('submittedWork', array($name, htmlFormatDate($week->submittedDate))).'</td>';
  				$result .='     <td style="width:27%;height:30px;padding-right:8px;">';
  				$result .='      <span id="buttonCancel'.$week->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('buttonCancel')
  				        . '       <script type="dojo/method" event="onClick" >'
  				        . '        saveImputationValidation('.$week->id.', "cancelSubmit");'
  								. '       </script>'
									. '     </span>';
  				$result .='     </td></tr></table></div></td>';
  			}else{
  				$result .='     <table width="100%"><tr><td style="height:30px;">'.formatIcon('Unsubmitted', 32, i18n('unsubmittedWork')).'</td>';
  				$result .='     <td style="height:30px;width:90%;">'.i18n('unsubmittedWork').'&nbsp'.htmlFormatDate($week->submittedDate).'</td></tr></table></div></td>';
  			}
  			$result .='   <td style="border: 1px solid grey;height:30px;width:23%;text-align:left;vertical-align:center;">';
  			$result .='   <div id="validatedDiv'.$week->id.'" name="validatedDiv'.$week->id.'" width="100%" dojoType="dijit.layout.ContentPane" region="center">';
  			$result .='     <table width="100%"><tr>';
  			if($week->validated){
  				$locker = SqlList::getNameFromId('Resource', $week->idLocker);
  				$result .='     <td style="height:30px;">'.formatIcon('Submitted', 32, i18n('validatedLineWorkPeriod', array($locker, htmlFormatDate($week->validatedDate)))).'</td>';
  				$result .='     <td style="width:73%;padding-left:5px;height:30px;">'.i18n('validatedLineWorkPeriod', array($locker, htmlFormatDate($week->validatedDate))).'</td>';
  				$result .='     <td style="width:27%;padding-right:8px;height:30px;">';
  				$result .='      <span id="buttonCancelValidation'.$week->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('buttonCancel')
  				        . '       <script type="dojo/method" event="onClick" >'
				          . '        saveImputationValidation('.$week->id.', "cancelValidation");'
  								. '       </script>'
									. '     </span>';
  			}else{
  			  $result .='     <td style="height:30px;">'.formatIcon('Unsubmitted', 32, i18n('unvalidatedWorkPeriod')).'</td>';
  				$result .='     <td style="width:73%;padding-left:5px;height:30px;">'.i18n('unvalidatedWorkPeriod').'</td>';
  				$result .='     <td style="width:27%;padding-right:8px;height:30px;">';
  				$result .='      <span id="buttonValidation'.$week->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('validateWorkPeriod')
  				        . '       <script type="dojo/method" event="onClick" >'
				          . '        saveImputationValidation('.$week->id.', "validateWork");'
  								. '       </script>'
									. '     </span>';
  			}
  			$idCheckBox++;
  			$result .='     </td>';
  			$result .='     <td style="padding-right:5px;"><div name="CheckBoxDiv'.$idCheckBox.'" id="CheckBoxDiv'.$idCheckBox.'">
  			                 <input type="checkbox" name="validCheckBox'.$idCheckBox.'" id="validCheckBox'.$idCheckBox.'"/></div></td>';
  			$result .='     </tr></table></div></td>';
  			$result .='   </tr>';
  			$countWeek++;
	  	}
	  }
	  $isChecked = "imputationValidationSelection(this.checked, ".$idCheckBox.")";
	  }
	  if($noData==true or isset($noResource)){
	    noData :
	  	$result .='<tr><td colspan="6">';
	  	$result .='<div style="background:#FFDDDD;font-size:150%;color:#808080;text-align:center;padding:15px 0px;width:100%;">'.i18n('noDataFound').'</div>';
	  	$result .='</td></tr>';
	  }
    $result .='</table>';
	  $result .='</div>';
	  echo $result;
	}
}