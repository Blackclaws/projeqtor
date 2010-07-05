<?php
/** ============================================================================
 * Save some information to session (remotely).
 */
require_once "../tool/projector.php";

$id=$_REQUEST['id'];
if ($id=='disconnect') {
  session_destroy();
  exit;
}

$value=$_REQUEST['value'];

$_SESSION[$id]=$value;

?>