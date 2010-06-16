<?php
/** ===========================================================================
 * Html specific functions
 */
require_once "../tool/projector.php";
/** ===========================================================================
 * Draw the options list for a select  
 * @param $col the name of the field, as idXxx. The table ref is then xxx.
 * @param $selection the value of the field, to be selected in the list
 * @param $obj optional - object for which list is generated
 * @param $required optional - indicates wether the list may present an empty value or not
 * @return void
 */
function htmlDrawOptionForReference($col, $selection, $obj=null, $required=false) {
//scriptLog('htmlDrawOptionForReference($col="' . $col . '", $selection="' . $selection . '", $obj="?", $required="' . $required . '")');  
  $listType=substr($col,2);
  $table=SqlList::getList($listType,'name',$selection);
  $restrictArray=array();
  $excludeArray=array();
  if ($obj) {
    if (get_class($obj)=='Project' and $col=="idProject" and $obj->id!=null) {
      $excludeArray=$obj->getRecursiveSubProjectsFlatList();
      $excludeArray[$obj->id]=$obj->name;
    } else if ($col=="idProject") {
      $user=$_SESSION["user"];
      $controlRightsTable=$user->getAccessControlRights();
      $controlRights=$controlRightsTable[$obj->getMenuClass()];
      if ($obj->id==null) {
        // creation mode
        if ($controlRights["create"]=="PRO") {
          $restrictArray=$user->getVisibleProjects();
        }
      } else {
        // read or update mode
        if (securityGetAccessRightYesNo($obj->getMenuClass(), 'update', $obj)=="YES") {
          // update
          if ($controlRights["update"]=="PRO") {
            $restrictArray=$user->getVisibleProjects();
          }            
        }
      }
    } else if ($col=='idStatus') {        
      $idType='id' . get_class($obj) . 'Type';
      $typeClass=get_class($obj) . 'Type';
      if (property_exists($obj,$idType) ) {
        if ($obj->$idType) {
          $profile="";
          if (array_key_exists('user', $_SESSION)) {
            $profile=$_SESSION['user']->idProfile;
          } 
          $type=new $typeClass($obj->$idType);
          if (property_exists($type,'idWorkflow') ) {
            $ws=new WorkflowStatus();
            $crit=array('idWorkflow'=>$type->idWorkflow, 'allowed'=>1, 'idProfile'=>$profile, 'idStatusFrom'=>$obj->idStatus);
            $wsList=$ws->getSqlElementsFromCriteria($crit, false);
            $compTable=array($obj->idStatus=>'ok');
            foreach ($wsList as $ws) {
              $compTable[$ws->idStatusTo]="ok";
            }
            $table=array_intersect_key($table,$compTable);
          }
        } else {
          reset($table);
          $table=array(key($table)=>current($table));
        }
      }
    }
  }
  if (! $required) {
    echo '<OPTION value=" " ></OPTION>';
  }
  foreach($table as $key => $val) {
    if (! array_key_exists($key, $excludeArray) and ( count($restrictArray)==0 or array_key_exists($key, $restrictArray) ) ) {
      echo '<OPTION value="' . $key . '"';
      if ( $selection and $key==$selection ) { echo ' SELECTED '; } 
      echo '>' . $val . '</OPTION>';
    }
  }
}

/** ===========================================================================
 * Display the info of the aplication (name, version) with link to website
 * @return void
 */
function htmlDisplayInfos() {
  global $copyright, $version, $website, $aboutMessage;
  echo "<a class='statusBar' href='$website' >$copyright $version&nbsp;</a>";
}

/** ===========================================================================
 * Display the info of the aplication (name, version) with link to website
 * @return void
 */
function htmlDisplayDatabaseInfos() {
  global $paramDbName, $paramDbDisplayName;
  if (! $paramDbDisplayName) {
    $paramDbDisplayName=$paramDbName;
  }
  echo "<div class='statusBar' style='text-align:center;'><b>$paramDbDisplayName</b></div>";
}

/** ===========================================================================
 * Display the message No object selected for the corresponding object,
 * translate using i18n
 * @param $className the class of the object
 * @return void
 */
function htmlGetNoDataMessage($className) {
    return '<br/><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . i18n('messageNoData',array(i18n($className))) . '</i>';
}

/** ===========================================================================
 * Draw an html Table as cross reference
 * @param $lineObj the object class containing line data
 * @param $columnTable the table containing column data
 * @param $pivotTable the table containing pivot data (must contain id'ColumnTable' and id'LineTable'
 * @param $pivotValue the name of the field in pivot table containing pivot data
 * @param $format the format of data : check, text, label
 * @return void
 */
function htmlDrawCrossTable($lineObj, $lineProp, $columnObj, $colProp, $pivotObj, $pivotProp, $format='label', $formatList=null) {
  $lineList=SqlList::getList($lineObj);
  $columnList=SqlList::getList($columnObj);

  echo '<table class="crossTable">';
  // Draw Header
  echo '<tr><td></td>';
  foreach ($columnList as $col) {
    echo '<td class="tabLabel">' . $col . '</td>';
  }
  echo '</tr>';
  foreach($lineList as $lineId => $lineName) {
debugLog($lineName);
    echo '<tr><td class="crossTableLine"><label>' . $lineName . '</label></td>';
    foreach ($columnList as $colId => $colName) {
      $crit=array();
      $crit[$lineProp]=$lineId;
      $crit[$colProp]=$colId;
      $name=$pivotObj . "_" . $lineId . "_" . $colId;
      $class=ucfirst($pivotObj);
      $obj=SqlElement::getSingleSqlElementFromCriteria($class, $crit);
      $val=$obj->$pivotProp;
      echo '<td class="crossTablePivot">';
      switch ($format) {
        case 'check':
          $checked = ($val!='0' and ! $val==null) ? 'checked' : '';
          echo '<input dojoType="dijit.form.CheckBox" type="checkbox" ' . $checked . ' id="' . $name . '" name="' . $name . '" />'; 
          break;
        case 'text':
          echo '<input dojoType="dijit.form.TextBox id="' . $name . '" name="' . $name . '" type="text" class="input" style="width: 100px;" value="' . $val . '" />';
          break;
        case 'list':
          //echo '<input dojoType="dijit.form.TextBox id="' . $name . '" name="' . $name . '" type="text" class="input" style="width: 100px;" value="' . $val . '" />';
          echo '<select dojoType="dijit.form.FilteringSelect" class="input" '; 
          echo ' style="width: 100px; font-size: 80%;"';
          echo ' id="' . $name . '" name="' . $name . '" ';
          echo ' >';
          htmlDrawOptionForReference('id' . $formatList, $val, null, true); 
          echo '</select>';
          break;  
        case 'label':
          echo $val;
          break;
      }
      echo '</td>';
    }
    echo '</tr>';
  }
  
  
  echo '</table>';
  
}

/** ===========================================================================
 * Get the data of a form table designed with htmlDrawCrossTable
 * @param $lineTable the table containing line data
 * @param $columnTable the table containing column data
 * @param $pivotTable the table containing pivot data (must contain id'ColumnTable' and id'LineTable'
 * @param $pivotValue the name of the field in pivot table containing pivot data
 * @param $format the format of data : check, text, label
 * @return an array containing 
 */
function htmlGetCrossTable($lineObj, $columnObj, $pivotObj) {
  $lineList=SqlList::getList($lineObj);
  $columnList=SqlList::getList($columnObj);
  $result=array();
  foreach($lineList as $lineId => $lineName) {
    foreach ($columnList as $colId => $colName) {
      $name=$pivotObj . "_" . $lineId . "_" . $colId;
      $val="";
      if (array_key_exists($name,$_REQUEST)) {
        $val=$_REQUEST[$name];
      }
      $result[$lineId][$colId]=$val;
    }
  }
  return $result;
}

/** ===========================================================================
 * Construct a Js table from a Php table (got from a database table)
 * @param $tableName name of database table containing data
 * @param $colName column name co,ntaining requested data in table
 * @return javascript creating an array 
 */
function htmlGetJsTable($tableName, $colName, $jsTableName=null) {
  $tab=SqlList::getList($tableName,$colName);
  $jsTableName=(! $jsTableName) ? 'tab'.ucfirst($tableName):$jsTableName;
  $script='var ' . $jsTableName . ' = [ ';
  $nb=0;
  foreach ($tab as $id=>$value) {
    $script .= (++$nb>1) ? ', ': '';
    $script .= ' { id: "' . $id . '", ' . $colName . ': "' . $value . '" } ';
  }
  $script.= ' ];';
  return $script;
}

/**
 * Format a date, depending on currentLocale
 * @param $val
 * @return unknown_type
 */
function htmlFormatDate($val) {
  global $currentLocale;
  if (strlen($val)!=10) {
    return $val;
  }
  if ($currentLocale=='fr') {
    return substr($val,8,2) . "/" . substr($val,5,2)  . "/" . substr($val,0,4);
  } else if ($currentLocale=='en') {
    return substr($val,5,2) . "/" . substr($val,8,2)  . "/" . substr($val,0,4);
  } else {
    return $val;
  }
}


/** ============================================================================
 * Transform string to be displays in html, pedending on context 
 * @param $context Printing context : 
 *   'print' : for printing purpose, also converts nl to <br> 
 *   'default' : default for conversion
 *   'none' : no convertion
 * @return string - the formated value 
 */
function htmlEncode($val,$context="default") {
  if ($context=='none') {
    return $val;
  } else if ($context=='print') {
    return nl2br(htmlentities($val,ENT_COMPAT,'UTF-8'));
  }
  return htmlspecialchars($val,ENT_QUOTES,'UTF-8');
  //return nl2br(htmlentities($val,ENT_QUOTES,'UTF-8'));
}

function htmlEncodeJson($val, $numericLength=0) {
  $val = str_replace('"',"",$val);
  $val = str_replace("'","",$val);
  $val = str_replace("&","",$val);
  $val = str_replace("<","",$val);
  $val = str_replace(">","",$val);       
  if ($numericLength>0) {
    $val=str_pad($val,$numericLength,'0', STR_PAD_LEFT);
  }
  return htmlspecialchars($val,ENT_QUOTES,'UTF-8');
}

/** ============================================================================
 * Return an error message formated as a resultDiv result
 * @param $message the message to display
 * @return formated html message, with corresponding html input
 */
function htmlGetErrorMessage($message) {
  $returnValue = '<span class="messageERROR" >' . $message . '</span>';
  $returnValue .= '<input type="hidden" id="lastSaveId" value="" />';
  $returnValue .= '<input type="hidden" id="lastOperation" value="control" />';
  $returnValue .= '<input type="hidden" id="lastOperationStatus" value="ERROR" />';
  return $returnValue;
}

/** ============================================================================
 * Return a warning message formated as a resultDiv result
 * @param $message the message to display
 * @return formated html message, with corresponding html input
 */
function htmlGetWarningMessage($message) {
  $returnValue = '<span class="messageWARNING" >' . $message . '</span>';
  $returnValue .= '<input type="hidden" id="lastSaveId" value="" />';
  $returnValue .= '<input type="hidden" id="lastOperation" value="control" />';
  $returnValue .= '<input type="hidden" id="lastOperationStatus" value="WARNING" />';
  return $returnValue;
}

/** ============================================================================
 * Return an mime/Type formated as an image
 * @param $mimeType the textual mimeType
 * @return formated html mimeType, as an image
 */
function htmlGetMimeType($mimeType) {
  // TODO : transform mimeType into Image
  return $mimeType;
}

/** ============================================================================
 * Return an fileSize formated as GB, MB KB or B 
 * @param $mimeType the textual mimeType
 * @return formated html mimeType, as an image
 */
function htmlGetFileSize($fileSize) {
  $nbDecimals=1;
  $limit=1000;
  if ($fileSize==null) {
    return '';
  }
  if ($fileSize<$limit) {
    return $fileSize . ' ' . i18n('byteLetter');
  } else {
    $fileSize=round($fileSize/1024,$nbDecimals);
    if ($fileSize<$limit) {
      return $fileSize . ' K' . i18n('byteLetter');
    } else {
      $fileSize=round($fileSize/1024,$nbDecimals);
      if ($fileSize<$limit) {
        return $fileSize . ' M' . i18n('byteLetter');
      } else {
        $fileSize=round($fileSize/1024,$nbDecimals);
        if ($fileSize<$limit) {
          return $fileSize . ' G' . i18n('byteLetter');
        } else {
          $fileSize=round($fileSize/1024,$nbDecimals);
          return $fileSize . ' T' . i18n('byteLetter');
        }      
      }
    }
  }
}

function htmlExtractArgument($tag, $arg) {
  $sp=explode($arg . '=', $tag);
  $fld=null;
  if (isset($sp[1])) {
    $fld=$sp[1];
    $fld=substr($fld,0,strpos($fld,' '));
    $fld=trim($fld,'"');
  }
  return $fld;
}
?>