<pre>
<?php
  include "../tool/projector.php"; // include before change testMode
  $testMode=true;
  var_dump (SqlList::getList('Project'));
?>
</pre>