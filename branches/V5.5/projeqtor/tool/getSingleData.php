<?PHP
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projeqtor.php"; 
    scriptLog('   ->/tool/getSingleData.php');
    $type=$_REQUEST['dataType']; // checked against constant values
    if ($type=='resourceCost') {
      $idRes=$_REQUEST['idResource']; // validated to be numeric value in SqlElement base constructor.
      if (! $idRes) return;
      $idRol=$_REQUEST['idRole'];
      Security::checkValidId($idRol);
      if (! $idRol) return;
      $r=new Resource($idRes);
      // #303
      //echo htmlDisplayNumeric($r->getActualResourceCost($idRol));
      echo $r->getActualResourceCost($idRol);
    } else if ($type=='resourceRole') {
      $idRes=$_REQUEST['idResource']; // validated to be numeric value in SqlElement base constructor.
      if (! $idRes) return;
      $r=new Resource($idRes);
      echo $r->idRole;
    } else if ($type=='resourceProfile') {
      $idRes=$_REQUEST['idResource']; // validated to be numeric value in SqlElement base constructor.
      if (! $idRes) return;
      $r=new Affectable($idRes);
      echo $r->idProfile;
    } else if ($type=='resourceCapacity') {
      $idRes=$_REQUEST['idResource']; // validated to be numeric value in SqlElement base constructor.
      if (! $idRes) return;
      $r=new Resource($idRes);
      echo $r->capacity;
    } else if ($type=='defaultPlanningMode') {
      $idType=$_REQUEST['idType'];
      $className=$_REQUEST['objectClass'];
      Security::checkValidClass($className);
      $typeClass=$className.'Type';
      $type=new $typeClass($idType);
      $planningModeName='id'.$className.'PlanningMode';
      echo $type->$planningModeName;
    } else if ($type=='restrictedTypeClass') {
      $idProjectType=$_REQUEST['idProjectType'];
      $idProject=$_REQUEST['idProject'];
      $idProfile=$_REQUEST['idProfile'];
      $list=Type::getRestrictedTypesClass($idProject,$idProjectType,$idProfile);
      $cpt=0;
      foreach ($list as $cl) {
        $cpt++;
        echo (($cpt>1)?', ':'').$cl;
      }
    } else if ($type=='affectationDescription') {
      $idAffectation=$_REQUEST['idAffectation'];
      $aff=new Affectation($idAffectation);
      echo htmlTransformRichtextToPlaintext($aff->description);
    } else if ($type=='responsible') {
      $responsibleFromProduct=Parameter::getGlobalParameter('responsibleFromProduct');
    	if (!$responsibleFromProduct) $responsibleFromProduct='always';
    	$idC=$_REQUEST['idComponent'];
    	$idP=$_REQUEST['idProduct'];
    	$idR=$_REQUEST['idResource'];
    	if ($responsibleFromProduct=='always' or ($responsibleFromProduct=='ifempty' and !trim($idR))) { 
    	  $comp=new Component($idC,true);
    	  if ($comp->idResource) {
    	    echo $comp->idResource;
    	  } else {
    	    $prod=new Product($idP,true);
    	    if ($prod->idResource) {
    	      echo $prod->idResource;
    	    }
    	  }
    	}
    } else {          
      echo '';
    } 
?>