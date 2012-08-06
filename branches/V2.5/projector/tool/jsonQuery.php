<?PHP
/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projector.php";
    scriptLog('   ->/tool/jsonQuery.php'); 
    $objectClass=$_REQUEST['objectClass'];
    $print=false;
    if ( array_key_exists('print',$_REQUEST) ) {
      $print=true;
      include_once('../tool/formatter.php');
    }
    $comboDetail=false;
    if ( array_key_exists('comboDetail',$_REQUEST) ) {
      $comboDetail=true;
    }
    $quickSearch=false;
    if ( array_key_exists('quickSearch',$_REQUEST) ) {
      $quickSearch=$_REQUEST['quickSearch'];
    }
    if (! isset($outMode)) { $outMode=""; } 
       
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

    if ($quickSearch) {
    	$queryWhere.= ($queryWhere=='')?'':' and ';
    	$queryWhere.="( 1=2 ";
    	$note=new Note();
    	$noteTable=$note->getDatabaseTableName();
    	foreach($obj as $fld=>$val) {
    		if ($obj->getDataType($fld)=='varchar') {    				
            $queryWhere.= ' or ' . $table . "." . $fld . " like '%" . $quickSearch . "%'";
    		}
    	}
    	if (is_numeric($quickSearch)) {
    		$queryWhere.= ' or ' . $table . ".id='" . $quickSearch . "'";
    	}
    	$queryWhere.=" or exists ( select 'x' from $noteTable " 
    	                           . " where $noteTable.refType='$objectClass' "
    	                           . " and $noteTable.refId=$table.id " 
    	                           . " and $noteTable.note like '%" . $quickSearch . "%' ) ";
    	$queryWhere.=" )";
    }
    $showIdle=false;
    if (! array_key_exists('idle',$_REQUEST) and ! $quickSearch) {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $table . "." . $obj->getDatabaseColumnName('idle') . "=0";
    } else {
      $showIdle=true;
    }
    if (array_key_exists('listIdFilter',$_REQUEST)  and ! $quickSearch) {
      $param=$_REQUEST['listIdFilter'];
      $param=strtr($param,"*?","%_");
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $table . "." . $obj->getDatabaseColumnName('id') . " like '%" . $param . "%'";
    }
    if (array_key_exists('listNameFilter',$_REQUEST)  and ! $quickSearch) {
      $param=$_REQUEST['listNameFilter'];
      $param=strtr($param,"*?","%_");
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $table . "." . $obj->getDatabaseColumnName('name') . " like '%" . $param . "%'";
    }
    if ( array_key_exists('objectType',$_REQUEST)  and ! $quickSearch) {
      if (trim($_REQUEST['objectType'])!='') {
        $queryWhere.= ($queryWhere=='')?'':' and ';
        $queryWhere.= $table . "." . $obj->getDatabaseColumnName('id' . $objectClass . 'Type') . "='" . $_REQUEST['objectType'] . "'";
      }
    }
    if ($objectClass=='Project' and $accessRightRead!='ALL') {
        $accessRightRead='ALL';
        $queryWhere.= ($queryWhere=='')?'':' and ';
        $queryWhere.=  '(' . $table . ".id in " . transformListIntoInClause($_SESSION['user']->getVisibleProjects()) ;
        if ($objectClass=='Project') {
          $queryWhere.= " or codeType='TMP' ";
        }
        $queryWhere.= ')';
    } 
    if (property_exists($obj, 'idProject') and array_key_exists('project',$_SESSION)) {
        if ($_SESSION['project']!='*') {
          $queryWhere.= ($queryWhere=='')?'':' and ';
          if ($objectClass=='Project') {
            $queryWhere.=  $table . '.id in ' . getVisibleProjectsList(! $showIdle) ;
          } else if ($objectClass=='Document') {
          	$queryWhere.= "(" . $table . ".idProject in " . getVisibleProjectsList() . " or " . $table . ".idProject is null)";
          } else {
            $queryWhere.= $table . ".idProject in " . getVisibleProjectsList() ;
          }
        }
    }

    $queryWhere.= ($queryWhere=='')?'(':' and (';
    $queryWhere.= getAccesResctictionClause($objectClass,$table);
    if ($objectClass=='Project') {
    	$queryWhere.= " or codeType='TMP' ";
    }
    $queryWhere.= ')';
    
    $crit=$obj->getDatabaseCriteria();
    foreach ($crit as $col => $val) {
      $queryWhere.= ($queryWhere=='')?'':' and ';
      $queryWhere.= $obj->getDatabaseTableName() . '.' . $obj->getDatabaseColumnName($col) . "='" . Sql::str($val) . "'";
    }

    if ($objectClass=='Document') {
    	if (array_key_exists('Directory',$_SESSION) and ! $quickSearch) {
    		$queryWhere.= ($queryWhere=='')?'':' and ';
        $queryWhere.= $obj->getDatabaseTableName() . '.' . $obj->getDatabaseColumnName('idDocumentDirectory') . "='" . $_SESSION['Directory'] . "'";
    	}
    }
    
    $arrayFilter=array();
    if (! $quickSearch) {
      if (! $comboDetail and is_array( $_SESSION['user']->_arrayFilters)) {
        if (array_key_exists($objectClass, $_SESSION['user']->_arrayFilters)) {
        	$arrayFilter=$_SESSION['user']->_arrayFilters[$objectClass];
        }
      } else if ($comboDetail and is_array( $_SESSION['user']->_arrayFiltersDetail)) {
        if (array_key_exists($objectClass, $_SESSION['user']->_arrayFiltersDetail)) {
          $arrayFilter=$_SESSION['user']->_arrayFiltersDetail[$objectClass];
        }
      }
    }
    
    // first sort from index (checked in List Header)
    $sortIndex=null;   
    if ($print) {
      if (array_key_exists('sortIndex', $_REQUEST)) {
        $sortIndex=$_REQUEST['sortIndex']+1;
        $sortWay=(array_key_exists('sortWay', $_REQUEST))?$_REQUEST['sortWay']:'asc';
        $nb=0;
        $numField=0;
        foreach ($array as $val) {
          $fld=htmlExtractArgument($val, 'field');      
          if ($fld) {            
            $numField+=1;
            if ($sortIndex and $sortIndex==$numField) {
              $queryOrderBy .= ($queryOrderBy=='')?'':', ';
              $queryOrderBy .= " " . $fld . " " . $sortWay;
            }
          }
        }
      }
    }
    
    // Then sort from Filter Criteria
    if (! $quickSearch) {
	    foreach ($arrayFilter as $crit) {
	      if ($crit['sql']['operator']=='SORT') {
	        $doneSort=false;
          $split=explode('_', $crit['sql']['attribute']);
	        if (count($split)>1 ) {
	          $externalClass=$split[0];
	          $externalObj=new $externalClass();
	          $externalTable = $externalObj->getDatabaseTableName();          
	          $idTab+=1;
	          $externalTableAlias = 'T' . $idTab;
	          $queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias .
	           ' on ( ' . $externalTableAlias . ".refType='" . get_class($obj) . "' and " .  $externalTableAlias . '.refId = ' . $table . '.id )';
	          $queryOrderBy .= ($queryOrderBy=='')?'':', ';
            $queryOrderBy .= " " . $externalTableAlias . '.' . $split[1] 
            . " " . $crit['sql']['value'];
	          $doneSort=true;
          }
	        if (substr($crit['sql']['attribute'],0,2)=='id' and strlen($crit['sql']['attribute'])>2 ) {
	          $externalClass = substr($crit['sql']['attribute'],2);
	          $externalObj=new $externalClass();
	          $externalTable = $externalObj->getDatabaseTableName();
	          $sortColumn='id';          
	          if (property_exists($externalObj,'sortOrder')) {
	          	$sortColumn=$externalObj->getDatabaseColumnName('sortOrder');
	          } else {
	          	$sortColumn=$externalObj->getDatabaseColumnName('name');
	          }
            $idTab+=1;
            $externalTableAlias = 'T' . $idTab;
            $queryOrderBy .= ($queryOrderBy=='')?'':', ';
            $queryOrderBy .= " " . $externalTableAlias . '.' . $sortColumn
               . " " . str_replace("'","",$crit['sql']['value']);
            $queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias .
            ' on ' . $table . "." . $obj->getDatabaseColumnName('id' . $externalClass) . 
            ' = ' . $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('id');
            $doneSort=true;
	        }
	        if (! $doneSort) {
	          $queryOrderBy .= ($queryOrderBy=='')?'':', ';
	          $queryOrderBy .= " " . $table . "." . $obj->getDatabaseColumnName($crit['sql']['attribute']) 
	                             . " " . $crit['sql']['value'];
	        }
	      }
	    }
    }
    
    // Build select clause, and eventualy extended From clause and Where clause
    // Also include default Sort criteria
    $numField=0;
    $formatter=array();
    $arrayWidth=array();
    if ($outMode=='csv') {
    	$obj=new $objectClass();
    	$clause=$obj->buildSelectClause();
    	$querySelect .= ($querySelect=='')?'':', ';
    	$querySelect .= $clause['select'];
    	//$queryFrom .= ($queryFrom=='')?'':', ';
    	$queryFrom .= $clause['from'];
    } else {
	    foreach ($array as $val) {
	      //$sp=preg_split('field=', $val);
	      //$sp=explode('field=', $val);
	      $fld=htmlExtractArgument($val, 'field');      
	      if ($fld) {
	        $numField+=1;        
	        $formatter[$numField]=htmlExtractArgument($val, 'formatter');
	        $from=htmlExtractArgument($val, 'from');
	        $arrayWidth[$numField]=htmlExtractArgument($val, 'width');
	        $querySelect .= ($querySelect=='')?'':', ';
	        if (strlen($fld)>9 and substr($fld,0,9)=="colorName") {
	          $idTab+=1;
	          // requested field are colorXXX and nameXXX => must fetch the from external table, using idXXX
	          $externalClass = substr($fld,9);
	          $externalObj=new $externalClass();
	          $externalTable = $externalObj->getDatabaseTableName();
	          $externalTableAlias = 'T' . $idTab;
	          $querySelect .= 'convert(concat(';
	          if (property_exists($externalObj,'sortOrder')) {
	            $querySelect .= $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('sortOrder');
	            $querySelect .=  ",'#split#',";
	          }
	          $querySelect .= $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('name');
	          $querySelect .=  ",'#split#',";
	          $querySelect .= $externalTableAlias . '.' . $externalObj->getDatabaseColumnName('color');
	          $querySelect .= ') using utf8) as ' . $fld;
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
	          // Test for bug #419
	          //$externalTableAlias = $externalClass;
	          //$externalTableAlias = $externalObj->getDatabaseTableName();          
	          $externalTableAlias = strtolower($externalClass);
	          $querySelect .=  $externalTableAlias . '.' . $externalObj->getDatabaseColumnName($fld) . ' as ' . $fld;
	          if (! stripos($queryFrom,$externalTableAlias)) {
	            $queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias .
	              ' on (' . $externalTableAlias . '.refId=' . $table . ".id" . 
	              ' and ' . $externalTableAlias . ".refType='" . $objectClass . "')";
	          }
	          if ( property_exists($externalObj,'wbsSortable') 
	            and strpos($queryOrderBy,$externalTableAlias . "." . $externalObj->getDatabaseColumnName('wbsSortable'))===false) {
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
    }
    // build order by clause
    if ($objectClass=='DocumentDirectory') {
    	$queryOrderBy .= ($queryOrderBy=='')?'':', ';
    	$queryOrderBy .= " " . $table . "." . $obj->getDatabaseColumnName('location');
    } else if ( property_exists($objectClass,'wbsSortable')) {
      $queryOrderBy .= ($queryOrderBy=='')?'':', ';
      $queryOrderBy .= " " . $table . "." . $obj->getDatabaseColumnName('wbsSortable');
    } else if (property_exists($objectClass,'sortOrder')) {
      $queryOrderBy .= ($queryOrderBy=='')?'':', ';
      $queryOrderBy .= " " . $table . "." . $obj->getDatabaseColumnName('sortOrder');
    } else {
      $queryOrderBy .= ($queryOrderBy=='')?'':', ';
      $queryOrderBy .= " " . $table . "." . $obj->getDatabaseColumnName('id') . " desc";
    }
    
    // Check for an advanced filter (stored in User
    foreach ($arrayFilter as $crit) {
      if ($crit['sql']['operator']!='SORT') {
      	$split=explode('_', $crit['sql']['attribute']);
        if (count($split)>1 ) {
          $externalClass=$split[0];
          $externalObj=new $externalClass();
          $externalTable = $externalObj->getDatabaseTableName();          
          $idTab+=1;
          $externalTableAlias = 'T' . $idTab;
          $queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias .
           ' on ( ' . $externalTableAlias . ".refType='" . get_class($obj) . "' and " .  $externalTableAlias . '.refId = ' . $table . '.id )';
          $queryWhere.=($queryWhere=='')?'':' and ';
          $queryWhere.=$externalTableAlias . "." . $split[1] . ' ' 
                 . $crit['sql']['operator'] . ' '
                 . $crit['sql']['value'];
        } else {
          $queryWhere.=($queryWhere=='')?'':' and ';
          $queryWhere.=$table . "." . $crit['sql']['attribute'] . ' ' 
		                 . $crit['sql']['operator'] . ' '
		                 . $crit['sql']['value'];
        }
      }
    }
    
    // constitute query and execute
    $queryWhere=($queryWhere=='')?' 1=1':$queryWhere;
    $query='select ' . $querySelect 
         . ' from ' . $queryFrom
         . ' where ' . $queryWhere 
         . ' order by' . $queryOrderBy;
    $result=Sql::query($query);
    $nbRows=0;
    $dataType=array();
    if ($print) {
    	if ($outMode=='csv') {
    		$csvSep=Parameter::getGlobalParameter('csvSeparator');
    		$csvQuotedText=true;
    		$obj=new $objectClass();
    		$first=true;
    		while ($line = Sql::fetchLine($result)) {
    			if ($first) {
	    			foreach ($line as $id => $val) {
	    				$val=utf8_decode($obj->getColCaption($id));
	    				//$val=utf8_decode($id);
	    				$val=str_replace($csvSep,' ',$val);
	            if ($id!='id') { echo $csvSep ;}
	    				echo $val;
	            $dataType[$id]=$obj->getDataType($id);
	          }
	          echo "\r\n";
    			}
    			foreach ($line as $id => $val) {
    				$foreign=false;
    				if (substr($id, 0,2)=='id' and strlen($id)>2) {
    					$class=substr($id, 2);
    					if (ucfirst($class)==$class) {
    						$foreign=true;
    					  $val=SqlList::getNameFromId($class, $val);
    					}
    				}
    				$val=utf8_decode($val);
    				if ($csvQuotedText) {
    				  $val=str_replace('"','""',$val);	
    				}
            $val=str_replace($csvSep,' ',$val);
            if ($id!='id') { echo $csvSep ;}
            if ( ($dataType[$id]=='varchar' or $foreign) and $csvQuotedText) {
              echo '"' . $val . '"';
            } else {
            	echo $val;
            }
    			}
    			$first=false;
    			echo "\r\n";
    		}
    		if ($first) {
    			echo utf8_decode(i18n("reportNoData")); 
    		}
    	} else {
        echo '<br/>';
        echo '<div class="reportTableHeader" style="width:100%; font-size:150%;border: 0px solid #000000;">' . i18n('menu'.$objectClass) . '</div>';
        echo '<br/>';
	      echo '<table>';
	      echo '<tr>';
	      echo str_ireplace('width="','style="width:',$layout);
	      echo '</tr>';
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
	            } else if ($formatter[$numField]=="sortableFormatter") {
	              $disp=sortableFormatter($val);
	            } else {
	              $disp=htmlEncode($val);
	            }
	            echo '<td class="tdListPrint" style="width:' . $arrayWidth[$numField] . ';">' . $disp . '</td>';
	          }
	          echo '</tr>';       
	        }
	      }
	      echo "</table>";
	      //echo "</div>";
    	}
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
            if ($id=='colorNameRunStatus') {
            	$split=explode('#',$val);
            	foreach ($split as $ix=>$sp) {
            	  if ($ix==0) {
            	  	$val=$sp;
            	  } else if ($ix==2) {
            		  $val.='#'.i18n($sp);	
            	  } else {
            	  	$val.='#'.$sp;
            	  }
            	} 
            }
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
