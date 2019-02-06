<?php
require_once '../external/PHPOffice/PHPPresentation/src/PhpPresentation/Autoloader.php';
\PhpOffice\PhpPresentation\Autoloader::register();

require_once '../external/PHPOffice/Common/src/Common/Autoloader.php';
\PhpOffice\Common\Autoloader::register();

echo "START<br/>";

use PhpOffice\PhpPresentation\Autoloader;
use PhpOffice\PhpPresentation\Settings;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\AbstractShape;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\Shape\Drawing;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\RichText\BreakElement;
use PhpOffice\PhpPresentation\Shape\RichText\TextElement;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\PhpOffice\PhpPresentation;

define('CLI', (PHP_SAPI == 'cli') ? true : false);
define('EOL', CLI ? PHP_EOL : '<br />');
define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
define('IS_INDEX', SCRIPT_FILENAME == 'index');


//$pptReader = IOFactory::createReader('PowerPoint2007');
//$ppt = $pptReader->load(__DIR__ . '/template04.pptx');
$ppt=new PhpPresentation();
$ppt->getDocumentProperties()
  ->setCreator('PHPOffice')
  ->setLastModifiedBy('PHPPresentation Team')
  ->setTitle('Sample 01 Title')
  ->setSubject('Sample 01 Subject')
  ->setDescription('Sample 01 Description')
  ->setKeywords('office 2007 openxml libreoffice odt php')
  ->setCategory('Sample Category');



foreach ($ppt->getAllSlides() as $slide) {
  echo get_class($slide).'<br/>';

  foreach ($slide->getSlideLayout()->getSlideMaster()->getShapeCollection() as $shape) {
    echo get_class($shape).'<br/>';
    
  }
  $shape = $slide->createRichTextShape()
  ->setHeight(1086)
  ->setWidth(740)
  ->setOffsetX(17)
  ->setOffsetY(10);
  $shape->getBorder()->setColor(new Color('FFBFBFBF'))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(6);

}

$writer = IOFactory::createWriter($ppt, 'PowerPoint2007');
$writer->save(__DIR__ . "/templateResult.pptx");

echo "END<br/>";

function drawMaster($slide) {
  
}