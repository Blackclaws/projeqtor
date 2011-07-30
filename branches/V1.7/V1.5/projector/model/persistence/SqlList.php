<?php
/** ===========================================================================
 * Static class to retrieves data to build a list for reference needs
 * (to be able to build a select html list)  
 */
class SqlList {

  static private $list=array();


  /** ==========================================================================
   * Constructor : private to lock instanciantion (static class)
   */
  private function __construct() {
  }

  /** ==========================================================================
   * Public method to get the list : either retrieve it from a static array
   * or fetch if from database (and store it in the static array)
   * @param $listType the name of the table containing the data
   * *@param $displayCol the name of the value column (defaut is name)
   * @return an array containing the list of references
   */
  public static function getList($listType, $displayCol='name', $selectedValue=null, $showIdle=false) {
    $listName=$listType . "_" . $displayCol;
    if ($showIdle) { $listName .= '_all'; }
    if (array_key_exists($listName, self::$list)) {
      return self::$list[$listName];
    } else {
      return self::fetchList($listType, $displayCol, $selectedValue, $showIdle);
    }
  }

   public static function getListWithCrit($listType, $crit, $displayCol='name', $selectedValue=null) {
     return self::fetchListWithCrit($listType, $crit, $displayCol, $selectedValue);
   }
  /** ==========================================================================
   * Private method to get fetch the list from database and store it in a static array
   * for further needs
   * @param $listType the name of the table containing the data
   * @return an array containing the list of references
   */
  private static function fetchList($listType,$displayCol, $selectedValue, $showIdle=false) {
    $res=array();
    $obj=new $listType();
    $query="select " . $obj->getDatabaseColumnName('id') . " as id, " . $obj->getDatabaseColumnName($displayCol) . " as name from " . $obj->getDatabaseTableName() ;
    if ($showIdle) {
      $query.= " where (1=1 ";
    } else {
      $query.= " where (idle=0 ";
    }
    $crit=$obj->getDatabaseCriteria();
    foreach ($crit as $col => $val) {
      $query .= ' and ' . $obj->getDatabaseTableName() . '.' . $obj->getDatabaseColumnName($col) . "='" . Sql::str($val) . "'";
    }
    $query .=')';
    if ($selectedValue) {
      $query .= " or " . $obj->getDatabaseColumnName('id') . "='" . $selectedValue . "'";
    }
    if (property_exists($obj,'sortOrder')) {
      $query .= ' order by ' . $obj->getDatabaseTableName() . '.sortOrder';
    } else if (property_exists($obj,'order')) {
      $query .= ' order by ' . $obj->getDatabaseTableName() . '.order';
    } else {
      $query .= ' order by ' . $obj->getDatabaseTableName() . '.' . $obj->getDatabaseColumnName($displayCol);
    }
    $result=Sql::query($query);
    if (Sql::$lastQueryNbRows > 0) {
      while ($line = Sql::fetchLine($result)) {
        $name=$line['name'];
        if ($obj->isFieldTranslatable($displayCol)){
          $name=i18n($name);
        }
        $res[($line['id'])]=$name;
      }
    }
    self::$list[$listType . "_" . $displayCol .(($showIdle)?'_all':'')]=$res;
    return $res;
  }
 
  private static function fetchListWithCrit($listType,$criteria, $displayCol, $selectedValue) {
    $res=array();
    $obj=new $listType();
    $query="select " . $obj->getDatabaseColumnName('id') . " as id, " . $obj->getDatabaseColumnName($displayCol) . " as name from " . $obj->getDatabaseTableName() . " where (idle=0 ";
    $crit=array_merge($obj->getDatabaseCriteria(),$criteria);
    foreach ($crit as $col => $val) {
      if (strtolower($listType)=='resource' and $col=='idProject') {
        $aff=new Affectation();
        $usr=new User();
        $query .= " and exists (select 'x' from " . $aff->getDatabaseTableName() . " a where a.idProject='" . $val . "' and a.idResource=" . $usr->getDatabaseTableName() . ".id)";
      } else {
        $query .= ' and ' . $obj->getDatabaseTableName() . '.' . $obj->getDatabaseColumnName($col) . "='" . Sql::str($val) . "'";
      }
    }
    $query .=')';
    if ($listType=='Report') {
      $hr=new HabilitationReport();
      $user=$_SESSION['user'];
      $lstIn="";
      $lst=$hr->getSqlElementsFromCriteria(array('idProfile'=>$user->idProfile, 'allowAccess'=>'1'), false);
      foreach ($lst as $h) {
        $lstIn.=(($lstIn=='')?'':', ') . $h->idReport;
      }
      $query .= ' and id in (' . $lstIn . ')' ;
    } 
    if ($selectedValue) {
      $query .= " or " . $obj->getDatabaseColumnName('id') . "='" . $selectedValue . "'";
    }
    if (property_exists($obj,'sortOrder')) {
      $query .= ' order by ' . $obj->getDatabaseTableName() . '.sortOrder';
    } else if (property_exists($obj,'order')) {
      $query .= ' order by ' . $obj->getDatabaseTableName() . '.order';
    } else{
      $query .= ' order by ' . $obj->getDatabaseTableName() . '.' . $obj->getDatabaseColumnName($displayCol); 
    }
    $result=Sql::query($query);
    if (Sql::$lastQueryNbRows > 0) {
      while ($line = Sql::fetchLine($result)) {
        $name=$line['name'];
        if ($obj->isFieldTranslatable($displayCol)){
          $name=i18n($name);
        }
        $res[($line['id'])]=$name;
      }
    }
    self::$list[$listType . "_" . $displayCol]=$res;
    return $res;
  }
  
  public static function getNameFromId($listType, $id) {
    return self::getFieldFromId($listType, $id, 'name');
  }
  
  public static function getFieldFromId($listType, $id, $field) {
    if ($id==null or $id=='') {
      return '';
    }
    $name=$id;
    $list=self::getList($listType,$field, null, true);
    if (array_key_exists($id,$list)) {
      $name=$list[$id];
      $obj=new $listType();
      if ($obj->isFieldTranslatable('_isNameTranslatable')) {
        $name=i18n(strtolower($listType) . ucfirst($name));
      }
    }
    return $name;
  }
 
  public static function getIdFromName($listType, $name) {
    if ($name==null or $name=='') {
      return '';
    }    
    $list=self::getList($listType);
    $id=array_search($name,$list);
    return $id;
  }
}

?>