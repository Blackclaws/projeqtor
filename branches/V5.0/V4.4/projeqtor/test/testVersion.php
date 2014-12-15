<?php
$current="V4.3.0.a";
$compare="V4.3.0";
echo $current . " / " . $compare. "<br/>";
echo "beforeVersion=".((beforeVersion($current,$compare))?'true':'false').'<br/>';
echo "afterVersion=".((afterVersion($current,$compare))?'true':'false');

function beforeVersion($V1,$V2) {
	$V1=ltrim($V1,'V');
	$V2=ltrim($V2,'V');
	return(version_compare($V1, $V2,"<"));
}

function afterVersion($V1,$V2) {
	$V1=ltrim($V1,'V');
	$V2=ltrim($V2,'V');
	return(version_compare($V1, $V2,">="));
}

?>