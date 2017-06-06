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
  $enterTextHere = '<p style="color:red;">'.i18n("textareaEnterText").'</p>';
  // get the modifications (from request)
  $note=new Note();
  $notes=$note->getSqlElementsFromCriteria(array('refType'=>$objectClass,'refId'=>$objectId));
  $ress=new Resource($user->id);
  $userId=$note->idUser;
  $userName=SqlList::getNameFromId('User', $userId);
  $creationDate=$note->creationDate;
  $updateDate=$note->updateDate;
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
	<div id="activityStreamTop" dojoType="dijit.layout.ContentPane" region="top" style="text-align:center" class="dijitAccordionTitle">
	  <span class="title" ><?php echo i18n("titleStream");?></span>
	</div>
	<div id="activityStreamCenter" dojoType="dijit.layout.ContentPane" region="center">
<?php }?>	
	  <script type="dojo/connect" event="onLoad" args="evt">
        scrollInto();
	  </script>
	  <table id="objectStream" style="width:100%;"> 
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
	        <tr style="height:100%;">
	          <td class="noteData" style="width:100%;">
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
	      <div style="overflow-x:auto;padding-left:4px;max-height:200px;" >
	      <?php 
	        $strDataHTML=$note->note;
		      if (! isTextFieldHtmlFormatted($strDataHTML)) {
		      	$strDataHTML=htmlEncode($strDataHTML,'plainText');
		      } else {
		      	$strDataHTML=preg_replace('@(https?://([-\w\.]<+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $strDataHTML);
		      }
		    echo '<div>'.$userNameFormatted.'&nbsp'.$colCommentStream.'</div>';
	      echo '<div style="color:white;margin-top:4px;word-break:break-all;min-width:188px;position:relative;" class="dijitSplitter">'.$strDataHTML.'</div>&nbsp';
	      echo '<div style="margin-top:6px;">'.formatDateThumb($note->creationDate,null,"left").'</div>';
	      echo '<div style="margin-top:11px;">'.$note->creationDate.'</div>';
	      ?>
	      </div>
	      </td>       
	        </tr>      
	     <?php };?>
	    <?php };?>
	  </table>
	   <div id="scrollToBottom" type="hidden"></div>
<?php if (!$onlyCenter) {?>   	  
	</div>

	<div id="activityStreamBottom" dojoType="dijit.layout.ContentPane" region="bottom" style="height:70px;overflow-x:hidden;">
	  <form id='noteFormStream' name='noteFormStream' onSubmit="return false;" >
         <input id="noteId" name="noteId" type="hidden" value="" />
         <input id="noteRefType" name="noteRefType" type="hidden" value="<?php echo $objectClass;?>" />
         <input id="noteRefId" name="noteRefId" type="hidden" value="<?php echo $objectId;?>" />
         <input id="noteEditorTypeStream" name="noteEditorTypeStream" type="hidden" value="<?php echo getEditorType();?>" />
        
         <div style="width:99%;">
           <textarea rows="4"  name="noteNoteStream" id="noteNoteStream" dojoType="dijit.form.SimpleTextarea"
            onKeyPress="saveNoteStream(event);return false;" style="width:98%;height:60px;overflow-x:hidden;overflow-y:auto;border:2px solid;" onmousedown="mouseDownStream()"><?php echo i18n("textareaEnterText");?></textarea>
         </div>
       </form>
    
   </div>
</div>
<?php }?>