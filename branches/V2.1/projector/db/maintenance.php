<?php
$maintenance=true;
// Version History : starts at 0.3.0 with clean database (before scripts are empty)
$versionHistory = array(
  "V0.3.0",
  "V0.4.0",
  "V0.5.0",
  "V0.6.0",
  "V0.7.0",
  "V0.8.0",
  "V0.9.0",
  "V1.0.0",
  "V1.1.0",
  "V1.2.0",
  "V1.3.0",
  "V1.4.0",
  "V1.5.0",
  "V1.6.0",
  "V1.7.0",
  "V1.8.0",
  "V1.9.0",
  "V2.0.0",
  "V2.0.1");
$versionParameters =array(
  'V1.2.0'=>array('paramMailSmtpServer'=>'localhost',
                 'paramMailSmtpPort'=>'25',
                 'paramMailSendmailPath'=>null,
                 'paramMailTitle'=>'[Project\'Or RIA] ${item} #${id} moved to status ${status}',
                 'paramMailMessage'=>'The status of ${item} #${id} [${name}] has changed to ${status}',
                 'paramMailShowDetail'=>'true' ),
  'V1.3.0'=>array('defaultTheme'=>'blue'),
  'V1.4.0'=>array('paramReportTempDirectory'=>'../files/report/'),
  'V1.5.0'=>array('currency'=>'€', 
                  'currencyPosition'=>'after'),
  'V1.8.0'=>array('paramLdap_allow_login'=>'false',
					'paramLdap_base_dn'=>'dc=mydomain,dc=com',
					'paramLdap_host'=>'localhost',
					'paramLdap_port'=>'389',
					'paramLdap_version'=>'3',
					'paramLdap_search_user'=>'cn=Manager,dc=mydomain,dc=com',
					'paramLdap_search_pass'=>'secret',
					'paramLdap_user_filter'=>'uid=%USERNAME%')
);
$SqlEndOfCommand=";";
$SqlComment="--";
   
require_once (dirname(__FILE__) . '/../tool/projector.php');

$nbErrors=0;
$currVersion=Sql::getDbVersion();
traceLog("");
traceLog("=====================================");
traceLog("");
traceLog("DataBase actual Version = " . $currVersion );
traceLog("ProjectOR actual Version = " . $version );
traceLog("");
if ($currVersion=="") {
  $currVersion='0.0.0';
  // if no current version, parameters are set through config.php
  $versionParameters=array(); // Clear $versionParameter to avoid dupplication of parameters
}
$arrVers=explode('.',substr($currVersion,1));
$currVer=$arrVers[0];
$currMaj=$arrVers[1];
$currRel=$arrVers[2];


foreach ($versionHistory as $vers) {
  $arrVers=explode('.',substr($vers,1));
  $histVer=$arrVers[0];
  $histMaj=$arrVers[1];
  $histRel=$arrVers[2];
  if ( $histVer > $currVer 
  or ( $histVer == $currVer and $histMaj > $currMaj)
  or ( $histVer == $currVer and $histMaj == $currMaj and $histRel > $currRel) ) {
    $nbErrors+=runScript($vers);
  }
}

if ($currVersion=='0.0.0') {
  traceLog ("create default project");
  $type=new ProjectType();
  $lst=$type->getSqlElementsFromCriteria(array('name'=>'Fixed Price'));
  $type=$lst[0];
  $proj=new Project();
  $proj->color='#0000FF';
  $proj->description='Default project' . "\n" .
                     'For example use only.' . "\n" .
                     'Remove or rename this project when initializing your own data.';
  $proj->name='Default project';
  $proj->idProjectType=$type->id;
  $result=$proj->save();
  traceLog($result);
}
deleteDuplicate();

// For V1.6.1
$tst=new ExpenseDetailType('1');
if (! $tst->id) {
	$nbErrors+=runScript('V1.6.1');
}

// For V1.7.0
if (! isset($paramMemoryLimitForPDF) ) {
	writeFile('$paramMemoryLimitForPDF = \'512\';',$parametersLocation);
  writeFile("\n",$parametersLocation);
  traceLog('Parameter $paramMemoryLimitForPDF added');
}

// For V1.9.0
if ($currVersion<"V1.9.0" and $currVersion!='0.0.0') {
	$adminFunctionality='updateReference';
	include('../tool/adminFunctionalities.php');
	echo "<br/>";
}

// For V1.9.1
if ($currVersion<"V1.9.1") {
  // update affectations
  $aff=new Affectation();
  $affList=$aff->getSqlElementsFromCriteria(null, false);
  foreach ($affList as $aff) {
    $aff->save();
  }
}

// To be sure, after habilitations updates ...
Habilitation::correctUpdates();
Habilitation::correctUpdates();
Habilitation::correctUpdates();

Sql::saveDbVersion($version);
traceLog('=====================================');
traceLog("");
echo "____________________________________________";
echo "<br/><br/>";
if ($nbErrors==0) {
  traceLog("DATABASE UPDATE COMPLETED TO VERSION " . Sql::getDbVersion() );
  echo "DATABASE UPDATE COMPLETED TO VERSION " . Sql::getDbVersion();
} else {
  traceLog($nbErrors . " ERRORS DURING UPDATE TO VERSION " . Sql::getDbVersion() );
  echo $nbErrors . " ERRORS DURING UPDATE TO VERSION " . Sql::getDbVersion() . "<br/>";
  echo "DETAILS CAN BE FOUND IN LOG FILE.";
}
traceLog("");
traceLog("=====================================");
traceLog("");
echo "<br/>____________________________________________";


function runScript($vers) {
  global $paramDbName, $paramDbPrefix, $versionParameters, $parametersLocation;
  set_time_limit(300);
  traceLog("=====================================");
  traceLog("");
  traceLog("VERSION " . $vers);
  traceLog("");
  $handle = @fopen("../db/Projector_" . $vers . ".sql", "r");
  $query="";
  $nbError=0;
  if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle);
        $buffer=trim($buffer);
        $buffer=str_replace('${database}', $paramDbName, $buffer);
        $buffer=str_replace('${prefix}', $paramDbPrefix, $buffer);
        if ( substr($buffer,0,2)=='--' ) {
          $buffer=''; // remove comments
        }
        if ($buffer!='') {
          $query.=$buffer . "\n";
        }
        if ( substr($buffer,strlen($buffer)-1,1)==';' ) {
          $result=Sql::query($query);
          if ( ! $result ) {
            traceLog( "<br/>***** SQL ERROR WHILE EXECUTING SQL REQUEST *****");
            traceLog("");
            traceLog(Sql::$lastQueryErrorMessage);
            traceLog("");
            traceLog("*************************************************");
            traceLog("");
            $nbError++;
          } else {
            $action="";
            if (substr($query,0,12)=='CREATE TABLE') {
              $action="CREATE TABLE";
            }
            if (substr($query,0,12)=='RENAME TABLE') {
              $action="RENAME TABLE";
            }
            if (substr($query,0,11)=='INSERT INTO') {
              $action="INSERT INTO";
            }
            if (substr($query,0,6)=='UPDATE') {
              $action="UPDATE";
            }
            if (substr($query,0,11)=='ALTER TABLE') {
              $action="ALTER TABLE";
            }
            if (substr($query,0,10)=='DROP TABLE') {
              $action="DROP TABLE";
            }
            if (substr($query,0,11)=='DELETE FROM') {
              $action="DELETE FROM";
            }
            if (substr($query,0,14)=='TRUNCATE TABLE') {
              $action="TRUNCATE TABLE";
            }
            $deb=strlen($action);
            $end=strpos($query,' ', $deb+1);
            $len=$end-$deb;
            $tableName=substr($query, $deb, $len );
            $tableName=trim($tableName);
            $tableName=trim($tableName,'`');
            switch ($action) {
              case "CREATE TABLE" :
                traceLog(" Table \"" . $tableName . "\" created."); 
                break;
              case "DROP TABLE" :
                traceLog(" Table \"" . $tableName . "\" dropped."); 
                break;
              case "ALTER TABLE" :
                traceLog(" Table \"" . $tableName . "\" altered."); 
                break;
              case "RENAME TABLE" :
                traceLog(" Table \"" . $tableName . "\" renamed."); 
                break;
              case "TRUNCATE TABLE" :
                traceLog(" Table \"" . $tableName . "\" truncated."); 
                break;                
              case "INSERT INTO":
                traceLog(" " . Sql::$lastQueryNbRows . " lines inserted into table \"" . $tableName . "\"."); 
                break;
              case "UPDATE":
                traceLog(" " . Sql::$lastQueryNbRows . " lines updated into table \"" . $tableName . "\"."); 
                break;
              case "DELETE FROM":
                traceLog(" " . Sql::$lastQueryNbRows . " lines deleted from table \"" . $tableName . "\"."); 
                break;              
              default:
                traceLog("ACTION '$action' NOT EXPECTED FOR QUERY : " . $query);
            }
          }
          $query="";
        }
    }
    if (array_key_exists($vers,$versionParameters)) {
      $nbParam=0;
      writeFile('// New parameters ' . $vers . "\n", $parametersLocation);
      foreach($versionParameters[$vers] as $id=>$val) {
        $nbParam++;
        writeFile('$' . $id . ' = \'' . addslashes($val) . '\';',$parametersLocation);
        writeFile("\n",$parametersLocation);
        traceLog('Parameter $' . $id . ' added');
      }
      echo i18n('newParameters', array($nbParam, $vers));
      echo '<br/>' . "\n";
    }
    fclose($handle);
    traceLog("");
    traceLog("DATABASE UPDATED");
    if ($nbError==0) {
      traceLog(" WITH NO ERROR");
    } else {
      traceLog(" WITH " . $nbError . " ERROR" . (($nbError>1)?"S":""));
    }
  }
  traceLog("");
  return $nbError;
}

/*
 * Delete duplicate if new version has been installed twice :
 *  - habilitation
 * 
 */
function deleteDuplicate() {
  // HABILITATION
  $hab=new Habilitation();
  $habList=$hab->getSqlElementsFromCriteria(array(), false, null, 'idMenu, idProfile, id ');
  $idMenu='';
  $idProfile='';
  foreach ($habList as $hab) {
    if ($hab->idMenu==$idMenu and $hab->idProfile==$idProfile) {
      $hab->delete();
    } else {
      $idMenu=$hab->idMenu;
      $idProfile=$hab->idProfile;
    }
  }
  // HABILITATIONREPORT
  $hab=new HabilitationReport();
  $habList=$hab->getSqlElementsFromCriteria(array(), false, null, 'idReport, idProfile, id ');
  $idReport='';
  $idProfile='';
  foreach ($habList as $hab) {
    if ($hab->idReport==$idReport and $hab->idProfile==$idProfile) {
      $hab->delete();
    } else {
      $idReport=$hab->idReport;
      $idProfile=$hab->idProfile;
    }
  }
// HABILITATIONOTHER
  $hab=new HabilitationOther();
  $habList=$hab->getSqlElementsFromCriteria(array(), false, null, 'scope, idProfile, id ');
  $scope='';
  $idProfile='';
  foreach ($habList as $hab) {
    if ($hab->scope==$scope and $hab->idProfile==$idProfile) {
      $hab->delete();
    } else {
      $scope=$hab->scope;
      $idProfile=$hab->idProfile;
    }
  }
  // ACCESSRIGHT
  $acc=new AccessRight();
  $accList=$acc->getSqlElementsFromCriteria(array(), false, null, 'idProfile, idMenu, id ');
  $idMenu='';
  $idProfile='';
  foreach ($accList as $acc) {
    if ($acc->idMenu==$idMenu and $acc->idProfile==$idProfile) {
      $acc->delete();
    } else {
      $idMenu=$acc->idMenu;
      $idProfile=$acc->idProfile;
    }
  }
  
// PARAMETER
  $par=new Parameter();
  $parList=$par->getSqlElementsFromCriteria(array(), false, null, 'idUser, idProject, parameterCode, id');
  $idUser='';
  $idProject='';
  $parameterCode='';
  foreach ($parList as $par) {
    if ($par->idUser==$idUser and $par->idProject==$idProject and $par->parameterCode==$parameterCode) {
      $par->delete();
    } else {
      $idUser=$par->idUser;
      $idProject=$par->idProject;
      $parameterCode=$par->parameterCode;
    }
  }
}
?>