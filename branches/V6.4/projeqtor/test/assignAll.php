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

require_once("../tool/projeqtor.php");
$prj=new Project();
$aff=new Affectation();
$act=new Activity();
$idProject=RequestHandler::getValue('idProject');
$crit=array('idle'=>'0');
if ($idProject) {
  $crit['id']=$idProject;
} else {
  echo "Renseigner idProject SVP";
  exit;
}
echo date('H:i:s')." DEBUT<br/>";
$prjList=$prj->getSqlElementsFromCriteria($crit);
foreach ($prjList as $prj) {
  Sql::beginTransaction();
  echo date('H:i:s')." Projet #$prj->id : $prj->name<br/>";
  $critProj=array('idProject'=>$prj->id);
  $affList=$aff->getSqlElementsFromCriteria($critProj);
  $actList=$act->getSqlElementsFromCriteria($critProj);
  foreach ($actList as $act) {
    echo date('H:i:s')." ... Activité #$act->id : $act->name<br/>";
    $cpt=0;
    foreach ($affList as $aff) {
      $ass=new Assignment();
      $critAss=array('idProject'=>$aff->idProject,'refType'=>'Activity','refId'=>$act->id, 'idResource'=>$aff->idResource);
      $cptAss=$ass->countSqlElementsFromCriteria($critAss);
      if ($cptAss>0) continue;
      $ass->idProject=$aff->idProject;
      $ass->refType='Activity';
      $ass->refId=$act->id;
      $ass->rate=100;
      $ass->assignedWork=0;
      $ass->realWork=0;
      $ass->leftWork=0;
      $ass->plannedWork=0;
      $ass->idResource=$aff->idResource;
      $ass->idRole=SqlList::getFieldFromId('Resource', $aff->idResource, 'idRole');  
      $ass->save();
      $cpt++;
    }
    echo date('H:i:s')." ...... $cpt assignation(s) créée(s)<br/>";
  }
  Sql::commitTransaction();
}
echo date('H:i:s')." FIN";

?>