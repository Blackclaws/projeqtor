<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 
include_once("../tool/projeqtor.php");
$user = new User(9);

var_dump($user->getVisibleProjects());
var_dump($user->getAccessControlRights());

?>

</pre>

</body>
</html>