<?php
/** ===========================================================================
 * Acknowledge an operation
 */
if (array_key_exists('resultAck',$_REQUEST)) {
  $result=$_REQUEST['resultAck'];
  $result=str_replace('\"','"',$result);
  echo $result;
} else {
  echo htmlGetErrorMessage(i18n('errorAck'));
}
?>
