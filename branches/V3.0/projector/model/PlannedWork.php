<?php 
/** ============================================================================
 * Project is the main object of the project managmement.
 * Almost all other objects are linked to a given project.
 */ 
class PlannedWork extends GeneralWork {

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
      $colScript .= '    if (dijit.byId("PlanningElement_realEndDate").get("value")==null) {';
      $colScript .= '      dijit.byId("PlanningElement_realEndDate").set("value", new Date); ';
      $colScript .= '    }';
      $colScript .= '  } else {';
      $colScript .= '    dijit.byId("PlanningElement_realEndDate").set("value", null); ';
      //$colScript .= '    dijit.byId("PlanningElement_realDuration").set("value", null); ';
      $colScript .= '  } '; 
      $colScript .= '  formChanged();';
      $colScript .= '</script>';
    }
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /**
   * Run planning calculation for project, starting at start date
   * @static
   * @param string $projectId id of project to plan
   * @param string $startDate start date for planning
   * @return string result
   */
    public static function plan($projectId, $startDate) {
//echo "<br/>******************************";
//echo "<br/>PLANNING - Started at " . date('H:i:s');
//echo "<br/>******************************";
  	set_time_limit(300);
  	ini_set('memory_limit', '512M');

    $withProjectRepartition=true;
    $result="";
    $startTime=time();
    $startMicroTime=microtime(true);
    $globalMaxDate=date('Y')+3 . "-12-31"; // Don't try to plan after Dec-31 of current year + 3
    $globalMinDate=date('Y')-1 . "-01-01"; // Don't try to plan before Jan-01 of current year -1
    
    $arrayPlannedWork=array();
    $arrayAssignment=array();
    $arrayPlanningElement=array();

    $accessRightRead=securityGetAccessRight('menuActivity', 'read');
    //echo $accessRightRead . "|" . $projectId . '|';
    if ($accessRightRead=='ALL' and ! trim($projectId)) {
      $listProj=explode(',',getVisibleProjectsList());
      if (count($listProj)-1 > Parameter::getGlobalParameter('maxProjectsToDisplay')) {
        $result=i18n('selectProjectToPlan');
        $result .= '<input type="hidden" id="lastPlanStatus" value="CONTROL" />';
        return $result;
      }
    }
      // build in list to get a where clause : "idProject in ( ... )"
    $proj=new Project($projectId);
    $inClause="idProject in " . transformListIntoInClause($proj->getRecursiveSubProjectsFlatList(true, true));
    $inClause.=" and " . getAccesResctictionClause('Activity',false);
    // Purge existing planned work
    $plan=new PlannedWork();
    $plan->purge($inClause);
    
    // #697 : moved the administrative project clause after the purge
    // Remove administrative projects :
    $inClause.=" and idProject not in " . Project::getAdminitrativeProjectList() ;
    // Get the list of all PlanningElements to plan (includes Activity and/or Projects)
    $pe=new PlanningElement();
    $clause=$inClause;
    $order="wbsSortable asc";
    $list=$pe->getSqlElementsFromCriteria(null,false,$clause,$order,true);
    $fullListPlan=PlanningElement::initializeFullList($list);
    $listPlan=self::sortPlanningElements($fullListPlan);
    $resources=array();
    $a=new Assignment();
    $topList=array();
    // Treat each PlanningElement
    foreach ($listPlan as $plan) {
      if (! $plan->id) {
        continue;
      }
    	$plan=$fullListPlan['#'.$plan->id];
      // Determine planning profile
      if ($plan->idle) {
      	continue;
      }
      if (isset($plan->_noPlan) and $plan->_noPlan) {
      	continue;
      } 
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
      if ($profile=="REGUL" or $profile=="FULL" 
       or $profile=="HALF" ) { // Regular planning
        $startPlan=$plan->validatedStartDate;
        $endPlan=$plan->validatedEndDate;
        $step=1;
      } else if ($profile=="FDUR") { // Fixed duration
      	if ($plan->validatedStartDate) { 
      	  $startPlan=$plan->validatedStartDate;
      	}
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
        $startPlan=$plan->validatedEndDate;
        $endPlan=$plan->validatedEndDate;
        $plan->plannedStartDate=$plan->validatedEndDate;
        $plan->plannedEndDate=$plan->validatedEndDate;
        $fullListPlan=self::storeListPlan($fullListPlan,$plan);
        //$plan->save();
        $step=1;
      } else {
        $profile=="ASAP"; // Default is ASAP
        $startPlan=$startDate;
        $endPlan=null;
        $step=1;
      }
      $precList=$plan->_predecessorListWithParent;
      foreach ($precList as $precId=>$precVal) { // #77 : $precVal = dependency delay
      	$prec=$fullListPlan[$precId];
        $precEnd=$prec->plannedEndDate;       
        if ($prec->realEndDate) {
        	$precEnd=$prec->realEndDate;
        }
        if (addWorkDaysToDate($precEnd,1+$precVal) > $startPlan) { // #77       
          if ($prec->refType=='Milestone') {
          	if ($plan->refType=='Milestone') {
          	  $startPlan=addWorkDaysToDate($precEnd,1+$precVal); // #77 
          	} else {
              $startPlan=addWorkDaysToDate($precEnd,1+$precVal); // #77 
            }         	
          } else {
          	if ($plan->refType=='Milestone') {
          	  $startPlan=addWorkDaysToDate($precEnd,1+$precVal); // #77 
          	} else {
              $startPlan=addWorkDaysToDate($precEnd,2+$precVal); // #77 
            }           
          }
        }
      }
      if ($plan->refType=='Milestone') {
        if ($profile!="FIXED") {
        	if (count($precList)>0) {
            $plan->plannedStartDate=addWorkDaysToDate($startPlan,2);
        	} else {
        		$plan->plannedStartDate=addWorkDaysToDate($startPlan,1);
        	}
          $plan->plannedEndDate=$plan->plannedStartDate;
          $plan->plannedDuration=0;
          //$plan->save();
          $fullListPlan=self::storeListPlan($fullListPlan,$plan);
        }
        if ($profile=="FIXED") {
        	$plan->plannedEndDate=$plan->validatedEndDate;
        	$plan->plannedDuration=0;
          //$plan->save();
          $fullListPlan=self::storeListPlan($fullListPlan,$plan);
        }
      } else {        
        if (! $plan->realStartDate) {
          $plan->plannedStartDate=($plan->leftWork>0)?$plan->plannedStartDate:$startPlan;
        }
        if (! $plan->realEndDate) {
          $plan->plannedEndDate=($plan->plannedWork==0)?$plan->validatedEndDate:$plan->plannedEndDate;
        }
        if ($profile=="FDUR") {
          if (! $plan->realStartDate) {
            $plan->plannedStartDate=$startPlan;
            $endPlan=addWorkDaysToDate($startPlan,$plan->validatedDuration);
          } else {
            $endPlan=addWorkDaysToDate($plan->realStartDate,$plan->validatedDuration);
          }
          if (! $plan->realEndDate) {
            $plan->plannedEndDate=$endPlan;
          }
          $fullListPlan=self::storeListPlan($fullListPlan,$plan);
          //$plan->save();
        }
        // get list of top project to chek limit on each project
        if ($withProjectRepartition) {
          $proj = new Project($plan->idProject);
          $listTopProjects=$proj->getTopProjectList(true);
        }
        $crit=array("refType"=>$plan->refType, "refId"=>$plan->refId);
        $listAss=$a->getSqlElementsFromCriteria($crit,false);        
        foreach ($listAss as $ass) {
          $changedAss=true;
          $ass->plannedStartDate=null;
          $ass->plannedEndDate=null;
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
          //$projRate=$ress['Project#' . $ass->idProject]['rate'];
          $capacityRate=round($assRate*$capacity,2);
          $left=$ass->leftWork;
          $regul=false;
          if ($profile=="REGUL" or $profile=="FULL" or $profile=="HALF" or $profile="FDUR") {
            $delai=workDayDiffDates($currentDate,$endPlan);
            if ($delai and $delai>0) { 
              $regul=$plan->leftWork/$delai;
              $regulDone=0;
              $interval=0;
            }
          }
          while (1) {            
            if ($left<0.01) {
              break;
            }
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
              if ($planned < $capacity)  {
                $value=$capacity-$planned; 
                 if ($value>$capacityRate) {
                 	 $value=$capacityRate;
                 }
                if ($withProjectRepartition) {
                  foreach ($listTopProjects as $idProject) {
                    $projectKey='Project#' . $idProject;
                    $plannedProj=0;
                    $rateProj=1;
                    if (array_key_exists($week,$ress[$projectKey])) {
                      $plannedProj=$ress[$projectKey][$week];
                    }
                    $rateProj=$ress[$projectKey]['rate'] / 100;
                    if ($rateProj==1) {
                    	$leftProj=round(7*$capacity*$rateProj,2)-$plannedProj; // capacity for a full week
                    	// => to be able to plan weekends
                    } else {
                      $leftProj=round(5*$capacity*$rateProj,2)-$plannedProj; // capacity for a week
                    }
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
                  if ($profile=="HALF" and $interval<$delai) {
                    if ($toPlan<0.5) {
                      $value=0;
                    } else {
                      $value=0.5;
                    }
                  }
                  $regulDone+=$value;
                }
                if ($value>=0.01) {             
                  $plannedWork=new PlannedWork();
                  $plannedWork->idResource=$ass->idResource;
                  $plannedWork->idProject=$ass->idProject;
                  $plannedWork->refType=$ass->refType;
                  $plannedWork->refId=$ass->refId;
                  $plannedWork->idAssignment=$ass->id;
                  $plannedWork->work=$value;
                  $plannedWork->setDates($currentDate);
                  $arrayPlannedWork[]=$plannedWork;
                  // plannedWork is alway Left + Real, not to be updated
                  //$ass->plannedWork+=$value;
                  if (! $ass->plannedStartDate or $ass->plannedStartDate>$currentDate) {
                    $ass->plannedStartDate=$currentDate;
                  }
                  if (! $ass->plannedEndDate or $ass->plannedEndDate<$currentDate) {
                    $ass->plannedEndDate=$currentDate;
                  }
                  if (! $plan->plannedStartDate or $plan->plannedStartDate>$currentDate) {
                    $plan->plannedStartDate=$currentDate;
                  }
                  if (! $plan->plannedEndDate or $plan->plannedEndDate<$currentDate) {
                    $plan->plannedEndDate=$currentDate;
                  }
                  $changedAss=true;
                  $left-=$value;
                  $ress[$currentDate]=$value+$planned;
                  // Set value on each project (from current to top)
                  if ($withProjectRepartition and $value >= 0.01) {
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
            }
            $currentDate=addDaysToDate($currentDate,$step);
            if ($currentDate<$startDate and $step=-1) {
              $currentDate=$startPlan;
              $step=1;
            }
          }
          if ($changedAss) {
            $ass->_noHistory=true;    
            $arrayAssignment[]=$ass;
          }
          $resources[$ass->idResource]=$ress;
        } 
      }
      $fullListPlan=self::storeListPlan($fullListPlan,$plan);
    }
    $cpt=0;
    $query='';
    foreach ($arrayPlannedWork as $pw) {
      if ($cpt==0) {
        $query='INSERT into ' . $pw->getDatabaseTableName() 
          . ' (`idResource`,`idProject`,`refType`,`refId`,`idAssignment`,`work`,`workDate`,`day`,`week`,`month`,`year`)'
          . ' VALUES ';
      } else {
        $query.=', ';
      }
      $query.='(' 
        . "'" . $pw->idResource . "',"
        . "'" . $pw->idProject . "',"
        . "'" . $pw->refType . "',"
        . "'" . $pw->refId . "',"
        . "'" . $pw->idAssignment . "',"
        . "'" . $pw->work . "',"
        . "'" . $pw->workDate . "',"
        . "'" . $pw->day . "',"
        . "'" . $pw->week . "',"
        . "'" . $pw->month . "',"
        . "'" . $pw->year . "')";
      $cpt++; 
      if ($cpt>=100) {
        $query.=';';
        SqlDirectElement::execute($query);
        $cpt=0;
        $query='';
      }
    }
    if ($query!='') {
      $query.=';';
      SqlDirectElement::execute($query);
    }
    // save Assignment
    foreach ($arrayAssignment as $ass) {
      $ass->simpleSave();
      /*$query='UPDATE ' . $ass->getDatabaseTableName() 
       . ' SET plannedEndDate=\'' . $ass->plannedEndDate . '\''
       . ', plannedStartDate=\'' .  $ass->plannedStartDate . '\''
       . ' WHERE id=' . $ass->id . ';';
       SqlDirectElement::execute($query);*/
    }
    
    foreach ($fullListPlan as $pe) {
   	  $pe->simpleSave();
   	  /*$query='UPDATE ' . $pe->getDatabaseTableName() 
       . ' SET plannedEndDate=\'' . $pe->plannedEndDate . '\''
       . ', plannedStartDate=\'' .  $pe->plannedStartDate . '\''
      . ' WHERE id=' . $pe->id . ';';
      SqlDirectElement::execute($query);*/  
    }
    
    
    $endTime=time();
    $endMicroTime=microtime(true);
    
    $duration = round(($endMicroTime - $startMicroTime)*1000)/1000;
    $result=i18n('planDone', array($duration));
    $result .= '<input type="hidden" id="lastPlanStatus" value="OK" />';

    return $result;
  }
  
  private static function storeListPlan($listPlan,$plan) {
//traceLog("storeListPlan(listPlan,$plan->id)");
    $listPlan['#'.$plan->id]=$plan;
    if (($plan->plannedStartDate or $plan->realStartDate) and ($plan->plannedEndDate or $plan->realEndDate) ) {
      foreach ($plan->_parentList as $topId=>$topVal) {
        $top=$listPlan[$topId];
        $startDate=($plan->realStartDate)?$plan->realStartDate:$plan->plannedStartDate;
        if (!$top->plannedStartDate or $top->plannedStartDate>$startDate) {
          $top->plannedStartDate=$startDate;
        }
        $endDate=($plan->realEndDate)?$plan->realEndDate:$plan->plannedEndDate;
        if (!$top->plannedEndDate or $top->plannedEndDate<$endDate) {
          $top->plannedEndDate=$endDate;
        }
        $listPlan[$topId]=$top;
      }
    }
    return $listPlan;
  }
  
  /*private static function sortPlanningElements($planList) {
    $result=array();
    foreach ($planList as $key=>$plan) {
      if ( ! array_key_exists ($key,$result)) {
        $predList=$plan->getPredecessorItemsArrayIncludingParents();
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
  }*/
  
  private static function sortPlanningElements($list) {
  	// first sort on simple criterias
    foreach ($list as $id=>$elt) {
      $crit=($elt->idPlanningMode=='2' or  $elt->idPlanningMode=='3' or  $elt->idPlanningMode=='7')?'0':'1';
      $crit.=str_pad($elt->priority,5,'0',STR_PAD_LEFT).$elt->wbsSortable;
      $elt->_sortCriteria=$crit;
      $list[$id]=$elt;
    }
    //self::traceArray($list);
    $bool = uasort($list,array(new PlanningElement(), "comparePlanningElementSimple"));
    //self::traceArray($list);
    // then sort on predecessors
    $result=self::specificSort($list);
    //self::traceArray($result);
    return $result;
  }
  
  private static function specificSort($list) {
  	// Sort to teake dependencies into account
  	$wait=array(); // array to store elements that has predecessors not sorted yet
  	$result=array(); // target array for sorted elements
  	foreach($list as $id=>$pe) {
  		$canInsert=false;
  		if ($pe->_predecessorListWithParent) {
  			$pe->_tmpPrec=array();
  			// retrieve prédecessors not sorted yet
  			foreach($pe->_predecessorListWithParent as $precId=>$precPe) {
  				if (! array_key_exists($precId, $result)) {
  					 $pe->_tmpPrec[$precId]=$precPe;
  				}
  			} 			
  			if (count($pe->_tmpPrec)>0) {
  				// if has some not written predecessor => wait (until no more predecessor)
  				$wait[$id]=$pe;
  				$canInsert=false;
  			} else {
  				// all predecessors are sorted yet => can insert it in sort list
  				$canInsert=true;
  			}
  		} else {
  			// no predecessor, so can insert
  			$canInsert=true;
  		}
  		if ($canInsert) {
  			$result[$id]=$pe;
  			// now, must check if can insert waiting ones
  			self::insertWaiting($result,$wait,$id);
  		}
  	}
  	// in the end, empty wait stack (should be empty !!!!)
  	foreach($wait as $wId=>$wPe) {
  		unset($wPe->_tmpPrec); // no used elsewhere
      $result[$wId]=$wPe;
  	}
  	return $result;
  }
  
  private static function insertWaiting(&$result,&$wait,$id) {
//traceLog("insertWaiting($id)");
    foreach($wait as $wId=>$wPe) {
      if (isset($wPe->_tmpPrec) and array_key_exists($id, $wPe->_tmpPrec)) {
        // ok, prec has been inserted, not waiting for it anymore
        unset($wPe->_tmpPrec[$id]);
        if (count($wPe->_tmpPrec)==0) {
          // Waiting for no more prec => store it
          unset($wPe->_tmpPrec);
          $result[$wId]=$wPe;
          // and remove it from wait list
          unset ($wait[$wId]);
          // and check if this new insertion can release others
          self::insertWaiting($result,$wait,$wId); 
        } else {
          // Store wait stack with new prec list (with less items...)
          $wait[$wId]=$wPe;
        }
      }
    }
  }
  private static function traceArray($list) {
  	// debugLog to keep
  	debugLog('*****traceArray()*****');
  	foreach($list as $id=>$pe) {
  		// debugLog to keep
  		debugLog($id . ' - ' . $pe->wbs . ' - ' . $pe->refType . '#' . $pe->refId . ' - ' . $pe->refName . ' - Prio=' . $pe->priority . ' - '.$pe->_sortCriteria);
  		if (count($pe->_predecessorListWithParent)>0) {
  			foreach($pe->_predecessorListWithParent as $idPrec=>$prec) {
  				// debugLog to keep
  			  debugLog('   ' . $idPrec.'=>'.$prec);
  			}
  		}
  	}
  }
  
}
?>
