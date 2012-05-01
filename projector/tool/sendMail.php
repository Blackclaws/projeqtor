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
    if ($_REQUEST['password']==md5($paramDefaultPassword)) {
      $pwdMsg=i18n('passwordResetMessage', array($paramDefaultPassword));
    }
    $title=i18n('userMailTitle');  
    $msg=i18n('userMailMessage',array($login,$pwdMsg,$paramAdminMail));
    $result=(sendMail($dest,$title,$msg))?'OK':'';
  } else if ($typeSendMail=="Meeting") {
    if (array_key_exists('id',$_REQUEST)) {
      $id=$_REQUEST['id'];
      $meeting=new Meeting($id);
      $dest=str_replace('"','',$meeting->attendees);
      $result=($meeting->sendMail()>0)?'OK':'';
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