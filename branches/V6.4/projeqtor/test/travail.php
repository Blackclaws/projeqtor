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

require_once("../tool/projeqtor.php");

$year=(isset($_REQUEST['year']))?$_REQUEST['year']:null;
$month=(isset($_REQUEST['month']))?$_REQUEST['month']:null;
if (!$year or !$month) {
  echo "year et month sont obligatoires";
  exit;
}
if (intval($month)<10) $month='0'.intval($month);
$period=$year.$month;
$query='select p.id as "id projet", p.projectCode as "code projet", p.name as "nom projet", 
a.id as "id activité", a.name as "nom activité", 
r.id as "id ressource", r.fullName as "nom ressoure", r.initials as "initiales",
w.month,
sum(w.work) as travail 
from work w, resource r, project p, activity a
where w.idResource=r.id and w.idProject=p.id and w.refType=\'Activity\' and w.refId=a.id
and w.month=\''.$period.'\'
group by p.id , p.projectCode, p.name, a.id, a.name, r.id , r.fullName, w.month';

$result=Sql::query($query);
if (Sql::$lastQueryNbRows == 0) {
  echo "aucune donnée retournée";
  exit;
}
$cpt=0;
while ($line = Sql::fetchLine($result)) {
  if (!$cpt) {
    foreach ($line as $fld=>$val) {
      echo "$fld;";
    }
    echo "\n";
  }
  foreach ($line as $fld=>$val) {
    echo "$val;";
  }
  echo "\n";
}
?>