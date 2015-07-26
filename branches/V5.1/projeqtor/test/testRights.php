<?php
include_once('../tool/projeqtor.php');

$user=getSessionUser();
var_dump($user->getSpecificAffectedProfiles());