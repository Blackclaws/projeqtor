<?php
/** ===========================================================================
 * Download a file descripbde in the correcponding object 
 * @param class=class of object containing file description
 * @param id = id of object
 * @param display = bolean (existence is enough) to enable display, either download is forced
 */

require_once "../tool/projector.php";
scriptLog('   ->/tool/download.php');
$class=$_REQUEST['class'];
$id=$_REQUEST['id'];

$obj=new $class($id);

if ($class=='Attachement') {
  $path = str_replace('${attachementDirectory}', $paramAttachementDirectory, $obj->subDirectory);
  $name = $obj->fileName;
  $size = $obj->fileSize;
  $type = $obj->mimeType;
  $file = $path . $name;
  if (! is_file($file)) {
    $file=addslashes($file);
  }
} else if ($class=='DocumentVersion') {
  $name = $obj->fileName;
  $size = $obj->fileSize;
  $type = $obj->mimeType;
  $file = $obj->getUploadFileName();
} else if ($class=='Document') {
	if (!$obj->idDocumentVersion) return;
	$obj=new DocumentVersion($obj->idDocumentVersion);
	$name = $obj->fileName;
  $size = $obj->fileSize;
  $type = $obj->mimeType;
  $file = $obj->getUploadFileName();
}
$contentType="application/force-download";
//if (array_key_exists('display',$_REQUEST)) {
//  $contentType=$type;
//}

if (($file != "") && (file_exists($file))) { 
  header("Content-Type: " . $contentType . "; name=\"" . $name . "\""); 
  header("Content-Transfer-Encoding: binary"); 
  header("Content-Length: $size"); 
  header("Content-Disposition: attachment; filename=\"" .$name . "\""); 
  header("Expires: 0"); 
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache");
  if (ob_get_length()){   
    ob_clean();
  }
  flush();
  
  readfile($file);  
} else {
	errorLog("download.php : ".$file . ' not found');
}

?>