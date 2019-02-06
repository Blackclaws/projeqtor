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
	
	static function drawUserWorkList($idUser, $idTeam){
	  $user=getCurrentUserId();
	  $resource = new User($idUser);
	  $team = new Team($idTeam);
	  $noData = true;
	  $result="";
	  $imputationUnitType = Parameter::getGlobalParameter('imputationUnit');
	  $imputationUnit = substr(i18n(Parameter::getGlobalParameter('imputationUnit')),0, 1);
	  if($imputationUnitType == "hours"){
	    $dayTime = Parameter::getGlobalParameter('dayTime');
	  }
	  $userVisbileResourceList = getUserVisibleResourcesList(true);
	  $proj = new Project();
	  $listAdmProj = $proj->getAdminitrativeProjectList(true);
	  $result .='<div id="activityDiv" align="center" style="margin-top:20px; overflow-y:auto; width:100%;">';
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
	  $result .='     <td style="border: 1px solid grey;height:60px;width:23%;text-align:center;vertical-align:center;">'.i18n('menuImputationValidation').'</td>';
	  $result .='   </tr>';
	  foreach ($userVisbileResourceList as $id=>$name){
	  	$periodValue = new WorkPeriod();
	  	$periodValueList = $periodValue->getSqlElementsFromCriteria(array("idResource"=>$id));
	  	if(!$periodValueList)continue;
	  	$res = new Resource($id,true);
	  	$idCalendar = $res->idCalendarDefinition;
	  	$countWeek = 0;
	  	foreach ($periodValueList as $week){
	  	  $noData = False;
  			$firstDay = date('Y-m-d', firstDayofWeek(substr($week->periodValue, 4, 2),substr($week->periodValue, 0, 4)));
  			$lastDay = lastDayofWeek(substr($week->periodValue, 4, 2),substr($week->periodValue, 0, 4));
  			$excepted = countDayDiffDates($firstDay, $lastDay, $idCalendar);
  			if($imputationUnitType == "hours"){
  				$excepted *= $dayTime;
  			}
  			$work = new Work();
  			$crit = array('idResource'=>$id, 'week'=>$week->periodValue);
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
  			if($imputationUnitType == "hours"){
  				$inputWork *= $dayTime;
  				$inputAdm *= $dayTime;
  			}
  			$inputTotal = $inputWork + $inputAdm;
  			$backgroundColor = "background-color:#ff7777;";
  			if($inputTotal == $excepted)$backgroundColor = "background-color:#a3d179;";
  			$weekValue = substr($week->periodValue, 0, 4).'-'.substr($week->periodValue, 4, 2);
				$result .='   <tr>';
  			if($countWeek == 0){
  				$result .='     <td style="border: 1px solid grey;height:30px;width:16%;text-align:left;vertical-align:center;">';
  				$result .='     <table width="100%">';
  				$result .='       <tr><td width="40%">'.formatUserThumb($id, $name, null, 22, 'right').'</td>';
  				$result .='       <td width="60%" float="left">&nbsp'.$name.'</td></tr>';
  				$result .='     </table></td>';
  			}else{
  				$result .='     <td style="border-left: 1px solid grey;border-rgiht: 1px solid grey;height:30px;width:16%;background-color:#DDDDDD;"></td>';
  			}
  			$result .='     <td style="border: 1px solid grey;height:30px;width:10%;text-align:center;vertical-align:center;">'.$weekValue.'</td>';
  			$result .='     <td style="border: 1px solid grey;height:30px;width:8%;text-align:center;vertical-align:center;">'.$excepted.$imputationUnit.'</td>';
  			$result .='     <td style="width:23%;border: 1px solid grey;">';
  			$result .='      <table width="100%">';
  			$result .='        <tr><td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputWork.$imputationUnit.'</td>';
  			$result .='        <td style="border-right: 1px solid grey;width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputAdm.$imputationUnit.'</td>';
  			$result .='        <td style="'.$backgroundColor.'width:33%;height:30px;text-align:center;vertical-align:center;">'.$inputTotal.$imputationUnit.'</td></tr>';
  			$result .='      </table>';
  			$result .='     </td>';
  			$result .='   <td style="border: 1px solid grey;height:30px;width:23%;text-align:left;vertical-align:center;">';
  			$result .='   <div id="sumittedDiv'.$week->id.'" name="sumittedDiv'.$week->id.'" width="100%">';
  			if($week->submitted){
  				$result .='     <table width="100%"><tr><td style="height:30px;">'.formatIcon('Submitted', 32, i18n('submittedWork', array($name, $week->submittedDate))).'</td>';
  				$result .='     <td style="width:73%;height:30px;">'.i18n('submittedWork', array($name, $week->submittedDate)).'</td>';
  				$result .='     <td style="width:27%;height:30px;">';
  				$result .='      <span id="buttonCancel'.$week->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('buttonCancel')
  				        . '       <script type="dojo/method" event="onClick" >'
  				        . '        saveImputationValidation('.$week->id.', "cancelSubmit");'
  								. '       </script>'
									. '     </span>';
  				$result .='     </td></tr></table></div></td>';
  			}else{
  				$result .='     <table width="100%"><tr><td style="height:30px;">'.formatIcon('Unsubmitted', 32, i18n('unsubmittedWork')).'</td>';
  				$result .='     <td style="height:30px;width:90%;">'.i18n('unsubmittedWork').'&nbsp'.$week->submittedDate.'</td></tr></table></div></td>';
  			}
  			$result .='   <td style="border: 1px solid grey;height:30px;width:23%;text-align:center;vertical-align:center;">';
  			$result .='   <div id="validationDiv'.$week->id.'" name="validationDiv'.$week->id.'" width="100%">';
  			$result .='     <table width="100%"><tr>';
  			if($week->validated){
  				$locker = SqlList::getNameFromId('Resource', $week->idLocker);
  				$result .='     <td style="width:69%;height:30px;">'.i18n('validatedLineWorkPeriod', array($locker, $week->validatedDate)).'</td>';
  				$result .='     <td style="width:31%;height:30px;">';
  				$result .='      <span id="buttonCancelValidation'.$week->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('buttonCancel')
  				        . '       <script type="dojo/method" event="onClick" >'
				          . '        saveImputationValidation('.$week->id.', "cancelValidation");'
  								. '       </script>'
									. '     </span>';
  			}else{
  				$result .='     <td style="width:69%;height:30px;">'.i18n('unvalidatedWorkPeriod').'</td>';
  				$result .='     <td style="width:31%;height:30px;">';
  				$result .='      <span id="buttonValidation'.$week->id.'" style="width:100px; " type="button" dojoType="dijit.form.Button" showlabel="true">'.i18n('validateWorkPeriod')
  				        . '       <script type="dojo/method" event="onClick" >'
				          . '        saveImputationValidation('.$week->id.', "validateWork");'
  								. '       </script>'
									. '     </span>';
  			}
  			$result .='     </td></tr></table></div></td>';
  			$result .='   </tr>';
  			$countWeek++;
	  	}
	  }
	  if($noData==true){
	  	$result .='<tr><td colspan="6">';
	  	$result .='<div style="background:#FFDDDD;font-size:150%;color:#808080;text-align:center;padding:15px 0px;width:100%;">'.i18n('noDataFound').'</div>';
	  	$result .='</td></tr>';
	  }
    $result .='</table>';
	  $result .='</div>';
	  echo $result;
	}
}