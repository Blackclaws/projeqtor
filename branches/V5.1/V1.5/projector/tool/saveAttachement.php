<?php 
include_once "../tool/projector.php";
header ('Content-Type: text/html; charset=UTF-8');
/** ===========================================================================
 * Save an attachement (file) : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */

// ATTENTION, this PHP script returns its result into an iframe (the only way to submit a file)
// then the iframe returns the result to resultDiv to reproduce expected behaviour
?>
<html>
<head>   
</head>
<body onload="parent.saveAttachementAck();">
<?php 
$error=false;
if (array_key_exists('attachementFile',$_FILES)) {
  $uploadedFile=$_FILES['attachementFile'];
} else {
  echo htmlGetErrorMessage(i18n('errorTooBigFile',array($paramAttachementMaxSize,'$paramAttachementMaxSize')));
  errorLog(i18n('errorTooBigFile',array($paramAttachementMaxSize,'$paramAttachementMaxSize')));
  $error=true; 
}
if (! $error) {
  if ( $uploadedFile['error']!=0 ) {
    switch ($uploadedFile['error']) {
      case 1:
        echo htmlGetErrorMessage(i18n('errorTooBigFile',array(ini_get('upload_max_filesize'),'upload_max_filesize')));
        errorLog(i18n('errorTooBigFile',array(ini_get('upload_max_filesize'),'upload_max_filesize')));
        break; 
      case 2:
        echo htmlGetErrorMessage(i18n('errorTooBigFile',array($paramAttachementMaxSize,'$paramAttachementMaxSize')));
        errorLog(i18n('errorTooBigFile',array($paramAttachementMaxSize,'$paramAttachementMaxSize')));
        break;  
      case 4:
        echo htmlGetWarningMessage(i18n('errorNoFile'));
        errorLog(i18n('errorNoFile'));
        break;  
      default:
        echo htmlGetErrorMessage(i18n('errorUploadFile',array($uploadedFile['error'])));
        errorLog(i18n('errorUploadFile',array($uploadedFile['error'])));
        break;
    }
    $error=true; 
  }
}
if (! $error) {
  if (! $uploadedFile['name']) {
    echo htmlGetWarningMessage(i18n('errorNoFile'));
    errorLog(i18n('errorNoFile'));
    $error=true; 
  }
}
if (! $error) {
  if (! array_key_exists('attachementRefType',$_REQUEST)) {
    echo htmlGetErrorMessage('attachementRefType parameter not found in REQUEST');
    errorLog('attachementRefType parameter not found in REQUEST');
    $error=true; 
  } else {
    $refType=$_REQUEST['attachementRefType'];
  }
}
if (! $error) {  
  if (! array_key_exists('attachementRefId',$_REQUEST)) {
    echo htmlGetErrorMessage('attachementRefId parameter not found in REQUEST');
    errorLog('attachementRefId parameter not found in REQUEST');
    $error=true; 
  } else {
    $refId=$_REQUEST['attachementRefId'];
  }
}
if (! $error) {    
  if (! array_key_exists('attachementDescription',$_REQUEST)) {
    echo htmlGetErrorMessage('attachementDescrition parameter not found in REQUEST');
    errorLog('attachementDescrition parameter not found in REQUEST');
    $error=true;
  } else {
    $attachementDescription=$_REQUEST['attachementDescription'];
  }
}

if (! $error) {
  $attachement=new Attachement();
  $attachement->refId=$refId;
  $attachement->refType=$refType;
  $attachement->idUser=$user->id;
  $attachement->creationDate=date("Y-m-d H:i:s");
  $attachement->fileName=basename($uploadedFile['name']);
  $attachement->description=$attachementDescription;
  $attachement->mimeType=$uploadedFile['type'];
  $attachement->fileSize=$uploadedFile['size'];
  $result=$attachement->save();
  $newId= $attachement->id;
}
if (! $error) {
  $uploaddir = $paramAttachementDirectory . $paramPathSeparator . "attachement_" . $newId . $paramPathSeparator;
  if (! file_exists($uploaddir)) {
    mkdir($uploaddir);
  }
  $uploadfile = $uploaddir . basename($uploadedFile['name']);
  if ( ! move_uploaded_file($uploadedFile['tmp_name'], $uploadfile)) {
     echo htmlGetErrorMessage(i18n('errorUploadFile','hacking ?'));
     errorLog(i18n('errorUploadFile','hacking ?'));
     $error=true;
     $attachement->delete(); 
  } else {
    $attachement->subDirectory=$uploaddir;
    $otherResult=$attachement->save();
  }
}
if (! $error) {
  // Message of correct saving
  if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
    echo '<span class="messageERROR" >' . $result . '</span>';
  } else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
    echo '<span class="messageOK" >' . $result . '</span>';
  } else { 
    echo '<span class="messageWARNING" >' . $result . '</span>';
  }
} else {
   echo '<input type="hidden" id="lastSaveId" value="" />';
   echo '<input type="hidden" id="lastOperation" value="file upload" />';
   echo '<input type="hidden" id="lastOperationStatus" value="ERROR" />';
}
?>
</body>
</html>