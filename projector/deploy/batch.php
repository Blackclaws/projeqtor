<?php
// THIS SCRIPT IS DEDICATED TO RUN SOME SCRIPTS IN BATCH MODE
if (php_sapi_name()!='cli') {
	echo "Batch script can not be run in web mode<br/>";
	echo "Stopped.";
	exit;
}


// set the base root of projectorrria scripts
$baseRoot=dirname(__FILE__) . "/.."; // for instance if current script is in a sub-directory of base root

// Position to the tool directory ! Mantdatory
chdir($baseRoot . '/tool');

// Set batch mode
$batchMode=true;        
require_once "projeqtor.php";
// Set user 
$user=new User(); // if script to be run requires specific rights, set "$user=new User(id)" where id is the id of admin user
$_SESSION['user']=$user;

// Run script
include 'cronRelaunch.php';