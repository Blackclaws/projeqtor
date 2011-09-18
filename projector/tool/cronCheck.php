<?php
require_once "../tool/projector.php";
if (file_exists('../files/cron/RUNNING')) {
  echo "running";
} else {
	echo "stopped";
}
