<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 
require_once "../tool/projeqtor.php";
$user=new User('1');
$rights=$user->getAccessControlRights();
var_dump($rights);
var_dump($_SESSION);

?>

</pre>

</body>
</html>