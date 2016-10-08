<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

?><html>
<head>
 <style type="text/css">
  body {
    font-family: arial;
  }
  table {
    border-collapse: collapse;
    border: 1px solid #AAAAAA;
  }	 
	th{
	  background: #EEEEEE;
	  border: 1px solid #AAAAAA;
	  padding: 0px 10px 0px 10px;
	}
	
	tr{
	}
	
	td {
	  border: 1px solid #AAAAAA;
    margin: 0;
    padding: 0px 10px 0px 10px;
    background-color: #FFC;
    text-align: center;
	}  
  
  
 </style>
</head>
<body>
<?php 
$parametersLocation = "../../_private/track/parametersTrack.php";
if (! file_exists($parametersLocation)) {
  $parametersLocation = "../files/config/parameters.php";
}
include_once $parametersLocation;

try {   
  ini_set('mysql.connect_timeout', 10);
  $cnx = mysql_connect($paramDbHost, $paramDbUser, $paramDbPassword);
  mysql_select_db($paramDbName, $cnx);
  ini_set('mysql.connect_timeout', 60);
  
  $req="select traceVersion as Version, count(distinct(traceIp)) as `Distinct IP`, count(*)as Count from trace group by traceVersion order by traceVersion desc";
  showStat($cnx,$req);
  
  $req="select concat(year(traceDateTime),'-',month(traceDateTime)) as Month, count(distinct(traceIp)) as `Distinct IP`, count(*) as Count "
     . " from trace group by concat(year(traceDateTime),'-',month(traceDateTime)) " 
     . " order by concat(year(traceDateTime),'-',month(traceDateTime))  desc";
  showStat($cnx,$req);

  $req="select count(distinct(traceIp)) as `Distinct IP`, count(*) as Total from trace";
  showStat($cnx,$req);
  
  $req="select traceIp as `IP`, count(*) as Total from trace group by traceIp having count(*) > 5 order by count(*) desc";
  showStat($cnx,$req);
  
} catch (Exception $e) {
	echo "error";
}

function showStat($cnx, $req) {
	$result = mysql_query($req,$cnx);
  $line=mysql_fetch_array($result, MYSQL_ASSOC);
  echo '<table><tr>';
  foreach($line as $col=>$val) {
  	echo "<th>".$col."</th>";
  }
  echo "</tr>";
  $tot=0;
  $nbCol=count($line);
  while ($line) {
  	echo "<tr>";
  	foreach($line as $col=>$val) {
  	  echo "<td>".$val."</td>";
  	  if ($col=="Count") {
  	  	$tot+=$val;
  	  }	
  	}
  	echo "</tr>";
  	$line=mysql_fetch_array($result, MYSQL_ASSOC);
  }
  if ($tot>0) {
    echo '<tr><th colspan="'. ($nbCol-1) . '">Total</th><th>' . $tot . '</th>';
  }
  echo "</table>";
  echo "<br/>";
}
?>
</body>
</html>