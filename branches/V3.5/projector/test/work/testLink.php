<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue">
<pre>
<?php 
include_once('../tool/projeqtor.php');

$obj = new Risk('1');
$link=Link::getLinksForObject($obj,null);

var_dump($obj);
var_dump($link);

?>
</pre>

</body>
</html>