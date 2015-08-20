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
$delay="";
if ($client->paymentDelay) {
  $delay=$client->paymentDelay.' '.i18n('days');
  if ($client->paymentDelayEndOfMonth) {
    $delay.=' '.i18n('colEndOfMonth');
  }
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
$cssheadertitle='text-align:left;font-size:20pt;color:#545381;';
$cssaddress='text-align:left;font-face:Verdana;height:45mm;width:85mm;border-bottom:1px solid #545381;padding-left:5mm;';
$csscontact='text-align:left;font-face:Verdana;height:25mm;width:85mm;padding-left:5mm;';
$csscellleft='text-align:left;font-face:Verdana;border:1px solid #545381;padding-left:10px;';
$csscellright='text-align:right;font-face:Verdana;border:1px solid #545381;padding-right:10px;';
$csscellcenter='text-align:center;font-face:Verdana;border:1px solid #545381;';
$csscelltitle='text-align:right;border:1px solid #545381;color:#545381;padding-right:15px;';
    
echo $nl;
echo '<div style="page-break-before:always;"></div>'.$nl;
// Background
//echo '<div style="position:absolute;top:0mm; left:0mm;width:190mm;height:277mm;'
//     .'background-size: 190mm 277mm;background-image:url(../report/object/backgroundA4.png);">&nbsp;</div>';
//echo '**START**'.$nl;
echo '<div style="position:absolute;'.(($outMode=='pdf')?'left:5mm; top:5mm':'').'">'.$nl;
echo $nl;
echo '<div style="position:absolute;top:0mm; left:0mm;width:190mm;height:270mm;">'.$nl;
echo ' <img src="../report/object/backgroundA4.png"  style="width:190mm; height:270mm" />'.$nl;
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
echo '     '.i18n('colNumTax').' '.$recipient->numTax.'</i>'.$nl;
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
echo '      <b>'.$client->name.'</b><br/>'.$nl;
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
echo '   <td style="'.$cssheader.'width:30%;border:1px solid #545381;font-size:20pt;font-weight:normal;" rowspan="5">'.i18n('Bill').'<br/>'.$ref.'</td>'.$nl;
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
echo '   <td style="'.$csssubheaderborder.'width:25%">'.i18n('codDesignation').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:25%">'.i18n('colDetail').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:20%">'.i18n('colUnit').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:10%">'.i18n('colQuantity').'</td>'.$nl;
echo '   <td style="'.$csssubheaderborder.'width:20%">'.i18n('colCountTotal').'</td>'.$nl;
echo '  </tr>'.$nl;
// each line
foreach ($billLines as $line) {
echo '  <tr style="height:8mm">'.$nl;
echo '   <td style="'.$csscellleft.'width:25%">'.$line->description.'</td>'.$nl;
echo '   <td style="'.$csscellleft.'width:25%">'.$line->detail.'</td>'.$nl;
echo '   <td style="'.$csscellright.'">'.htmlDisplayCurrency($line->price).'</td>'.$nl;
echo '   <td style="'.$csscellcenter.'">'.$line->quantity.'</td>'.$nl;
echo '   <td style="'.$csscellright.'">'.htmlDisplayCurrency($line->amount).'</td>'.$nl;
echo '  </tr>'.$nl;
}
echo '  <tr style="height:8mm">'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'font-weight:normal" colspan="3">'.i18n('colUntaxedAmount').'</td>'.$nl;
echo '   <td style="'.$cssheader.'">&nbsp;</td>'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'font-weight:normal">'.htmlDisplayCurrency($bill->untaxedAmount).'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td style="'.$csscellright.'" colspan="3">'.i18n('colTax').'</td>'.$nl;
echo '   <td style="'.$csscellcenter.'">'.htmlDisplayPct($bill->tax).'</td>'.$nl;
echo '   <td style="'.$csscellright.'">'.htmlDisplayCurrency($bill->fullAmount-$bill->untaxedAmount).'</td>'.$nl;
echo '  </tr>'.$nl;
echo '  <tr style="height:8mm">'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'" colspan="3">'.i18n('colFullAmount').'</td>'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'">&nbsp;</td>'.$nl;
echo '   <td style="'.$cssheader.$csscellright.'">'.htmlDisplayCurrency($bill->fullAmount).'</td>'.$nl;
echo '  </tr>'.$nl;
echo ' </table>'.$nl;
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
//echo '**END**'.$nl;
/*
echo '<table style="width: 100%;"><tr><td style="width: 50%;">';

	// RECIPIENT ADDRESS
	echo '<div style="position: relative; top: 1em; left: 1em; width: 20em; height: 10em;font-size: 12px">';
  	echo '<b>' . $recipient->designation .'</b><br/>';
	  echo ($recipient->street)?$recipient->street . '<br/>':'';
	  echo ($recipient->complement)?$recipient->complement . '<br/>':'';
	  echo ($recipient->zip)?$recipient->zip . '<br/>':'';
	  echo ($recipient->city)?$recipient->city . '<br/>':'';
	  echo ($recipient->state)?$recipient->state . '<br/>':'';
	  echo ($recipient->country)?$recipient->country . '<br/>':'';
  echo '</div>';
  echo '</td><td style="width:50%">';
  // BILLING
  $numBill=Parameter::getGlobalParameter('billPrefix')
          . str_pad($bill->billId,Parameter::getGlobalParameter('billNumSize'),'0', STR_PAD_LEFT)
          . Parameter::getGlobalParameter('billSuffix');   
  echo '<div style="position: relative; top: 1em; left: 1em; width: 90%; height: 4em; ';
    echo ' border: 2px solid #7070A0;-moz-border-radius: 15px; border-radius: 15px;">';
    echo '<table style="width:100%">';
    echo '<tr><td style="text-align:right; width:50%"><b>' . i18n('colBillId')  . '&nbsp;:&nbsp;</b></td>';
    echo '    <td style="text-align:left;white-space:nowrap;">' . $numBill . '</td></tr>';
    echo '<tr><td style="text-align:right;"><b>' . i18n('colCompanyNumber') . '&nbsp;:&nbsp;</b></td>';
    echo '    <td style="text-align:left;white-space:nowrap;">' . $recipient->companyNumber . '</td></tr>';
    echo '<tr><td style="text-align:right;"><b>' . i18n('colNumTax') . '&nbsp;:&nbsp;</b></td>';
    echo '    <td style="text-align:left;white-space:nowrap;">' . $recipient->numTax . '</td></tr>';
    echo '</table>';
	echo '</div>';
	// CONTACT
  echo '<div style="position: relative; top: 3em; left: 1em; width: 90%; height: 10em; font-size:14px;">';
    echo '<b>' . $contact->designation .'</b><br/>';
    echo ($contact->street)?$contact->street . '<br/>':'';
    echo ($contact->complement)?$contact->complement . '<br/>':'';
    echo ($contact->zip)?$contact->zip . '<br/>':'';
    echo ($contact->city)?$contact->city . '<br/>':'';
    echo ($contact->state)?$contact->state . '<br/>':'';
    echo ($contact->country)?$contact->country . '<br/>':'';
  echo '</div>';
  echo '</td></tr></table>';  
  echo '<table style="width:100%;"><tr><td width="100%">';
	// TITLE
	echo '<div style="solid red;position: relative; top: 3em; left: 1em; width: 98%; height: 2em;">';
    echo '<div style="width: 100%;border-bottom: 3px solid #7070A0">&nbsp;</div>';
  echo '</div>';
  echo '</td></tr><tr><td>';
  echo '<div style="position: relative; top: 1.5em; left: 1em; width: 98%; height: 2em;">';
	  echo '<div style="width: 100%;text-align:center;color:#7070A0"><h1><b>' . strtoupper(i18n('Bill')) . '</b></h1></div>';
	echo '</div>';
	echo '</td></tr><tr><td>';
	echo '<div style="position: relative; top: 1em; left: 1em; width: 98%; height: 2em;">';
    echo '<div style="width: 100%;border-bottom: 3px solid #7070A0">&nbsp;</div>';
  echo '</div>';
  echo '</td></tr><tr><td>';	
	// NAME
	echo '<table width="100%"><tr><td width="70%">';
	echo '<div style="position: relative; top: 1em; left: 1em; width: 100%; height: 3em; ">';
    echo " " . htmlEncode($bill->name) . '<br/>';
    echo " " . i18n('Project') . " : " . htmlEncode($project->name);
  echo '</div>';  
  echo '</td><td style="width:30%; text-align: right;">';
  // DATE
  echo '<div style="position: relative; top: 1em; width: 12em; height: 1.5em;';
  echo ' border: 2px solid #7070A0;-moz-border-radius: 15px; border-radius: 15px;';
  echo ' text-align:center; vertical-align: middle; ">';
    echo htmlFormatDate($bill->date);
  echo '</div>';
  echo '</td></tr></table>';
  echo '</td></tr></table>';
	// BILL LINES and TOTAL
	$line = new BillLine();
  $crit = array("refId"=>$bill->id,"refType"=>"Bill");
  $lineList = $line->getSqlElementsFromCriteria($crit,false,null,"line");
  echo '<div style="border: 0px solid red;width:98%; text-align: center; position: relative; top: 2em; left: 1em; ';
  echo ' font-family: arial; font-size: 11px; min-height: 55em; page-break-inside:avoid">';
	echo '<table style="width:100%; vertical-align: middle; text-align: center;">';
  echo '<tr>';
  echo '<th style="width:10%; border:solid 2px #7070A0; background: #F0F0F0; text-align: center;">' . ucfirst(i18n('colQuantity')) . '</th>';  
  echo '<th style="width:30%; border:solid 2px #7070A0; background: #F0F0F0; text-align: center;">' . ucfirst(i18n('colDescription')) . '</th>';
  echo '<th style="width:40%; border:solid 2px #7070A0; background: #F0F0F0; text-align: center;">' . ucfirst(i18n('colDetail')) . '</th>';
  echo '<th style="width:10%; border:solid 2px #7070A0; background: #F0F0F0; text-align: center;">' . ucfirst(i18n('colPrice')) . '</th>';
  echo '<th style="width:10%; border:solid 2px #7070A0; background: #F0F0F0; text-align: center;">' . ucfirst(i18n('colAmount')) . '</th>';  
  echo '</tr>';
  foreach ($lineList as $line) {
  	echo '<tr>';
  	echo '<td style="border-left:solid 2px #7070A0; border-right:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">&nbsp;</td>';
  	echo '</tr>';
    echo '<tr>';
    echo '<td style="text-align: center; vertical-align: top; border-left:solid 2px #7070A0; border-right:solid 2px #7070A0;">' . $line->quantity . '</td>';
    echo '<td style="text-align: left; vertical-align: top; border-right:solid 2px #7070A0;">' . htmlEncode($line->description,'withBR') . '</td>';
    echo '<td style="text-align: left; vertical-align: top; border-right:solid 2px #7070A0;">' . htmlEncode($line->detail,'withBR') . '</td>';
    echo '<td style="text-align: center; vertical-align: top; border-right:solid 2px #7070A0;">' . htmlDisplayCurrency($line->price) . '</td>';
    echo '<td style="text-align: center; vertical-align: top; border-right:solid 2px #7070A0;">' . htmlDisplayCurrency($line->amount) . '</td>';
    echo '</tr>';
  }
  echo '<tr>';
    echo '<td style="border-left:solid 2px #7070A0; border-right:solid 2px #7070A0;border-bottom:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;border-bottom:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;border-bottom:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;border-bottom:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;border-bottom:solid 2px #7070A0;">&nbsp;</td>';
  echo '</tr>';
  echo '<tr>';
    echo '<td colspan="4" style=" border-right:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">&nbsp;</td>';   
  echo '</tr>';
  echo '<tr>';
    echo '<td colspan="3" style="text-align: right;">&nbsp;</td>';
    echo '<td style=" border-right:solid 2px #7070A0;text-align: center;">' . i18n('colUntaxedAmount') . '&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">' . htmlDisplayCurrency($bill->untaxedAmount) . '</td>';   
  echo '</tr>';
  echo '<tr>';
    echo '<td colspan="4" style=" border-right:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">&nbsp;</td>';   
  echo '</tr>';
  echo '<tr>';
    echo '<td colspan="3" style="text-align: right;">' . i18n('colTax') . '&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">' . htmlDisplayPct($bill->tax) . '</td>';
    echo '<td style="border-right:solid 2px #7070A0;">' . htmlDisplayCurrency(( $bill->fullAmount - $bill->untaxedAmount) ) . '</td>';   
  echo '</tr>';
  echo '<tr>';
    echo '<td colspan="4" style="border-right:solid 2px #7070A0;">&nbsp;</td>';
    echo '<td style="border-right:solid 2px #7070A0;">&nbsp;</td>';   
  echo '</tr>';
  echo '<tr>';
    echo '<td colspan="3" style="text-align: right;">&nbsp;</td>';
    echo '<td style=" border-right:solid 2px #7070A0;text-align: center;font-weight: bold;">' . i18n('colFullAmount') . '&nbsp;</td>';
    echo '<td style="border:solid 2px #7070A0;font-weight: bold;">' . htmlDisplayCurrency($bill->fullAmount) . '</td>';   
  echo '</tr>';
  
  echo '</table>';
  echo '</div>';
	// PAYMENT  

	continue;
	

	
	$client = new Client($bill->idClient);
	echo htmlEncode($client->name)."<br/>";
	echo htmlEncode($client->description)."<br/>";
	echo "Delai : ".$client->paymentDelay."<br/>";
	
	if ($client->id)
	{
		$user = new User();
		$critb = array("idClient"=>$client->id);
		$userList = $user->getSqlElementsFromCriteria($critb,false);
		if (count($userList)!=0)
		{
			echo "Contact : ".htmlEncode($userList[0]->name)."<br/>";
			echo "Portable : ".$userList[0]->mobile."<br/>";
			echo "Fixe : ".$userList[0]->phone."<br/>";
			echo "Fax : ".$userList[0]->fax."<br/><br/>";
			echo $userList[0]->street."<br/>";
			echo $userList[0]->complement."<br/>";
			echo $userList[0]->zip."  ".$userList[0]->city."<br/>";
			echo $userList[0]->country."  ".$userList[0]->state."<br/>";
			
		}
	}
	
	// nom de contact et adresse
	
	
	echo "</td></tr>";
	echo '<tr><td>&nbsp;</td></tr>';
	//date et autres détails
	echo "<tr><td>";
	
	echo "Date de facturation : ".$bill->date."</td></tr>";
	
	if ($bill->startDate!="")
	{
		echo "<tr><td>Pour la periode du ".$bill->startDate." au ".$bill->endDate;
		echo "</td></tr>"; 
	}
	
	echo '<tr><td>&nbsp;</td></tr>';
	// affichage des lignes
	echo "<tr><td>";
	
	


	echo "</td></tr>";
	echo '<tr><td>&nbsp;</td></tr>';
	// totaux	
	echo "<tr><td>";
	echo "<table>";
	
	echo "<tr><td width=100px>Total HT : </td><td>".$acc."</td></tr>";
	echo "<tr><td>TVA : </td><td>".$client->tax."</td></tr>";
	echo "<tr><td>Total TTC : </td><td>".($acc+$acc/100*$client->tax)."</td></tr>";
	
	echo "</table>";
	echo "</td></tr>";
	echo '<tr><td>&nbsp;</td></tr>';
	// détails contractant
	echo "<tr><td>";
	
	echo i18n("colCompanyNumber") . " : ".$recipient->companyNumber."<br/>";
	echo "numero TVA : ".$recipient->numTax."<br/>";
	echo "banque : ".$recipient->bank."<br/>";
	echo "numero RIB : ".$recipient->numBank." ".$recipient->numOffice." ".$recipient->numAccount." ".$recipient->numKey."<br/>";
	
	echo "</td></tr>";
	echo "</table>";
*/

?>