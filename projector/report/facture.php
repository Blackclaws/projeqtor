<?php
// Header
include_once '../tool/projector.php';

$idProject = "";
if (array_key_exists('idProject', $_REQUEST))
{
	$idProject=trim($_REQUEST['idProject']);
}

$idClient = "";
if (array_key_exists('idClient', $_REQUEST))
{
	$idClient=trim($_REQUEST['idClient']);
}

$idBill = "";
if (array_key_exists('idBill', $_REQUEST))
{
	$idBill=trim($_REQUEST['idBill']);
}

$crit = array();
$crit['idle']="0";

if ($idBill != "")
{
	$crit['id']=$idBill;
}
else 
{
	if ($idClient!='')	$crit['idClient']=$idClient;
	if ($idProject!='') $crit['idProject']=$idProject;
}

$bill = new Bill();
$billList = $bill->getSqlElementsFromCriteria($crit,false);


// affichage des détails

foreach ($billList as $bill)
{
	
	echo '<table  width="95%" align="center"><tr><td style="width: 100%" class="section" colspan=2>';
	echo $bill->name;
	echo '</td></tr>';
	echo '<tr><td>&nbsp;</td></tr>';
	
	// Contractant
	echo "<tr><td>";
	
	$recipient = new Recipient($bill->idRecipient);
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
	$line = new Line();
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