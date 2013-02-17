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

$type='file';
if (! array_key_exists('attachementType',$_REQUEST)) {
    echo htmlGetErrorMessage('attachementType parameter not found in REQUEST');
    errorLog('attachementType parameter not found in REQUEST');
    $error=true;
} else {
  $type=$_REQUEST['attachementType'];
}
$attachementMaxSize=Parameter::getGlobalParameter('paramAttachementMaxSize');
if ($type=='file') {
  if (array_key_exists('attachementFile',$_FILES)) {
    $uploadedFile=$_FILES['attachementFile'];
  } else {
    echo htmlGetErrorMessage(i18n('errorTooBigFile',array($attachementMaxSize,'paramAttachementMaxSize')));
    errorLog(i18n('errorTooBigFile',array($attachementMaxSize,'paramAttachementMaxSize')));
    $error=true;
  }
  if (! $error) {
    if ( $uploadedFile['error']!=0 ) {
      echo "[".$uploadedFile['error']."] ";
      errorLog("[".$uploadedFile['error']."] saveAttachement.php");
      switch ($uploadedFile['error']) {
        case 1:
          echo htmlGetErrorMessage(i18n('errorTooBigFile',array(ini_get('upload_max_filesize'),'upload_max_filesize')));
          errorLog(i18n('errorTooBigFile',array(ini_get('upload_max_filesize'),'upload_max_filesize')));
          break;
        case 2:
          echo htmlGetErrorMessage(i18n('errorTooBigFile',array($attachementMaxSize,'paramAttachementMaxSize')));
          errorLog(i18n('errorTooBigFile',array($attachementMaxSize,'paramAttachementMaxSize')));
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
} else if ($type=='link') {
  if (! array_key_exists('attachementLink',$_REQUEST)) {
    echo htmlGetWarningMessage(i18n('attachementLink parameter not found in REQUEST'));
    errorLog(i18n('attachementLink parameter not found in REQUEST'));
    $error=true;
  } else {
    $link=$_REQUEST['attachementLink'];
  }
} else {
  echo htmlGetWarningMessage(i18n('error : unknown type '));
  errorLog(i18n('error : unknown type '.$type));
  $error=true;
}
$refType="";
if (! $error) {
  if (! array_key_exists('attachementRefType',$_REQUEST)) {
    echo htmlGetErrorMessage('attachementRefType parameter not found in REQUEST');
    errorLog('attachementRefType parameter not found in REQUEST');
    $error=true; 
  } else {
    $refType=$_REQUEST['attachementRefType'];
  }
}
if ($refType=='TicketSimple') {
  $refType='Ticket';    
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
if (! array_key_exists('attachmentPrivacy',$_REQUEST)) {
  throwError('attachmentPrivacy parameter not found in REQUEST');
}
$idPrivacy=$_REQUEST['attachmentPrivacy'];

$user=$_SESSION['user'];
Sql::beginTransaction();
if (! $error) {
  $attachement=new Attachement();
  $attachement->refId=$refId;
  $attachement->refType=$refType;
  $attachement->idUser=$user->id;
  $ress=new Resource($user->id);
  $attachement->idTeam=$ress->idTeam;
	if ($idPrivacy) {
	  $attachement->idPrivacy=$idPrivacy;
	} else if (! $attachement->idPrivacy) {
	  $attachement->idPrivacy=1;
	}
  $attachement->creationDate=date("Y-m-d H:i:s");
  if ($type=='file') {
    $attachement->fileName=basename($uploadedFile['name']);
    $attachement->mimeType=$uploadedFile['type'];
    $attachement->fileSize=$uploadedFile['size'];
  } else if ($type=='link') {
    $attachement->link=$link;
    $attachement->fileName=urldecode(basename($link));
  }
  $attachement->type=$type;
  $attachement->description=$attachementDescription;
  $result=$attachement->save();
  $newId= $attachement->id;
}
$pathSeparator=Parameter::getGlobalParameter('paramPathSeparator');
$attachementDirectory=Parameter::getGlobalParameter('paramAttachementDirectory');
if (! $error and $type=='file') {
  $uploaddir = $attachementDirectory . $pathSeparator . "attachement_" . $newId . $pathSeparator;
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
    $attachement->subDirectory=str_replace(Parameter::getGlobalParameter('paramAttachementDirectory'),'${attachementDirectory}',$uploaddir);
    $otherResult=$attachement->save();
  }
}

if (! $error and $attachement->idPrivacy==1) { // send mail if new attachment is public
  $elt=new $refType($refId);
	$mailResult=$elt->sendMailIfMailable(false,false,false,false,true);
	if ($mailResult) {
	  $result.=' - ' . i18n('mailSent');
	}
}
if (! $error) {
  // Message of correct saving
  if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  	Sql::rollbackTransaction();
    echo '<span class="messageERROR" >' . $result . '</span>';
  } else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  	Sql::commitTransaction();
    echo '<span class="messageOK" >' . $result . '</span>';
  } else { 
  	Sql::rollbackTransaction();
    echo '<span class="messageWARNING" >' . $result . '</span>';
  }
} else {
	Sql::rollbackTransaction();
   echo '<input type="hidden" id="lastSaveId" value="" />';
   echo '<input type="hidden" id="lastOperation" value="file upload" />';
   echo '<input type="hidden" id="lastOperationStatus" value="ERROR" />';
}
?>
</body>
</html>