<?php
require_once("../model/ImapMailbox.php");
require_once("../tool/projector.php");

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