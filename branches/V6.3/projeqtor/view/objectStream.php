<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  require_once "../tool/formatter.php";
  scriptLog('   ->/view/objectStream.php');
  global $print,$user;
  if (! isset($objectClass) ) $objectClass=RequestHandler::getClass('objectClass');
  if (! isset($objectId)) $objectId=RequestHandler::getId('objectId');
  $obj=new $objectClass($objectId);
  $canUpdate=securityGetAccessRightYesNo('menu' . $objectClass, 'update', $obj) == "YES";
  if ($obj->idle == 1) {
    $canUpdate=false;
  }
  $noData=htmlGetNoDataMessage($objectClass);
  // get the modifications (from request)
  $note=new Note();
  $notes=$note->getSqlElementsFromCriteria(array('refType'=>$objectClass,'refId'=>$objectId));
  $ress=new Resource($user->id);
  $userId=$note->idUser;
  $userName=SqlList::getNameFromId('User', $userId);
  debugLog("voici le userid de objstream".$userId);
  debugLog("voici le username de objstream".$userName);
  $creationDate=$note->creationDate;
  $updateDate=$note->updateDate;
  debugLog("voici le creationdate de objstream".$creationDate);
  debugLog("voici le updateDate de objstream".$updateDate);
  if ($updateDate == null) {
    $updateDate='';
  }
  $detailHeight=600;
  $detailWidth=1010;
  //// A CHANGER ////
  

  
  if (!$objectId) {echo $noData; exit;}
  $onlyCenter=(RequestHandler::getValue('onlyCenter')=='true')?true:false;
?>
<!-- Titre et listes de notes -->

<?php if (!$onlyCenter) {?>
<div class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false">
	<div id="activityStreamTop" dojoType="dijit.layout.ContentPane" region="top" style="height:32px">
	  <span style="color:black;" class="title" ><?php echo i18n("titleStream");?></span>
	</div>
	<div id="activityStreamCenter" dojoType="dijit.layout.ContentPane" region="center">
<?php }?>	
	  <script type="dojo/connect" event="onLoad" args="evt">
        alert("ok");
        var elmnt = document.getElementById("activityStreamCenter");
        console.log(elmnt);
        elmnt.scrollIntoView(false); 
	  </script>
	  <table id="objectStream"> 
	    <?php foreach ( $notes as $note ) { 
	      $userId=$note->idUser;
        $userName=SqlList::getNameFromId('User', $userId);
        $userNameFormatted = '<span style="color:blue"><strong>'.$userName.'</strong></span>';
        $idNote = '<span style="color:blue">'.$note->id.'</span>';
        $ticketName = '<span style="color:blue">'.$note->refType.' #'.$note->refId.'</span>';
        $colCommentStream = i18n ( 'addComment', array (
            $idNote,
            $ticketName
        ) );
        ?>
	      <?php if ($user->id == $note->idUser or $note->idPrivacy == 1 or ($note->idPrivacy == 2 and $ress->idTeam == $note->idTeam)) {?>
	        <tr style="height:50px;">
	          <td class="noteData" style="width:100%">
	            <div style="float:left;">
	              <?php
	                echo formatUserThumb($note->idUser, $userName, 'Creator',32);
	                echo formatPrivacyThumb($note->idPrivacy, $note->idTeam);
	              ?>
	            </div>
	            <div>
      	        <?php
      	         if ($canUpdate) echo  '<div style="float:right;" ><a onClick="removeNote(' . htmlEncode($note->id) . ');" title="' . i18n('removeNote') . '" > '.formatSmallButton('Remove').'</a></div>';
      	        ?>
	            </div>
	      <div style="overflow-x:auto;" >
	      <?php 
	        $strDataHTML=$note->note;
		      if (! isTextFieldHtmlFormatted($strDataHTML)) {
		      	$strDataHTML=htmlEncode($strDataHTML,'plainText');
		      } else {
		      	$strDataHTML=preg_replace('@(https?://([-\w\.]<+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $strDataHTML);
		      }
		    echo '<div>'.$userNameFormatted.'&nbsp'.$colCommentStream.'</div>';
	      echo '<div style="color:black;background-color:#DFF2FF;height:20px;margin-top:2px;">'.$strDataHTML.'</div>&nbsp';
	      echo '<div>'.$note->creationDate.'</div>';
	      ?>
	      </div>
	      </td>       
	        </tr>      
	     <?php };?>
	    <?php };?>
	  </table>
<?php if (!$onlyCenter) {?>   	  
	</div>

	<div id="activityStreamBottom" dojoType="dijit.layout.ContentPane" region="bottom" style="height:70px">
	  <form id='noteFormStream' name='noteFormStream' onSubmit="return false;" >
         <input id="noteId" name="noteId" type="hidden" value="<?php echo $note->id;?>" />
         <input id="noteRefType" name="noteRefType" type="hidden" value="<?php echo $note->refType;?>" />
         <input id="noteRefId" name="noteRefId" type="hidden" value="<?php echo $note->refId;?>" />
         <input id="noteEditorTypeStream" name="noteEditorTypeStream" type="hidden" value="<?php echo getEditorType();?>" />
        
         <div style="width:100%;">
           <input placeHolder="<?php echo i18n("textareaEnterText");?>" rows="4"  name="noteNoteStream" id="noteNoteStream" dojoType="dijit.form.TextBox"
            onKeyPress="if(event.keyCode==13) return saveNoteStream();" style="width:100%;height:50px;overflow-x:hidden;overflow-y:auto;" />
         </div>
       </form>
    
   </div>
</div>
<?php }?>