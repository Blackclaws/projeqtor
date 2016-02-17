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

include_once("../tool/projeqtor.php");

if (! array_key_exists('objectClass',$_REQUEST)) {
  throwError('Parameter objectClass not found in REQUEST');
}
$objectClass=$_REQUEST['objectClass'];
Security::checkValidClass($objectClass);

if (! array_key_exists('objectId',$_REQUEST)) {
  throwError('Parameter objectId not found in REQUEST');
}
$objectId=$_REQUEST['objectId'];
Security::checkValidId($objectId);

$structureId=null;
if (array_key_exists('structureId',$_REQUEST)) {
  $structureId=$_REQUEST['structureId'];
  Security::checkValidId($structureId);
}
if ($objectClass=='ProductVersion') {
  $listClass='ComponentVersion';
} else if ($objectClass=='ComponentVersion') {
  $listClass='ProductVersion';
} else {
  errorLog("Unexpected objectClass $objectClass");
  echo "Unexpected objectClass";
  exit;
}
?>
<table>
  <tr>
    <td>
      <form id='productVersionStructureForm' name='productVersionStructureForm' onSubmit="return false;">
        <input id="productVersionStructureObjectClass" name="productVersionStructureObjectClass" type="hidden" value="<?php echo $objectClass;?>" />
        <input id="productVersionStructureObjectId" name="productVersionStructureObjectId" type="hidden" value="<?php echo $objectId;?>" />
        <input id="productVersionStructureListClass" name="productVersionStructureListClass" type="hidden" value="<?php echo $listClass;?>" />
        <table>
          <tr>
            <td class="dialogLabel"  >
              <label for="productVersionStructureListId" ><?php echo i18n($listClass) ?>&nbsp;:&nbsp;</label>
            </td>
            <td>
              <select size="14" id="productVersionStructureListId" name="productVersionStructureListId[]""
                multiple class="selectList" onchange="enableWidget('dialogProductVersionStructureSubmit');"  ondblclick="saveProductVersionStructure();" value="">
                  <?php htmlDrawOptionForReference('id'.$listClass, null, null, true, 'id'.$objectClass, $objectId);?>
              </select>
            </td>
            <td style="vertical-align: top">
              <button id="productVersionStructureDetailButton" dojoType="dijit.form.Button" showlabel="false"
                title="<?php echo i18n('showDetail')?>"
                iconClass="iconView">
                <script type="dojo/connect" event="onClick" args="evt">
                <?php $canCreate=securityGetAccessRightYesNo('menu'.$listClass, 'create') == "YES"; ?>
                showDetail('productVersionStructureListId', <?php echo $canCreate;?>, '<?php echo $listClass;?>', true);
                </script>
              </button>
            </td>
          </tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>  
        </table>
        <table>  
          <tr>
            <td class="dialogLabel" >
              <label for="productVersionStructureComment" ><?php echo i18n("colComment") ?>&nbsp;:&nbsp;</label>
            </td>
            <td>
              <textarea dojoType="dijit.form.Textarea"
                id="productVersionStructureComment" name="productVersionStructureComment"
                style="width: 400px;"
                maxlength="4000"
                class="input"></textarea>
            </td>
          </tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td align="center">
      <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogProductVersionStructure').hide();">
        <?php echo i18n("buttonCancel");?>
      </button>
      <button class="mediumTextButton" disabled dojoType="dijit.form.Button" type="submit" id="dialogProductVersionStructureSubmit" onclick="protectDblClick(this);saveProductVersionStructure();return false;">
        <?php echo i18n("buttonOK");?>
      </button>
    </td>
  </tr>
</table>