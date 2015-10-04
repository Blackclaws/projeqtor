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
// THIS IS THE BILL REPORT
//
include_once '../tool/projeqtor.php';
$idProject = "";
$idClient = "";
$idBill = "";
$orientation="P";
if (array_key_exists('objectId', $_REQUEST)){
	$idBill=trim($_REQUEST['objectId']);
} else {
  echo "this report must be called from Bill screen, with one bill selected";
  exit;
}

$nl="\n";
$bill = new Bill($idBill);
// BILL TEMPLATE : BRING YOUR CHANGES HERE
$recipient = new Recipient($bill->idRecipient);
$project=new Project($bill->idProject);
$client=new Client($bill->idClient);
$contact=new Contact($bill->idContact);
$address=($contact->designation or $contact->street or $contact->complement)?$contact:$client;
$ref=$bill->reference;
$refShort=str_replace(array('ProjeQtOr-','PROJEQTOR-','Poojeqtor-'),array('','',''),$ref);
$delay="";
if ($bill->idPaymentDelay) {
  $delay=SqlList::getNameFromId('PaymentDelay', $bill->idPaymentDelay);
}
$orderRef="";
if ($bill->Origin and is_object($bill->Origin)) {
  if ($bill->Origin->originType=='Command') {
    $order=new Command($bill->Origin->originId);
    $orderRef=$order->externalReference;
  }
}
$billLine=new BillLine();
$crit=array('refType'=>'Bill', 'refId'=>$bill->id);
$billLines=$billLine->getSqlElementsFromCriteria($crit,false, null, 'line asc');

// Styles 
$cssframe='font-size:11pt;font-face:Verdana;position:absolute;left:6mm;width:180mm;';
$cssheader='text-align:center;font-weight:bold;color:#FFF;background:#545381;padding-top:1mm;padding-bottom:1mm;';
$cssheaderborder='text-align:center;font-weight:bold;color:#FFF;background:#545381;padding-top:1mm;padding-bottom:1mm;border:1px solid #FFFFFF;';
$csssubheaderborder='text-align:center;color:#FFF;background:#545381;padding-top:1mm;padding-bottom:1mm;border:1px solid #FFFFFF;';
$cssheadertitle='text-align:left;font-size:16pt;color:#545381;';
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
echo ' <table style="width:100%"><tr><td style="width:50%"></td>';
echo '  <td style="width:50%;'.$cssheadertitle.'">'.i18n('Bill').' '.$ref.'</td>';
echo ' </tr></table>'.$nl;
echo '</div>'.$nl;

// Sender / Receiver
echo $nl;
echo '<div style="'.$cssframe.'top:25mm;">'.$nl;
echo ' <table style="width:100%">'.$nl;
echo '  <tr>'.$nl;
echo '   <td style="'.$cssheader.'width:85mm;">'.i18n('Recipient').'</td>'.$nl;
echo '   <td style="width:5mm">&nbsp;</td>'.$nl;
echo '   <td style="'.$cssheader.'width:85mm;">'.i18n('Client').'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr style="height:75mm">'.$nl;
echo '   <td>'.$nl;
echo '     <div style="'.$cssaddress.'">'.$nl;
//echo '      <br/>'.$nl;
echo '      <b>'.$recipient->designation.'</b><br/>'.$nl;
$nbl=0;
if ($recipient->street) {
  echo '      '.$recipient->street.'<br/>'.$nl; 
  $nbl++;
}
if ($recipient->complement) {
  echo '      '.$recipient->complement.'</b><br/>'.$nl; 
  $nbl++;
}
if ($recipient->zip or $recipient->city) {
  echo '      '.$recipient->zip.' '.$recipient->city.'<br/>'.$nl; 
  $nbl++;
}
if ($recipient->state or $recipient->country) {
  echo '      '.$recipient->state.(($recipient->state and $recipient->country)?', ':'').$recipient->country.'<br/>'.$nl;
  $nbl++;
}
for ($i=0; $i<(4-$nbl);$i++) {echo '<br/>';}
echo '     <i>'.nl2br($recipient->legalNotice).'<br/>'.$nl;
echo '     <br/>'.$nl;
if ($recipient->numTax) echo '     '.i18n('colNumTax').' '.$recipient->numTax.'</i>'.$nl;
echo '     </div>'.$nl;
echo '     <div style="'.$csscontact.'">'.$nl;
echo '       '.$recipient->contactName;
echo '       <table><tr><td><img src="../view/css/images/mail.png" /></td>';
echo '         <td style="font-size:10pt">&nbsp;'.$recipient->contactEmail.'</td></tr></table>'.$nl;
echo '       <table><tr><td><img src="../view/css/images/phone.png" /></td>';
echo '         <td style="font-size:10pt">&nbsp;'.$recipient->contactPhone.(($recipient->contactPhone and $recipient->contactMobile)?' / ':'').$recipient->contactMobile.'</td></tr></table>'.$nl;
echo '     </div>'.$nl;
echo '   </td>'.$nl;
echo '   <td>'.$nl;
echo '   </td>'.$nl;
echo '   <td>'.$nl;
echo '     <div style="'.$cssaddress.'">'.$nl;
echo '      <br/><br/>'.$nl;
echo '      <b>'.(($client->designation)?$client->designation:$client->name).'</b><br/>'.$nl;
$nbl=0;
if ($client->street) {
  echo '      '.$client->street.'<br/>'.$nl;
  $nbl++;
}
if ($client->complement) {
  echo '      '.$client->complement.'<br/>'.$nl;
  $nbl++;
}
if ($client->zip or $client->city) {
  echo '      '.$client->zip.' '.$client->city.'<br/>'.$nl;
  $nbl++;
}
if ($client->state or $client->country) {
  echo '      '.$client->state.(($client->state and $client->country)?', ':'').$client->country.'<br/>'.$nl;
  $nbl++;
}
echo '     <br/>'.$nl;
if ($client->numTax) echo '      <i>'.i18n('colNumTax').' '.$client->numTax.'</i>'.$nl;
echo '     </div>'.$nl;
echo '     <div style="'.$csscontact.'">'.$nl;
echo '       '.$contact->name.'&nbsp;';
echo '       <table><tr><td><img src="../view/css/images/mail.png" /></td>';
echo '         <td style="font-size:10pt">&nbsp;'.$contact->email.'</td></tr></table>'.$nl;
echo '       <table><tr><td><img src="../view/css/images/phone.png" /></td>';
echo '         <td style="font-size:10pt">&nbsp;'.$contact->phone.(($contact->phone and $contact->mobile)?' / ':'').$contact->mobile.'</td></tr></table>'.$nl;
echo '     </div>'.$nl;
echo '   </td>'.$nl;
echo '  </tr>'.$nl;
echo ' </table>'.$nl;
echo '</div>'.$nl;

// Reference
echo '<div style="'.$cssframe.'top: 100mm;">'.$nl;
echo ' <table style="width:100%;">'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td colspan="2" style="'.$cssheader.'width:70%">'.i18n('sectionReference').'</td>'.$nl;
echo '   <td style="'.$cssheader.'width:30%;border:1px solid #545381;font-size:20pt;font-weight:normal;" rowspan="5">'.i18n('Bill').'<br/>'.$refShort.'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'width:35%;">'.i18n('colBillReference').'</td>';
echo '   <td style="'.$csscellleft.'width:35%">'.$ref.'</td>';
echo '  </tr>'.$nl;
echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'">'.i18n('colBillDate').'</td>';
echo '   <td style="'.$csscellleft.'">'.htmlFormatDate($bill->date).'</td>';
echo '  </tr>'.$nl;
echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'">'.i18n('colPaymentDelay').'</td>';
echo '   <td style="'.$csscellleft.'">'.$delay.'</td>';
echo '  </tr>'.$nl;
echo '  <tr >'.$nl;
echo '   <td style="'.$csscelltitle.'">'.i18n('colOrderReference').'</td>';
echo '   <td style="'.$csscellleft.'">'.$orderRef.'</td>';
echo '  </tr>'.$nl;
echo ' </table>'.$nl;
echo '</div>'.$nl;

// Detail
echo '<div style="'.$cssframe.'top: 130mm;">'.$nl;
echo ' <table style="width:100%;">'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td colspan="2" style="'.$cssheaderborder.'width:50%">'.i18n('ProductOrService').'</td>'.$nl;
echo '   <td colspan="3" style="'.$cssheaderborder.'width:50%">'.ucfirst(i18n('colPrice')).'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:20%">'.i18n('codDesignation').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:30%">'.i18n('colDetail').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:20%">'.i18n('colUnitPrice').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:15%">'.i18n('colQuantity').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:15%">'.i18n('colCountTotal').'</td>'.$nl;
echo '  </tr>'.$nl;
// each line
foreach ($billLines as $line) {
$unit=new MeasureUnit($line->idMeasureUnit);
$unitPrice=($unit->name)?' / '.$unit->name:'';
$unitQuantity=($unit->name)?' '.(($line->quantity>1)?$unit->pluralName:$unit->name):'';
echo '  <tr style="height:8mm;font-size:80%">'.$nl;
echo '   <td style="'.$csscellleft.'width:20%;">'.nl2br($line->description).'</td>'.$nl;
echo '   <td style="'.$csscellleft.'width:30%;">'.nl2br($line->detail).'</td>'.$nl;
echo '   <td style="'.$csscellright.'width:20%;">'.htmlDisplayCurrency($line->price).$unitPrice.'</td>'.$nl;
echo '   <td style="'.$csscellcenter.'width:15%;">'.htmlDisplayNumericWithoutTrailingZeros($line->quantity).$unitQuantity.'</td>'.$nl;
echo '   <td style="'.$csscellright.'width:15%;">'.htmlDisplayCurrency($line->amount).'</td>'.$nl;
echo '  </tr>'.$nl;
}
echo '  <tr style="height:8mm;font-size:80%">'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'font-weight:normal" colspan="3">'.i18n('colUntaxedAmount').'</td>'.$nl;
echo '   <td style="'.$cssheader.'">&nbsp;</td>'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'font-weight:normal">'.htmlDisplayCurrency($bill->untaxedAmount).'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr style="height:8mm;font-size:80%">'.$nl;
echo '   <td style="'.$csscellright.'" colspan="3">'.i18n('colTax').'</td>'.$nl;
echo '   <td style="'.$csscellcenter.'">'.htmlDisplayPct($bill->taxPct).'</td>'.$nl;
echo '   <td style="'.$csscellright.'">'.htmlDisplayCurrency($bill->fullAmount-$bill->untaxedAmount).'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr style="height:8mm;font-size:80%">'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'" colspan="3">'.i18n('colFullAmount').'</td>'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'">&nbsp;</td>'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'">'.htmlDisplayCurrency($bill->fullAmount).'</td>'.$nl;
echo '  </tr>'.$nl;
echo ' </table>'.$nl;
echo '<br/>';
echo '<div style="'.$csscomment.';font-size:80%">'.$bill->description.'</div>';
echo '</div>'.$nl;

// Bank account
echo '<div style="'.$cssframe.'top: 233mm;">'.$nl;
echo ' <table style="width:100%;">'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td colspan="2" style="'.$cssheader.'width:100%">'.i18n('sectionIBAN').'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr>'.$nl;
echo '   <td style="'.$csscelltitle.'width:40%;">'.i18n('colBankName').'</td>';
echo '   <td style="'.$csscellleft.'width:60%">'.$recipient->bankName.'</td>';
echo '  </tr>';
echo '  <tr>';
echo '   <td style="'.$csscelltitle.'">'.i18n('colBankNationalAccountNumber').'</td>';
echo '   <td style="'.$csscellleft.'">'.$recipient->bankNationalAccountNumber.'</td>';
echo '  </tr>';
echo '  <tr>';
echo '   <td style="'.$csscelltitle.'">'.i18n('colBankInternationalAccountNumber').'</td>';
echo '   <td style="'.$csscellleft.'">'.$recipient->bankInternationalAccountNumber.'</td>';
echo '  </tr>';
echo '  <tr>';
echo '   <td style="'.$csscelltitle.'">'.i18n('colBankIdentificationCode').'</td>';
echo '   <td style="'.$csscellleft.'">'.$recipient->bankIdentificationCode.'</td>';
echo '  </tr>';
echo '  <tr>';
echo '   <td style="'.$csscelltitle.'">'.i18n('colRecipient').'</td>';
echo '   <td style="'.$csscellleft.'">'.$recipient->name.'</td>';
echo '  </tr>';
echo ' </table>';
echo '</div>';

// Footer (Legal notice)
echo '<div style="'.$cssframe.'top: 270mm;">'.$nl;
echo ' <table style="color:#545381;width:100%;font-size:9pt;"><tr>';
//echo '  <td style="width:50%;text-align:left;line-height:99%;">'.$recipient->name.'<br/>'.i18n('colNumTax').' '.$recipient->numTax.'</td>';
echo '  <td style="width:50%;text-align:left;line-height:99%;vertical-align:top;">'.$recipient->name.'</td>';
echo '  <td style="width:50%;text-align:right;line-height:99%;">'.nl2br($recipient->legalNotice).'</td>';
echo ' </tr></table>'.$nl;
echo '</div>'.$nl;
// End
echo $nl;
echo '</div>'.$nl;

?>