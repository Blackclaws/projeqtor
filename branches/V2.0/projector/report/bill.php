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
	$client=new Client($project->idClient);
	
	if (! $first) {
	  echo '<div style="page-break-before:always;"></div>';
	}
	$first=false;
	// RECIPIENT ADDRESS
	echo '<div style="position: absolute; top: 5em; left: 1em; width: 20em; height: 10em; border: 1px solid grey;">';
  	echo '<b>' . $recipient->designation .'</b><br/>';
	  echo ($recipient->street)?$recipient->street . '<br/>':'';
	  echo ($recipient->complement)?$recipient->complement . '<br/>':'';
	  echo ($recipient->zip)?$recipient->zip . '<br/>':'';
	  echo ($recipient->city)?$recipient->city . '<br/>':'';
	  echo ($recipient->state)?$recipient->state . '<br/>':'';
	  echo ($recipient->country)?$recipient->country . '<br/>':'';
  echo '</div>';
	// LOGO
  echo '<div style="position: absolute; top: 0em; left: 1em; width: 20em; height: 5em; border: 1px solid grey;">';
    echo '<img style="width:20em; height:5em" src="http://projectorria.toolware.fr/track/view/img/logo.png" />';
  echo '</div>';
  // BILLING  
  echo '<div style="position: absolute; top: 0em; right: 1em; width: 20em; height: 5em; border: 1px solid grey;">';
    echo '<table>';
    echo '<tr><td style="text-align:right; width:90%"><b>' . i18n('colBillId') . ' : </b></td>';
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
	echo '<div style="position: absolute; top: 15em; left: 1em; width: 98%; height: 2em; border: 1px solid grey;">';
    echo '<div style="width: 100%;border-bottom: 2px solid #555">&nbsp;</div>';
	  echo '<div style="width: 100%;text-align:center;"><h1><b>BILL</b></h1></div>';
	echo '</div>';
	
	// CLIENT
	echo '<div style="position: absolute; top: 15em; left: 1em; width: 98%; height: 2em; border: 1px solid grey;">';
	  echo '<div style="width: 100%;border-bottom: 2px solid #555">&nbsp;</div>';
    echo '<div style="width: 100%;text-align:center;"><h1><b>BILL</b></h1></div>';
  echo '</div>';
	
	// BILL LINES
	echo '<div style="position: relative; font-family: arial; font-size: 11px; min-height: 50em">';
	echo '</div>';
	continue;
	
	
	$user = new Contact();
	$critb = array("idRecipient"=>$recipient->id);
	$userList = $user->getSqlElementsFromCriteria($critb,false);
	echo $recipient->name."<br/><br/>";
	if(count($userList)!=0)
	{
		echo $userList[0]->street."<br/>";
		echo $userList[0]->complement."<br/>";
		echo $userList[0]->zip."  ".$userList[0]->city."<br/>";
		echo $userList[0]->country."  ".$userList[0]->state."<br/>";
	}
	
	echo "</td>";
	//Client
	echo "<td width=200px>";

	
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
	
	echo "<table>";
	$acc=0;
	$line = new BillLine();
	$crit = array("refId"=>$bill->id,"refType"=>"Bill");
	$lineList = $line->getSqlElementsFromCriteria($crit,false,null,"line");
	echo "<tr><th width=70px style='border:solid 1px black'>Quantite";	
	echo "</th><th width=300px style='border:solid 1px black'>Description";
	echo "</th><th width=300px style='border:solid 1px black'>Reference";
	echo "</th><th width=100px style='border:solid 1px black'>Prix unitaire";
	echo "</th><th width=100px style='border:solid 1px black'>Prix total";
	
	echo "</th></tr>";
	foreach ($lineList as $line)
	{
		echo "<tr><td width=50px>";
		
		echo $line->quantity."</td><td>";
		echo $line->description."</td><td>";
		echo $line->reference."</td><td>";
		echo $line->price."</td><td>";
		echo $line->sum;
		$acc+=$line->sum;
		
		echo "</td></tr>";
	}
	echo "</table>";


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