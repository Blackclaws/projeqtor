<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 
include_once("../tool/projeqtor.php");
$proj = new Project(6);

$lst=$proj->getTopProjectList();
var_dump($lst);

$r=new Resource(3);
$lst=$r->getWork('2010-01-01',true);
var_dump($lst);

$r=new Resource(4);
$lst=$r->getWork('2010-01-01',true);
var_dump($lst);


?>

</pre>

</body>
</html>