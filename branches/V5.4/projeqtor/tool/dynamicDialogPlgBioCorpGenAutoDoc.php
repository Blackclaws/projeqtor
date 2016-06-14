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
if (! array_key_exists('idProject',$_REQUEST)) {
	throwError('Parameter idProject not found in REQUEST');
}
$idProject=$_REQUEST['idProject'];

if (! array_key_exists('id',$_REQUEST)) {
	throwError('Parameter id not found in REQUEST');
}
$idExpense=$_REQUEST['id'];

$docList=SqlList::getList("DocumentType");
asort($docList);
$directoryList=SqlList::getList("DocumentDirectory");
asort($directoryList);
$directoryLocationList=SqlList::getList("DocumentDirectory","location");

$idDoc=-1;
$idDirectory=-1;
foreach ($directoryList as $id=>$cle){
  if($idDirectory==-1)$idDirectory=$id;
  if(!strpos("commande",strtolower($cle.$directoryLocationList[$id]))===false){
    $idDirectory=$directoryList[i]->id;
    break;
  }
}

foreach ($docList as $id=>$cle){
  if($idDoc==-1)$idDoc=$id;
  if(!strpos("commande",strtolower($cle))===false){
    $idDoc=$docList[i]->id;
    break;
  }
}

?>
<form id="plgBioCorpForm" jsId="plgBioCorpForm" name="plgBioCorpForm" encType="multipart/form-data" action="" method="">
<input type="hidden" id="plgBioCorpPage" />
<table>
<tr>
 <td class="dialogLabel"  >
   <label for="plgBioCorpIdProject" ><?php echo i18n("plgBioCorpGenAutoDocIdProject") ?>&nbsp;:&nbsp;</label>
 </td>
 <td>
   <select dojoType="dijit.form.FilteringSelect" 
    id="plgBioCorpIdProject" name="plgBioCorpIdProject" required
    class="input" value="<?php echo $idProject;?>">
    <?php htmlDrawOptionForReference('idProject', null, null, true);?>
   </select>
 </td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
 <td class="dialogLabel"  >
   <label for="plgBioCorpType" ><?php echo i18n("plgBioCorpGenAutoDocType") ?>&nbsp;:&nbsp;</label>
 </td>
 <td>
   <select dojoType="dijit.form.FilteringSelect" 
    id="plgBioCorpType" name="plgBioCorpType" required
    class="input" value="<?php echo $idDoc;?>">
    <?php htmlDrawOptionForReference('idDocumentType', null, null, true);?>
   </select>
 </td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
 <td class="dialogLabel"  >
   <label for="plgBioCorpEmplacement" ><?php echo i18n("plgBioCorpGenAutoDocEmplacement") ?>&nbsp;:&nbsp;</label>
 </td>
 <td>
   <select dojoType="dijit.form.FilteringSelect" 
    id="plgBioCorpEmplacement" name="plgBioCorpEmplacement" required
    class="input" value="<?php echo $idDirectory;?>">
    <?php htmlDrawOptionForReference('idDocumentDirectory', null, null, true);?>
   </select>
 </td>
</tr>
<tr><td>&nbsp;</td><td><input dojoType="dijit.form.TextBox" type="hidden" id="idExpense" value="<?php echo $idExpense;?>"></td></tr>
  <tr>
    <td>
    </td>
    <td align="right">
      <input type="hidden" id="copyProjectAction">
      <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogPlgBioCorpGenAutoDoc').hide();">
        <?php echo i18n("buttonCancel");?>
      </button>
      <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogProjectCopySubmit" onclick="protectDblClick(this);plgBioCorpGenAutoDocSubmitDoc();return false;">
        <?php echo i18n("buttonOK");?>
      </button>
    </td>
  </tr>
</table>
</form>

