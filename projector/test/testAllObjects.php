<?php
include_once "../tool/projector.php";
include_once "testTools.php";

$classDir="../model/";
testHeader('ALL OBJECTS');
if (is_dir($classDir)) {
  if ($dirHandler = opendir($classDir)) {
    while (($file = readdir($dirHandler)) !== false) {
      if ($file!="." and $file!=".." and filetype($classDir . $file)=="file") {
        $split=explode('.',$file);
        $class=$split[0];
        $obj=new $class;
        if (is_subclass_of($obj, "SqlElement")) {
        	testObject($obj);
        }   
      }
    }
  }
}
testFooter();

function testObject($obj) {
	testTitle(get_class($obj));
	testSubTitle('Create');
	testResult('not tested', '');
	testSubTitle('Update');
	testResult('not tested', '');
	testSubTitle('Delete');
	testResult('not tested', '');
}