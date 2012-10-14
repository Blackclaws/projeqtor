<?php
/** =========================================================================== 
 * Chek login/password entered in connection screen
 */
  require_once "../tool/projector.php"; 
  scriptLog('   ->/tool/sendMail.php');  
  $title="";
  $msg="";
  $dest="";
  $typeSendMail="";
  
  if (array_key_exists('className',$_REQUEST)) {
    $typeSendMail=$_REQUEST['className'];
  }

  $result="";
  if ($typeSendMail=="User") {
    $login=$_REQUEST['name'];
    $dest=$_REQUEST['email'];
    $pwdMsg="";
    if ($_REQUEST['password']==md5(Parameter::getGlobalParameter('paramDefaultPassword'))) {
      $pwdMsg=i18n('passwordResetMessage', array(Parameter::getGlobalParameter('paramDefaultPassword')));
    }
    $title=i18n('userMailTitle');  
    $msg=i18n('userMailMessage',array($login,$pwdMsg,Parameter::getGlobalParameter('paramAdminMail')));
    $result=(sendMail($dest,$title,$msg))?'OK':'';
  } else if ($typeSendMail=="Meeting") {
    if (array_key_exists('id',$_REQUEST)) {
      $id=$_REQUEST['id'];
      $meeting=new Meeting($id);
      $dest=str_replace('"','',$meeting->attendees);
      $result=($meeting->sendMail()>0)?'OK':'';
    }
  } else if ($typeSendMail=="Mailable") {
  	$class=$_REQUEST['mailRefType'];
  	$id=$_REQUEST['mailRefId'];
  	$mailToContact=(array_key_exists('dialogMailToContact', $_REQUEST))?true:false;
    $mailToUser=(array_key_exists('dialogMailToUser', $_REQUEST))?true:false;
    $mailToResource=(array_key_exists('dialogMailToResource', $_REQUEST))?true:false;
    $mailToProject=(array_key_exists('dialogMailToProject', $_REQUEST))?true:false;
    $mailToLeader=(array_key_exists('dialogMailToLeader', $_REQUEST))?true:false;
    $mailToManager=(array_key_exists('dialogMailToManager', $_REQUEST))?true:false;
    $mailToOther=(array_key_exists('dialogMailToOther', $_REQUEST))?true:false;
    $otherMail=(array_key_exists('dialogOtherMail', $_REQUEST))?$_REQUEST['dialogOtherMail']:'';  
    $message=(array_key_exists('dialogMailMessage', $_REQUEST))?$_REQUEST['dialogMailMessage']:'';  
    $obj=new $class($id);
    $directStatusMail=new StatusMail();
    $directStatusMail->mailToContact=$mailToContact;
    $directStatusMail->mailToUser=$mailToUser;
    $directStatusMail->mailToResource=$mailToResource;
    $directStatusMail->mailToProject=$mailToProject;
    $directStatusMail->mailToLeader=$mailToLeader;
    $directStatusMail->mailToManager=$mailToManager;
    $directStatusMail->mailToOther=$mailToOther;
    $directStatusMail->otherMail=$otherMail;
    $directStatusMail->message=$message; // Attention, do not save this status mail
    $resultMail=$obj->sendMailIfMailable(false, false, false, false, false, $directStatusMail);
    if (! $resultMail or ! is_array($resultMail)) {
//debugLog("sendMail without result");
    	$result="";
    	$dest="";
    } else {
    	$result=$resultMail['result'];
      $dest=$resultMail['dest'];
//debugLog("sendMail with result: result=$result, dest=$dest");
    }
  }
  
  
  
  if ($result!="OK") {
    echo '<span class="messageERROR" >' . i18n('noMailSent',array($dest, $result)) . '</span>';
    echo '<input type="hidden" id="lastOperation" value="mail" />';
    echo '<input type="hidden" id="lastOperationStatus" value="ERROR" />';
  } else {
    echo '<span class="messageOK" >' . i18n('mailSentTo',array($dest)) . '</span>';
    echo '<input type="hidden" id="lastOperation" value="mail" />';
    echo '<input type="hidden" id="lastOperationStatus" value="OK" />';
  } 
?>