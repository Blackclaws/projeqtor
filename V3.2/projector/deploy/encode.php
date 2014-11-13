<?php
$key=$_REQUEST['key'];
$val=$_REQUEST['value'];

// max 32-126
echo crypt($val,$key);