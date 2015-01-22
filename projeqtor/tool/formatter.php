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

function colorNameFormatter($value) {
  global $print;
  if ($value) {
    $tab=explode("#split#",$value);
    if (count($tab)>1) {
      if (count($tab)==2) { // just found : val #split# color
        $val=$tab[0];
        $color=$tab[1];
        $order='';
      } else if (count($tab)==3) { // val #split# color #split# order
          $val=$tab[1];
          $color=$tab[2];
          $order=$tab[0];
      } else { // should not be found
        return value;
      }
      $foreColor='#000000';
      if (strlen($color)==7) {
        $red=substr($color,1,2);
        $green=substr($color,3,2);
        $blue=substr($color,5,2);
        $light=(0.3)*base_convert($red,16,10)+(0.6)*base_convert($green,16,10)+(0.1)*base_convert($blue,16,10);
        if ($light<128) { $foreColor='#FFFFFF'; }
      }
      return '<div style="text-align: center;width:' . (($print)?'95':'100') . '%;background-color: ' . $color . '; color:' . $foreColor . ';">' . $val . '</div>';

    } else {
      return $value;
    }
  } else { 
    return ''; 
  }
}
function colorTranslateNameFormatter($value) {
	global $print;
	if ($value) {
		$tab=explode("#split#",$value);
		if (count($tab)>1) {
			if (count($tab)==2) { // just found : val #split# color
				$val=$tab[0];
				$color=$tab[1];
				$order='';
			} else if (count($tab)==3) { // val #split# color #split# order
				$val=$tab[1];
				$color=$tab[2];
				$order=$tab[0];
			} else { // should not be found
				return value;
			}
			$foreColor='#000000';
			if (strlen($color)==7) {
				$red=substr($color,1,2);
				$green=substr($color,3,2);
				$blue=substr($color,5,2);
				$light=(0.3)*base_convert($red,16,10)+(0.6)*base_convert($green,16,10)+(0.1)*base_convert($blue,16,10);
				if ($light<128) { $foreColor='#FFFFFF'; }
			}
			return '<div style="text-align: center;width:' . (($print)?'95':'100') . '%;background-color: ' . $color . '; color:' . $foreColor . ';">' . i18n($val) . '</div>';

		} else {
			return i18n($value);
		}
	} else {
		return '';
	}
}

function booleanFormatter($value) {
  if ($value==1) { 
    return '<img src="img/checkedOK.png" width="12" height="12" />'; 
  } else { 
    return '<img src="img/checkedKO.png" width="12" height="12" />'; 
  }
}

function colorFormatter($value) {
  if ($value) { 
    return '<table width="100%"><tr><td style="background-color: ' . $value . '; width: 100%;">&nbsp;</td></tr></table>'; 
  } else { 
    return ''; 
  }
}

function dateFormatter($value) {
  return htmlFormatDate($value,false);
}

function timeFormatter($value) {
  return htmlFormatTime($value,false);
}

function dateTimeFormatter($value) {
  return htmlFormatDateTime($value,false);
}

function translateFormatter($value) {
  if ($value) { 
    return i18n($value); 
  } else { 
    return ''; 
  }
}

function percentFormatter($value) {
  if ($value!==null) { 
    return $value . '&nbsp;%';
  } else {
    return ''; 
  }
}

function numericFormatter($value) {
  return ltrim($value,"0");
}

function sortableFormatter($value) {
  $tab=explode(".",$value);
  $result='';
  foreach ($tab as $val) {
    $result.=($result!="")?".":"";
    $result.=ltrim($val,"0");
  }
  return $result; 
}

function thumbFormatter($objectClass,$id,$size) {
	$image=SqlElement::getSingleSqlElementFromCriteria('Attachment', array('refType'=>$objectClass, 'refId'=>$id));
  if ($image->id and $image->isThumbable()) {
    return '<img src="'.getImageThumb($image->getFullPathFileName(),$size).'" />';
  } else {
  	return "";
  }
}

function numericFixLengthFormatter($val, $numericLength=0) {  
  if ($numericLength>0) {
    $val=str_pad($val,$numericLength,'0', STR_PAD_LEFT);
  }
  return $val;
}

function workFormatter($value) {
  //$val=ltrim($value,"0");
  return Work::displayWorkWithUnit(htmlDisplayNumeric($value));
}

function costFormatter($value) {
	return htmlDisplayCurrency($value);
}

function iconFormatter($value) {
  if (! $value) return "";
  return '<img src="icons/'.$value.'" />';
}

function formatUserThumb($userId,$userName,$title,$size=22,$float='right') {
	if (! $userId) return '';
	$radius=round($size/2,0);
	$file=Affectable::getThumbUrl('Affectable', $userId, $size);
	$known=(substr($file,0,23) != '../view/img/Affectable/')?true:false;
	$res='<img style="width:'.$size.'px;height:'.($size).'px;float:'.$float.';border-radius:'.$radius.'px"';
	
	$res.=' src="'.$file.'" ';
	if ($title) {
		$title=htmlEncode(i18n('thumb'.$title.'Title',array($userName)),'quotes');
	}
	if ($known) {
	  $res.=' onMouseOver="showBigImage(\'Affectable\',\''.$userId.'\',this,\''.$title.'\');" onMouseOut="hideBigImage();"';
	}
	$res.='/>';
	return $res;
}

function formatColorThumb($col,$val, $size=20, $float='right') {
  $class=substr($col,2);
  if (! class_exists($class)) return ''; 
  $color=SqlList::getFieldFromId($class, $val, 'color');
  if (! $color) return '';
  $radius=round($size/2,0);
  $res='<div style="border: 1px solid #AAAAAA;background:'.$color.';';
  $res.='width:'.$size.'px;height:'.($size-2).'px;float:'.$float.';border-radius:'.$radius.'px">&nbsp;</div>';
  return $res;
}
function formatDateThumb($creationDate,$updateDate,$float='right',$size=16) {
  $res='<img style="width:'.$size.'px;height:.'.$size.'px;float:'.$float.';"';
  $today=date('Y-m-d');
  $date=($updateDate)?$updateDate:$creationDate;
  $date=substr($date,0,10);
  $color="White";
  if ($date==$today) {
    $color.='Red';
  } else if (addWorkDaysToDate($date,1)==$today) {
    $color.='Yellow';
  }  
  $file="../view/img/calendar$color$size.png";
	$res.=' src="'.$file.'" ';
  //$res.=' onMouseOver="showBigImage(\'Affectable\',\''.$userId.'\',this,\''.$title.'\');" onMouseOut="hideBigImage();"';
	$res.='/>';
	return $res;
}