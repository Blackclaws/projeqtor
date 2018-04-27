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

/* ============================================================================
 * Menu defines list of items to present to users.
 */ 
require_once('_securityCheck.php');
class ResourceTeamAffectation extends SqlElement {

  public $id;
  public $idResourceTeam;
  public $idResource;
  public $rate;
  public $description;
  public $startDate;
  public $endDate;
  public $idle;
  
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
  }

  
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }
  
  
  public static $maxAffectationDate='2029-12-31';
  public static $minAffectationDate='1970-01-01';
  
  private static function formatDate($date) {
    if ($date==self::$minAffectationDate) {
    		return "";
    }
    if ($date==self::$maxAffectationDate) {
    		return "";
    }
    return htmlFormatDate($date);
  }
  
  
  public static function buildResourcePeriodsPerResourceTeam($idResource, $showIdle=false){
    if (isset(self::$_resourcePeriodsPerProject[$idResource][$showIdle])) {
    		return self::$_resourcePeriodsPerProject[$idResource][$showIdle];
    }
    $periods=self::buildResourcePeriods($idResource,$showIdle);
    $cptProj=0;
    $projects=array();
    foreach ($periods as $p) {
    		foreach($p['idResource'] as $idP=>$affP) {
    		  if (! isset($projects[$idP])) {
    		    $cptProj++;
    		    $projects[$idP]=array('position'=>$cptProj,
    		        //'name'=>SqlList::getNameFromId('Project',$idP),
    		        'periods'=>array()
    		    );
    		  }
    		  $per=$projects[$idP]['periods'];
    		  $last=end($per);
    		  if (count($per)>0
    				and $last['end']==addDaysToDate($p['start'], -1)
    				and $last['rate']==$p['idResource'][$idP]) {
    		    $projects[$idP]['periods'][count($per)-1]['end']=$p['end'];
    		  } else {
    		    $projects[$idP]['periods'][]=array('start'=>$p['start'], 'end'=>$p['end'], 'rate'=>$p['idResource'][$idP]);
    		  }
    		}
    }
    if (!isset($_resourcePeriodsPerProject[$idResource])) {
    		$_resourcePeriodsPerProject[$idResource]=array();
    }
    $_resourcePeriodsPerProject[$idResource][$showIdle]=$projects;
    return $projects;
  }
  
  
  
  public static function buildResourcePeriods($idResourceAff,$showIdle=false) {
    if (isset(self::$_resourcePeriods[$idResourceAff][$showIdle])) {
      return self::$_resourcePeriods[$idResourceAff][$showIdle];
    }
    $aff=new ResourceTeamAffectation();
    $crit=array('idResourceTeam'=>$idResourceAff);
    if (!$showIdle) {
    		$crit['idle']='0';
    }
    $list=$aff->getSqlElementsFromCriteria($crit,false,null, 'startDate asc, endDate asc');
    $res=array();
    foreach ($list as $aff) {
    		$start=($aff->startDate)?$aff->startDate:self::$minAffectationDate;
    		$end=($aff->endDate)?$aff->endDate:self::$maxAffectationDate;
    		if ($aff->idle) $end=self::$minAffectationDate; // If affectation is closed : no work to plan
    		$myResource = new Resource($aff->idResource);
    		$arrAffResource=array($aff->idResource=>($aff->rate/100*$myResource->capacity));
    		foreach($res as $r) {
    		  if (!$start or !$end) break;
    		  if ($start<=$r['start']) {
    		    if ($end>=$r['start']) {
    		      if ($end<=$r['end']) {
    		        $res[$r['start']]=array(
    		            'start'=>$r['start'],
    		            'end'=>$end,
    		            'rate'=>($aff->rate/100*$myResource->capacity)+$r['rate'],
    		            'idResource'=>array_sum_preserve_keys($r['idResource'],$arrAffResource));
    		        if ($end!=$r['end']) {
    		          $next=addDaysToDate($end, 1);
    		          $res[$next]=array(
    		              'start'=>$next,
    		              'end'=>$r['end'],
    		              'rate'=>$r['rate'],
    		              'idResource'=>$r['idResource']);
    		        }
    		        $end=($start!=$r['start'])?addDaysToDate($r['start'], -1):'';
    		      } else {
    		        if ($start!=$r['start']) {
    		          $res[$start]=array(
    		              'start'=>$start,
    		              'end'=>addDaysToDate($r['start'], -1),
    		              'rate'=>($aff->rate/100*$myResource->capacity),
    		              'idResource'=>$arrAffResource);
    		        }
    		        $next=$r['start'];
    		        $res[$next]=array(
    		            'start'=>$next,
    		            'end'=>$r['end'],
    		            'rate'=>($aff->rate/100*$myResource->capacity),
    		            'idResource'=>array_sum_preserve_keys($r['idResource'],$arrAffResource));
    		        $start=($end!=$r['end'])?addDaysToDate($r['end'], 1):'';
    		      }
    		    }
    		  } else { //$start>$r['startDate']
    		    if ($start<=$r['end']) {
    		      $res[$r['start']]=array(
    		          'start'=>$r['start'],
    		          'end'=>addDaysToDate($start, -1),
    		          'rate'=>$r['rate'],
    		          'idResource'=>$r['idResource']);
    		      if ($end<=$r['end']) {
    		        $res[$start]=array(
    		            'start'=>$start,
    		            'end'=>$end,
    		            'rate'=>$r['rate']+($aff->rate/100*$myResource->capacity),
    		            'idResource'=>array_sum_preserve_keys($r['idResource'],$arrAffResource));
    		        if ($end!=$r['end']) {
    		          $next=addDaysToDate($end, 1);
    		          $res[$next]=array(
    		              'start'=>$next,
    		              'end'=>$r['end'],
    		              'rate'=>$r['rate'],
    		              'idResource'=>$r['idResource']);
    		        }
    		        $start='';$end='';
    		      } else { // ($end>$r['end'])
    		        $res[$start]=array(
    		            'start'=>$start,
    		            'end'=>$r['end'],
    		            'rate'=>$r['rate']+($aff->rate/100*$myResource->capacity),
    		            'idResource'=>array_sum_preserve_keys($r['idResource'],$arrAffResource));
    		        $start=addDaysToDate($r['end'], 1);
    		      }
    		    }
    		  }
    		} // End loop
    		if ($start and $end) {
    		  $res[$start]=array('start'=>$start,
    		      'end'=>$end,
    		      'rate'=>($aff->rate/100*$myResource->capacity),
    		      'idResource'=>$arrAffResource);
    		}
    }
    if (!isset($_resourcePeriods[$idResourceAff])) {
    		$_resourcePeriods[$idResourceAff]=array();
    }
    ksort($res);
    $_resourcePeriods[$idResourceAff][$showIdle]=$res;
   return $res;
  }

  public static function drawResourceTeamAffectation($idResourceAff, $showIdle=false) {
  global $print;
  	$periods=self::buildResourcePeriods($idResourceAff,$showIdle);
  	if (count($periods)==0) return;
  	$first=reset($periods);
  	$start=$first['start'];
  	$last=end($periods);
  	$end=$last['end'];
  	$projects=array();
  	$nb=count($periods);
  	if ( ($start==Affectation::$minAffectationDate or $end==Affectation::$maxAffectationDate) and $nb>1) {
  		if ($start==Affectation::$minAffectationDate) {
  			if ($end==Affectation::$maxAffectationDate){
  				$newDur=dayDiffDates($first['end'],$last['start'])+1;
  				
  			} else {
  				$newDur=dayDiffDates($first['end'],$end)+1;
  			}
  		} else {
  			$newDur=dayDiffDates($start,$last['start'])+1;
  		}
  		$gap=ceil(max(30,$newDur)/$nb);
  		$start=($start==Affectation::$minAffectationDate)?addDaysToDate($first['end'], $gap*(-1)):$start;
  		$end=($end==Affectation::$maxAffectationDate)?addDaysToDate($last['start'], $gap):$end;
  	} 	 
  	$duration=dayDiffDates($start, $end)+1;
  	$maxRate=100;
  	$lineHeight=15;
  	$cptProj=0;
  	foreach ($periods as $p) {
  		if ($p['rate']>$maxRate) $maxRate=$p['rate'];
  		foreach($p['idResource'] as $idP=>$affP) {
  			if (! isset($projects[$idP])) {
  				$cptProj++;
  				$projects[$idP]=array('position'=>$cptProj,
  						'name'=>SqlList::getNameFromId('Resource',$idP));
  			}
  		}
  	}
  	$result='<div style="position:relative;height:5px;"></div>'
  			.'<div style="position:relative;width:99%; height:'.((count($projects)+1)*($lineHeight+4)+4).'px; '
  			.' border: 1px solid #AAAAAA;background-color:#FEFEFE;'
  			.' box-shadow:2px 2px 2px #888888; overflow:hidden;">';
  	foreach ($periods as $p) {
  		$len=dayDiffDates(max($start,$p['start']), min($end,$p['end']))+1;
  		$width=($duration)?($len/$duration*100):0;
  		$left=(dayDiffDates($start, max($start,$p['start']))/$duration*100);
  		$title='['.$p['rate'].'] '.self::formatDate($p['start']).' => '.self::formatDate($p['end']);
  		
  		if($p['rate']<1){
  		  if($p['rate']<0.5){
  		    $lineHeight = 15;
  		  }else{
  		    $lineHeight = 15;
  		  }
  		}
  		
  		$result.= '<div style="position:absolute;left:'.$left.'%;width:'.$width.'%;top:3px;'
  		    //height des barres du haut
  			.' height:'.($lineHeight).'px;'
  			.' background-color:#'.'EEEEFF'.'; '
  			.' border:1px solid #'.'AAAAEE'.';" ';
  		if (! $print)	$result.='title="'.$title.'" ';
  		$result.='>';
  		$result.='<div style="z-index:1;position: absolute; top:0px;right:0px;height:'.$lineHeight.'px;white-space:nowrap;overflow:hidden;'
  				.'width:100%;text-align:center;color:#'.(($p['rate']>100)?'EEAAAA':'AAAAEE').';">';
  		$result.=$p['rate'].'';
  		$result.= '</div>';
  		$result.='</div>';	
  	}
  	$periodsPerProject=self::buildResourcePeriodsPerResourceTeam($idResourceAff, $showIdle);
  	foreach ($periodsPerProject as $idP=>$proj) {
  	  foreach ($proj['periods'] as $p) {
  	    $len=dayDiffDates(max($start,$p['start']), min($end,$p['end']))+1;
  	    $width=($len/$duration*100);
  	    $left=(dayDiffDates($start, max($start,$p['start']))/$duration*100);
  	    $title='['.$p['rate'].'] '.self::formatDate($p['start']).' => '.self::formatDate($p['end']);
  	    $title.="\n".SqlList::getNameFromId('Resource', $projects[$idP]['name']);
  	    $color='#EEEEEE';
  	    $result.= '<div style="position:absolute;left:'.$left.'%;width:'.$width.'%;'
  	        .' top:'.(3+($lineHeight+4)*($proj['position'])).'px;'
  	            .' height:'.($lineHeight).'px;z-index:'.(99-$proj['position']).';'
  	                .' background-color:'.$color.'; '
  	                    .' border:1px solid #222222;" ';
  	    if (! $print)	$result.='title="'.$title.'" ';
  	    $result.='>';
  	    $result.='<div style="position: absolute; top:0px;left:0px;width:100%;height:'.$lineHeight.'px;overflow:visible;'
  	        .'color:'.htmlForeColorForBackgroundColor($color).';text-shadow:1px 1px '.$color.';white-space:nowrap;z-index:9999">';
  	    $result.='['.$p['rate'].']&nbsp;'.SqlList::getNameFromId('Resource', $projects[$idP]['name']);
  	    $result.= '</div>';
  	    $result.='</div>';
  	  }
  	}
  	$result.= '</div>';
  	return $result;
  }
  
}
?>