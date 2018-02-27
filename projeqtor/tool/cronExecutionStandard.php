<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2018 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

require_once "../tool/projeqtor.php";

function cronPlanningDifferentrial(){
  debugLog("cronPlanningDifferentrial");
}
function cronPlanningComplete(){
  debugLog("cronPlanningComplete");
}

  
  /*
  $minutes=$_REQUEST['plgBackupMinutes'];
  $hours=$_REQUEST['plgBackupHours'];
  $dayOfMonth=$_REQUEST['plgBackupDayOfMonth'];
    $month=$_REQUEST['plgBackupMonth'];
    $dayOfWeek=$_REQUEST['plgBackupDayOfWeek'];
    
    $cronStr=$minutes.' '.$hours.' '.$dayOfMonth.' '.$month.' '.$dayOfWeek;
    $cronExecution=new CronExecution();
    if(Parameter::getGlobalParameter("plgBackupCron")!=null){
      $cronExecution=new CronExecution(Parameter::getGlobalParameter("plgBackupCron"));
    }else{
      $cronExecution->idle=0;
    }

    $cronExecution->fileExecuted="../tool/plgBackupCron.php";
    $cronExecution->fonctionName="startPlgBackupCron";
    $cronExecution->cron=$cronStr;
    $cronExecution->nextTime=null;
    traceLog($cronExecution->save());
  
    if(Parameter::getGlobalParameter("plgBackupCron")==null){
      Parameter::storeGlobalParameter("plgBackupCron",$cronExecution->id);
    }
  }else{
    
    Parameter::clearGlobalParameters();
    $nbFiles=5;
    if(Parameter::getGlobalParameter("plgBackupNbFiles")!=null){
      $nbFiles=Parameter::getGlobalParameter("plgBackupNbFiles");
    }
    $bk = new BackupMySQL(array(
    	'username' => $paramDbUser,
    	'passwd' => $paramDbPassword,
    	'dbname' => $paramDbName,
    	'dbprefix' => $paramDbPrefix,
    	'port' => $paramDbPort,
    	'dossier' => '../plugin/backupDatabase/backupDatabase/',
    	'anonymize' => false,
      'nbr_fichiers' => $nbFiles
    	));
      traceLog("BackupDatabase has been done by the Cron");*/
  }
}
//if(!isset($inCronBlockFonctionCustom) || $inCronBlockFonctionCustom==null || isset($_REQUEST['forcePlgBackupCronStart'])){
//  startPlgBackupCron();
//
}
?>