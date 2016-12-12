<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

// THIS SCRIPT IS DEDICATED TO RUN SOME SCRIPTS IN BATCH MODE
if (php_sapi_name()!='cli') {
	echo "Batch script can not be run in web mode<br/>";
	echo "Stopped.";
	exit;
}


// set the base root of projeqtor scripts
$baseRoot=dirname(__FILE__) . "/.."; // for instance if current script is in a sub-directory of base root

// Position to the tool directory ! Mantdatory
chdir($baseRoot . '/tool');

// Set batch mode
$batchMode=true;        
require_once "projeqtor.php";
// Set user 
$user=new User(); // if script to be run requires specific rights, set "$user=new User(id)" where id is the id of admin user
setSessionUser($user);

// Run script
include 'cronRelaunch.php';