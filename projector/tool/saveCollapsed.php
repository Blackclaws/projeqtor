<?php
/** ============================================================================
 * Save some information to session (remotely).
 */
require_once "../tool/projector.php";

$scope=$_REQUEST['scope'];
$value=$_REQUEST['value'];
if ($value=='true') {
  Collapsed::collapse($scope);
} else {
  Collapsed::expand($scope);
}

?>