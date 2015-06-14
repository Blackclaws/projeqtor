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
    public $zipFile;
    public $isDeployed;
    public $versionDeployed;
    public $versionCompatible;
    
    function __construct() {
    }
    
    function getInfos() {
      
    }
    
    public function load($file) {
      $this->name=str_repace('.zip','',$file['name']);
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
        self::errorLog("Plugin::load() : $result");
        return $result;
      }
      
      $descriptorFileName="../plugin/$plugin/pluginDescriptor.xml";
      if (! is_file($descriptorFileName)) {
        $result="cannot find file $descriptorFileName for plugin $plugin";
        self::errorLog("Plugin::load() : $result");
        return $result;
      }
      $descriptorXml=file_get_contents($descriptorFileName);
      $parse = xml_parser_create();
      xml_parse_into_struct($parse, $descriptorXml, $value, $index);
      xml_parser_free($parse);
    
      foreach($value as $prop) {
        if ($prop['tag']=='PROPERTY') {
          //print_r($prop);
          $name=$prop['attributes']['NAME'];
          $value=$prop['attributes']['VALUE'];
          $$name=$value;
        }
      }
    
      // Update database for plugIn
      if (isset($sql)) {
        $sqlfile="../plugin/$plugin/$sql";
        if (! is_file($sqlfile)) {
          $result="cannot find file $sqlfile for plugin $plugin";
          self::errorLog("Plugin::load() : $result");
          return $result;
        }
      }
      //$enforceUTF8=true;
      //Sql::query("SET NAMES utf8");
      
      // !!!! to be able to call runScrip, the calling script must include "../db/maintenanceFunctions.php"
      runScript(null,$sqlfile);

      kill($this->zipFile);
      $this->versionDeployed=Parameter::getGlobalParameter('dbVersion');
      $this->isDeployed=true;
      $this->save();
    }
    
    static function getDir() {
      return "../plugin/"; 
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
        if (is_file($filepath) and strtolower(substr($file,-3))=='.zip') {
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
 