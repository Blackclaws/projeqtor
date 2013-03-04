<?php
session_start(); 
echo "current session_id=".session_id().'<br/>';
echo "current session_name=".session_name().'<br/>';
phpinfo();
?>