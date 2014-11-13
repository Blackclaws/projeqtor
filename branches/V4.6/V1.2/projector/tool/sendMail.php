<?php
/** =========================================================================== 
 * Chek login/password entered in connection screen
 */
  require_once "../tool/projector.php"; 
  
  $title="";
  $msg="";
  $dest="";
  $typeSendMail="";
  
  if (array_key_exists('className',$_REQUEST)) {
    $typeSendMail=$_REQUEST['className'];
  }
  
  if ($typeSendMail=="User") {
    $login=$_REQUEST['name'];
    $dest=$_REQUEST['email'];
    $pwdMsg="";
    if ($_REQUEST['password']==md5($paramDefaultPassword)) {
      $pwdMsg=i18n('passwordResetMessage', array($paramDefaultPassword));
    }
    $title=i18n('userMailTitle');  
    $msg=i18n('userMailMessage',array($login,$pwdMsg,$paramAdminMail));    
  }  
  $result="";
  if ($title=="" or $msg=="" or $dest=="") {
    $result='';
  } else {
    $result=(sendMail($dest,$title,$msg))?'OK':'';
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