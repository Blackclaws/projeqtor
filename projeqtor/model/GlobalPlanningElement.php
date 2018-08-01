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

/** ============================================================================
 * Action is establised during meeting, to define an action to be followed.
 */ 
require_once('_securityCheck.php');
class GlobalPlanningElement extends SqlElement {

  // List of fields that will be exposed in general user interface
  

  
  public $id;
  public $idProject;
  public $refType;
  public $refId;
  public $refName;
  public $topId;
  public $topRefType;
  public $topRefId;
  public $priority;
  public $elementary;
  public $idle;
  public $done;
  public $cancelled;
  public $idPlanningMode;
  public $idBill;
  public $initialStartDate;
  public $validatedStartDate;
  public $plannedStartDate;
  public $realStartDate;
  public $initialEndDate;
  public $validatedEndDate;
  public $plannedEndDate;
  public $realEndDate;
  public $initialDuration;
  public $validatedDuration;
  public $plannedDuration;
  public $realDuration;
  public $initialWork;
  public $validatedWork;
  public $assignedWork;
  public $plannedWork;
  public $leftWork;
  public $realWork;
  public $validatedCost;
  public $assignedCost;
  public $plannedCost;
  public $leftCost;
  public $realCost;
  public $progress;
  public $expectedProgress;
  public $wbs;
  public $wbsSortable;
  public $isOnCriticalPath;
  public $notPlannedWork;
  public $needReplan;
  public $idType;
  public $idStatus;
  public $idResource;
  // public $validatedStartFraction;
  // public $plannedStartFraction;
  // public $validatedEndFraction;
  // public $plannedEndFraction;
  // public $validatedCalculated;
  // public $validatedExpenseCalculated;
  // public $latestStartDate;
  // public $latestEndDate;
  // public $_workVisibility;
  // public $_costVisibility;
  
  public $_global=true;
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" width="0%" >${id}</th>
    <th field="refType" formatter="classNameFormatter" width="10%" >${refType}</th>
    <th field="refType" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="refName" width="35%" >${name}</th>
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';

  private static $_fieldsAttributes=array(
  );  
  
  private static $_colCaptionTransposition = array(
  );
  
  //private static $_databaseColumnName = array('idResource'=>'idUser');
  private static $_databaseColumnName = array();
    
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
    if ($withoutDependentObjects) return;
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
  
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
  }

  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo framework)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);
    return $colScript;
  }
    
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  public static function getTableNameQuery() {
    global $showIdleProjects;
    $paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
    $obj=new GlobalPlanningElement();
    $na=Parameter::getUserParameter('notApplicableValue');
    if (!$na) $na='null';
    $pe=new PlanningElement();
    $peTable=$pe->getDatabaseTableName();
    $we=new WorkElement();
    $weTable=$we->getDatabaseTableName();
    $itemsToDisplay=Parameter::getUserParameter('globalPlanningSelectedItems');
    $itemsToDisplayArray=explode(',', $itemsToDisplay);
    if (count($itemsToDisplayArray)==0 or (count($itemsToDisplayArray)==1 and $itemsToDisplayArray[0]=='none')) return $pe->getDatabaseTableName();
    $query="\n  ( SELECT id,idProject,refType,refId,refName,topId,topRefType,topRefId,
      priority,elementary,idle,done,cancelled,idPlanningMode,idBill,
      initialStartDate,validatedStartDate,plannedStartDate,realStartDate,
      initialEndDate,validatedEndDate,plannedEndDate,realEndDate,
      initialDuration,validatedDuration,plannedDuration,realDuration,
      initialWork,validatedWork,assignedWork,plannedWork,leftWork,realWork,
      validatedCost,assignedCost,plannedCost,leftCost,realCost,
      progress,expectedProgress,wbs,wbsSortable,isOnCriticalPath,notPlannedWork, needReplan,
      null as idType, null as idStatus, null as idResource 
    FROM $peTable";
    $query.="\n    WHERE ".getAccesRestrictionClause('Activity',$peTable,$showIdleProjects);
        //validatedStartFraction,plannedStartFraction,validatedEndFraction,plannedEndFraction,validatedCalculated,validatedExpenseCalculated,latestStartDate,latestEndDate,
    foreach (self::getGlobalizables() as $class=>$className) {
      if ($itemsToDisplay and $itemsToDisplay!=' ' and !in_array($class,$itemsToDisplayArray)) {
        continue;
      }
      $clsObj=new $class();
      $table=$clsObj->getDatabaseTableName();
      $convert=self::$_globalizables[$class];
      $query.="\n  UNION ";
      $query.="\n    SELECT concat('$class',$table.id) as id";
      foreach ($obj as $fld=>$val) {
        if (substr($fld,0,1)=='_' or $fld=='id') continue;        
        $query.=", ";
        if ($fld=='priority' or $fld=='initialStartDate' or $fld=='initialEndDate' or $fld=='initialDuration' or $fld=='initialWork' or $fld=='validatedCost' or $fld=='progress') $query.="\n      ";
        if ($fld=='refType') $query.="'$class'";
        else if ($fld=='refId') $query.="$table.id";
        else if ($fld=='refName') $query.="$table.name";
        else if ($fld=='topId') $query.="null";
        else if ($fld=='topRefType') $query.="'Project'";
        else if ($fld=='topRefId') $query.="$table.idProject";
        else if ($fld=='elementary') $query.="1";
        else if ($fld=='idProject' or $fld=='idle' or $fld=='done' or $fld=='cancelled' or $fld=='idStatus' or $fld=='idResource') $query.="$table.$fld";
        else if ($fld=='idType') $query.="$table.id".$class."Type";
        else if ($fld=='wbs' or $fld=='wbsSortable') $query.="concat(pe.$fld,'._#',$table.id)";
        else if (isset($convert[$fld])) {
          if ($convert[$fld]=='null') $query.='null';
          else if (strpos($convert[$fld],'.')!==null or strpos($convert[$fld],"'")!==null) $query.=$convert[$fld];
          else $query.="$table.".$convert[$fld];
        }
        else $query.="$na";
        $query.=" as $fld";
      }
      $query.="\n    FROM $table LEFT JOIN $peTable AS pe ON pe.refType='Project' and pe.refId=$table.idProject";
      if (property_exists($clsObj, 'WorkElement')) {
        $query.="\n        LEFT JOIN $weTable AS we ON we.refType='$class' AND we.refId=$table.id ";
      }
      // Add control rights
//       $clause=getAccesRestrictionClause($class,$table, false);
//       if ($class=='Project') {
//          $query.=" WHERE (".$clause." or ".$table.".codeType='TMP' )"; // Templates projects are always visible in projects list
//       } else {
//         $query.=" WHERE ".$clause;
//       }
//       $crit=$clsObj->getDatabaseCriteria();
//       foreach ($crit as $col => $val) {
//         $query.= " and $table.".$clsObj->getDatabaseColumnName($col)."=".Sql::str($val);
//       }
    }
    $query.=')';
    return $query;
  }
  
  public static function getGlobalizables() {
    $result=array();
    foreach (self::$_globalizables as $key=>$val) {
      if (securityCheckDisplayMenu(null,$key)) {
        $result[i18n($key)]=$key;
      }
    }
    ksort($result);
    $result=array_flip($result);
    return $result;
  }
  
  static protected $_globalizables=array(
      /*
      initialStartDate,validatedStartDate,plannedStartDate,realStartDate,
      initialEndDate,validatedEndDate,plannedEndDate,realEndDate,
      initialDuration,validatedDuration,plannedDuration,realDuration,
      validatedWork,assignedWork,plannedWork,leftWork,realWork,
      validatedCost,assignedCost,plannedCost,leftCost,realCost,
      progress,expectedProgress,wbs,wbsSortable,isOnCriticalPath,notPlannedWork, needReplan 
       */
      'Ticket'=>array('plannedStartDate'=>'initialDueDateTime','realStartDate'=>'handledDateTime',
                      'validatedEndDate'=>'initialDueDateTime','plannedEndDate'=>'actualDueDateTime','realEndDate'=>'doneDateTime',
                      'validatedWork'=>"we.plannedWork",'assignedWork'=>"we.plannedWork",'plannedWork'=>"we.plannedWork",'leftWork'=>"we.leftWork",'realWork'=>"we.realWork",
                     ),
      'Action'=>array('plannedStartDate'=>'initialDueDate','realStartDate'=>'handledDate',
                      'validatedEndDate'=>'initialDueDate','plannedEndDate'=>'actualDueDate','realEndDate'=>'doneDate',
                      //'validatedWork'=>"null",'assignedWork'=>"null",'plannedWork'=>"null",'leftWork'=>"null",'realWork'=>"null",
                      //'validatedCost'=>"null",'assignedCost'=>"null",'plannedCost'=>"null",'leftCost'=>"null",'realCost'=>"null"
                     ),
      'Risk'=>array(),
      'Opportunity'=>array(),
      'Issue'=>array(),
      'Decision'=>array(),
      'Question'=>array(),
      'Delivery'=>array()
  );

  public static function drawGlobalizableList() {
    $itemsToDisplay=Parameter::getUserParameter('globalPlanningSelectedItems');
    $itemsToDisplayArray=explode(',', $itemsToDisplay);
    echo '<select dojoType="dojox.form.CheckedMultiSelect"  multiple="true" style="border:1px solid #A0A0A0;width:initial;height:218px;max-height:218px;"';
    echo '  id="globalPlanningSelectItems" name="globalPlanningSelectItems[]" onChange="globalPlanningSelectItems(this.value);" value="'.$itemsToDisplay.'" >';
    echo '  <option value=" ">'.i18n("activityStreamAllItems").'</option>';
    $items=self::getGlobalizables();
    foreach ($items as $class=>$className) {
      echo "  <option value='$class'>$className</option>";
    }
    echo '</select>';
  }
  
}
?>