<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

/* ============================================================================
 * Line defines right to the application for a menu and a profile.
 */  
require_once('_securityCheck.php'); 
class KpiValue extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  //public $name;
  public $idKpiDefinition;
  public $refType;
  public $refId;
  public $kpiType;
  public $kpiDate;
  public $day;
  public $week;
  public $month;
  public $year;
  public $kpiValue;
  public $weight;
  public $refDone;
  public $_noHistory=true; // Will never save history for this object
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
  }

  
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }

// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
 
  public function save() {
    $old=$this->getOld();
    $result=parent::save();
    if ($this->kpiValue!=$old->kpiValue) {
      $this->storeHistory();
    }
    return $result;
  }
  
  public function storeHistory() {
    $h=new KpiHistory();
    $clause="idKpiDefinition=$this->idKpiDefinition and refType='$this->refType' and refId=$this->refId and kpiDate='$this->kpiDate'";
    $h->purge($clause); // Purge existing history for same day, same item, same kpi
    foreach ($this as $fld=>$val) {
      $h->$fld=$val;
    }
    $h->id=null; // Will create new history
    $h->save();
  }
  
  public static function calculateKpi($obj) {
    $class=get_class($obj);
    $kpiListToCalculate=KpiDefinition::getKpiDefinitionList();
    if ($class=='ProjectPlanningElement' or ($class=='PlanningElement' and $obj->refType=='Project') ) {
      if (isset($kpiListToCalculate['duration'])) {
        if ($obj->validatedDuration and $obj->validatedDuration!=0) {
          $kpi=$kpiListToCalculate['duration'];
          $kv=SqlElement::getSingleSqlElementFromCriteria('KpiValue',array('refType'=>$obj->refType,'refId'=>$obj->refId,'idKpiDefinition'=>$kpi->id));
          $kv->idKpiDefinition=$kpi->id;
          $kv->refType=$obj->refType;
          $kv->refId=$obj->refId;
          $kv->kpiType='D';
          $kv->weight=1;
          $kv->refDone=($obj->realDuration)?1:0;
          $kv->setDates();
          if ($obj->realDuration) {
            $kv->kpiValue=$obj->realDuration/$obj->validatedDuration;
          } else {
            $kv->kpiValue=$obj->plannedDuration/$obj->validatedDuration;
          }
          $kv->save();
          self::consolidate($obj->refType,$obj->refId);
        }
      }
      if (isset($kpiListToCalculate['workload'])) {
        if ($obj->validatedWork and $obj->validatedWork!=0) {  
          $kpi=$kpiListToCalculate['workload'];
          $kv=SqlElement::getSingleSqlElementFromCriteria('KpiValue',array('refType'=>$obj->refType,'refId'=>$obj->refId,'idKpiDefinition'=>$kpi->id));
          $kv->idKpiDefinition=$kpi->id;
          $kv->refType=$obj->refType;
          $kv->refId=$obj->refId;
          $kv->kpiType='W';
          $kv->weight=$obj->validatedWork;
          $kv->refDone=($obj->realDuration)?1:0;
          $kv->setDates();
          $kv->kpiValue=$obj->plannedWork/$obj->validatedWork;
          $kv->save();
          self::consolidate($obj->refType,$obj->refId);
        }
      }
    } else if ($class=='Term') {
      if (isset($kpiListToCalculate['term'])) {
        $idP=$obj->idProject;
        $real=0;
        $validated=0;
        $list=$obj->getSqlElementsFromCriteria(array('idProject'=>$idP),false,null,null,false,false);
        foreach ($list as $term) {
          $term->setCalculatedFromActivities();
          $real+=$term->amount;
          $validated+=$term->validatedAmount;
        } 
        if ($validated!=0) {
          $kpi=$kpiListToCalculate['term'];
          $kv=SqlElement::getSingleSqlElementFromCriteria('KpiValue',array('refType'=>'Project','refId'=>$idP,'idKpiDefinition'=>$kpi->id));
          $kv->idKpiDefinition=$kpi->id;
          $kv->refType='Project';
          $kv->refId=$idP;
          $kv->kpiType='T';
          $kv->weight=1;
          $kv->refDone=0;
          $kv->setDates();
          $kv->kpiValue=$real/$validated;
          $kv->save();
        }
      }
    } else if ($class=='Deliverable' or $class=='Incoming') {
      if (isset($kpiListToCalculate[strtolower($class)])) {
        $idP=$obj->idProject;
        $ppe=SqlElement::getSingleSqlElementFromCriteria('ProjectPlanningElement',array('refType'=>'Project', 'refId'=>$idP));
        $classWeight=$class.'Weight';
        $classStatus=$class.'Status';
        $listWeight=SqlList::getList($classWeight,'value');
        $listStatus=SqlList::getList($classStatus,'value');
        $maxStatus=0;
        foreach ($listStatus as $value) { if ($value>$maxStatus) {$maxStatus=$value;} }
        $quality=0;
        $maxQuality=0;
        $list=$obj->getSqlElementsFromCriteria(array('idProject'=>$idP),false,null,null,false,false);
        foreach ($list as $item) {
          $fldS='id'.$class.'Status';
          $fldW='id'.$class.'Weight';
          if ($item->$fldW and $item->$fldS) {
            if (! isset($listWeight[$item->$fldW])) {
              $weight=new $classWeight($item->$fldW);
              $listWeight[$item->$fldW]=$weight->value;
            }
            if (! isset($listStatus[$item->$fldS])) {
              $status=new $classStatus($item->$fldS);
              $listStatus[$item->$fldS]=$status->value;
            }
            $weight=$listWeight[$item->$fldW];
            $status=$listStatus[$item->$fldS];
            $quality+=$weight*$status;
            $maxQuality+=$weight*$maxStatus;
          }
        }
        if ($maxQuality!=0) {
          $kpi=$kpiListToCalculate[strtolower($class)];
          $kv=SqlElement::getSingleSqlElementFromCriteria('KpiValue',array('refType'=>'Project','refId'=>$idP,'idKpiDefinition'=>$kpi->id));
          $kv->idKpiDefinition=$kpi->id;
          $kv->refType='Project';
          $kv->refId=$idP;
          $kv->kpiType=($class=='Deliverable')?'O':'I';
          $kv->weight=1;
          $kv->refDone=($ppe->realDuration)?1:0;
          $kv->setDates();
          $kv->kpiValue=$quality/$maxQuality;
          $kv->save();
          self::consolidate('Project',$idP);
        }
      }
    }
  }
  
  public static function consolidate($refType,$refId) {
    if (! SqlElement::class_exists($refType)) return;
    if (! $refId) return;
    $obj=new $refType($refId);
    if (! property_exists($obj,'idOrganization') or ! $obj->idOrganization) return;
    $consolidatedList=self::consolidateOrganization($obj->idOrganization);
    foreach ($consolidatedList as $id=>$consolidated) {
      $kv=SqlElement::getSingleSqlElementFromCriteria('KpiValue',array('refType'=>'Organization','refId'=>$obj->idOrganization,'idKpiDefinition'=>$id));
      if ($kv->id and $kv->kpiValue==$consolidated['value']) continue;
      $kv->idKpiDefinition=$id;
      $kv->refType='Organization';
      $kv->refId=$obj->idOrganization;
      $kv->kpiType=$consolidated['type'];
      $kv->weight=$consolidated['weight'];
      $kv->refDone=null;
      $kv->setDates();
      $kv->kpiValue=$consolidated['value'];
      $kv->save();
    }
  }
  public static function consolidateOrganization($id) {
    $result=array();
    $crit=array('idOrganization'=>$id);
    $listPrj=SqlList::getListWithCrit('Project', $crit);
    $where="idKpiDefinition in (1,2,4,5) and refDone=1 and refType='Project' and refId in ".transformListIntoInClause($listPrj); // For organization only done projects are consolidated
    $kpi=new KpiValue();
    $kpiList=$kpi->getSqlElementsFromCriteria(null,false,$where);
    foreach($kpiList as $kpi) {
      if (! isset($result[$kpi->idKpiDefinition])) $result[$kpi->idKpiDefinition]=array('type'=>$kpi->kpiType, 'nb'=>0,'total'=>0,'weight'=>0);
      $result[$kpi->idKpiDefinition]['nb']+=1;
      $result[$kpi->idKpiDefinition]['total']+=$kpi->weight*$kpi->kpiValue;
      $result[$kpi->idKpiDefinition]['weight']+=$kpi->weight;
      $result[$kpi->idKpiDefinition]['value']=
        ($result[$kpi->idKpiDefinition]['weight']!=0)
          ?($result[$kpi->idKpiDefinition]['total']/$result[$kpi->idKpiDefinition]['weight'])
          :null;
    }
    return $result;
  }
  
  public function setDates($date=null) {
    if (!$date) $date=date('Y-m-d');
    $gw=new GeneralWork();
    $gw->setDates($date);
    $this->kpiDate=$date;
    $this->day=$gw->day;
    $this->month=$gw->month;
    $this->year=$gw->year;
    $this->week=$gw->week;
  }
}
?>
