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

$tkt=new Ticket();
$list=$tkt->getSqlElementsFromCriteria(array('idActivity'=>'263'));
$cpt=0;
foreach ($list as $tkt) {
  $tkt->_noHistory=true;
  $savAct=$tkt->idActivity;
  $tkt->idActivity=null;
  $tkt->save();
  $tkt->idActivity=$savAct;
  $tkt->save();
  $cpt++;
  echo "<br/>saved ticket #$tkt->id";
}
echo "<br/>";
echo "<br/>=======================================";
echo "<br/>$cpt tickets updated";
echo "=======================================";
