<?php
/* ============================================================================
 * Presents the detail of an object, for viewing or editing purpose.
 *
 * TODO : modify visibility depending on profile
 */
//session_start();session_destroy();
  require_once "../tool/projector.php";
  scriptLog('   ->/view/objectDetail.php');
/** ===========================================================================
 * Draw all the properties of object as html elements, depending on type of data
 * @param $obj the object to present
 * @param $included boolean indicating wether the function is called recursively or not
 * @return void
 */
  
function drawTableFromObject($obj, $included=false, $parentReadOnly=false) {
  global $cr, $print, $treatedObjects, $displayWidth;
  $treatedObjects[]=$obj;
  $dateWidth='87';
  $verySmallWidth='44';
  $smallWidth='87';
  $mediumWidth='200';
  $largeWidth='406';
  $labelWidth=175; // To be changed if changes in css file (label and .label)
  $fieldWidth=$smallWidth;
  $currentCol=0;
  $nbCol=1;
  $detailWidth=null; // Default detail div width
  // Check screen resolution, to determine max field width (largeWidth)
  //var_dump($obj);
  if (array_key_exists('destinationWidth',$_REQUEST)) {
    $detailWidth=$_REQUEST['destinationWidth'];
  } else {
    if (array_key_exists('screenWidth',$_SESSION)) {
      $detailWidth = round(($_SESSION['screenWidth'] * 0.8) - 15) ; // 80% of screen - split barr - padding (x2)
    }
  }
//echo "screenWidth=" . $_SESSION['screenWidth'] . "<br/>detailWidth=" . $detailWidth . "<br/>";
  // Define internalTable values, to present data as a table
  $internalTable=0;
  $internalTableCols=0;
  $internalTableRows=0;
  $internalTableCurrentRow=0;
  $internalTableRowsCaptions=array();
  $classObj=get_class($obj);
  $section=''; $nbLineSection=0;
  // Loop on each propertie of the object
  if ( ! $included) {
    echo '<table id="mainTable" >'; // Main table to present multi-column
  }
  $nobr=false;
  foreach ($obj as $col => $val) {
    if ($detailWidth) {
      $colWidth = ( $detailWidth) / $nbCol;        // 2 columns should be displayable
      $maxWidth= $colWidth - $labelWidth ;          // subtract label width and a margin for slider place
      if ($maxWidth >= $mediumWidth) {
        $largeWidth = $maxWidth;
      } else {
        $largeWidth = $mediumWidth;
      }
    }
    $hide=false;
    $nobr_before=$nobr;
    $nobr=false; 
    if ( $included and ($col=='id' or $col=='refId' or $col=='refType' or $col=='refName') ) {
      $hide=true;
    }
    // If field is _tab_x_y, start a table presentation with x columns and y lines
    // the filed _tab_x_y must be an array containing x + y values : 
    //   - the x column headers
    //   - the y line headers 
    if (substr($col,0,4)=='_tab') {
      $decomp=explode("_",$col);
      $internalTableCols=$decomp[2];
      $internalTableRows=$decomp[3];
      $internalTable=$internalTableCols * $internalTableRows;
      $internalTableRowsCaptions=array_slice($val,$internalTableCols);
      $internalTableCurrentRow=0;
      $colWidth = ( $detailWidth) / $nbCol;
      echo '</table><table id="' . $col .'" class="detail"><tr class="detail">';
      echo '<td class="detail"><label></label></td>' . $cr; // Empty label, to have column header in front of columns
      for ($i=0 ; $i<$internalTableCols ; $i++) { // draw table headers
        echo '<td class="detail">';
        echo '<input type="text" class="tabLabel" value="' . htmlEncode($obj->getColCaption($val[$i])) . '" tabindex="-1" />' . $cr;
        if ( $i < $internalTableCols-1) { echo '</td>'; }
      }
      // echo '</tr>'; NOT TO DO HERE -  WILL BE DONE AFTER
    } else if (substr($col,0,5)=='_col_') { // if field is _col, draw a new main column
      $previousCol=$currentCol;
      $currentCol=substr($col,5,1);
      $nbCol=substr($col,7,1);
      $widthPct=round(98/$nbCol) . "%";
      if ($nbCol=='1') {
        $widthPct=$displayWidth;
      }
      if (substr($displayWidth,-2,2)=="px") {
        $val=substr($displayWidth,0,strlen($displayWidth)-2);
        $widthPct=round( ($val/$nbCol) - 2 * ($nbCol-1) ) . "px";
      }
      if ($print) {
        $widthPct= round( ( 900 / $nbCol) - 2 * ($nbCol-1) ) . "px";
      }
      if (strlen($col)>8) {
        $section=substr($col,9);
      } else {
        $section='';
      }
      if ($currentCol=='1') {
        if ($previousCol==0) {
          echo '</table>';
        } else {
          echo '</table></td></tr></table>';
        }
        echo '<table id="col1_' . $col .'" class="detail"><tr class="detail"><td class="detail" style="width:' . $widthPct . ';" valign="top"><table style="width:' . $widthPct . ';" id="Subcol1_' . $col .'" >';
        $nbLineSection++;
      } else {
        echo '</table></td><td class="detail" style="width: 2px;">&nbsp;</td><td class="detail" style="width:' . $widthPct . ';" valign="top"><table style="width:' . $widthPct . ';" id="subcol' . $currentCol . '_' . $col .'" >';
      }
      if (strlen($section)>1) {
        if ($nbLineSection>1) {
          echo '<tr><td></td><td>&nbsp;</td></tr>';
        }
        echo '<tr><td colspan=2 style="width: 100%" class="section">' . i18n('section' . ucfirst($section)) . '</td></tr>';
      }
    } else if (substr($col,0,5)=='_sec_') { // if field is _col, draw a new main column
      if (strlen($col)>8) {
        $section=substr($col,5);
      } else {
        $section='';
      }
      echo '<tr><td colspan=2 style="width: 100%" class="halfLine">&nbsp;</td></tr>';
      echo '<tr><td colspan=2 style="width: 100%" class="section">' . i18n('section' . ucfirst($section)) . '</td></tr>';
    } else if (substr($col,0,5)=='_spe_') { // if field is _spe_xxxx, draw the specific item xxx
      $item=substr($col,5);
      echo '<tr><td colspan=2>';
      echo $obj->drawSpecificItem($item); // the method must be implemented in the corresponidng class
      echo '</td></tr>';
    } else if (substr($col,0,5)=='_Link') { // Display links to other objects
      $linkClass=null;
      if (strlen($col)>5) {
        $linkClass=substr($col,6);
      }
      drawLinksFromObject($val, $obj,$linkClass);
    } else if (substr($col,0,11)=='_Assignment') { // Display Assignments
      drawAssignmentsFromObject($val, $obj);
    } else if (substr($col,0,11)=='_Dependency') { // Display Assignments
      $depType=(strlen($col)>11)?substr($col,12):"";
      drawDependenciesFromObject($val, $obj, $depType);
    } else if (substr($col,0,1)=='_' and substr($col,0,6)!='_void_' 
                                     and substr($col,0,7)!='_label_') { // field not to be displayed
      //    
    } else {
      $attributes=''; $isRequired=false; $readOnly=false;
      if (strpos($obj->getFieldAttributes($col), 'required')!==false) {
        $attributes.=' required="true" missingMessage="' . i18n('messageMandatory',array($obj->getColCaption($col))). '" invalidMessage="' . i18n('messageMandatory',array($obj->getColCaption($col))) .'"';
        $isRequired=true;
      }
      if (strpos($obj->getFieldAttributes($col), 'hidden')!==false) {
        $hide=true;
      }
      if (strpos($obj->getFieldAttributes($col), 'nobr')!==false) {
        $nobr=true;
      }
      if ( (securityGetAccessRightYesNo('menu' . $classObj, 'update', $obj) == "NO") 
      or (strpos($obj->getFieldAttributes($col), 'readonly')!==false)
      or $parentReadOnly 
      or ($obj->idle==1 and $col!='idle' and $col!='idStatus') ) {
        $attributes.=' readonly ';
        $readOnly=true;     
      } 
      if ($internalTable==0) {
        if (! is_object($val) and ! is_array($val) and !$hide and !$nobr_before) {
          echo '<tr><td class="label" width="10%">';
          echo '<label for="' . $col . '" >' . htmlEncode($obj->getColCaption($col)) . '&nbsp;:&nbsp;</label>' . $cr;
          echo '</td><td width="90%">';
        }
      } else {
        if ($internalTable % $internalTableCols == 0) {
          echo '</td></tr>' . $cr;
          echo '<tr>';
          echo '<td class="label" width="10%">';
          echo '<label>' . htmlEncode($obj->getColCaption($internalTableRowsCaptions[$internalTableCurrentRow])) . '&nbsp;:&nbsp;</label>';
          echo '</td><td  width="90%">';
          $internalTableCurrentRow++;
        } else {
          echo '</td><td  class="detail">';
        }
      }
      $dataType = $obj->getDataType($col);
      $dataLength = $obj->getDataLength($col);
//echo $col . "/" . $dataType . "/" . $dataLength;
      if ($dataLength) {
        if ($dataLength <= 3) {
          $fieldWidth=$verySmallWidth;
        } else if ($dataLength <= 10) {
          $fieldWidth=$smallWidth;
        } else if ($dataLength <= 25) {  
          $fieldWidth=$mediumWidth;
        } else {
          $fieldWidth=$largeWidth;
        }
      }
      if (substr($col,0,2)=='id' and $dataType=='int' and strlen($col)>2 
          and substr($col,2,1)==strtoupper(substr($col,2,1)) ) {
        $fieldWidth=$largeWidth;
      }
      if (strpos($obj->getFieldAttributes($col), 'Width')!==false) {
        if (strpos($obj->getFieldAttributes($col), 'smallWidth')!==false) {
          $fieldWidth=$smallWidth;
        }
        if (strpos($obj->getFieldAttributes($col), 'mediumWidth')!==false) {
          $fieldWidth=$mediumWidth;
        }
      }
//echo $dataType . '(' . $dataLength . ') ';

      if ($included) {
        $name=' id="' . $classObj . '_' . $col . '" name="' . $classObj . '_' . $col . '" ';
        $nameBis=' id="' . $classObj . '_' . $col . 'Bis" name="' . $classObj . '_' . $col . 'Bis" ';
      } else {
        $name=' id="' . $col . '" name="' . $col . '" jsId="' . $col .'" ';
        $nameBis=' id="' . $col . 'Bis" name="' . $col . 'Bis" jsId="' . $col .'Bis" ';
      }
      // prepare the javascript code to be executed
      $colScript = $obj->getValidationScript($col);
      if (is_object($val)) {
        // Draw an included object (recursive call) =========================== Type Object
        drawTableFromObject($val, true, $readOnly);
        $hide=true; // to avoid display of an extra field for the object and an additional carriage return 
      } else if (is_array($val)) {
        // Draw an array ====================================================== Type Array
        // TODO : impement array fields
        //echo $col . ' is an array' . $cr; 
      } else if (substr($col,0,6)=='_void_') {
        // Empty field for tabular presentation
        //echo $col . ' is an array' . $cr; 
      //  
      } else if (substr($col,0,7)=='_label_') { 
        $captionName=substr($col,7);
        echo '<label class="shortlabel">' . i18n('col' . ucfirst($captionName)) . '&nbsp;:&nbsp;</label>';
      } else if ($print) {   //================================================ Printing areas
        if ($hide) { // hidden field
          // nothing
        } else if ($col=='id') { // id
          echo '#' . $val;
        } else if ($col=='password') {
          echo "..."; // nothing
        } else if ($dataType=='date' and $val!=null and $val != '') {
          echo htmlFormatDate($val);
        } else if ($dataType=='datetime' and $val!=null and $val != '') {
          echo htmlFormatDateTime($val,false);
        } else if ($col=='color' and $dataLength == 7 ) { // color
          echo '<table><tr><td style="width: 100px;">';
          echo '<div class="colorDisplay" type="text" readonly ';
          echo '  value="' . htmlEncode($val) . '" ';
          echo '  style="width: ' . $smallWidth / 2 . 'px; ';
          echo ' color: ' . $val . '; ';
          echo ' background-color: ' . $val . ';"';
          echo ' >';
          echo '</div>';
          echo '</td>';
          if ($val!=null and $val!='') {
            echo '<td  class="detail">&nbsp;(' . htmlEncode($val) . ')</td>';
          }
          echo '</tr></table>';
        } else if ($dataType=='int' and $dataLength==1) { // boolean
          $checkImg="checkedKO.png";
          if ($val!='0' and ! $val==null) { 
            $checkImg= 'checkedOK.png';
          } 
          echo '<img src="img/' . $checkImg . '" />';
        } else if (substr($col,0,2)=='id' and $dataType=='int' and strlen($col)>2 
                   and substr($col,2,1)==strtoupper(substr($col,2,1)) ) { // Idxxx
          echo SqlList::getNameFromId(substr($col,2),$val);
        } else  if ($dataLength > 100) { // Text Area (must reproduce BR, spaces, ...
          //echo '<div style="width: ' . $fieldWidth . 'px;"> ' . htmlEncode($val,'print') . '</div>';
          echo htmlEncode($val,'print');
        } else {
          if ($obj->isFieldTranslatable($col))  {
              $val=i18n($val);
          }
          //echo '<div style="width: ' . ($fieldWidth / 2) . 'px;"> ' . htmlEncode($val,'print') . '</div>';
          echo htmlEncode($val,'print');
        }
      } else if ($hide) {
        // Don't draw the field =============================================== Hidden field
        echo '<div dojoType="dijit.form.TextBox" type="hidden"  ';
        echo $name;
        echo ' value="' . htmlEncode($val) . '" ></div>';
      } else if ($col=='id') {
        // Draw Id (only visible) ============================================= ID
        // id is only visible
        echo '#<div dojoType="dijit.form.TextBox" type="text"  ';
        echo $name;
        echo ' class="display" ';
        echo ' readonly style="width: ' . $smallWidth . 'px;" ' ;
        echo ' value="' . htmlEncode($val) . '" ></div>';
      } else if ($col=='password') {
        global $paramDefaultPassword;       
        // Password specificity  ============================================= PASSWORD
        echo '<button id="resetPassword" dojoType="dijit.form.Button" showlabel="true"'; 
        echo $attributes;
        echo ' title="' . i18n('helpResetPassword') . '" >';
        echo '<span>' . i18n('resetPassword') . '</span>';
        echo '<script type="dojo/connect" event="onClick" args="evt">';
		    echo '  dojo.byId("password").value="' . md5($paramDefaultPassword) . '";';
		    echo '  formChanged();';
		    echo '  showInfo("' . i18n('passwordReset',array($paramDefaultPassword)) . '");';
        echo '</script>';
        echo '</button>';
        // password not visible
        echo '<input type="password"  ';
        echo $name;
        echo ' class="display" ';
        echo ' readonly ' ;
        echo ' value="' . htmlEncode($val) . '" ></div>';
      } else if ($col=='color' and $dataLength == 7 ){
        // Draw a color selector ============================================== COLOR
        echo "<table ><tr><td class='detail'>";
        echo '<div dojoType="dijit.form.TextBox" class="colorDisplay" type="text" readonly ';
        echo $name;
        echo $attributes;
        echo '  value="' . htmlEncode($val) . '" ';
        echo '  style="width: ' . $smallWidth . 'px; ';
        echo ' color: ' . $val . '; ';
        echo ' background-color: ' . $val . ';"';
        echo ' >';
        echo $colScript;
        echo '</div>';
        echo '</td><td class="detail">';
        if (! $readOnly) {
          echo '<div id="' . 'colorButton" dojoType="dijit.form.DropDownButton"  ';
          //echo '  style="width: 100px; background-color: ' . $val . ';"';
          echo ' showlabel="false" iconClass="colorSelector" >';
          echo '  <span>Select color</span>';
  	      echo '  <div dojoType="dijit.ColorPalette" >';
  	      echo '    <script type="dojo/method" event="onChange" >';
          echo '      var fld=dojo.byId("color");';
          echo '      fld.style.color=this.value;';
          echo '      fld.style.backgroundColor=this.value;';
          echo '      fld.value=this.value;';
          echo '      formChanged();';
          echo '    </script>';
          echo '  </div>';
          echo '</div>';
        }
        echo '</td></tr></table>';
      } else if ($col=='durationSla'){
      // Draw a color selector ============================================== SLA as a duration
        echo '<div dojoType="dijit.form.TextBox" class="colorDisplay" type="text"  ';
        echo $name;
        echo $attributes;
        echo '  value="' . htmlEncode($val) . '" ';
        echo '  style="width: 30px; "';
        echo ' >';
        echo '</div>';
        echo i18n("shortDay") . "  ";
        echo '<div dojoType="dijit.form.TextBox" class="colorDisplay" type="text"  ';
        echo $attributes;
        echo '  value="' . htmlEncode($val) . '" ';
        echo '  style="width: 30px; "';
        echo ' >';
        echo '</div>';
        echo i18n("shortHour") . "  ";
        echo '<div dojoType="dijit.form.TextBox" class="colorDisplay" type="text"  ';
        echo $attributes;
        echo '  value="' . htmlEncode($val) . '" ';
        echo '  style="width: 30px; "';
        echo ' >';
        echo '</div>';
        echo i18n("shortMinute") . "  ";
      } else if ($dataType=='date') {
        // Draw a date ======================================================== DATE
        if ($col=='creationDate' and ($val=='' or $val==null) and ! $obj->id) {
          $val=date('Y-m-d');
        }
        echo '<div dojoType="dijit.form.DateTextBox" ';
        echo $name;
        echo $attributes;
        echo ' invalidMessage="' . i18n('messageInvalidDate') . '"'; 
        echo ' type="text" maxlength="' . $dataLength . '" ';
        //echo ' constraints="{datePattern:\'yy-MM-dd\'}" ';
        echo ' style="width:' . $dateWidth . 'px; text-align: center;" class="input" ';
        echo ' value="' . htmlEncode($val) . '" ';
        echo ' >';
        echo $colScript;
        echo '</div>';
      } else if ($dataType=='datetime') {
        // Draw a date ======================================================== DATETIME
        if (strlen($val>11)) {
          $valDate=substr($val,0,10);
          $valTime=substr($val,11);
        } else {
          $valDate=$val;
          $valTime='';
        }
        if ($col=='creationDateTime' and ($val=='' or $val==null) and ! $obj->id) {
          $valDate=date('Y-m-d');
          $valTime=date("G:i");
        }
        echo '<div dojoType="dijit.form.DateTextBox" ';
        echo $name;
        echo $attributes;
        echo ' invalidMessage="' . i18n('messageInvalidDate') . '"'; 
        echo ' type="text" maxlength="10" ';
        //echo ' constraints="{datePattern:\'yy-MM-dd\'}" ';
        echo ' style="width:' . $dateWidth . 'px; text-align: center;" class="input" ';
        echo ' value="' . $valDate . '" ';
        echo ' >';
        echo $colScript;
        echo '</div>';
         echo '<div dojoType="dijit.form.TimeTextBox" ';
        echo $nameBis;
        echo $attributes;
        echo ' invalidMessage="' . i18n('messageInvalidTime') . '"'; 
        echo ' type="text" maxlength="5" ';
        //echo ' constraints="{datePattern:\'yy-MM-dd\'}" ';
        echo ' style="width:' . round($dateWidth * 0.66) . 'px; text-align: center;" class="input" ';
        echo ' value="T' . $valTime . '" ';
        echo ' >';
        echo $colScript;
        echo '</div>';      
      } else if ($dataType=='time') {
        // Draw a date ======================================================== TIME
        if ($col=='creationTime' and ($val=='' or $val==null) and ! $obj->id) {
          $val=date("G:i");
        }
        echo '<div dojoType="dijit.form.TimeTextBox" ';
        echo $name;
        echo $attributes;
        echo ' invalidMessage="' . i18n('messageInvalidTime') . '"'; 
        echo ' type="text" maxlength="' . $dataLength . '" ';
        //echo ' constraints="{datePattern:\'yy-MM-dd\'}" ';
        echo ' style="width:' . $dateWidth . 'px; text-align: center;" class="input" ';
        echo ' value="T' . $val . '" ';
        echo ' >';
        echo $colScript;
        echo '</div>';
      } else if ($dataType=='int' and $dataLength==1) {
        // Draw a boolean (as a checkbox ====================================== BOOLEAN
        echo '<div dojoType="dijit.form.CheckBox" type="checkbox" ';
        echo $name;
        echo $attributes;
        //echo ' value="' . $col . '" ' ;
        if ($val!='0' and ! $val==null) { echo 'checked'; }
        echo ' >';
        echo $colScript;
        echo '</div>';
      } else if (substr($col,0,2)=='id' and $dataType=='int' and strlen($col)>2 
                 and substr($col,2,1)==strtoupper(substr($col,2,1))) {
        // Draw a reference to another object (as combo box) ================== IDxxxxx => ComboBox
        if ($col=='idProject') {
          if ($obj->id==null) {
            if (array_key_exists('project',$_SESSION)) {
              $val=$_SESSION['project'];
            }
            $accessRight=securityGetAccessRight('menu' . $classObj, 'create');
          } else {
            $accessRight=securityGetAccessRight('menu' . $classObj, 'update');
          }
          if ( securityGetAccessRight('menu' . $classObj, 'read')=='PRO') { 
            $isRequired=true;
          }
        }
        echo '<select dojoType="dijit.form.FilteringSelect" class="input" '; 
        echo '  style="width: ' . $fieldWidth . 'px;"';
        echo $name;
        echo $attributes;
        echo ' >';
        htmlDrawOptionForReference($col, $val, $obj, $isRequired);
        echo $colScript;
        echo '</select>';
      } else if ($dataType=='int' or $dataType=='decimal'){
        // Draw a number field ================================================ NUMBER
        $spl=explode(',',$dataLength);
        $dec=0;
        if (count($spl)>1) {
          $dec=$spl[1];
        }
        $ent=$spl[0]-$dec;
        $max=substr('99999999999999999999',0,$ent);
        //$pattern="'" . substr('###################',0,$ent-1) . '0';
        //if ($dec) {
        //  $pattern=$pattern . "." . substr('000000000000000000000',0,$dec);
        //}       
        //$pattern.="'";
        //echo $ent . " " . $dec . " " . $max;
        echo '<div dojoType="dijit.form.NumberTextBox" ';
        echo $name;
        echo $attributes;
        echo ' style="width: ' . $fieldWidth . 'px;" ';
        echo ' constraints="{min:-' . $max . ',max:' . $max . '}" ';
        echo ' class="input" ';
        echo ' value="' . htmlEncode($val) . '" ';
        echo ' >';
        echo $colScript;
        echo '</div>';        
      } else if ($dataLength > 100 and ! array_key_exists('testingMode', $_REQUEST)){
        // Draw a long text (as a textarea) =================================== TEXTAREA
        echo '<textarea dojoType="dijit.form.Textarea" ';
        echo ' onKeyPress="if (isUpdatableKey(event.keyCode)) {formChanged();}" '; // hard coding default event
        echo $name;
        echo $attributes;
        echo '  style="width: ' . $largeWidth . 'px;" ';
        echo ' maxlength="' . $dataLength . '" ';
        echo ' class="input" ' . '>';
        echo htmlEncode($val, 'none');
        //echo $colScript; // => this leads to the display of script in textarea
        echo '</textarea>';
      } else {
        // Draw defaut data (text medium size) ================================ TEXT (default)
        if ($obj->isFieldTranslatable($col)) {
          $fieldWidth = $fieldWidth / 2;
        }
        echo '<div type="text" dojoType="dijit.form.ValidationTextBox" ';
        echo $name;
        echo $attributes;
        echo '  style="width: ' . $fieldWidth . 'px;" ';
        echo ' trim="true" maxlength="' . $dataLength . '" class="input" ';
        echo ' value="' . htmlEncode($val) . '" ';
        if ($obj->isFieldTranslatable($col)) {
          echo ' title="' . i18n("msgTranslatable") . '" ';
        }
        echo ' >';
        echo $colScript;
        echo '</div>';
        if ($obj->isFieldTranslatable($col)) {
          echo '<div dojoType="dijit.form.TextBox" type="text"  ';
          echo ' class="display" ';
          echo ' readonly style="width: ' . $fieldWidth . 'px;" ' ;
          echo ' title="' . i18n("msgTranslation") . '" ';
          echo ' value="' . htmlEncode(i18n($val)) . '" ></div>';
        } 
      }
      if ($internalTable>0) {
        $internalTable--;
        if ($internalTable==0) {
          echo "</td></tr></table><table>";
        }
      } else {
        if ($internalTable==0 and !$hide and !$nobr) {
            echo '</td></tr>' . $cr;
        }
      }
    }
  }
  if ( ! $included) {
    if ($currentCol==0) {
      echo '</table>';
    } else {
      echo '</table></td></tr></table>';
    }
  }
 
}

function drawHistoryFromObjects($refresh=false) {
  global $cr, $print, $treatedObjects;
  $inList="( ('x',0)"; // initialize with non existing element, to avoid error if 1 only object involved
  foreach($treatedObjects as $obj) {
    //$inList.=($inList=='')?'(':', ';
    $inList.=", ('" . get_class($obj) . "', '" . $obj->id . "')";
  }
  $inList.=')';
  $where = ' (refType, refId) in ' . $inList;
  $order = ' operationDate desc, id asc';
  $hist=new History();
  $historyList=$hist->getSqlElementsFromCriteria(null,false,$where,$order);
  echo '<table width="100%">';
  echo '<tr>';
  echo '<td class="historyHeader" width="20%">' . i18n('colDate') . '</td>';
  echo '<td class="historyHeader" width="15%">' . i18n('colUser'). '</td>';
  echo '<td class="historyHeader" width="10%">' . i18n('colOperation'). '</td>';
  echo '<td class="historyHeader" width="15%">' . i18n('colColumn'). '</td>';
  echo '<td class="historyHeader" width="20%">' . i18n('colValueBefore'). '</td>';
  echo '<td class="historyHeader" width="20%">' . i18n('colValueAfter'). '</td>';
  echo '</tr>';
  $stockDate=null;
  $stockUser=null;
  $stockOper=null;
  foreach($historyList as $hist) {
    $colName=($hist->colName==null)?'':$hist->colName;
    $curObj=null; $dataType=""; $dataLength=0;
    $hide=false;
    $oper=i18n('operation' . ucfirst($hist->operation) );
    $user=$hist->idUser;
    $user=SqlList::getNameFromId('User',$user);
    $date=htmlFormatDateTime($hist->operationDate);
    $class="NewOperation";
    if ($stockDate==$hist->operationDate 
    and $stockUser==$hist->idUser
    and $stockOper==$hist->operation) {
      $oper="";
      $user="";
      $date="";
      $class="ContinueOperation";
    }
    if ($colName!='') {
      $curObj=new $hist->refType();
      if ($curObj) {
        $colCaption=$curObj->getColCaption($hist->colName);
        $dataType=$obj->getDataType($colName);
        $dataLength=$obj->getDataLength($colName);
        if (strpos($curObj->getFieldAttributes($colName), 'hidden')!==false) {
          $hide=true;
        }
      }
    } else {
      $colCaption='';
    }
    if (substr($hist->refType,-15)=='PlanningElement' and $hist->operation=='insert') {
      $hide=true;
    }
    if (! $hide) {
      echo '<tr>';
      echo '<td class="historyData'. $class .'">' . $date . '</td>';
      echo '<td class="historyData'. $class .'">' . $user . '</td>';
      echo '<td class="historyData'. $class .'">' . $oper . '</td>';
      
      echo '<td class="historyData">' . $colCaption . '</td>';
      $oldValue=$hist->oldValue;
      $newValue=$hist->newValue;
      if ($dataType=='int' and $dataLength==1) { // boolean
        $oldValue=htmlDisplayCheckbox($oldValue);
        $newValue=htmlDisplayCheckbox($newValue);
      } else if (substr($colName,0,2)=='id' and strlen($colName)>2
                 and strtoupper(substr($colName,2,1))==substr($colName,2,1)) {
        if ($oldValue!=null and $oldValue!='') {
          $oldValue=SqlList::getNameFromId(substr($colName,2),$oldValue);
        }
        if ($newValue!=null and $newValue!='') {
          $newValue=SqlList::getNameFromId(substr($colName,2),$newValue);
        }
      } else if ($colName=="color") {
        $oldValue=htmlDisplayColored("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$oldValue);
        $newValue=htmlDisplayColored("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$newValue);
      } else {
        $oldValue=htmlEncode($oldValue,'print');
        $newValue=htmlEncode($newValue,'print');
      }
      
      echo '<td class="historyData">' . $oldValue . '</td>';
      echo '<td class="historyData">' . $newValue . '</td>';
      echo '</tr>';
      $stockDate=$hist->operationDate;
      $stockUser=$hist->idUser;
      $stockOper=$hist->operation;
    }
  }
  echo '<tr>';
  echo '<td class="historyDataClosetable">&nbsp;</td>';
  echo '<td class="historyDataClosetable">&nbsp;</td>';
  echo '<td class="historyDataClosetable">&nbsp;</td>';
  echo '<td class="historyDataClosetable">&nbsp;</td>';
  echo '<td class="historyDataClosetable">&nbsp;</td>';
  echo '<td class="historyDataClosetable">&nbsp;</td>';
  echo '</tr>';
  echo '</table>';
}

function drawNotesFromObject($obj, $refresh=false) {
  global $cr, $print, $user;
  $canUpdate=securityGetAccessRightYesNo('menu' . get_class($obj), 'update', $obj)=="YES";
  if ($obj->idle==1) {$canUpdate=false;}
  if (isset($obj->_Note)) {
    $notes=$obj->_Note;
  } else {
    $notes=array();
  }   
  echo '<table width="100%">';
  echo '<tr>';
  if (! $print) {
    echo '<td class="noteHeader" width="5%">';
    if ($obj->id!=null and ! $print and $canUpdate) {
      echo '<img src="css/images/smallButtonAdd.png" onClick="addNote();" title="' . i18n('addNote') . '" class="smallButton"/> ';
    }
    echo '</td>';
  }
  echo '<td class="noteHeader" width="5%">' . i18n('colId') . '</td>';
  echo '<td class="noteHeader" width="20%">' . i18n('colDate') . '</td>';
  echo '<td class="noteHeader" width="15%">' . i18n('colUser'). '</td>';
  echo '<td class="noteHeader" width="55%">' . i18n('colNote'). '</td>';
  echo '</tr>';
  foreach($notes as $note) {
    $userId=$note->idUser;
    $userName=SqlList::getNameFromId('User',$userId);
    $creationDate=$note->creationDate;
    $updateDate=$note->updateDate;
    if ($updateDate==null) {$updateDate='';}
    echo '<tr>';
    if (! $print) {
      echo '<td class="noteData" style="text-align:center;">';
      if ($note->idUser==$user->id and ! $print and $canUpdate) {
        echo ' <img src="css/images/smallButtonEdit.png" onClick="editNote(' . $note->id . ');" title="' . i18n('editNote') . '" class="smallButton"/> ';
        echo ' <img src="css/images/smallButtonRemove.png" onClick="removeNote(' . $note->id . ');" title="' . i18n('removeNote') . '" class="smallButton"/> ';
      }
      echo '</td>';
    }
    echo '<td class="noteData">#' . $note->id  . '</td>';
    echo '<td class="noteData">' . htmlFormatDateTime($creationDate) . '<br/><i>' . htmlFormatDateTime($updateDate) . '</i></td>';
    echo '<td class="noteData">' . $userName . '</td>';
    echo '<td class="noteData">';
    echo '<input type="hidden" id="note_' . $note->id . '" value="' . htmlEncode($note->note,'none') .'"/>';
    echo htmlEncode($note->note,'print'); 
    echo '</td>';
    echo '</tr>';
  }
  echo '<tr>';
  if (! $print) {
    echo '<td class="noteDataClosetable">&nbsp;</td>';
  }
  echo '<td class="noteDataClosetable">&nbsp;</td>';
  echo '<td class="noteDataClosetable">&nbsp;</td>';
  echo '<td class="noteDataClosetable">&nbsp;</td>';
  echo '<td class="noteDataClosetable">&nbsp;</td>';
  echo '</tr>';
  echo '</table>';
}

function drawAttachementsFromObject($obj, $refresh=false) {
  global $cr, $print, $user;
  $canUpdate=securityGetAccessRightYesNo('menu' . get_class($obj), 'update', $obj)=="YES";
  if ($obj->idle==1) {$canUpdate=false;}
  if (isset($obj->_Attachement)) {
    $attachements=$obj->_Attachement;
  } else {
    $attachements=array();
  }   
  echo '<table width="100%">';
  echo '<tr>';
  if (! $print) {
    echo '<td class="attachementHeader" width="5%">';
    if ($obj->id!=null and ! $print and $canUpdate) {
      echo '<img src="css/images/smallButtonAdd.png" onClick="addAttachement();" title="' . i18n('addAttachement') . '" class="smallButton"/> ';
    }
    echo '</td>';
  }
  echo '<td class="attachementHeader" width="5%">' . i18n('colId') . '</td>';
  echo '<td class="attachementHeader" width="20%">' . i18n('colDate') . '</td>';
  echo '<td class="attachementHeader" width="15%">' . i18n('colUser'). '</td>';
  echo '<td class="attachementHeader" width="10%">' . i18n('colType'). '</td>';
  echo '<td class="attachementHeader" width="10%">' . i18n('colSize'). '</td>';
  echo '<td class="attachementHeader" width="35%">' . i18n('colFile'). '</td>';
  echo '</tr>';
  foreach($attachements as $attachement) {
    $userId=$attachement->idUser;
    $userName=SqlList::getNameFromId('User',$userId);
    $creationDate=$attachement->creationDate;
    echo '<tr>';
    if (! $print) {
      echo '<td class="attachementData" style="text-align:center;">';
      if ($attachement->fileName and $attachement->subDirectory and ! $print) {
        echo '<a href="../tool/download.php?class=Attachement&id='. $attachement->id . '"'; 
        echo ' target="printFrame" title="' . i18n('helpDownload') . '"><img src="css/images/smallButtonDownload.png" /></a>';
      }
      if ($attachement->idUser==$user->id and ! $print and $canUpdate) {
        echo ' <img src="css/images/smallButtonRemove.png" onClick="removeAttachement(' . $attachement->id . ');" title="' . i18n('removeAttachement') . '" class="smallButton"/>';
      }
      echo '</td>';
    }
    echo '<td class="attachementData">#' . $attachement->id  . '</td>';
    echo '<td class="attachementData">' . htmlFormatDateTime($creationDate) . '<br/></td>';
    echo '<td class="attachementData">' . $userName . '</td>';
    echo '<td class="attachementData">' . htmlGetMimeType($attachement->mimeType) . '</td>';
    echo '<td class="attachementData">' . htmlGetFileSize($attachement->fileSize) . '</td>';
    echo '<td class="attachementData" title="' . $attachement->description . '">';
    echo '<table><tr >';
    echo ' <td>';
    echo htmlEncode($attachement->fileName,'print'); 
    echo ' </td>';
    if ($attachement->description) {
      echo '<td>&nbsp;&nbsp;<img src="img/note.png" /></td>';
    }
    echo '</tr></table>';
    echo '</td>';
    echo '</tr>';
  }
  echo '<tr>';
  if (! $print) {
    echo '<td class="attachementDataClosetable">&nbsp;</td>';
  }
  echo '<td class="attachementDataClosetable">&nbsp;</td>';
  echo '<td class="attachementDataClosetable">&nbsp;</td>';
  echo '<td class="attachementDataClosetable">&nbsp;</td>';
  echo '<td class="attachementDataClosetable">&nbsp;</td>';
  echo '<td class="attachementDataClosetable">&nbsp;</td>';
  echo '<td class="attachementDataClosetable">&nbsp;</td>';
  echo '</tr>';
  echo '</table>';
}

function drawLinksFromObject($list, $obj, $classLink, $refresh=false) {
  global $cr, $print, $user;
  $canUpdate=securityGetAccessRightYesNo('menu' . get_class($obj), 'update', $obj)=="YES";
  if ($obj->idle==1) {$canUpdate=false;}
  echo '<tr><td colspan=2 style="width:100%;"><table style="width:100%;">';
  echo '<tr>';
  if (! $print) {
    echo '<td class="linkHeader" width="5%">';
    if ($obj->id!=null and ! $print and $canUpdate) {
      echo '<img src="css/images/smallButtonAdd.png" onClick="addLink(' . "'" . $classLink  . "'" . ');" title="' . i18n('addLink') . '" class="smallButton"/> ';
    }
    echo '</td>';
  }
  if ( ! $classLink ) {
    echo '<td class="linkHeader" width="10%">' . i18n('colType') . '</td>';
  }
  echo '<td class="linkHeader" width="5%">' . i18n('colId') . '</td>';
  echo '<td class="linkHeader" width="65%">' . i18n('colName') . '</td>';
  echo '<td class="linkHeader" width="15%">' . i18n('colIdStatus'). '</td>';
  echo '</tr>';
  foreach($list as $link) {
    $linkObj=null;
    if ($link->ref1Type==get_class($obj) and $link->ref1Id==$obj->id) {
      $linkObj=new $link->ref2Type($link->ref2Id);
    } else {
      $linkObj=new $link->ref1Type($link->ref1Id);
    }
    echo '<tr>';
    if (! $print) {
      echo '<td class="linkData" style="text-align:center;">';
      if ($canUpdate) {
        echo '  <img src="css/images/smallButtonRemove.png" onClick="removeLink(' . "'" . $link->id . "','" . get_class($linkObj) . "','" . $linkObj->id . "'" . ');" title="' . i18n('removeLink') . '" class="smallButton"/> ';
      }
      echo '</td>';
    }
    if ( ! $classLink ) {
      echo '<td class="linkData">' . i18n(get_class($linkObj)) . '</td>';
    }
    echo '<td class="linkData">#' . $linkObj->id  . '</td>';
    echo '<td class="linkData">' . $linkObj->name . '</td>';
    $objStatus=new Status($linkObj->idStatus);
    $color=$objStatus->color;
    $foreColor=getForeColor($color);
    echo '<td class="linkData"><table width="100%"><tr><td style="background-color: ' . $objStatus->color . '; color:' . $foreColor . ';width: 100%;">' . $objStatus->name . '</td></tr></table></td>';
    echo '</tr>';
  }
  /*echo '<tr>';
  if (! $print) {
    echo '<td class="linkDataClosetable">&nbsp;</td>';
  }
  if ( ! $classLink ) {
    echo '<td class="linkDataClosetable">&nbsp;</td>';
  }
  echo '<td class="linkDataClosetable">&nbsp;</td>';
  echo '<td class="linkDataClosetable">&nbsp;</td>';
  echo '<td class="linkDataClosetable">&nbsp;</td>';
  echo '</tr>';*/
  echo '</table></td></tr>';
}

function drawDependenciesFromObject($list, $obj, $depType, $refresh=false) {
  global $cr, $print, $user;
  $canUpdate=securityGetAccessRightYesNo('menu' . get_class($obj), 'update', $obj)=="YES";
  if ($obj->idle==1) {$canUpdate=false;}
  echo '<tr><td colspan=2 style="width:100%;"><table style="width:100%;">';
  echo '<tr>';
  if (! $print) {
    echo '<td class="dependencyHeader" width="5%">';
    if ($obj->id!=null and ! $print and $canUpdate) {
      echo '<img src="css/images/smallButtonAdd.png" onClick="addDependency(' . "'" . $depType . "'" . ');" title="' . i18n('addDependency' . $depType) . '" class="smallButton"/> ';
    }
    echo '</td>';
  }
  echo '<td class="dependencyHeader" width="15%">' . i18n('colType') . '</td>';
  echo '<td class="dependencyHeader" width="5%">' . i18n('colId') . '</td>';
  echo '<td class="dependencyHeader" width="60%">' . i18n('colName') . '</td>';
  echo '<td class="dependencyHeader" width="15%">' . i18n('colIdStatus'). '</td>';
  echo '</tr>';
  foreach($list as $dep) {
    $depObj=null;
    if ($dep->predecessorRefType==get_class($obj) and $dep->predecessorRefId==$obj->id) {
      $depObj=new $dep->successorRefType($dep->successorRefId);
      //$depType="Successor";
    } else {
      $depObj=new $dep->predecessorRefType($dep->predecessorRefId);
      //$depType="Predecessor";
    }
    echo '<tr>';
    if (! $print) {
      echo '<td class="dependencyData" style="text-align:center;">';
      if ($canUpdate) {
        echo '  <img src="css/images/smallButtonRemove.png" onClick="removeDependency(' . "'" . $dep->id . "','" . get_class($depObj) . "','" . $depObj->id . "'" . ');" title="' . i18n('removeDependency' . $depType) . '" class="smallButton"/> ';
      }
      echo '</td>';
    }
    echo '<td class="dependencyData">' . i18n(get_class($depObj)) . '</td>';
    echo '<td class="dependencyData">#' . $depObj->id  . '</td>';
    echo '<td class="dependencyData">' . $depObj->name . '</td>';
    if (property_exists($depObj,'idStatus')) {
      $objStatus=new Status($depObj->idStatus);
    } else {
      $objStatus=new Status();
    }
    $color=$objStatus->color;
    $foreColor=getForeColor($color);
    echo '<td class="dependencyData"><table width="100%"><tr><td style="background-color: ' . $objStatus->color . '; color:' . $foreColor . ';width: 100%;">' . $objStatus->name . '</td></tr></table></td>';
    echo '</tr>';
  }
  echo '</table></td></tr>';
}

function drawAssignmentsFromObject($list, $obj, $refresh=false) {
  global $cr, $print, $user, $browserLocale;
  $canUpdate=securityGetAccessRightYesNo('menu' . get_class($obj), 'update', $obj)=="YES";
  if ($obj->idle==1) {$canUpdate=false;}
  echo '<tr><td colspan=2 style="width:100%;"><table style="width:100%;">';
  echo '<tr>';
  if (! $print) {
    echo '<td class="assignHeader" width="10%">';
    if ($obj->id!=null and ! $print and $canUpdate and !$obj->idle) {
      echo '<img src="css/images/smallButtonAdd.png" onClick="addAssignment();" title="' . i18n('addAssignment') . '" class="smallButton"/> ';
    }
    echo '</td>';
  }
  echo '<td class="assignHeader" width="40%">' . i18n('colIdResource') . '</td>';
  echo '<td class="assignHeader" width="14%">' . i18n('colRate'). '</td>';
  echo '<td class="assignHeader" width="12%">' . i18n('colAssigned'). '</td>';
  echo '<td class="assignHeader" width="12%">' . i18n('colReal'). '</td>';
  echo '<td class="assignHeader" width="12%">' . i18n('colLeft'). '</td>';
  
  echo '</tr>';
  $fmt = new NumberFormatter52( $browserLocale, NumberFormatter52::DECIMAL );
  foreach($list as $assignment) {
    echo '<tr>';
    if (! $print) {
      echo '<td class="assignData" style="text-align:center;">';
      if ($canUpdate and ! $print) {
        echo '  <img src="css/images/smallButtonEdit.png" ' 
        . 'onClick="editAssignment(' . "'" . $assignment->id . "'" 
        . ",'" . $assignment->idResource . "'"
        . ",'" . $assignment->rate . "'"
        . ",'" . $fmt->format($assignment->assignedWork) . "'"
        . ",'" . $fmt->format($assignment->realWork) . "'"
        . ",'" . $fmt->format($assignment->leftWork) . "'"
        . ",'" . htmlEncodeJson($assignment->comment) . "'"    
        . ');" ' 
        . 'title="' . i18n('editAssignment') . '" class="smallButton"/> ';      
      }
      if ($assignment->realWork==0 and $canUpdate and ! $print)  {
        echo '  <img src="css/images/smallButtonRemove.png" ' 
        . 'onClick="removeAssignment(' . "'" . $assignment->id . "','" 
               . $assignment->realWork . "','" 
               . SqlList::getNameFromId('Resource', $assignment->idResource)  . "'" . ');" ' 
        . 'title="' . i18n('removeAssignment') . '" class="smallButton"/> ';
      }
      echo '</td>';
    }
    echo '<td class="assignData" title="' . htmlEncodeJson($assignment->comment) . '">'; 
    echo '<table><tr>';
    echo '<td>' . SqlList::getNameFromId('Resource', $assignment->idResource) . '</td>';
    if ($assignment->comment) {
     echo '<td>&nbsp;&nbsp;<img src="img/note.png" /></td>';
    }
    echo '</tr></table>';
    echo '</td>';
    echo '<td class="assignData" align="center">' . $assignment->rate  . '</td>';
    echo '<td class="assignData" align="right">' . $fmt->format($assignment->assignedWork)  . '</td>';
    echo '<td class="assignData" align="right">' . $fmt->format($assignment->realWork)  . '</td>';
    echo '<td class="assignData" align="right">' . $fmt->format($assignment->leftWork)  . '</td>';
    echo '</tr>';
  }
  echo '</table></td></tr>';
}

// fetch information depending on, request
$objClass=$_REQUEST['objectClass'];
if (! isset($noselect)) { 
  $noselect=false; 
} 
if ( $noselect ) {
  $objId="";
  $obj=null;
} else {
  $objId=$_REQUEST['objectId'];
  $obj=new $objClass($objId);
  if ( array_key_exists('refreshNotes',$_REQUEST) ) {
    drawNotesFromObject($obj, true);
    exit;
  }
  if ( array_key_exists('refreshAttachements',$_REQUEST) ) {
    drawAttachementsFromObject($obj, true);
    exit;
  }
  if ( array_key_exists('refreshAssignment',$_REQUEST) ) {
    drawAttachementsFromObject($obj, true);
    exit;
  }
  if ( array_key_exists('refreshHistory',$_REQUEST) ) {
    $treatedObjects[]=$obj;
    foreach ($obj as $col => $val) {
      if (is_object($val)) {
        $treatedObjects[]=$val;
      }
    }    
    drawHistoryFromObjects(true);
    exit;
  }  
}

// save the current object in session
$_SESSION['currentObject']=$obj;
$print=false;
if ( array_key_exists('print',$_REQUEST) ) {
  $print=true;
}
$refresh=false;
if ( array_key_exists('refresh',$_REQUEST) ) {
  $refresh=true;
}

$treatedObjects=array();

$displayWidth='98%';
if (array_key_exists('destinationWidth',$_REQUEST)) {
  $width=$_REQUEST['destinationWidth'];
  $width-=30;
  $displayWidth=$width . 'px';
} else {
  if (array_key_exists('screenWidth',$_SESSION)) {
    $detailWidth = round(($_SESSION['screenWidth'] * 0.8) - 15) ; // 80% of screen - split barr - padding (x2)
  } else {
    $displayWidth='98%';
  } 
}
if ($print) {
  $displayWidth='800px'; // must match iFrmae size (see main.php)
}

// New refresh method
if ( array_key_exists('refresh',$_REQUEST) ) {
  echo '<input type="hidden" id="className" name="className" value="' . $objClass . '" />' . $cr;  
  drawTableFromObject($obj);
  exit;
}
?>

<div dojoType="dijit.layout.BorderContainer" >
  <?php 
  if ( ! $refresh and  ! $print) { ?>
    <div id="buttonDiv" dojoType="dijit.layout.ContentPane" region="top" >
      <div dojoType="dijit.layout.BorderContainer" >
        <div id="buttonDivContainer" dojoType="dijit.layout.ContentPane" region="left" >
          <?php  include 'objectButtons.php'; ?>
        </div>
        <div id="resultDiv" dojoType="dijit.layout.ContentPane" region="center" >       
        </div> 
      </div>
    </div>
    <div id="formDiv" dojoType="dijit.layout.ContentPane" region="center" >
  <?php 
  }
  if ( ! $print) { ?>
      <form dojoType="dijit.form.Form" id="objectForm" jsId="objectForm" name="objectForm" encType="multipart/form-data" action="" method="" >
        <script type="dojo/method" event="onSubmit" >
        // Don't do anything on submit, just cancel : no button is default => must click
        //alert("OK");
		//submitForm("../tool/saveObject.php","resultDiv", "objectForm", true);
		return false;        
        </script>
        <div id="detailFormDiv" dojoType="dijit.layout.ContentPane" region="top" >       
  <?php 
  }
  $noData=htmlGetNoDataMessage($objClass); 
  if ( $noselect) {
    echo $noData;
  } else {
    echo '<input type="hidden" id="className" name="className" value="' . $objClass . '" />' . $cr;  
    drawTableFromObject($obj); 
  }
  if ( ! $print ) { ?>
      </div>
      </form>
  <?php
  }
  $displayAttachement='YES_OPENED';
  if (array_key_exists('displayAttachement',$_SESSION)) {
    $displayAttachement=$_SESSION['displayAttachement'];
  }
  if (isset($obj->_Attachement) and $isAttachementEnabled) { ?>
    <br/>
    <?php if ($print) {?>
    <table width="100%">
      <tr><td class="section"> <?php echo i18n('sectionAttachements');?> </td></tr>
      <tr><td>
      <?php drawAttachementsFromObject($obj); ?>
      </td></tr>
    </table>
    <?php } else { ?>
    <div id="attachementsPane" style="width: <?php echo $displayWidth;?>" dojoType="dijit.TitlePane" 
     title="<?php echo i18n('sectionAttachements');?>"
     <?php $openMode=($displayAttachement=='YES_OPENED')?'true':'false'; ?>
     open="<?php echo $openMode; ?>" > 
     <?php drawAttachementsFromObject($obj); ?>
    </div>
    <?php }?>
  <?php    
  }
  $displayNote='YES_OPENED';
  if (array_key_exists('displayNote',$_SESSION)) {
    $displayNote=$_SESSION['displayNote'];
  }
  if (isset($obj->_Note)) { ?>
    <br/>
    <?php if ($print) {?>
    <table width="100%">
      <tr><td class="section"> <?php echo i18n('sectionNotes');?> </td></tr>
      <tr><td>
      <?php drawNotesFromObject($obj); ?>
      </td></tr>
    </table>
    <?php } else { ?>
    <div id="notesPane" style="width: <?php echo $displayWidth;?>" dojoType="dijit.TitlePane" 
     title="<?php echo i18n('sectionNotes');?>"
     <?php $openMode=($displayNote=='YES_OPENED')?'true':'false'; ?>
     open="<?php echo $openMode; ?>" > 
     <?php drawNotesFromObject($obj); ?>
    </div>
    <?php }?>
  <?php    
  }
  $displayHistory='NO';
  if (! $print and array_key_exists('displayHistory',$_SESSION)) {
    $displayHistory=$_SESSION['displayHistory'];
  }
  if (  ( ! $noselect) and $displayHistory != 'NO') { 
    echo '<br/>';
    ?>
      <div id="historyPane" style="width: <?php echo $displayWidth;?>;" dojoType="dijit.TitlePane" 
       title="<?php echo i18n('elementHistoty');?>"
       <?php $openMode=($displayHistory=='YES_OPENED')?'true':'false'; ?>
        open="<?php echo $openMode; ?>" >
        <?php drawHistoryFromObjects();?>
      </div>
      <br/>
  <?php 
  } 
  if ( ! $refresh and  ! $print) { ?>
    </div>
  <?php 
  }?>   

</div>
