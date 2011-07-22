<?php
/** ============================================================================
 * Save some information to session (remotely).
 */
require_once "../tool/projector.php";

debugLog("XXXXX");
$id=$_REQUEST['id'];
debugLog($id);
if ($id=='disconnect') {
  purgeFiles($paramReportTempDirectory,"user" . getCurrentUserId() . "_");
  traceLog("DISCONNECTED USER '" . $_SESSION['user']->name . "'");
  session_destroy();
  exit;
}

$value=$_REQUEST['value'];

$_SESSION[$id]=$value;

?>