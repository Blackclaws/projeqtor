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
	public $idle;
	public $sendFrequency;
	public $email;
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
	  foreach ($parameter as $name=>$value){
      RequestHandler::setValue($name, $value);
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
    $message = Parameter::getGlobalParameter('paramMailTitleReport');
    $title = str_replace('${dbName}', Parameter::getGlobalParameter('paramDbDisplayName'), $title);
    $title = str_replace('${report}', $report->name, $title);
    $title = str_replace('${date}', date('Y-m-d'), $title);
    $email = explode(',', $this->email);
    foreach ($email as $dest){
      sendMail($dest, $title, $message, null, null, null, array($fileName), null);
    }
	}
	
	public function returnReportParameters($report, $frequency, $includeAllBooleans=false) {
		$result=array();
		$currentWeek=weekNumber(date('Y-m-d'));
		if (strlen($currentWeek)==1) {
			$currentWeek='0' . $currentWeek;
		}
		$currentYear=strftime("%Y") ;
		$currentMonth=strftime("%m") ;
		$param=new ReportParameter();
		$crit=array('idReport'=>$report->id);
		$listParam=$param->getSqlElementsFromCriteria($crit,false,null,'sortOrder');
		foreach ($listParam as $param) {
			if ($param->paramType=='organizationList'){
				if($param->defaultValue=='currentOrganization'){
					$defaultValue= '';
					$userId=getCurrentUserId();
					$user = new Affectable($userId);
					$result[$param->name]=$user->idOrganization;
					$defaultValue= $user->idOrganization;
				}
			} else if ($param->paramType=='week') {
				$result['periodType']='week';
				$result['periodValue']=($param->defaultValue=='currentWeek')?$currentYear . $currentWeek:$param->defaultValue;
				$result['yearSpinner']=substr($result['periodValue'],0,4);
				$result['weekSpinner']=substr($result['periodValue'],4,2);
			} else if ($param->paramType=='month') {
				$result['periodType']='month';
				$result['periodValue']=($param->defaultValue=='currentMonth')?$currentYear . $currentMonth:$param->defaultValue;
				$result['yearSpinner']=substr($result['periodValue'],0,4);
				$result['monthSpinner']=substr($result['periodValue'],4,2);
			} else if ($param->paramType=='year') {
				$result['periodType']='year';
				$result['periodValue']=($param->defaultValue=='currentYear')?$currentYear:$param->defaultValue;
				$result['yearSpinner']=$result['periodValue'];
			} else if ($param->paramType=='date') {
				$result[$param->name]=($param->defaultValue=='today')?date('Y-m-d'):$param->defaultValue;
			} else if ($param->paramType=='periodScale') {
				$result[$param->name]=$param->defaultValue;
			} else if ($param->paramType=='boolean') {
				if ($param->defaultValue=='true') {
					$result[$param->name]=true;
				} else if ($includeAllBooleans) {
					$result[$param->name]=$param->defaultValue;
				}
			} else if ($param->paramType=='projectList') {
				$defaultValue='';
				if ($param->defaultValue=='currentProject') {
					if (sessionValueExists('project')) {
						if (getSessionValue('project')!='*') {
							$defaultValue=getSessionValue('project');
						}
					}
				} else if ($param->defaultValue) {
					$defaultValue=$param->defaultValue;
				}
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='productList') {
				$defaultValue='';
				if ($param->defaultValue) {
					$defaultValue=$param->defaultValue;
				}
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='userList') {
				$defaultValue='';
				if ($param->defaultValue=='currentUser') {
					if (sessionUserExists()) {
						$user=getSessionUser();
						$defaultValue=$user->id;
					}
				} else if ($param->defaultValue) {
					$defaultValue=$param->defaultValue;
				}
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='versionList') {
				$defaultValue=$param->defaultValue;
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='testSessionList') {
				$defaultValue=$param->defaultValue;
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='resourceList') {
				$defaultValue='';
				if ($param->defaultValue=='currentResource') {
					if (sessionValueExists('project')) {
						$user=getSessionUser();
						$defaultValue=$user->id;
					}
				} else if ($param->defaultValue) {
					$defaultValue=$param->defaultValue;
				}
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='requestorList') {
				$defaultValue='';
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='showDetail') {
				$defaultValue='';
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='ticketType') {
				$defaultValue='';
				if ($param->defaultValue) {
					$defaultValue=$param->defaultValue;
				}
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='objectList') {
				$defaultValue='';
				if ($param->defaultValue) {
					$defaultValue=$param->defaultValue;
				}
				$result[$param->name]=$defaultValue;
			} else if ($param->paramType=='id') {
				$defaultValue='';
				if ($param->defaultValue) {
					$defaultValue=$param->defaultValue;
				}
				$result[$param->name]=$defaultValue;
			} else {
				$defaultValue='';
				if ($param->defaultValue) {
					$defaultValue=$param->defaultValue;
				}
				$result[$param->name]=$defaultValue;
			}
		}
		return $result;
	}
}