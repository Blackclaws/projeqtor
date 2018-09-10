<?php
include_once('../tool/projeqtor.php');

$tkt=new Ticket(3);
echo securityGetAccessRightYesNo('menuTicket', 'update', $this);

$user=getSessionUser();
var_dump($user->getSpecificAffectedProfiles());