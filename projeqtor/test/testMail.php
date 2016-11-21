<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

require_once("../model/ImapMailbox.php");
require_once("../tool/projeqtor.php");

// IMAP must be enabled in Google Mail Settings
define('GMAIL_EMAIL', 'pascal.bernard.muret@gmail.com');
define('GMAIL_PASSWORD', 'Looping31!');
define('ATTACHMENTS_DIR', dirname(__FILE__) . '/../files/attach');

$mailbox = new ImapMailbox('{imap.gmail.com:993/imap/ssl}INBOX', GMAIL_EMAIL, GMAIL_PASSWORD, ATTACHMENTS_DIR, 'utf-8');
$mails = array();

// Get some mail
$mailsIds = $mailbox->searchMailBox('UNSEEN UNDELETED');
if(!$mailsIds) {
        die('Mailbox is empty');
}
echo "Nombre de mails = ".count($mailsIds);

$mailId = reset($mailsIds);
$mail = $mailbox->getMail($mailId);
$mailbox->markMailAsUnread($mailId);

$body=$mail->textPlain;
$bodyHtml=$mail->textHtml;

$class=null;
$id=null;
$msg=null;
$senderId=null;

// Class and Id of object
$posClass=strpos($body,'directAccess=true&objectClass=');
if ($posClass) { // It is a ProjeQtor mail
  $posId=strpos($body,'&objectId=',$posClass);
  $posEnd=strpos($body,'>',$posId);
  $class=substr($body,$posClass+30,$posId-$posClass-30);
  $id=substr($body,$posId+10,$posEnd-$posId-10);
  echo "<br/>***** $class #$id *****";
}
// Message
$posEndMsg=strpos($body,"\r\n\r\n\r\n");
if ($posEndMsg) {
  $msg=substr($body,0,$posEndMsg);
  echo "<br/>***** $msg *****";
}
// Sender
$sender=$mail->fromAddress;
$crit=array('email'=>$sender);
$usr=new Affectable();
$usrList=$usr->getSqlElementsFromCriteria($crit,false,null,'idle asc, isUser desc, isResource desc');
var_dump($usrList);
if (count($usrList)) {
	$senderId=$usrList[0]->id;
}

$obj=new $class($id);
if ($obj->id) {
	$note=new Note();
	$note->refType=$class;
	$note->refId=$id;
	$note->idPrivacy=1;
	$note->note=$msg;
	$note->idUser=$senderId;
	$note->creationDate=date('Y-m-d H:i:s');
	$note->save();
	$mailbox->markMailAsRead($mailId);
} else {
  $mailbox->markMailAsUnread($mailId);
}

echo "===========================================================================";
var_dump($mail);