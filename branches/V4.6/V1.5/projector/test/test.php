<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 
include_once '../tool/projector.php';
$user=$_SESSION['user'];
                    $crit=array('scope'=>'imputation', 'idProfile'=>$user->idProfile);
                    $habilitation=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther', $crit);
                    $scope=new AccessScope($habilitation->rightAccess);
                    $table=array();
                    if ($scope->accessCode=='NO') {
                      $table[$user->id]=' ';
                    } else if ($scope->accessCode=='ALL') {
                      $table=SqlList::getList('Resource');
                    } else if ($scope->accessCode=='OWN' and $user->isResource ) {
                      $table=array($user->id=>SqlList::getNameFromId('Resource', $user->id));
                    } else if ($scope->accessCode=='PRO') {
                      $crit='idProject in ' . transformListIntoInClause($user->getVisibleProjects());
                      $aff=new Affectation();
                      $lstAff=$aff->getSqlElementsFromCriteria(null, false, $crit, null, true);
                      $fullTable=SqlList::getList('Resource');
                      foreach ($lstAff as $id=>$aff) {
                        if (array_key_exists($aff->idResource,$fullTable)) {
                          $table[$aff->idResource]=$fullTable[$aff->idResource];
                        }
                      }
                    }
                    if (count($table)==0) {
                      $table=array($user->id=>' ');
                    }
                    foreach($table as $key => $val) {
                      echo '<OPTION value="' . $key . '"';
                      if ( $key==$user->id ) { echo ' SELECTED '; } 
                      echo '>' . $val . '</OPTION>';
                    }?>  

</pre>

</body>
</html>