<?php
/** =========================================================================== 
 * Chek login/password entered in connection screen
 */
  require_once "../tool/projector.php"; 
  
  $password="";

  if (array_key_exists('password',$_POST)) {
    $password=$_POST['password'];
  }    
  if ($password=="") {
    passwordError();
  }
  if ($password==$paramDefaultPassword) {
    passwordError();
  }
  
  if ( ! $user ) {
   passwordError();
  } 
  if ( ! $user->id) {
    passwordError();
  } 
  if ( $user->idle!=0) {
    passwordError();
  } 
  if ($user->isLdap<>0) {
    passwordError();
  } 

  if (strlen($password)<5) {
    passwordError();
  }
  
  changePassword($user, $password);
  
  /** ========================================================================
   * Display an error message because of invalid login
   * @return void
   */
  function passwordError() {
    echo '<span class="messageERROR">';
    echo i18n('invalidPasswordChange');
    echo '</span>';
    exit;
  }
  
   /** ========================================================================
   * Valid login
   * @param $user the user object containing login information
   * @return void
   */
  function changePassword ($user, $newPassword) {
    $user->password=md5($newPassword);
    $user->save();
    echo '<span class="messageOK">';
    echo i18n('passwordChanged');
    echo '<div id="validated" name="validated" type="hidden"  dojoType="dijit.form.TextBox">OK';
    echo '</div>';
    echo '</span>';
    $_SESSION['user']=$user;
  }
  
?>