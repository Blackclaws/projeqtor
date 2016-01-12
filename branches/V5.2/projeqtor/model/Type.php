<?php 
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

/* ============================================================================
 * RiskType defines the type of a risk.
 */ 
require_once('_securityCheck.php');
class Type extends SqlElement {

  // extends SqlElement, so has $id
  public $_sec_Description;
  public $id;    // redefine $id to specify its visible place 
  public $name;
  public $code;
  public $idWorkflow;
  public $sortOrder=0;
  public $idle;
  public $description;
  public $_sec_Behavior;
  public $mandatoryDescription;
  public $_lib_mandatoryField;
  public $mandatoryResourceOnHandled;
  public $_lib_mandatoryOnHandledStatus;
  public $mandatoryResultOnDone;
  public $_lib_mandatoryOnDoneStatus;
  public $lockHandled;
  public $_lib_statusMustChangeHandled;
  public $lockDone;
  public $_lib_statusMustChangeDone;
  public $lockIdle;
  public $_lib_statusMustChangeIdle;
  public $lockCancelled;
  public $_lib_statusMustChangeCancelled;
  public $showInFlash;
  public $internalData;
  
  public static $_cacheClassList;
  public static $_cacheRestrictedTypesClass;
  public static $_cacheListRestritedTypesForClass;
  
  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="10%"># ${id}</th>
    <th field="name" width="50%">${name}</th>
    <th field="code" width="10%">${code}</th>
    <th field="sortOrder" width="5%">${sortOrderShort}</th>
    <th field="nameWorkflow" width="20%" >${idWorkflow}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';

  private static $_fieldsAttributes=array("name"=>"required", 
                                          "idWorkflow"=>"required",
                                          "mandatoryDescription"=>"nobr",
                                          "mandatoryResourceOnHandled"=>"nobr",
                                          "mandatoryResultOnDone"=>"nobr",
                                          "lockHandled"=>"nobr",
                                          "lockDone"=>"nobr",
                                          "lockIdle"=>"nobr",
                                          "lockCancelled"=>"nobr",
  										                    "internalData"=>"hidden",
                                          "showInFlash"=>"hidden");
  
  private static $_databaseTableName = 'type';
  private static $_databaseCriteria = array();
  
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
  
    /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseTableName() {
    $paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
    return $paramDbPrefix . self::$_databaseTableName;
  }
  
  /** ========================================================================
   * Return the specific database criteria
   * @return the databaseTableName
   */
  protected function getStaticDatabaseCriteria() {
    return self::$_databaseCriteria;
  }
  /** =========================================================================
   * 
   * @return 
   */
  public static function getClassList() {
    global $hideAutoloadError;
    if (self::$_cacheClassList) {
      return self::$_cacheClassList;
    } else if (getSessionValue('typeClassList')) {
      self::$_cacheClassList=getSessionValue('typeClassList');
      return self::$_cacheClassList;
    }
    $hideAutoloadError=true;
    $dir='../model/';
    $handle = opendir($dir);
    $result=array();
    while ( ($file = readdir($handle)) !== false) {
      if ($file == '.' || $file == '..' || $file=='index.php' // exclude ., .. and index.php
      || substr($file,-4)!='.php'                             // exclude non php files
      || substr($file,-8)!='Type.php' || strlen($file)<=8) {  // exclude non *Type.php
        continue;
      }
      $class=pathinfo($file,PATHINFO_FILENAME);
      $ext=pathinfo($file,PATHINFO_EXTENSION);
      $classObj=substr($class,0,strlen($class)-4);
      if (SqlElement::is_subclass_of ( $class, 'Type') and class_exists($classObj)) {
        $result[$class]=i18n($class);
      }
    }
    closedir($handle);
    asort($result);
    setSessionValue('typeClassList',$result);
    self::$_cacheClassList=$result;
    return $result;
  }
  public static function getRestrictedTypes($idProject,$idProjectType) {
    if ($idProject) {
      $crit['idProject']=$idProject;
    } else {
      $crit['idProjectType']=$idProjectType;
    }
    $rtList=SqlList::getListWithCrit('RestrictType', $crit, 'idType');
    return $rtList;
  }
  public static function getRestrictedTypesClass($idProject,$idProjectType) {
    $key="$idProject#$idProjectType";
    if (self::$_cacheRestrictedTypesClass and isset(self::$_cacheRestrictedTypesClass[$key])) {
      return self::$_cacheRestrictedTypesClass[$key];
    } else {
      $sessionValue=getSessionValue('restrictedTypesClass',array());
      if ($sessionValue and isset($sessionValue[$key])) {
        if (!self::$_cacheRestrictedTypesClass) self::$_cacheRestrictedTypesClass=array();
        self::$_cacheRestrictedTypesClass[$key]=$sessionValue[$key];
        return self::$_cacheRestrictedTypesClass[$key];
      }
    }
    if (!$sessionValue) $sessionValue=array();
    if (!self::$_cacheRestrictedTypesClass) self::$_cacheRestrictedTypesClass=array();
    $listClass=SqlList::getList('Type','scope');    
    $result=array();
    $list=self::getRestrictedTypes($idProject,$idProjectType);
    foreach ($list as $id=>$val) {
      if (isset($listClass[$val]) and ! isset($result[$listClass[$val]])) {
        $result[$listClass[$val]]=i18n($listClass[$val]);
      }
    }
    asort($result);
    self::$_cacheRestrictedTypesClass[$key]=$result;
    $sessionValue[$key]=$result;
    setSessionValue('restrictedTypesClass', $sessionValue);
    return $result;
  }
  public static function listRestritedTypesForClass($class,$idProject,$idProjectType) {
    $key="$class#$idProject#$idProjectType";
    if (self::$_cacheListRestritedTypesForClass and isset(self::$_cacheListRestritedTypesForClass[$key])) {
      return self::$_cacheListRestritedTypesForClass[$key];
    } else {
      $sessionValue=getSessionValue('listRestritedTypesForClass',array());
      if ($sessionValue and isset($sessionValue[$key])) {
        if (!self::$_cacheListRestritedTypesForClass) self::$_cacheListRestritedTypesForClass=array();
        self::$_cacheListRestritedTypesForClass[$key]=$sessionValue[$key];
        return self::$_cacheListRestritedTypesForClass[$key];
      }
    }
    if (!$sessionValue) $sessionValue=array();
    if (!self::$_cacheListRestritedTypesForClass) self::$_cacheRestrictedTypesClass=array();
    if (!$idProjectType) {
      $lst=SqlList::getListWithCrit('RestrictType', array('idProject'=>$idProject, 'className'=>$class),'idType');
      if (count($lst)) { // If restrictions exist for the project, get them
        return $lst;
      }
      $proj=new Project($idProject,true);
      $idProjectType=$proj->idProjectType;
    } // else will retreive from project type
    $result=SqlList::getListWithCrit('RestrictType', array('idProjectType'=>$idProjectType, 'className'=>$class),'idType');
    self::$_cacheListRestritedTypesForClass[$key]=$result;
    $sessionValue[$key]=$result;
    setSessionValue('listRestritedTypesForClass', $sessionValue);
    return $result;
  }
  
  public static function getSpecificRestrictTypeValue($idType,$idProject,$idProjectType) {
    $crit=array('idType'=>$idType);
    if ($idProject) {
      $crit['idProject']=$idProject;
    } else {
      $crit['idProjectType']=$idProjectType;
    }
    $rt=SqlElement::getSingleSqlElementFromCriteria('RestrictType', $crit);
    if ($rt->id) return true;
    else return false;
  }
  
  public static function clearRestrictTypeCache() {
    self::$_cacheRestrictedTypesClass=null;
    unsetSessionValue('restrictedTypesClass');
    self::$_cacheListRestritedTypesForClass=null;
    unsetSessionValue('listRestritedTypesForClass');
  }
}
?>