<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class unregister_html {

  function showForm() {

$params =& JComponentHelper::getParams('com_unregister');

echo $params->get('warning');
?>


  <form action="index.php" method="post">
  <input type="hidden" name="test2" value="test4">
  <input type="hidden" name="option" value="com_unregister">
  <input type="hidden" name="action" value="unreg">	
  <table>
  <tr>
    <td width="50%" align="left"><?php echo $params->get('password'); ?></td>
    <td><input type="password" name="pass"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="submit" value="Unregister">
    </td>
  </tr>
  </table>
  </form>

<?
  }
}

?>