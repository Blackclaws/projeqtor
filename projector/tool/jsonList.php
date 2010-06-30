<?PHP
/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projector.php"; 
    $type=$_REQUEST['listType'];
    echo '{"identifier":"id",' ;
    echo 'label: "name",';
    echo ' "items":[';
    
    if ($type=='empty') {
          
    } else if ($type=='object') {    
      $objectClass=$_REQUEST['objectClass'];
      $obj=new $objectClass();
      $nbRows=0;
      // return result in json format
      foreach ($obj as $col=>$val) {
        if (substr($col, 0,1) <> "_" 
        and substr($col, 0,1) <> ucfirst(substr($col, 0,1))) { 
          if ($nbRows>0) echo ', ';
          $dataType = $obj->getDataType($col);
          $dataLength = $obj->getDataLength($col);
          if ($dataType=='int' and $dataLength==1) { 
            $dataType='bool'; 
          } else if ($dataType=='datetime') { 
            $dataType='date'; 
          } else if ((substr($col,0,2)=='id' and $dataType=='int' and strlen($col)>2 
                      and substr($col,2,1)==strtoupper(substr($col,2,1)))) { 
            $dataType='list'; 
          }
          echo '{id:"' . $col . '", name:"'. $obj->getColCaption($col) .'", dataType:"' . $dataType . '"}';
          $nbRows++;
        }
      }
    } else if ($type=='operator') {    
      $dataType=$_REQUEST['dataType'];
      if ($dataType=='int' or $dataType=='date' or $dataType=='datetime') {
        echo ' {id:"=", name:"="}';
        echo ',{id:">=", name:">="}';
        echo ',{id:"<=", name:"<="}';
      } else if ($dataType=='varchar') {
        echo ' {id:"LIKE", name:"' . i18n("contains") . '"}';
      } else if ($dataType=='bool') {
        echo ' {id:"=", name:"="}';
      } else if ($dataType=='list') {
        echo ' {id:"IN", name:"' . i18n("amongst") . '"}';
      } else  {
        echo ' {id:"UNK", name:"?"}';
      }
      
    } else if ($type=='list') {    
      $dataType=$_REQUEST['dataType'];
      $class=substr($dataType,2);
      $list=SqlList::getList($class);
      $nbRows=0;
      // return result in json format
      foreach ($list as $id=>$name) {
        if ($nbRows>0) echo ', ';
        echo '{id:"' . $id . '", name:"'. $name . '"}';
        $nbRows+=1;
      }
    } else if ($type=='listResourceProject') {
      $obj=$_SESSION['currentObject'];
      $idPrj=$_REQUEST['idProject'];
      $prj=new Project($obj->idProject);
      $lstTopPrj=$prj->getTopProjectList(true);
      $in=transformValueListIntoInClause($lstTopPrj);
      $where="idProject in " . $in; 
      $aff=new Affectation();
      $list=$aff->getSqlElementsFromCriteria(null,null, $where);
      $nbRows=0;
      $lstRes=array();
      if (array_key_exists('selected', $_REQUEST)) {
        $lstRes[$_REQUEST['selected']]=SqlList::getNameFromId('Resource', $_REQUEST['selected']);
      }
      foreach ($list as $aff) {
        if (! array_key_exists($aff->idResource, $lstRes)) {
          $lstRes[$aff->idResource]=SqlList::getNameFromId('Resource', $aff->idResource);
        }
      }
      asort($lstRes);
      // return result in json format
      foreach ($lstRes as $id=>$name) {
        if ($nbRows>0) echo ', ';
        echo '{id:"' . $id . '", name:"'. $name . '"}';
        $nbRows+=1;
      }
    }
    echo ' ] }';
?>
