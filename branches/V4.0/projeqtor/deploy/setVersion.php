<?php
require_once "../tool/projeqtor.php"; 
//scriptLog('   ->/deploy/setVersion.php');

$crit = array('parameterCode'=>'dbVersion');
$vers=SqlElement::getSingleSqlElementFromCriteria('Parameter', $crit);

$newVers=$_REQUEST['version'];

$vers->parameterValue=$newVers;
echo date('d/m/Y H:i:s');
echo '<br/>';
echo $vers->save();
