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

$parametersLocation = "/var/wwwFiles/projectorria/track/config/parameters.php";
include_once $parametersLocation;
$version="";

try { 
  ini_set('mysql.connect_timeout', 10);
  $cnx = mysql_connect($paramDbHost, $paramDbUser, $paramDbPassword);
  mysql_select_db($paramDbName, $cnx);
  ini_set('mysql.connect_timeout', 60);
  $req="select * from " . $paramDbPrefix . "parameter where idUser is null and idProject is null and parameterCode='dbVersion'";
  $result = mysql_query($req,$cnx);
  $line=mysql_fetch_array($result, MYSQL_ASSOC);
  $version=$line['parameterValue'];
  
  $ip=$_SERVER['REMOTE_ADDR'];
  $date=date('Y-m-d H:i:s');
  $req="insert into trace (traceIp, traceVersion) ";
  $req.=" value ('$ip', '$version')";
  $result = mysql_query($req,$cnx);
  
} catch (Exception $e) {
	//echo "error";
}

echo $version;
