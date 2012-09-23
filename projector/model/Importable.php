<?php 
/* ============================================================================
 * Habilitation defines right to the application for a menu and a profile.
 */ 
class Importable extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visible place 
  public $name;
  
  public $_isNameTranslatable = true;
  
  public static $importResult;
  public static $importCptOK;
  public static $importCptError;
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
  }

  
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }

// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  public static function import($fileName, $class) {
  	set_time_limit(3600);
  	$htmlResult="";
  	$cptOK=0;
  	$cptError=0;
		$lines=file($fileName);
		$title=null;
		$idxId=-1;
		$csvSep=Parameter::getGlobalParameter('csvSeparator');
		$obj=new $class();
		$captionArray=array();
		foreach ($obj as $fld=>$val) {
		  $captionArray[$obj->getColCaption($fld)]=$fld;
		}
		$htmlResult.='<TABLE WIDTH="100%" style="border: 1px solid black">';
		Sql::beginTransaction();
		foreach ($lines as $nbl=>$line) {
		  if (! mb_detect_encoding($line, 'UTF-8', true) ) {
		    $line=utf8_encode($line);
		  }
		  if ($title) {
		    $htmlResult.= '<TR>';
		    $fields=explode($csvSep,$line);     
		    $id=($idxId>=0)?$fields[$idxId]:null;
		    $obj=new $class($id);
		//$htmlResult $id . "/" . $obj->id . "<br/>";
		    foreach ($fields as $idx=>$field) { 
		      if ($field=='') {
		        $htmlResult.= '<td class="messageData" style="color:#000000;">' . htmlEncode($field) . '</td>';
		        continue; 
		      }
		      if ( strtolower($field)=='null') {
		        $field=null;
		      } 
		      if (substr(trim($field),0,1)=='"' and substr(trim($field),-1,1)=='"') {
		        $field=substr(trim($field),1,strlen(trim($field))-2);
		      }
		      $field=str_replace('""','"',$field);     
		      if (property_exists($obj,$title[$idx])) {
		        $obj->$title[$idx]=$field;
		        $htmlResult.= '<td class="messageData" style="color:#000000;">' . htmlEncode($field) . '</td>';
		        continue; 
		      } 
		      $idTitle='id' . ucfirst($title[$idx]);
		      if (property_exists($obj,$idTitle)) {
		        $val=SqlList::getIdFromName(ucfirst($title[$idx]),$field);
		        $htmlResult.= '<td class="messageData" style="color:#000000;">' . htmlEncode($field) . "/" . htmlEncode($val) . '</td>';
		        //$htmlResult.= " => " . htmlEncode($idTitle);
		        //$htmlResult.= "=" . htmlEncode($val);
		        $obj->$idTitle=$val;
		        continue; 
		      } 
		      if (property_exists($obj,get_class($obj).'PlanningElement')) {
		        $peClass=get_class($obj).'PlanningElement';
		        if (! is_object($obj->$peClass)) {
		          $obj->$peClass=new $peClass();
		        }
		        $pe=$obj->$peClass;
		        if (property_exists($pe,$title[$idx])) {
		          $obj->$peClass->$title[$idx]=$field;
		          $htmlResult.= '<td class="messageData" style="color:#000000;">' . htmlEncode($field) . '</td>';
		          continue; 
		        }
		        $idTitle='id' . ucfirst($title[$idx]);
		        if (property_exists($pe,$idTitle)) {   
		          $htmlResult.= '<td class="messageData" style="color:#000000;">' . htmlEncode($field) . '</td>';
		          $val=SqlList::getIdFromName(ucfirst($title[$idx]),$field);   
		          $obj->$peClass->$idTitle=$val;
		          continue; 
		        } 
		      }
		      $htmlResult.= '<td class="messageData" style="color:#A0A0A0;">' . htmlEncode($field) . '</td>';
		      continue; 
		    }
		    $htmlResult.= '<TD class="messageData" width="20%">';
		    //$obj->id=null;
		    $result=$obj->save();
		    if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
		      $htmlResult.= '<span class="messageERROR" >' . $result . '</span>';
		      $cptError+=1;
		    } else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
		      $htmlResult.= '<span class="messageOK" >' . $result . '</span>';
		      $cptOK+=1;
		    } else { 
		    	debugLog($result);
		      $htmlResult.= '<span class="messageWARNING" >' . $result . '</span>';
		      $cptError+=1;
		    }
		    $htmlResult.= '</TD></TR>';
		  } else {
		    $title=explode($csvSep,$line);
		    $htmlResult.= "<TR>";
		    $obj=new $class();
		    foreach ($title as $idx=>$caption) {
		      $title[$idx]=str_replace(' ','',strtolower(substr($caption,0,1)) . substr($caption,1));
		      $title[$idx]=str_replace(chr(13),'',$title[$idx]);
		      $title[$idx]=str_replace(chr(10),'',$title[$idx]);
		      $color="#A0A0A0";
		      $colCaption=$caption;
		      if (property_exists($obj,$title[$idx])) {
		        $color="#000000";
		        $colCaption=$obj->getColCaption($title[$idx]);
		        if ($title[$idx]=='id') {
		          $idxId=$idx;
		        }
		      } else { 
		        $idTitle='id' . ucfirst($title[$idx]);
		        if (property_exists($obj,$idTitle)) {   
		          $color="#000000";
		          $colCaption=$obj->getColCaption($idTitle);
		        } else if (array_key_exists($caption,$captionArray) and property_exists($obj,$captionArray[$caption]) ) {
		          $color="#000000";
		          $colCaption=$caption;
		          $title[$idx]=$captionArray[$caption];
		          if (substr($title[$idx],0,2)=="id" and strlen($title[$idx])>2) {
		            $title[$idx]=substr($title[$idx],2);
		          }
		        } else if (property_exists($obj,get_class($obj).'PlanningElement')) {
		          $peClass=get_class($obj).'PlanningElement';
		          $pe=$obj->$peClass;
		          if (property_exists($pe,$title[$idx])) {
		            $color="#000000";
		            $colCaption=$pe->getColCaption($title[$idx]);
		          } else {
		            $idTitle='id' . ucfirst($title[$idx]);
		            if (property_exists($pe,$idTitle)) {   
		              $color="#000000";
		              $colCaption=$pe->getColCaption($idTitle);
		            }
		          }
		        }
		      }
		      $htmlResult.= '<TH class="messageHeader" style="color:' . $color . ';">' . $colCaption . "</TH>";
		    }
		    $htmlResult.= '<th class="messageHeader" style="color:#208020">' . i18n('colResultImport') . '</th></TR>';
		  }
		}
		Sql::commitTransaction();
		$htmlResult.= "</TABLE>";
		self::$importResult=$htmlResult;
		self::$importCptOK=$cptOK;
		self::$importCptError=$cptError;
		if ($cptError==0) {
			return "OK";
		} else {
			return "Error";
		}
  }
  
  public static function getLogHeader() {
  	$nl="\n";
  	$result="";
  	$result.='<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"'.$nl; 
    $result.='"http://www.w3.org/TR/html4/strict.dtd">'.$nl;
    $result.='<html>'.$nl;
    $result.='<head>'.$nl;
    $result.='<meta http-equiv="content-type" content="text/html; charset=UTF-8" />'.$nl;
    $result.='<title>' . i18n("applicationTitle") . '</title>'.$nl;
    $result.='<style type="text/css">'.$nl;
    $result.='body{font-family:Verdana,Arial,Tahoma,sans-serif;font-size:8pt;}'.$nl;
    $result.='table{width:100%;border-collapse:collapse;border:1px;}'.$nl;
    $result.='.messageData{font-size:90%;padding:1px 5px 1px 5px;border:1px solid #AAAAAA;vertical-align:top;background-color:#FFFFFF;}'.$nl;
    $result.='.messageHeader{border:1px solid #AAAAAA;text-align:center;font-weight:bold;background:#DDDDDD;color:#505050;}';
    $result.='.messageERROR{color:red;font-weight:bold;}';
    $result.='.messageOK{color:green;}';
    $result.='.messageWARNING{color:black;}';
    $result.='</style>'.$nl;
    $result.='</head>'.$nl;
    $result.='<body class="white" onLoad="top.hideWait();" style="overflow: auto; ">'.$nl;
    return $result;
  }
  public static function getLogFooter() {
  	$nl="\n";
    $result="";
    $result.='</body>'.$nl;
    $result.='</html>';
  }
}
?>