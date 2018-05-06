<?php
include_once "../external/rst/autoload.php";
    
$parser = new Gregwar\RST\Parser;

// RST document
$rst = file_get_contents('../docs/user/Bill.rst');

// Parse it
$document = $parser->parse($rst);

// Render it
echo $document;

