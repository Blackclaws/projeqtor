<?php 
require_once "../tool/projeqtor.php";
echo Importable::getLogHeader();
Parameter::regenerateParamFile(true);
echo Importable::getLogFooter();?>