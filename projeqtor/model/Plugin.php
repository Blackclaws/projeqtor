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
require_once('_securityCheck.php');
class Plugin extends SqlElement {
    public $id;
    public $name;
    public $description;
    public $zipFile;
    public $isDeployed;
    public $deploymentDate;
    public $deploymentVersion;
    public $compatibilityVersion;
    public $pluginVersion;
    public $idle;
    
    function __construct() {
    }
    
    function __destruct() {
      parent::__destruct();
    }
    
    static function getFromName($name) {
      return SqlElement::getSingleSqlElementFromCriteria('Plugin', array('name'=>$name, 'idle'=>'0'));
    }
    
    public function load($file) {
      traceLog("New plugin found : ".$file['name']);
      $this->name=str_replace('.zip','',$file['name']);
      $pos=strpos(strtolower($this->name),'_v');
      if ($pos) $this->name=substr($this->name,0,$pos);
      $this->zipFile=$file['path'];
      $plugin=$this->name;
      
      $result="OK";
      // unzip plugIn files
      $zip = new ZipArchive;
      $res = $zip->open($this->zipFile);
      if ($res === TRUE) {
        $zip->extractTo(self::getDir());
        $zip->close();
      } else {
        $result="not able to unzip file '$this->zipFile'";
        errorLog("Plugin::load() : $result");
        return $result;
      }
      traceLog("Plugin unzipped succefully");
      
      $descriptorFileName="../plugin/$plugin/pluginDescriptor.xml";
      if (! is_file($descriptorFileName)) {
        $result="cannot find descriptor file $descriptorFileName for plugin $plugin";
        errorLog("Plugin::load() : $result");
        return $result;
      }
      $descriptorXml=file_get_contents($descriptorFileName);
      $parse = xml_parser_create();
      xml_parse_into_struct($parse, $descriptorXml, $value, $index);
      xml_parser_free($parse);
    
      foreach($value as $prop) {
        if ($prop['tag']=='PROPERTY') {
          //print_r($prop);
          $name='plugin'.ucfirst($prop['attributes']['NAME']);
          $value=$prop['attributes']['VALUE'];
          $$name=$value;
        }
      }
      // TODO : check version compatibility
        
      if (isset($pluginName)) $this->name=$pluginName;
      if (isset($pluginDescription)) $this->description=$pluginDescription;
      if (isset($pluginVersion)) $this->pluginVersion=$pluginVersion;
      if (isset($pluginCompatibility)) $this->compatibilityVersion=$pluginCompatibility;
      
      traceLog("Plugin descriptor information :");
      traceLog(" => name : $this->name");
      traceLog(" => description : $this->description");
      traceLog(" => version : $this->pluginVersion");
      traceLog(" => compatibility : $this->compatibilityVersion");
      
      // Update database for plugIn
      if (isset($pluginSql) and $pluginSql) {
        $sqlfile="../plugin/$plugin/$pluginSql";
        if (! is_file($sqlfile)) {
          $result="cannot find Sql file $sqlfile for plugin $plugin";
          errorLog("Plugin::load() : $result");
          return $result;
        }
        //$enforceUTF8=true;
        //Sql::query("SET NAMES utf8");
        // Run Sql defined in Descriptor
        // !!!! to be able to call runScrip, the calling script must include "../db/maintenanceFunctions.php"
        $nbErrors=runScript(null,$sqlfile);
        traceLog("Plugin updated database with $nbErrors errors from script $sqlfile");
        // TODO : display error and decide action (stop / continue)
      }
      
      // TODO : move files if needed
      
      // Delete zip
      kill($this->zipFile);
      // set previous version to idle (if exists)
      $old=self::getFromName($this->name);
      if ($old->id) {
        $old->idle=1;
        $old->save();
      }
      // Save deployment data
      $this->deploymentVersion=Parameter::getGlobalParameter('dbVersion');
      $this->deploymentDate=date('Y-m-d');
      $this->isDeployed=1;
      $this->idle=0;
      $resultSave=$this->save();
      debugLog($resultSave);
      traceLog("Plugin completely deployed");
      return "OK";
    }
    
    static function getDir() {
      return "../plugin"; 
    }
    
    static function getZipList() {
      $error='';
      $dir=self::getDir();
      if (! is_dir($dir)) {
        traceLog ("Plugin->getList() - directory '$dir' does not exist");
        $error="Plugin->getList() - directory '$dir' does not exist";
      }
      if (! $error) {
        $handle = opendir($dir);
        if (! is_resource($handle)) {
          traceLog ("Plugin->getList() - Unable to open directory '$dir' ");
          $error="Plugin->getList() - Unable to open directory '$dir' ";
        }
      } 
      $files=array();
      while (!$error and ($file = readdir($handle)) !== false) {
        if ($file == '.' || $file == '..' || $file=='index.php') {
          continue;
        }
        $filepath = ($dir == '.') ? $file : $dir . '/' . $file;
        if (is_link($filepath)) {
          continue;
        }
        if (is_file($filepath) and strtolower(substr($file,-4))=='.zip') {
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
 