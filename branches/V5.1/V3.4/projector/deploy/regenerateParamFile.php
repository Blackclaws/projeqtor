<?php 
require_once "../tool/projector.php";
echo Importable::getLogHeader();
Parameter::regenerateParamFile(true);
echo Importable::getLogFooter();?>