<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" onLoad="alert('loaded');">
<pre>
<textArea style="width:1000px; height:500px;">
<?php 

// =====================================================
// Change these  2 values 
// =====================================================
$_REQUEST['objectClass']='Risk';
$_REQUEST['objectId']='1';
// =====================================================


$_REQUEST['testingMode']=true;
//require_once "../tool/projeqtor.php";
require "../view/objectDetail.php";

?>
</textArea>
</pre>

</body>
</html>