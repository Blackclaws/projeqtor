<?php
require_once "../tool/projector.php";
echo AuditSummary::finishOldSessions($_REQUEST['day']);
//echo AuditSummary::updateAuditSummary($_REQUEST['day']);

