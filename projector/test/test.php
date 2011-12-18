<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
</head>

<body class="blue" >
<pre>

<?php 
include_once '../tool/projector.php';
echo '2011-12-24->' . isOffDay('2011-12-24') . "\n";
echo '2011-12-25->' . isOffDay('2011-12-25') . "\n";
echo '2011-12-26->' . isOffDay('2011-12-26') . "\n";
echo '2011-12-27->' . isOffDay('2011-12-27') . "\n";
echo '2011-12-28->' . isOffDay('2011-12-28') . "\n";

echo workDayDiffDates('2011-12-23','2011-12-28');
?>
</pre>

</body>
</html>