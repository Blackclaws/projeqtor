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

include_once "../tool/projeqtor.php";
include_once "testTools.php";
header ('Content-Type: text/html; charset=UTF-8');
projeqtor_set_time_limit(3600);
Sql::beginTransaction();
$listPrj=SqlList::getList('Project');

foreach ($listPrj as $id=>$name) {
	echo $id . " => " . $name . '<br/>';
	if (strlen($id)==3) {
		$x=substr($id,0,1);
		$y=substr($id,1,1);
		$z=substr($id,2,1);
		if ($z==0) {
			if ($y!=0) {
				// level 2
				if ($x!=0) {
				  $prj=new Project($id);
          $prj->idProject=$x.'00';
          $prj->save();
				} else {
					$prj=new Project($id);
          $prj->idProject=1000;
          $prj->save();
				}
			} else {
				// level 1
				$prj=new Project($id);
				$prj->idProject=1000;
				$prj->save();
			} 
			
		} else {
			// level 3
			if ($x!=0) {
				if ($y!=0) {
			    $prj=new Project($id);
          $prj->idProject=$x.$y.'0';
          $prj->save();
				} else {
					$prj=new Project($id);
          $prj->idProject=$x.'00';
          $prj->save();
				}
			} else {
				$prj=new Project($id);
        $prj->idProject=1000;
        $prj->save();
			}
		}
	}
}
Sql::commitTransaction();
