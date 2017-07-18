<?php
// Include the PHPWord.php, all other classes were loaded by an autoloader
require_once '../external/PhpWord/PhpWord.php';

$PHPWord = new PhpWord();

$section = $PHPWord->createSection();
$sectionStyle = $section->getSettings();
$sectionStyle->setMarginLeft(750);
$sectionStyle->setMarginRight(750);
$sectionStyle->setMarginTop(750);
$sectionStyle->setMarginBottom(750);


$header = $section->createHeader();
$tableStyle = array('cellMarginTop'=>80,
    'cellMarginLeft'=>80,
    'cellMarginRight'=>80,
    'cellMarginBottom'=>80);
$table = $header->addTable($tableStyle);
$table->addRow( 1200);
$cell = $table->addCell( 2000);
$imageStyle = array('width'=>150, 'align'=>'center');
$cell->addImage("../view/img/titleSmall.png",$imageStyle);


$section->addText('Hello world!');

$section->addPageBreak();
$styleTOC = array('tabLeader'=>PHPWord_Style_TOC::TABLEADER_DOT);
$styleFont = array('spaceAfter'=>60, 'name'=>'Verdana', 'size'=>12);
$section->addTOC($styleFont, $styleTOC);
$section->addPageBreak();


// You can directly style your text by giving the addText function an array:
$section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));

// If you often need the same style again you can create a user defined style to the word document
// and give the addText function the name of the style:
$PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
$section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');



// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('helloWorld'.date('His').'.docx');