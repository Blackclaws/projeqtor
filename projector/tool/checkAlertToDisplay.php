<?php
require_once "../tool/projector.php";
if (! array_key_exists('user',$_SESSION)) {
	echo "noUser";
	return;
}
$user=$_SESSION['user'];
$crit=array('idUser'=>$user->id,'readFlag'=>'0', 'idle'=>'0');
$alert=new Alert();
$lst=$alert->getSqlElementsFromCriteria($crit, false, null, 'id asc');
if (count($lst)==0) {
	return;
}
$date=date('Y-m-d H:i');
foreach($lst as $alert) {
	if ($alert->alertDateTime<=$date) {
	  echo '<b>' . htmlEncode($alert->title) . '</b>';
	  echo '<br/><br/>';
	  echo  htmlEncode($alert->message,'withBR');
	  echo '<input type="hidden" id="idAlert" name="idAlert" value="' . $alert->id . ' " ./>';
	  echo '<input type="hidden" id="alertType" name="alertType" value="' . $alert->alertType . '" ./>';
	  return;
	}
}
