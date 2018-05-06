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

class File {

  private static $dir='../user/';
	/** ==========================================================================
	 * Constructor
	 * @param $id the id of the object in the database (null if not stored yet)
	 * @return void
	 */
	function __construct() {
		
	}
	
	/** ==========================================================================
	 * Destructor
	 * @return void
	 */
	function __destruct() {
		
	}
	
	public static function getRstList() {
	  $handle = opendir(self::$dir);
	  $result=array();
	  while ( ($file = readdir($handle)) !== false) {
	    if ($file == '.' || $file == '..' || $file=='index.php' || is_dir(self::$dir.$file) || substr($file,0,1)=='.' || substr($file,-4)!='.rst') {
	      continue;
	    }
	    $result[]=$file;
	  }
	  closedir($handle);
	  asort($result);
	  return $result;
	}
	
	public static function getFile($file) {
	  return file_get_contents(self::$dir.$file);
	}
	public static function convert($data) {
	  $parser = new Gregwar\RST\Parser;
	  //foreach (self::getRstList() as $file) {
	  //  $data=".. include:: ".self::$dir.$file."\n".$data;
	  //}
	  //$data=str_replace(array('  .. compound::',   ' .. compound::',    '  .. xnote::',   ' .. xnote::'),
	  //                  array('.. compoundblock::','.. compoundblock::','.. noteblock::','.. noteblock::'),$data);
	  $data=str_replace(array(':term:','* - ','**\*',':kbd:'),array(':ref:','* ','** *',':ref:'),$data);
	  $data=preg_replace('/ {1,2}\.\. note::/i','.. noteblock::',$data);
	  $data=preg_replace('/ {1,2}\.\. compound::/i','.. compoundblock::',$data);
	  
	  $doc=$parser->parse($data);
	  $doc=str_replace('images/', self::$dir.'images/', $doc);
	  return $doc;
	}
	public static function getDir() {
	  return self::$dir;
	}
	public static function saveFile($fileName,$data,$withBackup=true) {
	  $filepath=self::$dir.$fileName;
	  if ($withBackup) {
	    if (file_exists($filepath.'.bak')) {
	      unlink($filepath.'.bak');
	    }
	    rename($filepath,$filepath.'.bak');
	  }
	  $res=file_put_contents($filepath,$data);
	  if ($res===false) {
	    return "An error occured - File not saved";
	  } else {
	    return "file $fileName saved";
	  }
	}
	
}