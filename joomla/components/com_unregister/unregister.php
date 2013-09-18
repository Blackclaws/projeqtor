<?php
/**
* Unregister++ Component
*
* @Copyright (C) 2004-2006 Mike Noel and 2008 Max Shinn
* @ All rights reserved
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version 1.0
**/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

require_once("components/com_unregister/unregister.html.php");

jimport('joomla.application.component.controller');

global $mainframe;

$my = JFactory::getUser();

$message = "Click here to unregister";

$version = "2.0";

$userid = $my->get('id');

$option = JRequest::getVar('option', "com_unregister");
$action = JRequest::getVar('action', "mkform");
$params =& JComponentHelper::getParams('com_unregister');

if (!$userid) {
  print($params->get('login'));
  return;
}

$baseurl = "index.php?option=$option";

switch ($action) {
 case "unreg":
   removeUser($mainframe,$database,$option,$userid,$pass, $params);
   break;
 case "mkform":
 default:
   makeForm($database,$option,$userid);
   break;
 }

/***********************************************************************/

function makeForm($db,$option,$userid) {
  unregister_html::showForm();
}

function removeUser($mainframe,$db,$option,$userid,$pass, $params) {
  $user = JFactory::getUser();
  JPluginHelper::importPlugin( 'user' );
  //trigger the onBeforeDeleteUser event
  $dispatcher =& JDispatcher::getInstance();
  $dispatcher->trigger( 'onBeforeDeleteUser', array( $user->getProperties() ) );

  // Create the user table object
  $table =& $user->getTable();
  $part = explode(":",$user->get('password'));
  if($user->get('password') != md5(JRequest::getVar('pass', '').$part[1]).':'.$part[1])
  {
  	echo '<script type="text/javascript">alert("'.$params->get('wrong_password').'"); window.history.go(-1);</script>';
  	exit();
  }

  $result = false;
  if (!$result = $table->delete($user->id)) {
  	$user->setError($table->getError());
  }

  //trigger the onAfterDeleteUser event
  $dispatcher->trigger( 'onAfterDeleteUser', array( $user->getProperties(), $result, $user->getError()) );

  $mainframe->redirect('index.php', $params->get('done'));
}


?>