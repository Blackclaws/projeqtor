<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 

include_once("../tool/projeqtor.php");
$w = new Workflow(1);

$test=$w->drawSpecificItem('workflowstatus');
var_dump($test);


?>

</pre>

</body>
</html>