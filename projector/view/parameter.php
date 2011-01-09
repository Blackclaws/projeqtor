<?php
/* ============================================================================
 * List of parameter specific to a user.
 * Every user may change these parameters (for his own user only !).
 */
  require_once "../tool/projector.php";
  scriptLog('   ->/view/parameter.php');
  
  $type=$_REQUEST['type'];
  $criteriaRoot=array();
  $user=$_SESSION['user'];
      
  $parameterList=Parameter::getParamtersList($type);
  switch ($type) {
    case ('userParameter'):
      $criteriaRoot['idUser']=$user->id;
      $criteriaRoot['idProject']=null;
      break;
    case ('projectParameter'):
      $criteriaRoot['idUser']=null; 
      $criteriaRoot['idProject']=null;
      break;
    case ('globalParameter'):
      $criteriaRoot['idUser']=null; 
      $criteriaRoot['idProject']=null; 
      break;
  }
  
  /** =========================================================================
   * Design the html tags for parameter page depending on list of paramters
   * defined in $parameterList
   * @param $objectList array of parameters with format
   * @return void
   */
  function drawTableFromObjectList($objectList) {
    global $criteriaRoot, $type;
    echo '<table>';
    foreach($objectList as $code => $format) { 
      $criteria=$criteriaRoot;
      $criteria['parameterCode']=$code;
      // fetch the parameter saved in Database
      $obj=SqlElement::getSingleSqlElementFromCriteria('Parameter', $criteria);
      if ($type=='userParameter') { // user parameters may be stored in session
        if (array_key_exists($code,$_SESSION) ) {
          $obj->parameterValue=$_SESSION[$code];
        }
      }
      echo '<tr><td class="label"><label for="' . $code . '" title="' . i18n('help' . ucfirst($code)) . '">' . i18n('param' . ucfirst($code) ) . ' :&nbsp;</label></td><td>';
      if ($format=='list') {
        $listValues=Parameter::getList($code);
        echo '<select dojoType="dijit.form.FilteringSelect" class="input" name="' . $code . '" id="' . $code . '" ';
        echo ' title="' . i18n('help' . ucfirst($code)) . '">';
        if ($type=='userParameter') {
          echo $obj->getValidationScript($code);
        } 
        foreach ($listValues as $value => $valueLabel ) {
          $selected = ($obj->parameterValue==$value)?'selected':'';
          echo '<option value="' . $value . '" ' . $selected . '>' . $valueLabel . '</option>';
        }
        echo '</select>';
      }
      echo '</td></tr>'; 
    }
    echo '</table>';
  }
?>

<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="parameterButtonDiv" class="dojoxGridRowSelected" dojoType="dijit.layout.ContentPane" region="top">
    <table width="100%">
      <tr>
        <td width="50px" align="center">
          <img src="css/images/icon<?php echo ucfirst($type);?>32.png" width="32" height="32" />
        </td>
        <td NOWRAP width="50px" class="title" >
          <?php echo str_replace(" ","&nbsp;",i18n('menu'.ucfirst($type)))?>&nbsp;&nbsp;&nbsp;
        </td>
        <td width="10px" >&nbsp;
        </td>
        <td width="50px"> 
          <button id="saveParameterButton" dojoType="dijit.form.Button" showlabel="false"
            title="<?php echo i18n('buttonSaveParameters');?>"
            iconClass="dijitEditorIcon dijitEditorIconSave" >
              <script type="dojo/connect" event="onClick" args="evt">
        	submitForm("../tool/saveParameter.php","resultDiv", "parameterForm", true);
          </script>
          </button>
          <div dojoType="dijit.Tooltip" connectId="saveButton"><?php echo i18n("buttonSaveParameter")?></div>
        </td>
        <td>
           <div id="resultDiv" dojoType="dijit.layout.ContentPane" region="center" >
           </div>       
        </td>
      </tr>
    </table>
  </div>
  <div id="formDiv" dojoType="dijit.layout.ContentPane" region="center"> 
    <form dojoType="dijit.form.Form" id="parameterForm" jsId="objectForm" name="objectForm" encType="multipart/form-data" action="" method="" >
      <input type="hidden" name="parameterType" value="<?php echo $type;?>" />
      <?php 
        if ($type=='habilitation') {
          htmlDrawCrossTable('menu', 'idMenu', 'profile', 'idProfile', 'habilitation', 'allowAccess', 'check') ;
        } else if ($type=='accessRight') {
          htmlDrawCrossTable('menuProject', 'idMenu', 'profile', 'idProfile', 'accessRight', 'idAccessProfile', 'list', 'accessProfile') ;
        } else if ($type=='habilitationReport') {
          htmlDrawCrossTable('report', 'idReport', 'profile', 'idProfile', 'habilitationReport', 'allowAccess', 'check') ;
        } else if ($type=='habilitationOther') {
          echo '<table width="100%"><tr><td class="section">' . i18n('sectionImputation') . '</td></tr></table>',
          htmlDrawCrossTable(array('imputation'=>i18n('imputationAccess')), 'scope', 'profile', 'idProfile', 'habilitationOther', 'rightAccess', 'list', 'accessScope') ;
          echo '<br/><br/>';
          echo '<table width="100%"><tr><td class="section">' . i18n('sectionWorkCost') . '</td></tr></table>',
          htmlDrawCrossTable(array('work'=>i18n('workAccess'),'cost'=>i18n('costAccess')), 'scope', 'profile', 'idProfile', 'habilitationOther', 'rightAccess', 'list', 'visibilityScope') ;
        } else {
          drawTableFromObjectList($parameterList);
        }
      ?>
    </form>
  </div>
</div>
