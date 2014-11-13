<?php
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
