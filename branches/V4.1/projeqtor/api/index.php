<?php 
$invalidQuery="query should be ../api/class of object/id of object";
require_once "../tool/projeqtor.php";
IF ($_SERVER['REQUEST_METHOD']=='GET') {
  if (isset($_REQUEST['uri'])) {
    $uri=$_REQUEST['uri'];
echo $uri;
    $split=explode('/',$uri);
    if (count($split>1)) {
    	$class=ucfirst($split[0]);
    	if (class_exists($class)) {
    		if (count($split)==2) {
    			$id=$split[1];
    			$obj=new $class($id);
    			echo '{"identifier":"id",' ;
          echo ' "items":[';
          echo jsonDumpObj($obj);
          echo ']';
          echo ' }';
    		}
    		
    	} else {
    		returnError($invalidQuery);
    		returnError("<br/>$class is not a known class");
    	}
    } else {
    	returnError($invalidQuery);
    }
  } else {
    returnError($invalidQuery);
  }
} else {
  returnError ('method '.$_SERVER['REQUEST_METHOD'].' not taken into acocunt in this API');
}


function returnError($msg) {
	echo "ERROR : ".$msg;
}

function jsonDumpObj($obj, $included=false) {
	$res="";
	foreach($obj as $fld=>$val) {
		
		if (is_object($val)) {
		  //if ($res!="") { $res.=", ";}
			//$res.=jsonDumpObj($obj, true);
		} else if (substr($fld,0,1)=='_') {
			// Nothing
		} else if ($obj->isAttributeSetToField($fld, 'hidden')) {
			// Nothing
		} else {
		  if ($res!="") { $res.=", ";}
		  $res.='"' . htmlEncode($fld) . '":"' . htmlEncodeJson($val) . '"';
		}  
	}
	return $res;
}
?>