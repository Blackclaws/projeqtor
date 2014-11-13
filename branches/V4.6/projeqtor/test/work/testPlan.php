<?php 
require_once "../tool/projeqtor.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 

$date="2010-05-10";
$proj="1";

$result=PlannedWork::plan($proj, $date);

echo '<br/><br/><br/><b>' . $result . '</b>'; 
?>

</pre>

</body>
</html>