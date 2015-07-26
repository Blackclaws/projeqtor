<?php 
/** ============================================================================
 * Project is the main object of the project managmement.
 * Almost all other objects are linked to a given project.
 */ 
class PlannedWork extends Work {

  public $_noHistory;
  
  // List of fields that will be exposed in general user interface
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%" ># ${id}</th>
    <th field="nameResource" width="35%" >${resourceName}</th>
    <th field="nameProject" width="35%" >${projectName}</th>
    <th field="rate" width="15%" formatter="percentFormatter">${rate}</th>  
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
  }

   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }

// ============================================================================**********
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }


// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);

    if ($colName=="idle") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.checked) { ';
      $colScript .= '    if (dijit.byId("PlanningElement_realEndDate").value==null) {';
      $colScript .= '      dijit.byId("PlanningElement_realEndDate").attr("value", new Date); ';
      $colScript .= '    }';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("PlanningElement_realEndDate").attr("value", null); ';
      //$colScript .= '    dijit.byId("PlanningElement_realDuration").attr("value", null); ';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  public static function plan($projectId, $startDate) {
//echo "<br/>******************************";
//echo "<br/>PLANNING - Started at " . date('H:i:s');
//echo "<br/>******************************";
    $withProjectRepartition=true;
    $result="";
    $startTime=time();
    $startMicroTime=microtime(true);
    $globalMaxDate=date('Y')+3 . "-12-31"; // Don't try to plan after Dec-31 of current year + 3
    $globalMinDate=date('Y')-1 . "-01-01"; // Don't try to plan before Jan-01 of current year -1
    
    // build in list to get a where clause : "idProject in ( ... )" 
    $proj=new Project($projectId);
    $inClause="idProject in " . transformListIntoInClause($proj->getRecursiveSubProjectsFlatList(true, true));
    
    // Purge existing planned work
    $plan=new PlannedWork();
    $plan->purge($inClause);
    
    // Get the list of all PlanningElements to plan (includes Activity and/or Projects)
    $pe=new PlanningElement();
    $clause=$inClause . " and idle=0";
    $order=" priority asc";
    $list=$pe->getSqlElementsFromCriteria(null,false,$clause,$order,true);
    $listPlan=self::sortPlanningElements($list);
    $resources=array();
    $a=new Assignment();
    // Treat each PlanningElement
    foreach ($listPlan as $plan) {
      $changedPlan=false;
      // Determine planning profile
      $profile="ASAP";
      $startPlan=$startDate;
      $endPlan=null;
      $step=1;
      if (! $plan->idPlanningMode) {
        $profile="ASAP";
      } else {
        $pm=new PlanningMode($plan->idPlanningMode);
        $profile=$pm->code;  
      }
      if ($profile=="REGUL") { // Regular planning between dates
        $startPlan=$plan->validatedStartDate;
        $endPlan=$plan->validatedEndDate;
        $step=1;
      } else if ($profile=="FULL") { // Regular planning trying to affect full days of work
        $startPlan=$plan->validatedStartDate;
        $endPlan=$plan->validatedEndDate;
        $step=1;
      } else if ($profile=="ASAP") { // As soon as possible
        $startPlan=$plan->validatedStartDate;
        $endPlan=null;
        $step=1;
      } else if ($profile=="ALAP") { // As late as possible (before end date)
          $startPlan=$plan->validatedEndDate;
          $endPlan=$startDate;
          $step=-1;
      } else if ($profile=="FLOAT") { // Floating milestone
        $startPlan=$startDate;
        $endPlan=null;
        $step=1;
      } else if ($profile=="FIXED") { // Fixed milestone
        $startPlan=$startDate;
        $endPlan=null;
        $step=1;
      } else {
        $profile=="ASAP"; // Default is ASAP
        $startPlan=$startDate;
        $endPlan=null;
        $step=1;
      }
      // If dependencies exist,
      $dep=new Dependency(); 
      $precList=$dep->getSqlElementsFromCriteria(array("successorId"=>$plan->id),false);
      foreach ($precList as $precDep) {
        $prec=new PlanningElement($precDep->predecessorId);
        if ($prec->plannedEndDate > $startPlan) {
          $startPlan=$prec->plannedEndDate;
        }
      }
      if ($plan->leftWork>0) {
        // get list of top project to chek limit on each project
        if ($withProjectRepartition) {
          $proj = new Project($plan->idProject);
          $listTopProjects=$proj->getTopProjectList(true);
        }
        $minDate=$globalMaxDate;
        $maxDate=addDaysToDate($startDate,-1);
        $crit=array("refType"=>$plan->refType, "refId"=>$plan->refId);
        $listAss=$a->getSqlElementsFromCriteria($crit,false);        
        foreach ($listAss as $ass) {
          $changedAss=false;
          $r=new Resource($ass->idResource);
          $capacity=($r->capacity)?$r->capacity:1;
          if (array_key_exists($ass->idResource,$resources)) {
            $ress=$resources[$ass->idResource];
          } else {
            $ress=$r->getWork($startDate, $withProjectRepartition);        
          }
          if ($startPlan>$startDate) {
            $currentDate=$startPlan;
          } else {
            $currentDate=$startDate;
            if ($step==-1) {
              $step=1;
            }
          }
          $assRate=1;
          if ($ass->rate) {
            $assRate=$ass->rate / 100;
          }
          // Get data to limit to affectation on each project           
          if ($withProjectRepartition) {
            foreach ($listTopProjects as $idProject) {
              $projKey='Project#' . $idProject;
              if (! array_key_exists($projKey,$ress)) {
                $ress[$projKey]=array();
              }
              if (! array_key_exists('rate',$ress[$projKey])) {
                $ress[$projKey]['rate']=$r->getAffectationRate($idProject);
              }
            }
          }
          $capacityRate=round($assRate*$capacity,2);
          $left=$ass->leftWork;
          $regul=false;
          if ($profile=="REGUL" or $profile=="FULL") {
            $delai=workDayDiffDates($currentDate,$endPlan);
            if ($delai and $delai>0) { 
              $regul=$plan->leftWork/$delai;
              $regulDone=0;
              $interval=0;
            }
          }
          while (1) {            
            // Set limits to avoid eternal loop
            if ($currentDate==$globalMaxDate) { break; }         
            if ($currentDate==$globalMinDate) { break; }
            if ($ress['Project#' . $plan->idProject]['rate']==0) { break ; }
            
            if (isOpenDay($currentDate)) {
              $planned=0;
              $week=weekFormat($currentDate);
              if (array_key_exists($currentDate, $ress)) {
                $planned=$ress[$currentDate];
              }
              if ($regul) {
                  $interval+=$step;
              }
              if ($planned < $capacityRate)  {
                $value=$capacityRate-$planned;
                if ($withProjectRepartition) {
                  foreach ($listTopProjects as $idProject) {
                    $projectKey='Project#' . $idProject;
                    $plannedProj=0;
                    $rateProj=1;
                    if (array_key_exists($week,$ress[$projectKey])) {
                      $plannedProj=$ress[$projectKey][$week];
                    }
                    $rateProj=$ress[$projectKey]['rate'] / 100;
                    $leftProj=round(5*$capacity*$rateProj,2)-$plannedProj; // capacity for a week
                    if ($value>$leftProj) {
                      $value=$leftProj;
                    }
                  }
                }
                $value=($value>$left)?$left:$value;
                if ($regul) {
                  $regulTarget=round( ($interval*$regul) ,1);
                  $toPlan=$regulTarget-$regulDone;
                  if ($value>$toPlan) {
                    $value=$toPlan;
                  }
                  if ($profile=="FULL" and $toPlan<1 and $interval<$delai) {
                    $value=0;
                  }
                  $regulDone+=$value;
                }
                $plannedWork=new PlannedWork();
                $plannedWork->idResource=$ass->idResource;
                $plannedWork->idProject=$ass->idProject;
                $plannedWork->refType=$ass->refType;
                $plannedWork->refId=$ass->refId;
                $plannedWork->idAssignment=$ass->id;
                $plannedWork->work=$value;
                $plannedWork->setDates($currentDate);
                $plannedWork->save();
                $ass->plannedWork+=$value;
                $changedAss=true;
                $left-=$value;
                $minDate=($currentDate<$minDate)?$currentDate:$minDate;
                $maxDate=($currentDate>$maxDate)?$currentDate:$maxDate;
                $ress[$currentDate]=$value+$planned;
                // Set value on each project (from current to top)
                if ($withProjectRepartition and $value > 0) {
                  foreach ($listTopProjects as $idProject) {
                    $projectKey='Project#' . $idProject;
                    $plannedProj=0;
                    if (array_key_exists($week,$ress[$projectKey])) {
                      $plannedProj=$ress[$projectKey][$week];
                    }
                    $ress[$projectKey][$week]=$value+$plannedProj;               
                  }
                }
              }            
            }
            if ($left<0.01) {
              break;
            }
            $currentDate=addDaysToDate($currentDate,$step);
            if ($currentDate<$startDate and $step=-1) {
              $currentDate=$startPlan;
              $step=1;
            }
          }
          if ($changedAss) {
            $ass->save();
          }
          $resources[$ass->idResource]=$ress;
        }
        if ($minDate!=$globalMaxDate and ! $plan->realStartDate) {
          $changedPlan=true;
          $plan->plannedStartDate=$minDate;
        }
        if ($maxDate>=$startDate) {
          $changedPlan=true;
          $plan->plannedEndDate=$maxDate;
        }
      } else {
        if ( ! $plan->realStartDate) {
          $changedPlan=true;
          $plan->plannedStartDate=$startPlan;
        }  
        if ( ! $plan->realEndDate) {
          $changedPlan=true;
          $plan->plannedEndDate=$startPlan;
        }  
      }
      if ($changedPlan) {
        $plan->save();
      }
    }
    $endTime=time();
    $endMicroTime=microtime(true);
//echo "<br/>";
//echo "<br/>****************************";
//echo "<br/>PLANNING - Ended at " . date('H:i:s');
//echo "<br/>****************************";
    $duration = round(($endMicroTime - $startMicroTime)*1000)/1000;
    $result=i18n('planDone', array($duration));
    $result .= '<input type="hidden" id="lastPlanStatus" value="OK" />';

    return $result;
  }
  
  private static function sortPlanningElements($planList) {
    $result=array();
    foreach ($planList as $key=>$plan) {
      if ( ! array_key_exists ($key,$result)) {
        $predList=$plan->getPredecessorItemsArray();
        if (count($predList)==0) {
          $result[$key]=$plan;
        } else {
          $tempList=array();
          foreach ($planList as $tmpKey=>$tmpPlan) {
            if (array_key_exists($tmpKey,$predList)) {
              $tempList[$tmpKey]=$tmpPlan;
            }
          }
          $result=array_merge($result,self::sortPlanningElements($tempList));
          $result[$key]=$plan;
        }
      }
    }
    return $result;
  }
}
?>