<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * Print page of application.
 */
   require_once "../tool/projeqtor.php";
   //scriptLog('   ->/view/print.php'); 
   projeqtor_set_time_limit(300);
   ob_start();
   $outMode='html';
   $printInNewPage=getPrintInNewWindow();
   if (array_key_exists('outMode', $_REQUEST)) {
     if ($_REQUEST['outMode']) {
       $outMode=$_REQUEST['outMode'];
     }
   }

   if (!array_key_exists('idDocumentDirectory', $_REQUEST)) {
     throwError("Parameter idDocumentDirectory not found in REQUEST");
   }
   $location=$_REQUEST['idDocumentDirectory'];
   
   $outMode=$_REQUEST['outMode'];
   $orientation='L';
   if (array_key_exists('orientation', $_REQUEST)) {
   	$orientation=$_REQUEST['orientation'];
   }
   if ($outMode=='pdf') {
     $printInNewPage=getPrintInNewWindow('pdf');
     $memoryLimitForPDF=Parameter::getGlobalParameter('paramMemoryLimitForPDF');
     if (isset($memoryLimitForPDF)) {
       $limit=$memoryLimitForPDF;	
     } else {
     	 $limit='';
     }
     if ($limit===0) {
     	 header ('Content-Type: text/html; charset=UTF-8');
     	 echo "<html><head></head><body>";
     	 echo i18n("msgPdfDisabled");
     	 echo "</body></html>";
     	 return;
     } else if ($limit=='') {
       // Keep existing
     } else {
      projeqtor_set_memory_limit($limit.'M');
     }
   }
   $detail=false;
   if (array_key_exists('detail', $_REQUEST)) {
   	$detail=true;
   }
   ?>
<html>
<head>   
  <title><?php echo getPrintTitle();?></title>
  <link rel="stylesheet" type="text/css" href="css/jsgantt.css" />
  <link rel="stylesheet" type="text/css" href="css/projeqtorPrint.css" />
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
<?php if (! isset($debugIEcompatibility) or $debugIEcompatibility==false) {?>  
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php }?> 
  <script type="text/javascript" src="../external/dojo/dojo.js"
    djConfig='modulePaths: {"i18n":"../tool/i18n",
                            "i18nCustom":"../plugin"},
              parseOnLoad: true,
              isDebug: <?php echo getBooleanValueAsString(Parameter::getGlobalParameter('paramDebugMode'));?>'></script>
  <script type="text/javascript" src="../external/dojo/projeqtorDojo.js"></script>
  <script type="text/javascript" src="../view/js/jsgantt.js"></script>
  <script type="text/javascript"> 
    var customMessageExists=<?php echo(file_exists(Plugin::getDir()."/nls/$currentLocale/lang.js"))?'true':'false';?>;
    dojo.require("dojo.parser");
    dojo.require("dojo.i18n");
    //dojo.require("dojo.date.locale");
    dojo.addOnLoad(function(){
      <?php 
        if (array_key_exists('directPrint', $_REQUEST)) {
          echo "window.print();";
          //echo "window.close();";
        }
      ?>
      var printInNewWindow=<?php echo (getPrintInNewWindow())?'true':'false';?>;
      if (printInNewWindow) {
        objTop=window.opener;
      } else {
    	  objTop=top;
      }
      objTop.hideWait();
      objTop.window.document.title="<?php echo getPrintTitle();?>";
      window.document.title="<?php echo getPrintTitle();?>";
    }); 
    
  </script>
</head>
<page backtop="100px" backbottom="20px" footer="page">
<<?php echo ($printInNewPage or $outMode=='pdf') ?'body':'div';?> style="-webkit-print-color-adjust: exact;font-size:10px" id="bodyPrint" class="white" onload="top.hideWait();">
  <?php 
  $page=$_REQUEST['page'];
  securityCheckPage($page);
  include $page;
  ?>
</<?php echo ($printInNewPage or $outMode=='pdf')?'body':'div';?>>
</page>
</html>
<?php
  finalizePrint($location);
?>
<?php function finalizePrint($location) {
  global $outMode, $includeFile, $orientation;
  $idDocumentDirectory=$location;
  $idDocumentDirectory=SqlElement::getSingleSqlElementFromCriteria("DocumentDirectory", Array("id"=>$idDocumentDirectory));
  $pdfLib='html2pdf';
  //$pdfLib='dompdf';
  if ($outMode=='pdf') {
    $content = ob_get_clean();   
    if ($pdfLib=='html2pdf') {
      /* HTML2PDF way */
      include_once('../external/html2pdf/_class/tcpdfConfig.php');
      require_once('../external/html2pdf/html2pdf.class.php');
      include_once('../external/html2pdf/vendor/tecnickcom/tcpdf/tcpdf.php');
      include_once('../external/html2pdf/_class/locale.class.php');
      include_once('../external/html2pdf/_class/myPdf.class.php');
      include_once('../external/html2pdf/_class/exception.class.php');
      include_once('../external/html2pdf/_class/parsingCss.class.php');
      include_once('../external/html2pdf/_class/parsingHtml.class.php');
      $html2pdf = new HTML2PDF($orientation,'A4','en');
      //$html2pdf->setModeDebug();
      $html2pdf->pdf->SetDisplayMode('fullpage');
      $html2pdf->pdf->SetMargins(10,10,10,10);
      $fontForPDF=Parameter::getGlobalParameter('fontForPDF');
      if (!$fontForPDF) $fontForPDF='freesans';
      $html2pdf->setDefaultFont($fontForPDF);
      $html2pdf->setTestTdInOnePage(false);
      //$html2pdf->setModeDebug(); 
      $content=str_replace("à","&agrave;",$content);
traceExecutionTime($includeFile,true);
      $html2pdf->writeHTML($html2pdf->getHtmlFromPage($content)); 
      $html2pdf->Output($idDocumentDirectory->name.$idDocumentDirectory->location.'testFile.pdf','F');;
traceExecutionTime($includeFile);
    }
  }
}
?>