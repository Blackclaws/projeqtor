<?php 
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
