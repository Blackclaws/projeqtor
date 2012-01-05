<?php
/** ===========================================================================
 * Acknowledge an operation
 */
if (array_key_exists('resultAck',$_REQUEST)) {
  $result=$_REQUEST['resultAck'];
  $result=str_replace('\"','"',$result);
  echo $result;
} else if (array_key_exists('documentVersionAck',$_REQUEST)) {
  $result=$_REQUEST['documentVersionAck'];
  $result=str_replace('\"','"',$result);
  echo $result;
} else {
  echo 'errorAck';
}
?>
