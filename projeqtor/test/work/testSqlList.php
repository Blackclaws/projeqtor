<pre>
<?php
  include "../tool/projeqtor.php"; // include before change testMode
  $testMode=true;
  var_dump (SqlList::getList('Project'));
?>
</pre>