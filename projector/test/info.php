<?php
session_start(); 
echo "current session_id=".session_id().'<br/>';
echo "current session_name=".session_name().'<br/>';
echo "Request=".'<br/>';
var_dump($_REQUEST);
echo "Server=".'<br/>';
var_dump($_SERVER);
phpinfo();
?>