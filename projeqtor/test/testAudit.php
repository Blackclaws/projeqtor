<?php
require_once "../tool/projeqtor.php";
echo AuditSummary::finishOldSessions($_REQUEST['day']);
//echo AuditSummary::updateAuditSummary($_REQUEST['day']);

