<?php
include_once "../tool/projector.php";
header ('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title><?php echo i18n("applicationTitle");?></title>
  <link rel="shortcut icon" href="../view/img/logo.ico" type="../view/image/x-icon" />
  <link rel="icon" href="../view/img/logo.ico" type="../view/image/x-icon" />
  <link rel="stylesheet" type="text/css" href="../view/css/projector.css" />
</head>

<body class="white" onLoad="top.hideWait();" style="overflow: auto; ">
<?php 
$class='';
$dateFormat='dd/mm/yyyy';

if (! array_key_exists('elementType',$_REQUEST)) {
  throwError('elementType parameter not found in REQUEST');
}
$class=$_REQUEST['elementType'];
///
/// Upload file
$error=false;
if (array_key_exists('importFile',$_FILES)) {
  $uploadedFile=$_FILES['importFile'];
} else {
  echo htmlGetErrorMessage(i18n('errorNotFoundFile'));
  errorLog(i18n('errorNotFoundFile'));
  exit;
}
if ( $uploadedFile['error']!=0 ) {
  switch ($uploadedFile['error']) {
    case 1:
      echo htmlGetErrorMessage(i18n('errorTooBigFile',array(ini_get('upload_max_filesize'),'upload_max_filesize')));
      errorLog(i18n('errorTooBigFile',array(ini_get('upload_max_filesize'),'upload_max_filesize')));
      exit;
      break; 
    case 2:
      echo htmlGetErrorMessage(i18n('errorTooBigFile',array($paramAttachementMaxSize,'$paramAttachementMaxSize')));
      errorLog(i18n('errorTooBigFile',array($paramAttachementMaxSize,'$paramAttachementMaxSize')));
      exit;
      break;  
    case 4:
      echo htmlGetWarningMessage(i18n('errorNoFile'));
      errorLog(i18n('errorNoFile'));
      exit;
      break;  
    default:
      echo htmlGetErrorMessage(i18n('errorUploadFile',array($uploadedFile['error'])));
      errorLog(i18n('errorUploadFile',array($uploadedFile['error'])));
      exit;
      break;
  }
}
if (! $uploadedFile['name']) {
  echo htmlGetWarningMessage(i18n('errorNoFile'));
  errorLog(i18n('errorNoFile'));
  $error=true; 
}
$uploaddir = $paramAttachementDirectory . $paramPathSeparator . "import" . $paramPathSeparator;
if (! file_exists($uploaddir)) {
  mkdir($uploaddir);
}
$uploadfile = $uploaddir . basename($uploadedFile['name']);
if ( ! move_uploaded_file($uploadedFile['tmp_name'], $uploadfile)) {
   echo htmlGetErrorMessage(i18n('errorUploadFile','hacking ?'));
   errorLog(i18n('errorUploadFile','hacking ?'));
   exit; 
}
////

$fileName=$uploadfile;

$lines=file($fileName);
$title=null;
echo '<TABLE WIDTH="100%" style="border: 1px solid black">';
foreach ($lines as $nbl=>$line) {
  if ($title) {
    echo '<TR>';
    $obj=new $class();
    $fields=explode(';',$line);
    foreach ($fields as $idx=>$field) {      
      if (property_exists($obj,$title[$idx])) {
        $obj->$title[$idx]=$field;
        echo '<td class="messageData" style="color:#000000;">' . htmlEncode($field);
      } else { 
        $idTitle='id' . ucfirst($title[$idx]);
        if (property_exists($obj,$idTitle)) {
          echo '<td class="messageData" style="color:#000000;">' . htmlEncode($field);   
          $val=SqlList::getIdFromName(ucfirst($title[$idx]),$field);
          //echo " => " . htmlEncode($idTitle);
          //echo "=" . htmlEncode($val);
          $obj->$idTitle=$val;
        } else {
          echo '<td class="messageData" style="color:#A0A0A0;">' . htmlEncode($field); 
        }
      }
    }
    echo '</TD><TD class="messageData" width="20%">';
    $obj->id=null;
    $result=$obj->save();
    if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
      echo '<span class="messageERROR" >' . $result . '</span>';
    } else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
      echo '<span class="messageOK" >' . $result . '</span>';
    } else { 
      echo '<span class="messageWARNING" >' . $result . '</span>';
    }
    echo '</TD></TR>';
  } else {
    $title=explode(';',$line);
    echo "<TR>";
    foreach ($title as $idx=>$caption) {
      $title[$idx]=str_replace(' ','',strtolower(substr($caption,0,1)) . substr($caption,1));
      $title[$idx]=str_replace(chr(13),'',$title[$idx]);
      $title[$idx]=str_replace(chr(10),'',$title[$idx]);
      $obj=new $class();
      $color="#A0A0A0";
      $colCaption=$caption;
      if (property_exists($obj,$title[$idx])) {
        $color="#000000";
        $colCaption=$obj->getColCaption($title[$idx]);
      } else { 
        $idTitle='id' . ucfirst($title[$idx]);
        if (property_exists($obj,$idTitle)) {   
          $color="#000000";
          $colCaption=$obj->getColCaption($idTitle);
        }
      }
      echo '<TH class="messageHeader" style="color:' . $color . ';">' . $colCaption . "</TH>";
    }
    echo '<td class="messageHeader" style="color:#208020">' . i18n('colResultImport') . '</td></TR>';
  }
}
echo "</TABLE>";
?>
</body>
</html>
