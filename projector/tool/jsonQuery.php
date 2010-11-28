<?PHP
/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projector.php"; 
    $objectClass=$_REQUEST['objectClass'];
    $print=false;
    if ( array_key_exists('print',$_REQUEST) ) {
      $print=true;
      include_once('../tool/formatter.php');
    }
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
    if (array_key_exists('listIdFilter',$_REQUEST) ) {
      $param=$_REQUEST['listIdFilter'];
      $param=strtr($param,"*?","%_");
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $table . "." . $obj->getDatabaseColumnName('id') . " like '%" . $param . "%'";
    }
    if (array_key_exists('listNameFilter',$_REQUEST) ) {
      $param=$_REQUEST['listNameFilter'];
      $param=strtr($param,"*?","%_");
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $table . "." . $obj->getDatabaseColumnName('name') . " like '%" . $param . "%'";
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
        $queryWhere.=  $table . ".id in " . transformListIntoInClause($_SESSION['user']->getVisibleProjects()) ;
    } 
    if (property_exists($obj, 'idProject') and array_key_exists('project',$_SESSION)) {
        if ($_SESSION['project']!='*') {
          $queryWhere.= ($queryWhere=='')?'':' and ';
          if ($objectClass=='Project') {
            $queryWhere.=  $table . '.id in ' . getVisibleProjectsList() ;
          } else {
            $queryWhere.= $table . ".idProject in " . getVisibleProjectsList() ;
          }
        }
    }
    if ($accessRightRead=='NO') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  "(1 = 2)";      
    } else if ($accessRightRead=='OWN') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  $table . ".idUser = '" . $_SESSION['user']->id . "'";            
    } else if ($accessRightRead=='PRO') {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.=  $table . ".idProject in " . transformListIntoInClause($_SESSION['user']->getVisibleProjects()) ;      
    } else if ($accessRightRead=='ALL') {
      // No restriction to add
    }
    $crit=$obj->getDatabaseCriteria();
    foreach ($crit as $col => $val) {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $obj->getDatabaseTableName() . '.' . $obj->getDatabaseColumnName($col) . "='" . Sql::str($val) . "'";
    }
    
    $sortIndex=null;
    if ($print) {
      if (array_key_exists('sortIndex', $_REQUEST)) {
        $sortIndex=$_REQUEST['sortIndex']+1;
        $sortWay=(array_key_exists('sortWay', $_REQUEST))?$_REQUEST['sortWay']:'asc';
        $nb=0;
      }
    }
    // Build select clause, and eventualy extended From clause and Where clause
    $numField=0;
    $formatter=array();
    foreach ($array as $val) {
      //$sp=preg_split('field=', $val);
      //$sp=explode('field=', $val);
      $fld=htmlExtractArgument($val, 'field');      
      if ($fld) {
        $numField+=1;
        if ($sortIndex and $sortIndex==$numField) {
          $queryOrderBy .= ($queryOrderBy=='')?'':', ';
          $queryOrderBy .= " " . $fld . " " . $sortWay;
        }
        $formatter[$numField]=htmlExtractArgument($val, 'formatter');
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
          if ( property_exists($externalObj,'wbsSortable') and ! $sortIndex) {
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
    
    // Chek for an advanced filter (stored in User
    
    $arrayFilter=array();
    if (is_array( $_SESSION['user']->_arrayFilters)) {
      if (array_key_exists($objectClass, $_SESSION['user']->_arrayFilters)) {
        $arrayFilter=$_SESSION['user']->_arrayFilters[$objectClass];
      }
      foreach ($arrayFilter as $crit) {
        $queryWhere.=($queryWhere=='')?'':' and ';
        $queryWhere.=$table . "." . $crit['sql']['attribute'] . ' ' 
                   . $crit['sql']['operator'] . ' '
                   . $crit['sql']['value'];
      }
    }
//debugLog( $queryWhere);   
    
    // constitute query and execute
    $queryWhere=($queryWhere=='')?' 1=1':$queryWhere;
    $query='select ' . $querySelect 
         . ' from ' . $queryFrom
         . ' where ' . $queryWhere 
         . ' order by' . $queryOrderBy;
    $result=Sql::query($query);
    $nbRows=0;
    if ($print) {
      //echo "<div style='overflow: auto;'>";
      echo "<table>";
      echo $layout;
      if (Sql::$lastQueryNbRows > 0) {
        while ($line = Sql::fetchLine($result)) {
          echo '<tr>';
          $numField=0;
          foreach ($line as $id => $val) {
            $numField+=1;
            $disp="";
            if ($formatter[$numField]=="colorNameFormatter") {
              $disp=colorNameFormatter($val);
            } else if ($formatter[$numField]=="booleanFormatter") {
              $disp=booleanFormatter($val);
            } else if ($formatter[$numField]=="colorFormatter") {
              $disp=colorFormatter($val);
            } else if ($formatter[$numField]=="dateTimeFormatter") {
              $disp=dateTimeFormatter($val);
            } else if ($formatter[$numField]=="dateFormatter") {
              $disp=dateFormatter($val);
            } else if ($formatter[$numField]=="translateFormatter") {
              $disp=translateFormatter($val);
            } else if ($formatter[$numField]=="percentFormatter") {
              $disp=percentFormatter($val);
            } else if ($formatter[$numField]=="numericFormatter") {
              $disp=numericFormatter($val);
            } else {
              $disp=htmlEncode($val);
            }
            echo '<td class="tdListPrint" >' . $disp . '</td>';
          }
          echo '</tr>';       
        }
      }
      echo "</table>";
      //echo "</div>";
    } else {
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
            $numericLength=($id=='id')?6:0;
            echo '"' . htmlEncode($id) . '":"' . htmlEncodeJson($val, $numericLength) . '"';
          }
          echo '}';       
        }
      }
       echo ']';
      //echo ', "numberOfRow":"' . $nbRows . '"' ;
      echo ' }';
    }
?>
