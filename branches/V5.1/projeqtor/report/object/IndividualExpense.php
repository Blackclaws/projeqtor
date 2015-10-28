<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 *
 ******************************************************************************
 *** WARNING *** T H I S    F I L E    I S    N O T    O P E N    S O U R C E *
 ******************************************************************************
 *
 * This file is an add-on to ProjeQtOr, packaged as a plug-in module.
 * It is NOT distributed under an open source license. 
 * It is distributed in a proprietary mode, only to the customer who bought
 * corresponding licence. 
 * The company ProjeQtOr remains owner of all add-ons it delivers.
 * Any change to an add-ons without the explicit agreement of the company 
 * ProjeQtOr is prohibited.
 * The diffusion (or any kind if distribution) of an add-on is prohibited.
 * Violators will be prosecuted.
 *    
 *** DO NOT REMOVE THIS NOTICE ************************************************/

//
// THIS IS THE INDIVIDUAL EXPENSE REPORT
//
include_once '../tool/projeqtor.php';
include_once '../tool/formatter.php';
$idProject = "";
$idClient = "";
$idIndividualExpense = "";
$orientation="P";
if (array_key_exists('objectId', $_REQUEST)){
	$idIndividualExpense=trim($_REQUEST['objectId']);
} else {
  echo "this report must be called from Individual Expense screen, with one Expense selected";
  exit;
}

$nl="\n";
$expense = new IndividualExpense($idIndividualExpense);
// BILL TEMPLATE : BRING YOUR CHANGES HERE
$project=new Project($expense->idProject);
$resource=new Resource($expense->idResource);
$type=new IndividualExpenseType($expense->idIndividualExpenseType);
$ref=$expense->reference;
$refShort=str_replace(array('ProjeQtOr-','PROJEQTOR-','Poojeqtor-'),array('','',''),$ref);
$expenseLine=new ExpenseDetail();
$crit=array('idExpense'=>$expense->id);
$expenseLines=$expenseLine->getSqlElementsFromCriteria($crit,false, null, 'id asc');

// Styles 
$cssframe='font-size:11pt;font-face:Verdana;position:absolute;left:6mm;width:180mm;';
$cssheader='text-align:center;font-weight:bold;color:#FFF;background:#545381;padding-top:1mm;padding-bottom:1mm;';
$cssheaderborder='text-align:center;font-weight:bold;color:#FFF;background:#545381;padding-top:1mm;padding-bottom:1mm;border:1px solid #FFFFFF;';
$csssubheaderborder='text-align:center;color:#FFF;background:#545381;padding-top:1mm;padding-bottom:1mm;border:1px solid #FFFFFF;';
$cssheadertitle='text-align:left;font-size:14pt;color:#545381;';
$cssaddress='text-align:left;font-face:Verdana;height:45mm;width:85mm;border-bottom:1px solid #545381;padding-left:5mm;';
$csscontact='text-align:left;font-face:Verdana;height:25mm;width:85mm;padding-left:5mm;';
$csscellleft='text-align:left;font-face:Verdana;border:1px solid #545381;padding-left:10px;';
$csscellright='text-align:right;font-face:Verdana;border:1px solid #545381;padding-right:10px;';
$csscellcenter='text-align:center;font-face:Verdana;border:1px solid #545381;';
$csscelltitle='text-align:right;border:1px solid #545381;color:#545381;padding-right:15px;';
$csscomment='font-face:Verdana;width:60mm;';
    
echo $nl;
echo '<div style="page-break-before:always;"></div>'.$nl;
// Background
//echo '<div style="position:absolute;top:0mm; left:0mm;width:190mm;height:277mm;'
//     .'background-size: 190mm 277mm;background-image:url(../report/object/backgroundA4.png);">&nbsp;</div>';
//echo '**START**'.$nl;
$logo="../report/object/backgroundA4.png";
$logoA4=true;
if (file_exists("../logo.gif")) {$logo='../logo.gif'; $logoA4=false;}
else if (file_exists("../logo.jpg")) {$logo='../logo.jpg'; $logoA4=false;}
else if (file_exists("../logo.png")) {$logo='../logo.png'; $logoA4=false;}
echo '<div style="position:absolute;'.(($outMode=='pdf')?'left:5mm; top:5mm':'').'">'.$nl;
echo $nl;
echo '<div style="position:absolute;top:0mm; left:0mm;width:190mm;height:270mm;">'.$nl;
echo ' <img src="'.$logo.'"';
if ($logoA4) {
  echo ' style="width:190mm; height:270mm"';
} else {
  $size=getimagesize($logo);
  $addStyle='';
  if ($size[0]>300 and ($size[1]*6)<=$size[0]) $addStyle.='width:300px';
  else if ($size[1]>50 or ($size[1]*6)>$size[0]) $addStyle.='height:50px';
  echo ' style="max-width:80mm;max-height:20mm;'.$addStyle.'"';
}
echo ' />'.$nl;
echo '</div>'.$nl;

// Header 
echo '<div style="'.$cssframe.'top:5mm;">'.$nl;
echo ' <table style="width:100%"><tr><td style="width:45%"></td>';
echo '  <td style="white-space:nowrap;width:55%;'.$cssheadertitle.'">'.$type->name.' '.$ref.'</td>';
echo ' </tr></table>'.$nl;
echo '</div>'.$nl;

// Reference
echo '<div style="'.$cssframe.'top: 25mm;">'.$nl;
echo ' <table style="width:100%;">'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td colspan="2" style="'.$cssheader.'width:70%">'.i18n('sectionReference').'</td>'.$nl;
echo '   <td style="'.$cssheader.'width:30%;border:1px solid #545381;font-size:12pt;font-weight:normal;" rowspan="6">'
    .$type->name.'<br/>'
    .getMonthName(substr($expense->expenseRealDate,5,2)).' '.substr($expense->expenseRealDate,0,4).'<br/>'
    .$resource->name.'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'width:25%;">'.i18n('colType').'</td>';
echo '   <td style="'.$csscellleft.'width:45%">'.$type->name.'</td>';
echo '  </tr>'.$nl;
echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'width:25%;">'.i18n('colReference').'</td>';
echo '   <td style="'.$csscellleft.'width:45%">'.$ref.'</td>';
echo '  </tr>'.$nl;echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'">'.i18n('colDate').'</td>';
echo '   <td style="'.$csscellleft.'">'.htmlFormatDate($expense->expenseRealDate).'</td>';
echo '  </tr>'.$nl;
echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'">'.i18n('colName').'</td>';
echo '   <td style="'.$csscellleft.'">'.$expense->name.'</td>';
echo '  </tr>'.$nl;
echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'">'.i18n('colIdResource').'</td>';
echo '   <td style="'.$csscellleft.'">'.$resource->name.'</td>';
echo '  </tr>'.$nl;
echo ' </table>'.$nl;
echo '</div>'.$nl;

// Detail
echo '<div style="'.$cssframe.'top: 60mm;">'.$nl;
echo ' <table style="width:100%;">'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td colspan="5" style="'.$cssheaderborder.'width:50%">'.i18n('colDetail').'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:15%">'.i18n('colDate').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:20%">'.i18n('colName').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:20%">'.i18n('colType').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:30%">'.i18n('colDetail').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:15%">'.i18n('colAmount').'</td>'.$nl;
echo '  </tr>'.$nl;
// each line
foreach ($expenseLines as $line) {
echo '  <tr style="height:8mm;font-size:80%">'.$nl;
echo '   <td style="'.$csscellcenter.'width:15%;">'.htmlFormatDate($line->expenseDate).'</td>'.$nl;
echo '   <td style="'.$csscellleft.'width:20%;">'.nl2br($line->name).'</td>'.$nl;
echo '   <td style="'.$csscellleft.'width:20%;">'.SqlList::getNameFromId('ExpenseDetailType', $line->idExpenseDetailType).'</td>'.$nl;
echo '   <td style="'.$csscellleft.'width:30%;">'.nl2br($line->getFormatedDetail()).'</td>'.$nl;
echo '   <td style="'.$csscellright.'width:15%;">'.htmlDisplayCurrency($line->amount).'</td>'.$nl;
echo '  </tr>'.$nl;
}
echo '  <tr style="height:8mm;font-size:100%">'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'" colspan="4">'.i18n('colAmount').'</td>'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'">'.htmlDisplayCurrency($expense->realAmount).'</td>'.$nl;
echo '  </tr>'.$nl;
echo ' </table>'.$nl;
echo '<br/>';
echo '<div style="'.$csscomment.';font-size:80%">'.$expense->description.'</div>';
echo '</div>'.$nl;

// End
echo $nl;
echo '</div>'.$nl;

?>