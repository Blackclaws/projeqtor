<?php
require_once "../tool/projector.php";
//function cronAbort() {Cron::abort();}
//register_shutdown_function('cronAbort');
Cron::relaunch();