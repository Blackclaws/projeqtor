<?php
require_once "../tool/projector.php";

 $crit=array();
 $user=$_SESSION['user'];
 $crit['idUser']=$user->id;
 $crit['idProject']=null;
 $crit['parameterCode']=$_REQUEST['parameter'];
 $obj=SqlElement::getSingleSqlElementFromCriteria('Parameter', $crit);
 $obj->parameterValue=$_REQUEST['value'];;
 $result=$obj->save();
echo "OK";
 ?>