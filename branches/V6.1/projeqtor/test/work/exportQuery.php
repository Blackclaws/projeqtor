<?PHP
/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projeqtor.php"; 
    $objectClass=$_REQUEST['objectClass'];
    $obj=new $objectClass();
    $table=$obj->getDatabaseTableName();
    
    $accessRightRead=securityGetAccessRight($obj->getMenuClass(), 'read');
    
    $querySelect = '';
    $queryFrom=$table;
    $queryWhere='';
    $queryOrderBy='';
    $idTab=0;

    $res=array();
    $layout=$obj->getLayout();
    $array=explode('</th>',$layout);

    if (! array_key_exists('idle',$_REQUEST) ) {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $table . "." . $obj->getDatabaseColumnName('idle') . "=0";
    }
    if ( array_key_exists('objectType',$_REQUEST) ) {
      if (trim($_REQUEST['objectType'])!='') {
        $queryWhere.= ($queryWhere=='')?'':' and ';
        $queryWhere.= $table . "." . $obj->getDatabaseColumnName('id' . $objectClass . 'Type') . "='" . $_REQUEST['objectType'] . "'";
      }
    }
    if ($objectClass=='Project' and $accessRightRead!='ALL') {
        $accessRightRead='ALL';
        $queryWhere.= ($queryWhere=='')?'':' and ';
        $queryWhere.=  $table . ".id in " . transformListIntoInClause(getSessionUser()->getVisibleProjects()) ;
    } 
    if (property_exists($obj, 'idProject') and array_key_exists('project',$_SESSION)) {
        if ($_SESSION['project']!='*') {
          $queryWhere.= ($queryWhere=='')?'':' and ';
          $queryWhere.=  '(' . $table . ".idProject in " . getVisibleProjectsList() ;
          $queryWhere.= ' or ' . $table . '.id in ' . getVisibleProjectsList() . ')';
        }
    }
    if ($accessRightRead=='NO') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  "(1 = 2)";      
    } else if ($accessRightRead=='OWN') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  $table . ".idUser = '" . getSessionUser()->id . "'";            
    } else if ($accessRightRead=='RES') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  $table . ".idResource = '" . getSessionUser()->id . "'";            
    } else if ($accessRightRead=='PRO') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  $table . ".idProject in " . transformListIntoInClause(getSessionUser()->getVisibleProjects()) ;      
    } else if ($accessRightRead=='ALL') {
      // No restriction to add
    }
    $crit=$obj->getDatabaseCriteria();
    foreach ($crit as $col => $val) {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $obj->getDatabaseTableName() . '.' . $obj->getDatabaseColumnName($col) . "=" . Sql::str($val) . " ";
    }
    
    // Build select clause, and eventualy extended From clause and Where clause
    foreach ($array as $val) {
      //$sp=preg_split('field=', $val);
      $sp=explode('field=', $val);
      $fld=htmlExtractArgument($val, 'field'); 
      if ($fld) {
        $from=htmlExtractArgument($val, 'from');
        $querySelect .= ($querySelect=='')?'':', ';
        if (strlen($fld)>9 and substr($fld,0,9)=="colorName") {
          $idTab+=1;
          // requested field are colorXXX and nameXXX => must fetch the from external table, using idXXX
          $externalClass = substr($fld,9);
          $externalObj=new $externalClass();
          $externalTable = $externalObj->getDatabaseTableName();
          $externalTableAlias = 'T' . $idTab;
          $querySelect .= 'concat(';
          if (property_exists($externalObj,'sortOrder')) {
            $querySelect .= $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('sortOrder');
            $querySelect .=  ",'#split#',";
          }
          $querySelect .= $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('name');
          $querySelect .=  ",'#split#',";
          $querySelect .= $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('color');
          $querySelect .= ') as ' . $fld;
          $queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias .
            ' on ' . $table . "." . $obj->getDatabaseColumnName('id' . $externalClass) . 
            ' = ' . $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('id');
        } else if (strlen($fld)>4 and substr($fld,0,4)=="name") {
          $idTab+=1;
          // requested field is nameXXX => must fetch it from external table, using idXXX
          $externalClass = substr($fld,4);
          $externalObj=new $externalClass();
          $externalTable = $externalObj->getDatabaseTableName();
          $externalTableAlias = 'T' . $idTab;
          $querySelect .= $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('name') . ' as ' . $fld;
          //if (! stripos($queryFrom,$externalTable)) {
            $queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias .
              ' on ' . $table . "." . $obj->getDatabaseColumnName('id' . $externalClass) . 
              ' = ' . $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('id');
          //}   
        } else if (strlen($fld)>5 and substr($fld,0,5)=="color") {
          $idTab+=1;
          // requested field is colorXXX => must fetch it from external table, using idXXX
          $externalClass = substr($fld,5);
          $externalObj=new $externalClass();
          $externalTable = $externalObj->getDatabaseTableName();
          $externalTableAlias = 'T' . $idTab;
          $querySelect .= $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('color') . ' as ' . $fld;
          //if (! stripos($queryFrom,$externalTable)) {
            $queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias . 
              ' on ' . $table . "." . $obj->getDatabaseColumnName('id' . $externalClass) . 
              ' = ' . $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('id');
          //}
        } else if ($from) {
          // Link to external table
          $externalClass = $from;
          $externalObj=new $externalClass();
          $externalTable = $externalObj->getDatabaseTableName();
          $externalTableAlias = $externalClass;
          $querySelect .=  $externalTableAlias . '.' . $externalObj->getDatabaseColumnName($fld) . ' as ' . $fld;
          if (! stripos($queryFrom,$externalTable)) {
            $queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias .
              ' on (' . $externalTableAlias . '.refId=' . $table . ".id" . 
              ' and ' . $externalTableAlias . ".refType='" . $objectClass . "')";
          }
          if ( property_exists($externalObj,'wbsSortable')) {
            $queryOrderBy .= ($queryOrderBy=='')?'':', ';
            $queryOrderBy .= " " . $externalTableAlias . "." . $externalObj->getDatabaseColumnName('wbsSortable') . " ";
          } 
        } else {      
        //var_dump($fld); echo '<br/>';
          // Simple field to add to request 
          $querySelect .= $table . '.' . $obj->getDatabaseColumnName($fld) . ' as ' . strtr($fld,'.','_');
        }
      }
    }
  
    // build order by clause
    if ( property_exists($objectClass,'wbsSortable')) {
      $queryOrderBy .= ($queryOrderBy=='')?'':', ';
      $queryOrderBy .= " " . $table . "." . $obj->getDatabaseColumnName('wbsSortable');
    } else if (property_exists($objectClass,'sortOrder')) {
      $queryOrderBy .= ($queryOrderBy=='')?'':', ';
      $queryOrderBy .= " " . $table . "." . $obj->getDatabaseColumnName('sortOrder');
    } else {
      $queryOrderBy .= ($queryOrderBy=='')?'':', ';
      $queryOrderBy .= " " . $table . "." . $obj->getDatabaseColumnName('id') . " desc";
    }
    
    // constitute query and execute
    $queryWhere=($queryWhere=='')?' 1=1':$queryWhere;
    $query='select ' . $querySelect 
         . ' from ' . $queryFrom
         . ' where ' . $queryWhere 
         . ' order by' . $queryOrderBy;
    $result=Sql::query($query);
    $nbRows=0;
    // return result in json format
    echo '{"identifier":"id",' ;
    echo ' "items":[';
    if (Sql::$lastQueryNbRows > 0) {
      while ($line = Sql::fetchLine($result)) {
        echo (++$nbRows>1)?',':'';
        echo  '{';
        $nbFields=0;
        foreach ($line as $id => $val) {
          echo (++$nbFields>1)?',':'';
          echo '"' . htmlEncode($id) . '":"' . htmlEncodeJson($val) . '"';
          //echo '"' . htmlEncode($id) . '":"' . htmlEncode($val) . '"';
        }
        echo '}';       
      }
    }
    echo ' ] }';
?>
