<?php
if (! class_exists('SqlElement') ){
	if (file_exists('../tool/projeqtor.php')) {
	  include_once('../tool/projeqtor.php');
	} else if (file_exists('../../tool/projeqtor.php')) {
		include_once('../../tool/projeqtor.php');
	} else {
		exit;
	}
	traceHack('Direct acces to class file '.$_SERVER['REQUEST_URI']);
	exit;
}?>