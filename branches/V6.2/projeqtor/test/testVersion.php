<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

$current="V4.3.0.a";
$compare="V4.3.0";
echo $current . " / " . $compare. "<br/>";
echo "beforeVersion=".((beforeVersion($current,$compare))?'true':'false').'<br/>';
echo "afterVersion=".((afterVersion($current,$compare))?'true':'false');

function beforeVersion($V1,$V2) {
	$V1=ltrim($V1,'V');
	$V2=ltrim($V2,'V');
	return(version_compare($V1, $V2,"<"));
}

function afterVersion($V1,$V2) {
	$V1=ltrim($V1,'V');
	$V2=ltrim($V2,'V');
	return(version_compare($V1, $V2,">="));
}

?>