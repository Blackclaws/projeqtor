<?php
include_once('File.php');
include_once "../../external/rst/autoload.php";

$action=$_REQUEST['action'];
switch ($action) {
  case "getFile":
    echo File::getFile($_REQUEST['file']);
    break;
  case "convert":
    $fileList=File::getRstList();
    $fileDir=File::getDir();
    echo File::convert($_REQUEST['editor']);
    break;
  case "save":
    $data=$_REQUEST['editor'];
    $fileName=$_REQUEST['file'];
    $result=File::saveFile($fileName,$data);
    echo $result;
    break;
}
