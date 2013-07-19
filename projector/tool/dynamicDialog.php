<?php
include_once '../tool/projeqtor.php';
if (! array_key_exists('dialog', $_REQUEST)) {
	throwError('dialog parameter not found in REQUEST');
}
$dialog=$_REQUEST['dialog'];
//echo "<br/>".$dialog."<br/>";
if ($dialog=="dialogTodayParameters") {
  include('../tool/dynamicDialogTodayParameters.php');
} else if ($dialog=="dialogAttachement") {
	include('../tool/dynamicDialogAttachement.php');
} else if ($dialog=="dialogDocumentVersion") {
  include('../tool/dynamicDialogDocumentVersion.php');
} else {
	echo "ERROR dialog=".$dialog." is not an expected dialog";
}