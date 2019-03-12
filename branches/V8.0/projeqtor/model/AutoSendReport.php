<?php
use Spipu\Html2Pdf\Html2Pdf;
use PHPMailer\PHPMailer\PHPMailer;
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

class AutoSendReport extends SqlElement{
  
	public $id;
	public $name;
	public $idReport;
	public $idResource;
	public $idReceiver;
	public $idle;
	public $sendFrequency;
	public $otherReceiver;
	public $cron;
	public $nextTime;
	public $reportParameter;
	
	private static $_databaseTableName = 'cronautosendreport';
	
	/** ==========================================================================
	 * Constructor
	 * @param $id the id of the object in the database (null if not stored yet)
	 * @return void
	*/
	function __construct($id=NULL, $withoutDependentObjects=false) {
	  parent::__construct($id,$withoutDependentObjects);
	}
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }
	
	protected function getStaticDatabaseTableName() {
		$paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
		return $paramDbPrefix . self::$_databaseTableName;
	}
	
	function save(){
	  return parent::save();
	}
	
	public function calculNextTime($cron=null){
		$UTC=new DateTimeZone(Parameter::getGlobalParameter ( 'paramDefaultTimezone' ));
		$date=new DateTime('now');
		$date->modify('+1 minute');
		if(!$cron){
		  $splitCron=explode(" ",$this->cron);
		}else{
		  $splitCron=explode(" ",$cron);
		}
		$count=0;
		if(count($splitCron)==5){
			$find=false;
			while(!$find){ //cron minute/hour/dayOfMonth/month/dayOfWeek
				if(($splitCron[0]=='*' || $date->format("i")==$splitCron[0])
				&& ($splitCron[1]=='*' || $date->format("H")==$splitCron[1])
				&& ($splitCron[2]=='*' || $date->format("d")==$splitCron[2])
				&& ($splitCron[3]=='*' || $date->format("m")==$splitCron[3])
				&& ($splitCron[4]=='*' || $date->format("N")==$splitCron[4])){
					$find=true;
					$date->setTime($date->format("H"), $date->format("i"), 0);
					$this->nextTime=$date->format("U");
					$this->save(false);
				}else{
					$date->modify('+1 minute');
				}
				$count++;
				if($count>=2150000){
					$this->idle=1;
					$this->save(false);
					$find=true;
					errorLog("Can't find next time for cronAutoSendReport because too many execution #".$this->id);
				}
			}
		}else{
			errorLog("Can't find next time for cronAutoSendReport because too many execution #".$this->id);
		}
	}
	
	public function sendReport($idReport, $reportParameter){
	  global $graphEnabled;
	  debugLog('report send at : '.date('H:i'));
	  ob_start();
	  $report = new Report($idReport);
	  $parameter = json_decode($reportParameter);
	  foreach ($parameter as $paramName=>$paramValue){
	  	if($paramName != 'yearSpinner' and $paramName != 'monthSpinner' and $paramName != 'weekSpinner' and $paramName != 'startDate' and $paramName != 'periodValue'){
	  	  RequestHandler::setValue($paramName, $paramValue);
	  	}
	  }
  	foreach ($parameter as $paramName=>$paramValue){
  	  if($paramName == 'yearSpinner'){
  	    if($paramValue == 'current'){
  	      RequestHandler::setValue($paramName, date('Y'));
  	    }else if($paramValue == 'previous'){
  	      RequestHandler::setValue($paramName, date('Y')-1);
  	    }
  	  }
  	  if($paramName == 'monthSpinner'){
  	  if($paramValue == 'current'){
  	      RequestHandler::setValue($paramName, date('m'));
  	    }else if($paramValue == 'previous'){
  	      RequestHandler::setValue($paramName, date('m')-1);
  	    }
  	  }
  	  if($paramName == 'weekSpinner'){
  	  if($paramValue == 'current'){
  	      RequestHandler::setValue($paramName, date('W'));
  	    }else if($paramValue == 'previous'){
  	      RequestHandler::setValue($paramName, date('W')-1);
  	    }
  	  }
  	  if($paramName == 'startDate'){
  	    if($paramValue == 'currentDate'){
  	      RequestHandler::setValue($paramName, date('Y-m-d'));
  	    }else{
  	      RequestHandler::setValue($paramName, $paramValue);
  	    }
  	  }
  	  if($paramName == 'periodValue'){
  	    $value = explode('-', $paramValue);
  	    $year = '';
	      if($value[0] == "currentYear"){
	        $year = date('Y');
	        RequestHandler::setValue($paramName, $year);
        }else if($value[0] == 'previousYear'){
	        	$year = date('Y')-1;
	        	RequestHandler::setValue($paramName, $year);
	      }
	      if(count($value) > 1){
  	      if($value[1] == 'currentMonth'){
  	      	$month = date('m');
  	      	RequestHandler::setValue($paramName, $year.$month);
  	      }else if($value[1] == 'previousMonth'){
  	      	$month = date('m')-1;
  	      	if($month < 10){
  	      		$month = '0'.$month;
  	      	}
  	      	RequestHandler::setValue($paramName, $year.$month);
  	      }
  	      if($value[1] == 'currentWeek'){
  	      	$week = date('W');
  	      	RequestHandler::setValue($paramName, $year.$week);
  	      }else if($value[1] == 'previousWeek'){
  	      	$week = date('W')-1;
  	      	if($week < 10){
  	      		$week = '0'.$week;
  	      	}
  	      	RequestHandler::setValue($paramName, $year.$week);
  	      }
  	    }
  	  }
  	}
	  $reportFile=explode('?', $report->file);
	  if (count($reportFile) > 1) {
	    $reportFileParam = explode('&', $reportFile[1]);
	    foreach ($reportFileParam as $value){
	    	$param = explode('=', $value);
	    	RequestHandler::setValue($param[0], $param[1]);
	    }
	  }
	  header ('Content-Type: text/html; charset=UTF-8');
	  echo '<html>
            	  <head>
            	    <link rel="stylesheet" type="text/css" href="../view/css/jsgantt.css" />
            	    <link rel="stylesheet" type="text/css" href="../view/css/projeqtorPrint.css" />
            	    <link rel="stylesheet" type="text/css" href="../view/css/projeqtorFlat.css" />
	              </head><body>';
    include '../report/'.$reportFile[0];
    echo '</body></html>';
    $result = ob_get_clean();
    ob_clean();
    
    require_once '../external/html2pdf/vendor/autoload.php';
    $pdf = new Html2Pdf();
    $pdf->writeHTML($result);
    $path = Parameter::getGlobalParameter('paramReportTempDirectory');
    $fileName=__DIR__.'/'.$path.$this->name.'.pdf';
    $pdf->output($fileName, 'F');
    $title = Parameter::getGlobalParameter('paramMailTitleReport');
    $title = str_replace('${dbName}', Parameter::getGlobalParameter('paramDbDisplayName'), $title);
    $title = str_replace('${report}', $report->name, $title);
    $title = str_replace('${date}', date('Y-m-d'), $title);
    $message = Parameter::getGlobalParameter('paramMailBodyReport');
    $message = str_replace('${dbName}', Parameter::getGlobalParameter('paramDbDisplayName'), $message);
    $message = str_replace('${report}', $report->name, $message);
    $message = str_replace('${date}', date('Y-m-d'), $message);
    $resource = new Resource($this->idReceiver, true);
    sendMail($resource->email, $title, $message, null, null, null, array($fileName), null);
    $email = explode(',', $this->otherReceiver);
    foreach ($email as $dest){
      if($dest != $resource->email and $dest != ''){
        sendMail($dest, $title, $message, null, null, null, array($fileName), null);
      }
    }
	}
	
	public static function drawAutoSendReportList($idUser){
	  $autoSendReport = new AutoSendReport();
	  $user = getSessionUser();
	  $profile = new Profile($user->idProfile, true);
	  $crit = array("idResource"=>getCurrentUserId());
	  if($profile->profileCode == 'ADM'){
	    if($idUser != ''){
	    	$crit = array("idResource"=>$idUser);
	    }else{
	    	$crit = null;
	    }
	  }
	  $listAutoSendReport = $autoSendReport->getSqlElementsFromCriteria($crit);
	  
	  $result = "";
	  $result .='<div id="autoSendReportDiv" align="center" style="margin-top:20px;margin-bottom:20px; overflow-y:auto; width:100%;">';
	  $result .='  <table width="98%" style="margin-left:20px;margin-right:20px;border: 1px solid grey;">';
	  $result .='   <tr class="reportHeader">';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('Resource').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:12%;text-align:center;vertical-align:center;">'.i18n('colSendName').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colReportName').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:15%;text-align:center;vertical-align:center;">'.i18n('colReceivers').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colFrequency').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:10%;text-align:center;vertical-align:center;">'.i18n('colNextTime').'</td>';
	  $result .='     <td style="border: 1px solid grey;border-right: 1px solid white;height:60px;width:17%;text-align:center;vertical-align:center;">'.i18n('colParam').'</td>';
	  $result .='     <td style="border: 1px solid grey;height:60px;width:20%;text-align:center;vertical-align:center;"></td>';
	  $result .='   </tr>';
	  $countLine = 0;
	  foreach ($listAutoSendReport as $send){
	    $resource = new Resource($send->idResource, true);
	    $receiver = new Resource($send->idReceiver, true);
	    $report = new Report($send->idReport, true);
	  	$result .='<tr>';
	  	if($countLine == 0){
  				$result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:left;vertical-align:center;background:white;">';
  				$result .=' <table width="100%">';
  				$result .='   <tr><td width="40%">'.formatUserThumb($resource->id, $resource->name, null, 22, 'right').'</td>';
  				$result .='       <td width="60%" float="left">&nbsp'.$resource->name.'</td></tr>';
  				$result .=' </table></td>';
			}else{
  				$result .='     <td style="border-left: 1px solid grey;border-right: 1px solid grey;height:40px;width:10%;background-color:transparent;"></td>';
			}
			$result .='<td style="border: 1px solid grey;height:40px;width:12%;text-align:center;vertical-align:center;background:white;">'.$send->name.'</td>';
			$result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:center;vertical-align:center;background:white;">'.$report->name.'</td>';
			$result .='<td style="border: 1px solid grey;height:40px;width:15%;text-align:center;vertical-align:center;background:white;">'.$receiver->name;
			if($send->otherReceiver != ''){
			  $result .= ','.$otherReceiver;
			}
			$result .='</td>';
			$result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:center;vertical-align:center;background:white;">'.$send->sendFrequency.'</td>';
			$result .='<td style="border: 1px solid grey;height:40px;width:10%;text-align:center;vertical-align:center;background:white;">'.htmlFormatDate(date('Y-m-d', $send->nextTime)).'</td>';
			$result .='<td style="border: 1px solid grey;height:40px;width:17%;text-align:center;vertical-align:center;background:white;">';
			$param = json_decode($send->reportParameter);
			foreach ($param as $name=>$value){
			  if($value != ''){
			    if($name == 'yearSpinner'){
			      $result .= 'year : '.$value.'&nbsp';
			    }
			    if($name == 'monthSpinner'){
			    	$result .= 'month : '.$value.'&nbsp';
			    }
			    if($name == 'weekSpinner'){
			    	$result .= 'week : '.$value.'&nbsp';
			    }
			  }
			}
			$result .='</td>';
			$result .='</tr>';
	  	$countLine++;
	  }
	  $result .='  </table>';
	  $result .='</div>';
	  echo $result;
	}
	public static function htmlReturnOptionForMinutesHoursCron($selection, $isHours=false, $isDayOfMonth=false, $required=false) {
		$arrayWeekDay=array();
		$max=59;
		$start=0;
		$modulo=5;
		if($isHours){
			$max=23;
			$start=0;
			$modulo=1;
		}
		if($isDayOfMonth){
			$max=31;
			$start=1;
			$modulo=1;
		}
		for($i=$start;$i<=$max;$i++){
			$key=$i;
			//if($key<10)$key='0'.$key;
			if ( $i % $modulo==0) $arrayWeekDay[$key]=$key;
		}
		$result="";
		if (! $required) {
			$result.='<option value="*" '.(($selection=='*')?'selected':'').'>'.i18n('all').'</option>';
		}
		foreach($arrayWeekDay as $key=>$line) {
			$result.= '<option value="' . $key . '"';
			if ($selection!==null and $key==$selection ) { $result.= ' SELECTED '; }
			$result.= '>'.$line.'</option>';
		}
		return $result;
	}
}