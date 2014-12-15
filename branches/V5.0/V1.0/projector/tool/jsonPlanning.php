<?PHP
/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projector.php";
    
    $objectClass='PlanningElement';
    $obj=new $objectClass();
    $table=$obj->getDatabaseTableName();
    
    $accessRightRead=securityGetAccessRight('menuProject', 'read');
    
    $querySelect = '';
    $queryFrom='';
    $queryWhere='';
    $queryOrderBy='';
    $idTab=0;

    if (! array_key_exists('idle',$_REQUEST) ) {
      $queryWhere= $table . ".idle=0 ";
    }
    if (property_exists($obj, 'idProject') and array_key_exists('project',$_SESSION)) {
        if ($_SESSION['project']!='*') {
          $queryWhere.= ($queryWhere=='')?'':' and ';
          $queryWhere.=  $table . ".idProject in " . getVisibleProjectsList() ;
        }
    }
    
    if ($accessRightRead=='NO') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  "(1 = 2)";      
    } else if ($accessRightRead=='OWN') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      //$queryWhere.=  $table . ".idUser = '" . $_SESSION['user']->id . "'";     
      $queryWhere.=  "(1 = 2)"; // If visibility = own => no visibility            
    } else if ($accessRightRead=='PRO') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  $table . ".idProject in " . transformListIntoInClause($_SESSION['user']->getVisibleProjects()) ;      
    } else if ($accessRightRead=='ALL') {
      // No restriction to add
    }

    $querySelect .= $table . ".* ";
    $queryFrom .= $table;
    // Link to resource
    //$querySelect .= ", user.fullName as nameResource ";
    //$queryFrom .= " left join user on ( task.idResource=user.id )";    
    
    $queryOrderBy .= $table . ".wbsSortable ";

    // constitute query and execute
    $queryWhere=($queryWhere=='')?' 1=1':$queryWhere;
    $query='select ' . $querySelect 
         . ' from ' . $queryFrom
         . ' where ' . $queryWhere 
         . ' order by ' . $queryOrderBy;

    $result=Sql::query($query);
    $nbRows=0;
    // return result in json format
    $d=new Dependency();
    echo '{"identifier":"id",' ;
    echo ' "items":[';
    if (Sql::$lastQueryNbRows > 0) {
      while ($line = Sql::fetchLine($result)) {
        echo (++$nbRows>1)?',':'';
        echo  '{';
        $nbFields=0;
        $idPe="";
        foreach ($line as $id => $val) {
          if ($val==null) {$val=" ";}
          if ($val=="") {$val=" ";}
          echo (++$nbFields>1)?',':'';
          echo '"' . htmlEncode($id) . '":"' . htmlEncodeJson($val) . '"';
          if ($id=='id') {$idPe=$val;}
        }
        $crit=array('successorId'=>$idPe);
        $listPred="";
        $depList=$d->getSqlElementsFromCriteria($crit,false);
        foreach ($depList as $dep) {
          $listPred.=($listPred!="")?'; ':'';
          $listPred.=$dep->predecessorId;
        }
        echo ', "depend":"' . $listPred . '"';
        echo '}';       
      }
    }
    echo ' ] }'; 
?>
