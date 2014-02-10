<?php
if (! class_exists('SqlElement') ){
	include_once('../tool/projeqtor.php');
	traceLog('Hack detected : direct acces to file');
	traceLog($_SERVER);
	exit;
}?>