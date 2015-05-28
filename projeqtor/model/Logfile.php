<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
* Copyright 2009-2015 Pascal BERNARD - support@projeqtor.org
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
require_once('_securityCheck.php');
class Logfile
{
    var $name;
    var $size;
    var $date;
 
    function purge($datePurge) {
      $error="";
      traceLog("Logfile->purge() : Technical trace to keep current log file");
      $cpt=0;
      disableCatchErrors();
      foreach (self::getList() as $file) {
        $date=$file['date'];
        if ($date<$datePurge) {
          if ( is_writable($file['path'])){
            unlink($file['path']);
            $cpt++;
          } else {
            $error.=i18n("cannotDeleteFile",$file['name'])."<br/>";
          }
        }
      }
      enableCatchErrors();
      if (! $error) {
        $returnValue=$cpt . " " . i18n(get_class($this)) . '(s) ' . i18n('doneoperationdelete');
        $returnStatus="OK";
      } else {
        $returnValue=$error;
        $returnStatus="ERROR";
      }
      $returnValue .= '<input type="hidden" id="lastSaveId" value="" />';
      $returnValue .= '<input type="hidden" id="lastOperation" value="delete" />';
      $returnValue .= '<input type="hidden" id="lastOperationStatus" value="'.$returnStatus.'" />';
      $returnValue .= '<input type="hidden" id="noDataMessage" value="' . htmlGetNoDataMessage(get_class($this)) . '" />';
      return $returnValue;
    }
    
    static function getDir() {
      $logName=Parameter::getGlobalParameter('logFile');
      return pathinfo($logName,PATHINFO_DIRNAME); 
    }
    
    static function getList() {
      $error='';
      $dir=self::getDir();
      if (! is_dir($dir)) {
        traceLog ("Logfile->getList() - directory '$dir' does not exist");
        $error="Logfile->getList() - directory '$dir' does not exist";
      }
      if (! $error) {
        $handle = opendir($dir);
        if (! is_resource($handle)) {
          traceLog ("Logfile->getList() - Unable to open directory '$dir' ");
          $error="Logfile->getList() - Unable to open directory '$dir' ";
        }
      } 
      $files=array();
      while (!$error and ($file = readdir($handle)) !== false) {
        if ($file == '.' || $file == '..') {
          continue;
        }
        $filepath = ($dir == '.') ? $file : $dir . '/' . $file;
        if (is_link($filepath)) {
          continue;
        }
        if (is_file($filepath) and substr($file,0,1)!='.') {
          $fileDesc=array('name'=>$file,'path'=>$filepath);
          $dt=filemtime ($filepath);
          $date=date('Y-m-d H:i',$dt);
          $fileDesc['date']=$date;
          $fileDesc['size']=filesize($filepath);
          $files[]=$fileDesc;
        }
      }
      if (! $error) closedir($handle);
      return $files;
    }
}
 