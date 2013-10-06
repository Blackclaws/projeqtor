<?php
/** ============================================================================
 * Save some information about planning columns status.
 */
require_once "../tool/projeqtor.php";

Sql::beginTransaction();
$user=$_SESSION['user'];
$action=$_REQUEST['action'];
if ($action=='status') {
  $status=$_REQUEST['status'];
  $item=$_REQUEST['item'];
  $cs=new ColumnSelector($item);
  if (! $cs->id) {
  	errorLog("ERROR in saveSelectedColumn, impossible to retrieve ColumnSelector($item)");
  } else {
  	$cs->hidden=($status=='hidden')?1:0;
    $cs->save();
  }
}  
Sql::commitTransaction();
?>