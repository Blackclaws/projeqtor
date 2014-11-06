<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2014 Pascal BERNARD - support@projeqtor.org
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

/** ============================================================================
 * Project is the main object of the project managmement.
 * Almost all other objects are linked to a given project.
 */  
require_once('_securityCheck.php');
class Affectation extends SqlElement {

  // List of fields that will be exposed in general user interface
  public $_col_1_2_Description;
  public $id;    // redefine $id to specify its visible place 
  public $idResourceSelect;
  public $idResource;
  public $idContact;
  public $idUser;
  public $idProject;
  public $rate;
  public $startDate;
  public $endDate;
  public $idle;
  public $description;
  public $_col_2_2;
  public $_resourcePeriods=array();
  
public $_noCopy;

  // Define the layout that will be used for lists
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="5%" ># ${id}</th>
    <th field="nameResourceSelect" width="20%" >${resourceName}</th>
    <th field="nameContact" width="20%" >${contactName}</th>
    <th field="nameUser" width="20%" >${userName}</th>
    <th field="nameProject" width="20%" >${projectName}</th>
    <th field="rate" width="10%" formatter="percentFormatter">${rate}</th>  
    <th field="idle" width="5%" formatter="booleanFormatter" >${idle}</th>
    ';
  
  private static $_colCaptionTransposition = array('idUser'=>'orUser', 
                                                   'idContact'=>'orContact',
                                                   'idResourceSelect'=>'idResource');
  
   private static $_fieldsAttributes=array("idResourceSelect"=>"hidden, forceExport", "idResource"=>"noExport,noList"); 
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
    /*if ($this->id) {
    	if ($this->idResource) {
    		if (!$this->idContact) {
    			$this->idContact=$this->idResource;
    		}
    	  if (!$this->idUser) {
          $this->idUser=$this->idResource;
        }
    	}
    }*/
    if (SqlList::getNameFromId('Resource', $this->idResource)==$this->idResource) {
    	$this->idResource=null;
    }
    
    if (! $this->id) {
    	$this->rate=100;
    }
  }

   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }

// ============================================================================**********
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
     /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld) {
    return self::$_colCaptionTransposition;
  }
// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********
  
  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    $colScript = parent::getValidationScript($colName);

     if ($colName=="idResource") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= 'if (testAllowedChange(this.value)) {';
      $colScript .= '  dijit.byId("idContact").set("value",this.value);';
      $colScript .= '  if (! dijit.byId("idContact").get("value")) { dijit.byId("idContact").set("value",null); }'; 
      $colScript .= '  dijit.byId("idUser").set("value",this.value);'; 
      $colScript .= '  if (! dijit.byId("idUser").get("value")) { dijit.byId("idUser").set("value",null); }'; 
      $colScript .= '  terminateChange();';
      $colScript .= '  formChanged();';
      $colScript .= '};';
      $colScript .= '</script>';
    }
    if ($colName=="idContact") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= 'if (testAllowedChange(this.value)) {';
      $colScript .= '  dijit.byId("idResource").set("value",this.value);';
      $colScript .= '  if (! dijit.byId("idResource").get("value")) { dijit.byId("idResource").set("value",null); }'; 
      $colScript .= '  dijit.byId("idUser").set("value",this.value);'; 
      $colScript .= '  if (! dijit.byId("idUser").get("value")) { dijit.byId("idUser").set("value",null); }'; 
      $colScript .= '  terminateChange();';
      $colScript .= '  formChanged();';
      $colScript .= '}';
      $colScript .= '</script>';
    }
    if ($colName=="idUser") {   
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= 'if (testAllowedChange(this.value)) {';;
      $colScript .= '  dijit.byId("idContact").set("value",this.value);';
      $colScript .= '  if (! dijit.byId("idContact").get("value")) { dijit.byId("idContact").set("value",null); }'; 
      $colScript .= '  dijit.byId("idResource").set("value",this.value);'; 
      $colScript .= '  if (! dijit.byId("idResource").get("value")) { dijit.byId("idResource").set("value",null); }'; 
      $colScript .= '  terminateChange();';
      $colScript .= '  formChanged();';
      $colScript .= '}';
      $colScript .= '</script>';
    }
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  public function drawAffectationList($critArray, $nameDisp) {
    $result="<table>";
    $affList=$this->getSqlElementsFromCriteria($critArray, false);
// TEST - New - Start
//drawAffectationsFromObject($affList, $$obj, $nameDisp, false);
//return;    
// TEST - New - Stop
    foreach ($affList as $aff) {
    	if ($nameDisp=='Resource' and ! $aff->idResource) continue;
    	if ($nameDisp=='Resource' and SqlList::getNameFromId('Resource', $aff->idResource)==$aff->idResource) continue;
    	if ($nameDisp=='Contact' and ! $aff->idContact) continue;
    	if ($nameDisp=='User' and ! $aff->idUser) continue; 
      $result.= '<tr>';
      $result.= '<td valign="top" width="20px"><img src="css/images/iconList16.png" height="16px" /></td>';
      $result.= '<td>';
      $disp=''; 
      if ($nameDisp=='Resource') {
        $disp.=SqlList::getNameFromId('Resource', $aff->idResource);
      } else if ($nameDisp=='Contact') {
        $disp.=SqlList::getNameFromId('Contact', $aff->idContact);
      } else if ($nameDisp=='User') {
        $disp.=SqlList::getNameFromId('User', $aff->idUser);
      } else if ($nameDisp=='Project') {
        $disp.=SqlList::getNameFromId('Project', $aff->idProject);      
      } else{
        $disp.=SqlList::getNameFromId('Resource', $aff->idResource);
        $disp.=' - ';
        $disp.=SqlList::getNameFromId('Project', $aff->idProject);
      }
      if ($aff->rate ) {
        $disp.=' (' . $aff->rate . '%)';
      }
      $result.=htmlDrawLink($aff,$disp);
      $result.= '</td></tr>';
    }
    $result .="</table>";
    return $result; 
  }
  
  public function control(){
    $result="";
    $this->idResource=trim($this->idResource);
    $this->idResourceSelect=trim($this->idResourceSelect);
    $this->idContact=trim($this->idContact);
    $this->idUser=trim($this->idUser);
    $this->idProject=trim($this->idProject);
    if (!$this->idResource) {
      if ($this->idContact) {
      	$this->idResource=$this->idContact;
      } else if ($this->idResourceSelect) {
      	$this->idResource=$this->idResourceSelect;
      } else {
      	$this->idResource=$this->idUser;
      }
    }
    //echo " ress=".$this->idResourceSelect." cont=".$this->idContact." user=".$this->idUser;
    //echo " id=".$this->idResource;
    $affectable=new Affectable($this->idResource);
    if ($affectable->isResource) {
      $this->idResourceSelect=$this->idResource;
    } else {
      $this->idResourceSelect=null;
    }
    if ($affectable->isUser) {
      $this->idUser=$this->idResource;
    } else {
      $this->idUser=null;
    }
    if ($affectable->isContact) {
      $this->idContact=$this->idResource;
    } else {
      $this->idContact=null;
    }
    
    if (! $this->idResource) {
    	$result.='<br/>' . i18n('messageMandatory',array(i18n('colIdResource') 
    	                                         . ' ' . i18n('colOrContact') 
    	                                         . ' ' . i18n('colOrUser')));
    }
    if (! $this->idProject) {
    	$result.='<br/>' . i18n('messageMandatory',array(i18n('colIdProject')));
    }
    if ($result=='') {
      $clauseWhere=" idResource=".Sql::fmtId($this->idResource)
         ." and idProject=".Sql::fmtId($this->idProject)
         ." and id<>".Sql::fmtId($this->id);
      $search=$this->getSqlElementsFromCriteria(null, false, $clauseWhere);
      if (count($search)>0) { 
      	$result.='<br/>' . i18n('errorDuplicateAffectation');
      }
    } else {
    
    }
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }if ($result=="") {
      $result='OK';
    }
    return $result;
  }
  
  /**=========================================================================
   * Overrides SqlElement::save() function to add specific treatments
   * @see persistence/SqlElement#save()
   * @return the return message of persistence/SqlElement#save() method
   */
  public function save() {
  	$old=$this->getOld();
  	$result = parent::save();
    if (! $old->id or $this->idle!=$old->idle) {
      User::resetAllVisibleProjects(null,$this->idUser);
    }
    return $result;
  }
  
  public function delete() {
    $result = parent::delete();
    User::resetAllVisibleProjects(null,$this->idUser);
    return $result;
  }
  
  public static function updateAffectations($resource) {
  	$crit=array('idResource'=>$resource);
  	$aff=new Affectation();
  	$affList=$aff->getSqlElementsFromCriteria($crit, false);
  	foreach ($affList as $aff) {
  		$aff->save();
  	}
  }
  
  public static function updateIdle($idProject,$idResource) {
    $aff=new Affectation();
    $crit=array("idle"=>'0');
    if ($idProject) {$crit['idProject']=$idProject;}
    if ($idResource) {$crit['idResource']=$idResource;}
    $affList=$aff->getSqlElementsFromCriteria($crit, false);
    foreach ($affList as $aff) {
      $aff->idle=1;
      $aff->save();
    }
  }
  public static $maxAffectationDate='2029-12-31';
  public static $minAffectationDate='1970-01-01';
  public static function buildResourcePeriods($idResource,$showIdle=false) {
    if (isset($_resourcePeriods[$idResource][$showIdle])) {
    	return $_resourcePeriods[$idResource][$showIdle];
    }
  	$aff=new Affectation();
  	$crit=array('idResource'=>$idResource);
  	if (!$showIdle) {
  		$crit['idle']='0';
  	}
  	$list=$aff->getSqlElementsFromCriteria($crit,false,null, 'startDate asc, endDate asc, idProject asc');
  	$res=array();
  	foreach ($list as $aff) {
  		$start=($aff->startDate)?$aff->startDate:self::$minAffectationDate;
  		$end=($aff->endDate)?$aff->endDate:self::$maxAffectationDate;
  		$arrAffProj=array($aff->idProject=>$aff->rate);
  		foreach($res as $r) {
  			if (!$start or !$end) break;
  			if ($start<=$r['start']) {
  				if ($end>=$r['start']) {
  					if ($end<=$r['end']) {
  						$res[$r['start']]=array(
  								'start'=>$r['start'],
  								'end'=>$end,
  								'rate'=>$aff->rate+$r['rate'],
  								'projects'=>array_sum_preserve_keys($r['projects'],$arrAffProj));
  						if ($end!=$r['end']) {
	  						$next=addDaysToDate($end, 1);
	  						$res[$next]=array(
	  								'start'=>$next,
	  								'end'=>$r['end'],
	  								'rate'=>$r['rate'],
	  								'projects'=>$r['projects']);
  						}
  						$end=($start!=$r['start'])?addDaysToDate($r['start'], -1):'';
  					} else {
  					  if ($start!=$r['start']) {
	  						$res[$start]=array(
	  								'start'=>$start,
	  								'end'=>addDaysToDate($r['start'], -1),
	  								'rate'=>$aff->rate,
	  								'projects'=>$arrAffProj);
  					  }
  						$next=$r['start'];
  						$res[$next]=array(
  								'start'=>$next,
  								'end'=>$r['end'],
  								'rate'=>$r['rate']+$aff->rate,
  								'projects'=>array_sum_preserve_keys($r['projects'],$arrAffProj));
  						$start=($end!=$r['end'])?addDaysToDate($r['end'], 1):'';
  					}
  				}  				
  			} else { //$start>$r['startDate'] 
  				if ($start<=$r['end']) {
  					$res[$r['start']]=array(
  							'start'=>$r['start'],
  							'end'=>addDaysToDate($start, -1),
  							'rate'=>$r['rate'],
  							'projects'=>$r['projects']);
  					if ($end<=$r['end']) { 						
  						$res[$start]=array(
  								'start'=>$start,
  								'end'=>$end,
  								'rate'=>$r['rate']+$aff->rate,
  								'projects'=>array_sum_preserve_keys($r['projects'],$arrAffProj));
  						if ($end!=$r['end']) {
  							$next=addDaysToDate($end, 1);
  							$res[$next]=array(
  									'start'=>$next,
  									'end'=>$r['end'],
  									'rate'=>$r['rate'],
  									'projects'=>$r['projects']);
  						}
  						$start='';$end='';
  					} else { // ($end>$r['end'])
  						$res[$start]=array(
  								'start'=>$start,
  								'end'=>$r['end'],
  								'rate'=>$r['rate']+$aff->rate,
  								'projects'=>array_sum_preserve_keys($r['projects'],$arrAffProj));
  						$start=addDaysToDate($r['end'], 1);
  					}
  				}
  			}
  		} // End loop
  		if ($start and $end) {
  		  $res[$start]=array('start'=>$start,
  		  		               'end'=>$end,
  		  		               'rate'=>$aff->rate,
  		  		               'projects'=>$arrAffProj);
  		}
  	}
  	if (!isset($_resourcePeriods[$idResource])) {
  		$_resourcePeriods[$idResource]=array();
  	}
  	ksort($res);
  	$_resourcePeriods[$idResource][$showIdle]=$res;
  	return $res;
  }
  public static function buildResourcePeriodsPerProject($idResource, $showIdle=false){
  	$periods=self::buildResourcePeriods($idResource,$showIdle);
  	$cptProj=0;
  	$projects=array();
  	foreach ($periods as $p) {
  		foreach($p['projects'] as $idP=>$affP) {
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
  				and $last['end']=addDaysToDate($p['start'], -1) 
  				and $last['rate']=$p['rate']) {
  				$projects[$idP]['periods'][count($per)-1]['end']=$p['end'];
  			} else {
  				$projects[$idP]['periods'][]=array('start'=>$p['start'], 'end'=>$p['end'], 'rate'=>$p['projects'][$idP]);
  			}
  		}
  	}
  	return $projects; 
  }
  
  public static function drawResourceAffectation($idResource, $showIdle=false) {
  	global $print;
  	$periods=self::buildResourcePeriods($idResource,$showIdle);
  	if (count($periods)==0) return;
  	$first=reset($periods);
  	$start=$first['start'];
  	$last=end($periods);
  	$end=$last['end'];
  	$projects=array();
  	$nb=count($periods);
  	if ( ($start==self::$minAffectationDate or $end==self::$maxAffectationDate) and $nb>1) {
  		if ($start==self::$minAffectationDate) {
  			if ($end==self::$maxAffectationDate){
  				$newDur=dayDiffDates($first['end'],$last['start'])+1;
  				
  			} else {
  				$newDur=dayDiffDates($first['end'],$end)+1;
  			}
  		} else {
  			$newDur=dayDiffDates($start,$last['start'])+1;
  		}
  		$gap=ceil($newDur/$nb);
  		$start=($start==self::$minAffectationDate)?addDaysToDate($first['end'], $gap*(-1)):$start;
  		$end=($end==self::$maxAffectationDate)?addDaysToDate($last['start'], $gap):$end;
  	} 	 
  	$duration=dayDiffDates($start, $end)+1;
  	$maxRate=100;
  	$lineHeight=15;
  	$cptProj=0;
  	foreach ($periods as $p) {
  		if ($p['rate']>$maxRate) $maxRate=$p['rate'];
  		foreach($p['projects'] as $idP=>$affP) {
  			if (! isset($projects[$idP])) {
  				$cptProj++;
  				$projects[$idP]=array('position'=>$cptProj,
  						'name'=>SqlList::getNameFromId('Project',$idP), 
  						'color'=>SqlList::getFieldFromId('Project', $idP, 'color'));
  			}
  		}
  	}
  	$result='<div style="position:relative;height:5px;"></div>'
  			.'<div style="position:relative;width:99%; height:'.((count($projects)+1)*($lineHeight+4)+4).'px; '
  			.' border: 1px solid #AAAAAA;background-color:#FEFEFE;'
  			.'border-radius:5px; box-shadow:2px 2px 2px #888888; overflow:hidden;">';
  	foreach ($periods as $p) {
  		$len=dayDiffDates(max($start,$p['start']), min($end,$p['end']))+1;
  		$width=($len/$duration*100);
  		$left=(dayDiffDates($start, max($start,$p['start']))/$duration*100);
  		$title=self::formatDate($p['start']).' => '.self::formatDate($p['end']).' - '.$p['rate'].'%';
  		foreach ($p['projects'] as $idP=>$affP) {
  			$title.="\n".$affP.'% - '.SqlList::getNameFromId('Project',$idP);
  		}
  		$result.= '<div style="position:absolute;left:'.$left.'%;width:'.$width.'%;top:3px;'
  			.' height:'.($lineHeight).'px;'
  			.' background-color:#'.(($p['rate']>100)?'FFDDDD':'EEEEFF').'; '
  			.' border:1px solid #'.(($p['rate']>100)?'EEAAAA':'AAAAEE').';border-radius:5px;" ';
  		if (! $print)	$result.='title="'.$title.'" ';
  		$result.='>';
  		$result.='<div style="z-index:1;position: absolute; top:0px;right:0px;height:'.$lineHeight.'px;white-space:nowrap;overflow:hidden;'
  				.'width:100%;text-align:center;color:#'.(($p['rate']>100)?'EEAAAA':'AAAAEE').';">';
  		$result.=$p['rate'].'%';
  		$result.= '</div>';
  		$result.='</div>';	
  	}
  	$periodsPerProject=self::buildResourcePeriodsPerProject($idResource, $showIdle);
  	foreach ($periodsPerProject as $idP=>$proj) {
  		foreach ($proj['periods'] as $p) {
	  		$len=dayDiffDates(max($start,$p['start']), min($end,$p['end']))+1;
	  		$width=($len/$duration*100);
	  		$left=(dayDiffDates($start, max($start,$p['start']))/$duration*100);
	  		$title=self::formatDate($p['start']).' => '.self::formatDate($p['end']).' - '.$p['rate'].'%';
	  		$title.="\n".$projects[$idP]['name'];
	  		$color=($projects[$idP]['color'])?$projects[$idP]['color']:'#EEEEEE';
	  		$result.= '<div style="position:absolute;left:'.$left.'%;width:'.$width.'%;'
	  				.' top:'.(3+($lineHeight+4)*($proj['position'])).'px;'
	  				.' height:'.($lineHeight).'px;z-index:'.(99-$proj['position']).';'
	  				.' background-color:'.$color.'; '
	  				.' border:1px solid #222222;border-radius:5px" ';
  		if (! $print)	$result.='title="'.$title.'" ';
  		$result.='>';
debugLog($projects[$idP]['name']." debut=".$p['start']." fin=".$p['end']." left=".$left."% width:".$width."%");
	  		//$result.='<div style="z-index:1;position: absolute; top:0px;right:0px;height:'.$lineHeight.'px;white-space:nowrap;overflow:hidden;'
	  		//		.'width:100%;text-align:right;color:'.htmlForeColorForBackgroundColor($color).';">';
	  		//$result.=$p['rate'].'%';
	  		//$result.= '</div>';
	  		$result.='<div style="position: absolute; top:0px;left:0px;width:100%;height:'.$lineHeight.'px;overflow:visible;'
	  				.'color:'.htmlForeColorForBackgroundColor($color).';text-shadow:1px 1px '.$color.';white-space:nowrap;z-index:9999">';
	  		$result.='['.$p['rate'].'%]&nbsp;'.$projects[$idP]['name'];
	  		$result.= '</div>';
	  		$projects[$idP]['name']='';	  			
	  		$result.='</div>';
  		}
  	}
  	$result.= '</div>';
  	return $result;
  }
  
  private static function formatDate($date) {
  	if ($date==self::$minAffectationDate) {
  		return "*";
  	}
  	if ($date==self::$maxAffectationDate) {
  		return "*";
  	}
  	return htmlFormatDate($date);
  }
  
}
?>