<?php
//
// THIS IS THE BILL REPORT
// USE IT AS A TEMPLATE (GO TO "BILL TEMPLATE" COMMENT) 
// INSERT YOUR OWN LOGO, CHANGE DISPLAY TO EDIT YOUR OWN BILL FORMAT
//
include_once '../tool/projector.php';
$idProject = "";
if (array_key_exists('idProject', $_REQUEST)){
	$idProject=trim($_REQUEST['idProject']);
}
$idClient = "";
if (array_key_exists('idClient', $_REQUEST)){
	$idClient=trim($_REQUEST['idClient']);
}
$idBill = "";
if (array_key_exists('idBill', $_REQUEST)){
	$idBill=trim($_REQUEST['idBill']);
}
$crit = array();
$crit['idle']="0";
if ($idBill != ""){
	$crit['id']=$idBill;
} else {
	if ($idClient)	$crit['idClient']=$idClient;
	if ($idProject) $crit['idProject']=$idProject;
}
$bill = new Bill();
$billList = $bill->getSqlElementsFromCriteria($crit,false);
$first=true;
foreach ($billList as $bill)
{
  // BILL TEMPLATE : BRING YOUR CHANGES HERE
	$recipient = new Recipient($bill->idRecipient);
	$project=new Project($bill->idProject);
	$client=new Client($bill->idClient);
	$contact=new Contact($bill->idContact);
	
	if (! $first) {
	  echo '<div style="page-break-before:always;"></div>';
	}
	$first=false;
	// RECIPIENT ADDRESS
	echo '<div style="position: absolute; top: 5em; left: 1em; width: 20em; height: 10em;font-size: 12px">';
  	echo '<b>' . $recipient->designation .'</b><br/>';
	  echo ($recipient->street)?$recipient->street . '<br/>':'';
	  echo ($recipient->complement)?$recipient->complement . '<br/>':'';
	  echo ($recipient->zip)?$recipient->zip . '<br/>':'';
	  echo ($recipient->city)?$recipient->city . '<br/>':'';
	  echo ($recipient->state)?$recipient->state . '<br/>':'';
	  echo ($recipient->country)?$recipient->country . '<br/>':'';
  echo '</div>';
	// LOGO
  echo '<div style="position: absolute; top: 0em; left: 1em; width: 20em; height: 5em;">';
    echo '<img style="width:20em; height:5em" src="http://projectorria.toolware.fr/track/view/img/logo.png" />';
  echo '</div>';
  // BILLING  
    echo '<div style="position: absolute; top: 1em; right: 1em; width: 45%; height: 5em; ';
    echo ' border: 2px solid #A0A0D0;-moz-border-radius: 15px; border-radius: 15px;">';
    echo '<table style="width:100%">';
    echo '<tr><td style="text-align:right; width:50%"><b>' . i18n('colBillId') . ' : </b></td>';
    echo '    <td style="text-align:left;white-space:nowrap;">' . $bill->billId . '</td></tr>';
    echo '<tr><td style="text-align:right;"><b>' . i18n('colCompanyNumber') . ' : </b></td>';
    echo '    <td style="text-align:left;white-space:nowrap;">' . $recipient->companyNumber . '</td></tr>';
    echo '<tr><td style="text-align:right;"><b>' . i18n('colNumTax') . ' : </b></td>';
    echo '    <td style="text-align:left;white-space:nowrap;">' . $recipient->numTax . '</td></tr>';
    echo '</table>';
	  echo '</td>';
	  echo '</tr></table>';
	echo '</div>';
	// TITLE
	echo '<div style="position: absolute; top: 22em; right: 1em; width: 98%; height: 2em;">';
    echo '<div style="width: 100%;border-bottom: 3px solid #A0A0D0">&nbsp;</div>';
  echo '</div>';
  echo '<div style="position: absolute; top: 23em; right: 1em; width: 98%; height: 2em;">';
	  echo '<div style="width: 100%;text-align:center;color:#A0A0D0"><h1><b>BILL</b></h1></div>';
	echo '</div>';
	echo '<div style="position: absolute; top: 26em; right: 1em; width: 98%; height: 2em;">';
    echo '<div style="width: 100%;border-bottom: 3px solid #A0A0D0">&nbsp;</div>';
  echo '</div>';	
	// CONTACT
	echo '<div style="position: absolute; top: 8em; left: 50%; width: 45%; height: 10em; font-size:14px;">';
	  echo '<b>' . $contact->designation .'</b><br/>';
    echo ($contact->street)?$contact->street . '<br/>':'';
    echo ($contact->complement)?$contact->complement . '<br/>':'';
    echo ($contact->zip)?$contact->zip . '<br/>':'';
    echo ($contact->city)?$contact->city . '<br/>':'';
    echo ($contact->state)?$contact->state . '<br/>':'';
    echo ($contact->country)?$contact->country . '<br/>':'';
  echo '</div>';
	// NAME
	echo '<div style="position: absolute; top: 28em; left: 1em; width: 50%; height: 5em; ">';
    echo " " . $bill->name . '<br/>';
    echo " " . i18n('Project') . " : " . $project->name;
  echo '</div>';  
  // DATE
  echo '<div style="position: absolute; top: 28em; right: 1em; width: 10em; height: 1.5em;';
  echo ' border: 2px solid #A0A0D0;-moz-border-radius: 15px; border-radius: 15px;';
  echo ' text-align:center; vertical-align: middle; ">';
    echo htmlFormatDate($bill->date);
  echo '</div>';
	// BILL LINES
	$line = new BillLine();
  $crit = array("refId"=>$bill->id,"refType"=>"Bill");
  $lineList = $line->getSqlElementsFromCriteria($crit,false,null,"line");
  echo '<div style="width:98%; text-align: center; position: absolute; top: 30em; left: 1em; ';
  echo ' font-family: arial; font-size: 11px; min-height: 30em">';
	echo '<table style="width:100%; vertical-align: middle; text-align: center;">';
  echo '<tr>';
  echo '<th style="width:10%; border:solid 2px #A0A0D0">' . i18n('colQuantity') . '</th>';  
  echo '<th style="width:30%; border:solid 2px #A0A0D0">' . i18n('colDescription') . '</th>';
  echo '<th style="width:40%; border:solid 2px #A0A0D0">' . i18n('colDetail') . '</th>';
  echo '<th style="width:10%; border:solid 2px #A0A0D0">' . i18n('colPrice') . '</th>';
  echo '<th style="width:10%; border:solid 2px #A0A0D0">' . i18n('colAmount') . '</th>';  
  echo '</tr>';
  foreach ($lineList as $line) {
    echo '<tr>';
    echo '<td style="text-align: center; vertical-align: top;">' . $line->quantity . '</td>';
    echo '<td style="text-align: center; vertical-align: top;">' . $line->description . '</td>';
    echo '<td style="text-align: center; vertical-align: top;">' . $line->detail . '</td>';
    echo '<td style="text-align: center; vertical-align: top;">' . $line->price . '</td>';
    echo '<td style="text-align: center; vertical-align: top;">' . $line->amount . '</td>';
    echo '</tr>';
  }
  echo '</table>';
	echo '</div>';

	
	
	

	
	$client = new Client($bill->idClient);
	echo $client->name."<br/>";
	echo $client->description."<br/>";
	echo "Delai : ".$client->paymentDelay."<br/>";
	
	if ($client->id)
	{
		$user = new User();
		$critb = array("idClient"=>$client->id);
		$userList = $user->getSqlElementsFromCriteria($critb,false);
		if (count($userList)!=0)
		{
			echo "Contact : ".$userList[0]->name."<br/>";
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
}

?>